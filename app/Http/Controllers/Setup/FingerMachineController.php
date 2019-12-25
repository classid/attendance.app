<?php

namespace CID\Finger\Http\Controllers\Setup;

use CID\Finger\Models\FingerMachine;
use Illuminate\Http\Request;

class FingerMachineController extends Controller
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->prefixView .= 'finger-machine';

        $this->setActiveMenu('fingerMachine');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->setPageTitle('Finger Machines');
        $this->setBreadCrumbs('Finger Machine');

        $this->setData('machines', FingerMachine::cursor());

        return $this->view('index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setPageTitle('Finger Machine Baru');
        $this->setBreadCrumbs(['title' => 'Finger Machine', 'href' => route('setup.fingerMachine')]);
        $this->setBreadCrumbs('Baru');
        $this->setActiveMenu('fingerMachine');

        return $this->view('new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $machine->fill($request->except(['_token']));
        FingerMachine::create($request->except(['_token']));

        return redirect()->route('setup.fingerMachine');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $machine
     * @return \Illuminate\Http\Response
     */
    public function show(FingerMachine $machine)
    {
        $this->setPageTitle('Edit Finger Machine');
        $this->setBreadCrumbs(['title' => 'Finger Machine', 'href' => route('setup.fingerMachine')]);
        $this->setBreadCrumbs('Edit');
        $this->setActiveMenu('fingerMachine');
        $this->setData('machine', $machine);

        return $this->view('edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $machine
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FingerMachine $machine)
    {
        if (!$request->post('enable')) $request['enable'] = 0;
        $machine->update($request->except(['_token']));

        return redirect()->route('setup.fingerMachine');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $machine
     * @return \Illuminate\Http\Response
     */
    public function destroy(FingerMachine $machine, Request $request)
    {
        $machine->delete();

        if ($request->ajax()) return response()->json(['redirect' => route('setup.fingerMachine'), ]);
        return redirect()->route('setup.fingerMachine');
    }
}
