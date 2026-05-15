<?php

namespace App\Services;

class OrderWorkflowService
{
    private array $allowedTransitions = [
        'new' => ['assigned'],
        'assigned' => ['on_the_way'],
        'on_the_way' => ['picked_up'],
        'picked_up' => ['delivered'],
        'delivered' => ['completed'],
        'completed' => [],
    ];

    public function canTransition(string $currentStatus, string $newStatus): bool
    {
        return in_array(
            $newStatus,
            $this->allowedTransitions[$currentStatus] ?? [],
            true
        );
    }

    public function getNextStatuses(string $currentStatus): array
    {
        return $this->allowedTransitions[$currentStatus] ?? [];
    }
}
