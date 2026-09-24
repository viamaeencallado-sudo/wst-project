<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_tasks_can_be_created_and_listed(): void
    {
        $this->post(route('tasks.store'), ['task_name' => 'Prepare presentation', 'description' => 'Finish the final slides', 'status' => 'Pending', 'due_date' => '2026-10-01'])
            ->assertRedirect(route('tasks.index'));

        $this->get(route('tasks.index'))->assertOk()->assertSee('Prepare presentation');
        $this->assertDatabaseHas('tasks', ['task_name' => 'Prepare presentation', 'status' => 'Pending']);
    }

    public function test_tasks_can_be_updated_status_toggled_and_deleted(): void
    {
        $task = Task::create(['task_name' => 'Old name', 'description' => null, 'status' => 'Pending', 'due_date' => null]);

        $this->put(route('tasks.update', $task), ['task_name' => 'Updated name', 'description' => 'New details', 'status' => 'Pending', 'due_date' => null])
            ->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', ['task_name' => 'Updated name']);

        $this->patch(route('tasks.status', $task))->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'status' => 'Completed']);

        $this->delete(route('tasks.destroy', $task))->assertRedirect(route('tasks.index'));
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}