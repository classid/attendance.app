<?php

namespace CID\Finger\Http\Controllers\Logs;

use CID\Finger\Http\Controllers\Controller as BaseController;

class Controller extends BaseController
{
    protected $prefixView = 'app.logs.';

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setActiveMenu('logs');
        $this->setBreadCrumbs('Logs');
    }
}
