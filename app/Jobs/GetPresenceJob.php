<?php

namespace CID\Finger\Jobs;

use CID\Finger\Models\FingerMachine;
use CID\Finger\Models\Presence;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class GetPresenceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $machine;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($machine = null)
    {
        $this->machine = $machine;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (! $this->machine) {
//            Log::info('Getting Enabled Machines');
            $this->getMachines();
        }

        if (is_array($this->machine) && Arr::has($this->machine, ['host', 'port', 'key'])) {
//            Log::info('Trying connect to ' . $this->machine['name'] . ' at ' . $this->machine['host'] . ':' . $this->machine['port']);
            $this->getLogs($this->machine);
        }
    }

    protected function getMachines()
    {
        foreach (FingerMachine::whereEnable(true)->cursor() as $key => $val) {
            $this::dispatchNow($val->toArray());
        }
    }

    protected function getLogs($machine)
    {
        try {
            Log::info('Trying connect to ' . $machine['name'] . ' at ' . $machine['host'] . ':' . $machine['port']);

            $connected = fsockopen($machine['host'], $machine['port'], $errno, $errStr, 1);
            if($connected) {
                $soapRequest = "<GetAttLog><ArgComKey xsi:type=\"xsd:integer\">" . $machine['key'] . "</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg></GetAttLog>";
                $newLine = "\r\n";

                fputs($connected, "POST /iWsService HTTP/1.0" . $newLine);
                fputs($connected, "Content-Type: text/xml" . $newLine);
                fputs($connected, "Content-Length: " . strlen($soapRequest) . $newLine . $newLine);
                fputs($connected, $soapRequest . $newLine);

                $buffer = "";
                while($response = fgets($connected, 1024)) {
                    $buffer .= $response;
                }

                $buffer = $this->parseData($buffer, "<GetAttLogResponse>","</GetAttLogResponse>");
                $buffer = explode($newLine, $buffer);

                for($i = 0; $i < count($buffer); $i++){
                    $dataRec = $this->parseData($buffer[$i], "<Row>", "</Row>");
                    $pin = $this->parseData($dataRec, "<PIN>", "</PIN>");
                    $dateTime = $this->parseData($dataRec, "<DateTime>", "</DateTime>");
                    $verified = $this->parseData($dataRec, "<Verified>", "</Verified>");
                    $status = $this->parseData($dataRec, "<Status>", "</Status>");

                    if (trim($pin) != '') {
                        $log = [
                            'pin' => $pin,
                            'datetime' => $dateTime,
                            'status' => $status,
                            'verified' => $verified,
                        ];

                        dump($log);
                        Presence::firstOrCreate($log);
                    }
                }
            }
        } catch (Exception $e) {
            Log::error('Error Grabing from ' . $machine['name'] . ' at ' . $machine['host'] . ':' . $machine['port']);
            Log::error($e);
        }
    }

    protected function parseData($data, $p1, $p2) {
        $data = " " . $data;
        $hasil = "";
        $awal = strpos($data, $p1);
        if($awal != ""){
            $akhir = strpos(strstr($data, $p1), $p2);
            if($akhir != "") {
                $hasil = substr($data, ($awal + strlen($p1)), ($akhir - strlen($p1)));
            }
        }
        return $hasil;
    }
}
