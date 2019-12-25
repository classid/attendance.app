<?php

namespace CID\Finger\Http\Controllers\Setup;

use CID\Finger\Http\Controllers\Controller as BaseController;

class Controller extends BaseController
{
    protected $prefixView = 'app.setup.';

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setActiveMenu('setup');
        $this->setBreadCrumbs('Setup');
    }
}
