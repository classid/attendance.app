<?php

namespace CID\Finger\Http\Controllers\Logs;

use CID\Finger\Models\Presence;
use Illuminate\Http\Request;

class PresenceController extends Controller
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->prefixView .= 'presence';

        $this->setActiveMenu('log:presence');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->setPageTitle('Presence Logs');
        $this->setBreadCrumbs('Presence Logs');

        $this->setData('presences', Presence::orderByRaw('datetime DESC')->cursor());

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
        $this->setBreadCrumbs(['title' => 'Finger Machine', 'href' => route('setup.machine')]);
        $this->setBreadCrumbs('Baru');
        $this->setActiveMenu('machine');

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
        Machine::create($request->except(['_token']));

        return redirect()->route('setup.machine');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $machine
     * @return \Illuminate\Http\Response
     */
    public function show(Machine $machine)
    {
        $this->setPageTitle('Edit Finger Machine');
        $this->setBreadCrumbs(['title' => 'Finger Machine', 'href' => route('setup.machine')]);
        $this->setBreadCrumbs('Edit');
        $this->setActiveMenu('machine');
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
    public function update(Request $request, Machine $machine)
    {
        if (!$request->post('enable')) $request['enable'] = 0;
        $machine->update($request->except(['_token']));

        return redirect()->route('setup.machine');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $machine
     * @return \Illuminate\Http\Response
     */
    public function destroy(Machine $machine, Request $request)
    {
        $machine->delete();

        if ($request->ajax()) return response()->json(['redirect' => route('setup.machine'), ]);
        return redirect()->route('setup.machine');
    }
}
