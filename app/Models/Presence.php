<?php

namespace CID\Finger\Models;

use Yusronarif\Core\Database\Eloquent\Model;

class Presence extends Model
{
    protected $table = 'log_presences';

    protected $primaryKey = 'id';
    protected $keyType = 'uuid';

    protected $fillable = [
        'machine_id', 'pin', 'datetime', 'status', 'verified', 'sent_at',
    ];

    protected $attributes = [];

    public function machine()
    {
        return $this->belongsTo(Machine::class, 'machine_id', 'id');
    }
}
