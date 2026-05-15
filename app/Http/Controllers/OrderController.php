<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Driver;
use Illuminate\Http\Request;
use App\Services\OrderWorkflowService;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('driver')->latest();

        if ($request->filter === 'active') {
            $query->active();
        }

        if ($request->filter === 'completed') {
            $query->completed();
        }

        if ($request->filter === 'delayed') {
            $query->delayed();
        }

        $orders = $query->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $order = new Order();
        $drivers = Driver::where('is_available', true)->orderBy('name')->get();

        return view('orders.create', compact('order', 'drivers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['nullable', 'string', 'max:50'],
            'pickup_address' => ['required', 'string', 'max:255'],
            'dropoff_address' => ['required', 'string', 'max:255'],
            'vehicle_model' => ['nullable', 'string', 'max:255'],
            'vehicle_plate' => ['nullable', 'string', 'max:50'],
            'service_type' => ['required', 'string', 'max:100'],
            'priority' => ['required', 'string', 'max:50'],
            'assigned_driver_id' => ['nullable', 'exists:drivers,id'],
            'scheduled_at' => ['nullable', 'date'],
        ]);

        $validated['status'] = $validated['assigned_driver_id'] ? 'assigned' : 'new';
        $validated['created_by'] = auth()->id();

        $order = Order::create($validated);

        $order->events()->create([
            'event_type' => 'created',
            'note' => 'Order created',
            'created_by' => auth()->id(),
        ]);

        return redirect()
            ->route('orders.show', $order)
            ->with('success', 'Order created successfully.');
    }

    public function show(Order $order, OrderWorkflowService $workflow)
    {
        $order->load('driver', 'creator');

        $nextStatuses = $workflow->getNextStatuses($order->status);

        return view('orders.show', compact(
            'order',
            'nextStatuses'
        ));
    }

    public function edit(Order $order)
    {
        $drivers = Driver::orderBy('name')->get();

        return view('orders.edit', compact('order', 'drivers'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['nullable', 'string', 'max:50'],
            'pickup_address' => ['required', 'string', 'max:255'],
            'dropoff_address' => ['required', 'string', 'max:255'],
            'vehicle_model' => ['nullable', 'string', 'max:255'],
            'vehicle_plate' => ['nullable', 'string', 'max:50'],
            'service_type' => ['required', 'string', 'max:100'],
            'priority' => ['required', 'string', 'max:50'],
            'status' => ['required', 'in:new,assigned,on_the_way,picked_up,delivered,completed,cancelled'],
            'assigned_driver_id' => ['nullable', 'exists:drivers,id'],
            'scheduled_at' => ['nullable', 'date'],
        ]);

        $validated['completed_at'] = $validated['status'] === 'completed' ? now() : null;

        $order->update($validated);

        return redirect()
            ->route('orders.show', $order)
            ->with('success', 'Order updated successfully.');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()
            ->route('orders.index')
            ->with('success', 'Order deleted successfully.');
    }

    public function updateStatus(
        Request $request,
        Order $order,
        OrderWorkflowService $workflow
    ) {
        $validated = $request->validate([
            'status' => ['required', 'in:new,assigned,on_the_way,picked_up,delivered,completed'],
            'note' => ['nullable', 'string'],
        ]);

        if (! $workflow->canTransition($order->status, $validated['status'])) {
            return back()->withErrors([
                'status' => 'Invalid status transition.'
            ]);
        }

        $oldStatus = $order->status;

        $order->update([
            'status' => $validated['status'],
            'completed_at' => $validated['status'] === 'completed' ? now() : $order->completed_at,
        ]);

        $order->events()->create([
            'event_type' => 'status_changed',
            'note' => $validated['note']
                ?: "Status changed from {$oldStatus} to {$validated['status']}",
            'created_by' => auth()->id(),
        ]);

        return back()->with('success', 'Status updated');
    }
}
