<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\OrderWorkflowService;

class OrderWorkflowServiceTest extends TestCase
{
    public function test_it_allows_valid_status_transition(): void
    {
        $workflow = new OrderWorkflowService();

        $result = $workflow->canTransition('new', 'assigned');

        $this->assertTrue($result);
    }

    public function test_it_rejects_invalid_status_transition(): void
    {
        $workflow = new OrderWorkflowService();

        $result = $workflow->canTransition('new', 'completed');

        $this->assertFalse($result);
    }

    public function test_it_returns_next_statuses_for_current_status(): void
    {
        $workflow = new OrderWorkflowService();

        $result = $workflow->getNextStatuses('assigned');

        $this->assertEquals(['on_the_way'], $result);
    }

    public function test_completed_status_has_no_next_status(): void
    {
        $workflow = new OrderWorkflowService();

        $result = $workflow->getNextStatuses('completed');

        $this->assertEquals([], $result);
    }
}
