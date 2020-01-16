<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth')->name('home')->group(function () {
    Route::any('/', 'HomeController@index');
    Route::any('home', 'HomeController@index');
});

Route::any('{path}', function() {
    return redirect()->route('auth.login', [], 301);
})->where('path', '(auth|login|register)+');

Route::name('auth.')->prefix('auth')->group(function() {
    Auth::routes();
});

Route::middleware('auth')->namespace('Setup')->name('setup.')->prefix('setup')->group(function () {
    Route::resource('finger-machine', 'MachineController', [
        'names' => [
            'index' => 'machine',
            'create' => 'machine.create',
            'store' => 'machine.store',
            'show' => 'machine.edit',
            'update' => 'machine.update',
            'destroy' => 'machine.destroy',
        ],
        'parameters' => ['finger-machine' => 'machine',],
        'except' => ['edit'],
    ]);
});

Route::middleware('auth')->namespace('Logs')->name('logs.')->prefix('logs')->group(function () {
    Route::resource('presence', 'PresenceController', [
        'names' => [
            'index' => 'presence',
        ],
        'only' => ['index'],
    ]);
});

Route::get('info', function() {
    abort(404);
//    phpinfo();
//    echo sys_get_temp_dir();
});

Route::get('test', function() {
    if (request()->get('accept') == 'json') {
        header('Accept: application/json');
        header('Content-Type: application/json');
        app('debugbar')->disable();
    }
//    \CID\Finger\Jobs\PullPresences::dispatchNow();
    \CID\Finger\Jobs\PushPresences::dispatchNow();

//    try {
//        $address = '192.168.35.10:88';
//        $client = \Graze\TelnetClient\TelnetClient::factory();
//        $client->getSocket()->setOption(SOL_SOCKET, SO_SNDTIMEO, ['sec' => 1, 'usec' => 0]);
//
//        dump($client->connect($address));
//    }
//    catch (\Graze\TelnetClient\Exception\TelnetException $e) {
//        dump([$e->getCode(), $e->getMessage(), $e->getTraceAsString()]);
//    }

//    try {
//        $factory = new \Socket\Raw\Factory();
////        dump($factory->createClient('localhost'));
//        $address = 'sips.pt-best.com:22';
//        $socket = $factory->createClient($address);
////        dump($socket);
//        $client = $socket->accept();
////        dump($client);
////        dump($socket->bind($address));
////        dump($socket->connect($address));
////        $socket->shutdown();
////        $socket->close();
//    }
//    catch (\Socket\Raw\Exception $e) {
//        dump(['ERROR', $e->getMessage(), $e->getCode(), $e->getTraceAsString()]);
//    }

//    try {
//        $address = '192.168.35.10:80';
//        $socket = stream_socket_client($address, $errno, $errstr, 3);
//
//        dump($socket);
//    }
//    catch (\Exception $e) {
//        dump([$e->getCode(), $e->getMessage(), $e->getTraceAsString()]);
//    }

//    dump($client);
//    $ss = $client->connect('192.168.2.10:23');
//    dump($ss);

//    foreach (\CID\Finger\Models\Machine::whereEnable(true)->cursor() as $key => $val) {
//        $conn = fsockopen($val->host, $val->port, $errno, $errStr, 1);
//        dump([$val->host . ':' . $val->port, $conn, !$conn?'not connected':'connected', (bool) $conn]);
//        dump($client->connect($val->host . ':' . $val->port));
//    }
//    abort(404);
});
