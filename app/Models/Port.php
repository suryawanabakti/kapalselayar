<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Port extends Model
{
    protected $fillable = ['name'];

    public function schedulesAsOrigin()
    {
        return $this->hasMany(Schedule::class, 'origin_port_id');
    }

    public function schedulesAsDestination()
    {
        return $this->hasMany(Schedule::class, 'destination_port_id');
    }
}
