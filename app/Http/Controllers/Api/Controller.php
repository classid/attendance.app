<?php

namespace CID\Finger\Http\Controllers\Api;

use CID\Finger\Http\Controllers\ControllerTrait;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use ControllerTrait;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        auth()->setDefaultDriver('api');

        $this->middleware(function ($request, $next) {
            if (auth()->check()) {
                $this->authUser = auth()->user();
            } else {
                $this->authUser = (object)[];
            }

            return $next($request);
        });
    }
}
