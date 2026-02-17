<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ship extends Model
{
    /** @use HasFactory<\Database\Factories\ShipFactory> */
    use HasFactory;

    protected $fillable = ['name', 'capacity'];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
