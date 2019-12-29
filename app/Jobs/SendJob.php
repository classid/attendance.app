<?php

namespace CID\Finger\Jobs;

use Carbon\Carbon;
use CID\Finger\Models\Presence;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise\RejectedPromise;
use GuzzleHttp\Promise\RejectionException;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;
use Ramsey\Uuid\Uuid;

class SendJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $key;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($key = null)
    {
        $this->key = $key;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->key)
            $this->syncAttendance($this->key);
        else
            $this->setLock();
    }

    protected function setLock()
    {
        $key = Uuid::uuid4()->getHex();
        Presence::whereIn('id', function ($query) {
            /*$query->from((new Presence)->getTable())->select('id')->whereNull('sent_at')->where(function ($q) {
                $q->whereNull('locked')->orWhere(function ($q) {
                    $q->where('locked', '<>', 'sent')->whereNotNull('locked');
                });
            });*/
            $query->from((new Presence)->getTable())->select('id')->whereNull('sent_at')->whereNull('locked');
        })->orderBy('created_at', 'asc')->limit(5)->update([
            'locked' => $key,
        ]);

        $this::dispatchNow($key);
    }

    protected function syncAttendance($key)
    {
        $src = Presence::whereLocked($key)->cursor();
        echo count($src) . '<br>';
        if (count($src) > 0) {
            $atts = [];
            foreach ($src as $val) {
                array_push($atts, [
                    'xxxxx', // machine sn
                    $val->pin,  // nip | nis | nim
                    strtotime($val->datetime),
                    1,  // inode
                ]);
            }

            try {
                echo 'trying process<br>';
                /*$request = new GuzzleRequest('POST', config('cid.app.attendance_sync'), [
                    'Content-Type' => 'application/json',
                    'client-id' => env('CID_CLIENT_ID'),
                    'client-secret' => env('CID_CLIENT_SECRET'),
                ], [
                    'form_params' => [
                        'user_refs' => $atts,
                    ],
                ]);
                $promise = $this->client->sendAsync($request)->then(*/
//                $promise = $this->client->postAsync(config('cid.app.attendance_sync'), [
//                    'headers' => [
//                        'Content-Type' => 'application/json',
//                        'client-id' => env('CID_CLIENT_ID'),
//                        'client-secret' => env('CID_CLIENT_SECRET'),
//                    ],
//                    'form_params' => [
//                        'user_refs' => $atts,
//                    ],
//                ])->then(
//                    function (ResponseInterface $response) use ($key) {
//                        Presence::whereLocked($key)->update([
//                            'locked' => 'sent',
//                            'sent_at' => Carbon::now(),
//                        ]);
//                        Log::info($response->getBody());
//                    },
//                    function ($e) {
//                        Log::error(':: RequestException');
//                        Log::error($e);
//                    }
//                );
//                $promise->wait();

//                $request = new GuzzleRequest('POST', config('cid.app.attendance_sync'), [
//                    'Content-Type' => 'application/json',
//                    'client-id' => env('CID_CLIENT_ID'),
//                    'client-secret' => env('CID_CLIENT_SECRET'),
//                ]);
//                $promise = $this->client->sendAsync($request, [
//                    'form_params' => [
//                        'user_refs' => $atts,
//                    ],
//                ])->then(
//                    function (ResponseInterface $response) use ($key) {
//                        Presence::whereLocked($key)->update([
//                            'locked' => 'sent',
//                            'sent_at' => Carbon::now(),
//                        ]);
//                        Log::info($response->getBody());
//                    },
//                    function (\ErrorException $e) {
//                        Log::error(':: Rejected');
//                        Log::error($e);
//                    }
//                );
//                $promise->wait();

//                $response = $this->client->post(config('cid.app.attendance_sync'), [
//                    'headers' => [
//                        'Content-Type' => 'application/json',
//                        'client-id' => env('CID_CLIENT_ID'),
//                        'client-secret' => env('CID_CLIENT_SECRET'),
//                    ],
//                    'form_params' => [
//                        'user_refs' => $atts,
//                    ],
//                ]);

//                Log::info($response);

//                dump(json_encode($atts));

//                $response = $this->client()->request('GET', 'http://demo.class.id/api/v1/virtual-payment/inquiry', [
//                    'query' => ['vano' => '00000000000'],
//                ]);
//
//                dump(['response', $response->getBody()->getContents()]);

                echo 'before<br>';
                $promise = $this->client()->requestAsync('POST', config('cid.app.attendance_sync'), [
                    'headers' => [
//                        'Content-Type' => 'application/x-www-form-urlencoded',
                        'Content-Type' => 'application/json',
                        'client-id' => env('CID_CLIENT_ID'),
                        'client-secret' => env('CID_CLIENT_SECRET'),
                    ],
                    'json' => [
                        'user_refs' => $atts,
                    ],
                ])->then(
                    function (ResponseInterface $response) use ($key) {
                        Presence::whereLocked($key)->update([
                            'locked' => 'sent',
                            'sent_at' => Carbon::now(),
                        ]);
                        Log::info($response->getBody());
                        Log::info('response status: ' . $response->getStatusCode());
                        Log::info('response body: ' . $response->getBody());
                    },
                    function (ClientException $e) {
                        dump([':: Rejected', $e]);
                        Log::error(':: Rejected');
                        Log::error('message: ' . $e->getMessage());
                        Log::error('request header: ' . json_encode($e->getRequest()->getHeaders()));
                        Log::error('request body: ' . $e->getRequest()->getBody());
                        Log::error('response status: ' . $e->getResponse()->getStatusCode());
                        Log::error('response body: ' . $e->getResponse()->getBody());
                        echo ':: Rejected<br>';
                    }
                );
                $promise->wait();
                echo 'after<br>';

//                dump(['response', $response->getBody()->getContents()]);
//                Log::info($response->getBody()->getContents());
            }
            catch (RequestException $e) {
                Log::error(':: GuzzleException');
                Log::error($e);
            }
            catch (\Exception $e) {
                Log::error(':: Exception');
                Log::error($e);
            }
        }

        Presence::whereNotNull('locked')->update(['locked' => null, 'sent_at' => null]);
        echo 'ok';
    }

    public function client()
    {
//        $platformUrl = config('cid.app.attendance_sync');
        $client = new GuzzleClient([
            // Base URI is used with relative requests
//            'base_uri' => $platformUrl,
            // You can set any number of default request options.
            'timeout' => 500.0,
            'defaults' => [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
            ],
        ]);

        return $client;
    }
}
