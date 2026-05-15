<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'customer_phone',
        'pickup_address',
        'dropoff_address',
        'vehicle_model',
        'vehicle_plate',
        'service_type',
        'priority',
        'status',
        'assigned_driver_id',
        'created_by',
        'scheduled_at',
        'completed_at',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'assigned_driver_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function events()
    {
        return $this->hasMany(OrderEvent::class);
    }

    public function isDelayed(): bool
    {
        return
            $this->scheduled_at &&
            $this->scheduled_at->isPast() &&
            $this->status !== 'completed';
    }

    public function scopeActive($query)
    {
        return $query->where('status', '!=', 'completed');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeDelayed($query)
    {
        return $query->where('status', '!=', 'completed')
            ->whereNotNull('scheduled_at')
            ->where('scheduled_at', '<', now());
    }

}
