<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    /** @use HasFactory<\Database\Factories\ScheduleFactory> */
    use HasFactory;

    protected $fillable = [
        'ship_id',
        'departure_date',
        'departure_time',
        'price',
        'quota'
    ];

    public function ship()
    {
        return $this->belongsTo(Ship::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
