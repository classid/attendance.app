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

Route::get('info', function() {
//    phpinfo();
    echo sys_get_temp_dir();
});

Route::get('test', function() {
//    \CID\Finger\Jobs\GetPresenceJob::dispatchNow();
    \CID\Finger\Jobs\SendJob::dispatchNow();
});
