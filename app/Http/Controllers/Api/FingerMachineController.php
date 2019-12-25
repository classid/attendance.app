<?php

namespace CID\Finger\Http\Controllers\Api;

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
    }

    public function lookup(Request $request)
    {
        $rs = FingerMachine::cursor();

        return response()->json($rs);
    }
}
