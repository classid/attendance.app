<?php

namespace CID\Finger\Models;

use Yusronarif\Core\Database\Eloquent\Model;

class FingerMachine extends Model
{
    protected $table = 'finger_machines';

    protected $primaryKey = 'id';
    protected $keyType = 'uuid';

    protected $fillable = ['name', 'host', 'port', 'enable'];

    protected $attributes = [
        'host' => '127.0.0.1',
        'port' => 80,
        'enable' => true,
    ];
}
