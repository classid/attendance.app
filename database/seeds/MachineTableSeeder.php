<?php

use CID\Finger\Models\Machine;
use Illuminate\Database\Seeder;

class MachineTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Solution X100-C',
                'host' => '192.168.1.201',
                'port' => 80,
                'key' => '0',
                'sn' => 'BWXP191260343',
            ],
        ];

        foreach ($data as $key => $val) {
            Machine::create($val);
        }
    }
}
