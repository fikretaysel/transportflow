<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Driver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_orders_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/orders');

        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_create_order(): void
    {
        $user = User::factory()->create();

        $driver = Driver::create([
            'name' => 'Test Driver',
            'phone' => '123456789',
            'is_available' => true,
        ]);

        $response = $this->actingAs($user)->post('/orders', [
            'customer_name' => 'Test Customer',
            'customer_phone' => '123456789',
            'pickup_address' => 'Berlin',
            'dropoff_address' => 'Hamburg',
            'vehicle_model' => 'BMW X5',
            'vehicle_plate' => 'B-TF-123',
            'service_type' => 'transport',
            'priority' => 'normal',
            'assigned_driver_id' => $driver->id,
            'scheduled_at' => now()->addDay()->format('Y-m-d H:i:s'),
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('orders', [
            'customer_name' => 'Test Customer',
            'pickup_address' => 'Berlin',
            'dropoff_address' => 'Hamburg',
            'status' => 'assigned',
            'assigned_driver_id' => $driver->id,
        ]);

        $this->assertDatabaseHas('order_events', [
            'event_type' => 'created',
            'note' => 'Order created',
        ]);
    }
}
