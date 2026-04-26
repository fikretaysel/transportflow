<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'vehicle_type',
        'is_available',
        'notes',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'assigned_driver_id');
    }

}
