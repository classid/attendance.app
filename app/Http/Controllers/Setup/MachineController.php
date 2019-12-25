<?php

namespace CID\Finger\Http\Controllers\Setup;

use Illuminate\Http\Request;

class MachineController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $this->setPageTitle('Dashboard');
        $this->setBreadCrumbs('Dashboard');
        $this->setActiveMenu('homed');

        return $this->view('home');
    }
}
