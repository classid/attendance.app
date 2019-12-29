<?php

namespace CID\Finger\Http\Controllers\Api;

use CID\Finger\Models\Machine;
use Illuminate\Http\Request;

class MachineController extends Controller
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
        $rs = Machine::cursor();

        return response()->json($rs);
    }
}
