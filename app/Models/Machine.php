<?php

namespace CID\Finger\Models;

use Yusronarif\Core\Database\Eloquent\Model;

class Machine extends Model
{
    protected $table = 'machines';

    protected $primaryKey = 'id';
    protected $keyType = 'uuid';

    protected $fillable = ['type', 'group', 'name', 'host', 'port', 'enable', 'sn'];

    protected $attributes = [
        'host' => '127.0.0.1',
        'port' => 80,
        'enable' => true,
    ];

    public function presences()
    {
        return $this->hasMany(Presence::class, 'machine_id', 'id');
    }
}
