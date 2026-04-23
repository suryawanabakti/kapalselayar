<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passenger extends Model
{
    /** @use HasFactory<\Database\Factories\PassengerFactory> */
    use HasFactory;

    protected $fillable = [
        'order_id',
        'name',
        'nik',
        'ticket_code',
        'is_validated',
        'validated_at'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($passenger) {
            $passenger->ticket_code = 'TKT-' . strtoupper(bin2hex(random_bytes(4)));
            
            // Ensure uniqueness
            while (static::where('ticket_code', $passenger->ticket_code)->exists()) {
                $passenger->ticket_code = 'TKT-' . strtoupper(bin2hex(random_bytes(4)));
            }
        });
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
