<?php

namespace CID\Finger\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class ClearPresences implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $machine;
    protected $pin;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($machine = null, $pin = null)
    {
        $this->machine = $machine;
        $this->pin = $pin;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (is_array($this->machine) && Arr::has($this->machine, ['host', 'port', 'key'])) {
            $this->getLogs($this->machine, $this->pin);
        }
    }

    protected function getLogs($machine, $pin = null)
    {
        try {
            if (! empty($pin) && strtolower($pin) === 'all')
                $pin = Str::studly($pin);

//            Log::info('Trying connect to ' . $machine['name'] . ' at ' . $machine['host'] . ':' . $machine['port']);

            $connected = fsockopen($machine['host'], $machine['port'], $errno, $errStr, 1);
            if($connected) {
                $soapRequest = '<ClearData><ArgComKey xsi:type="xsd:integer">' . $machine['key'] . '</ArgComKey><Arg><Value xsi:type="xsd:integer">1</Value></Arg></ClearData>';
                $newLine = "\r\n";

                fputs($connected, "POST /iWsService HTTP/1.0" . $newLine);
                fputs($connected, "Content-Type: text/xml" . $newLine);
                fputs($connected, "Content-Length: " . strlen($soapRequest) . $newLine . $newLine);
                fputs($connected, $soapRequest . $newLine);

                $buffer = "";
                while($response = fgets($connected, 1024)) {
                    $buffer .= $response;
                }

                $buffer = xml_data($buffer, '<GetAttLogResponse>','</GetAttLogResponse>');
                $buffer = explode($newLine, $buffer);

                for($i = 0; $i < count($buffer); $i++){
                    $dataRec = xml_data($buffer[$i], '<Row>', '</Row>');
                    $pin = xml_data($dataRec, '<PIN>', '</PIN>');
                    $dateTime = xml_data($dataRec, '<DateTime>', '</DateTime>');
                    $verified = xml_data($dataRec, '<Verified>', '</Verified>');
                    $status = xml_data($dataRec, '<Status>', '</Status>');

                    if (trim($pin) != '') {
                        $log = [
                            'machine_id' => $machine['id'],
                            'pin' => $pin,
                            'datetime' => $dateTime,
                            'status' => $status,
                            'verified' => $verified,
                        ];

//                        dump($log);
                        Presence::firstOrCreate($log);
                    }
                }
            }
        } catch (\Exception $e) {
//            Log::error('Error Grabing from ' . $machine['name'] . ' at ' . $machine['host'] . ':' . $machine['port']);
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
        }
    }
}
