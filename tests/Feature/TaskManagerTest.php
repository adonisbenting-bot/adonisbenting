<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskManagerTest extends TestCase
{
    use RefreshDatabase;

    public function test_personal_task_manager_can_create_and_manage_tasks(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('Task Manager')
            ->assertSee('/css/style.css');

        $this->post('/tasks', [
            'task_name' => 'Write project brief',
            'description' => 'Outline the next sprint and goals.',
            'status' => 'pending',
            'due_date' => '2026-09-30',
        ])->assertRedirect('/');

        $this->assertDatabaseHas('tasks', [
            'task_name' => 'Write project brief',
            'status' => 'pending',
        ]);

        $task = Task::first();

        $this->get('/tasks/' . $task->id . '/edit')
            ->assertOk()
            ->assertSee('Edit Task')
            ->assertSee('/css/style.css');

        $this->put('/tasks/' . $task->id, [
            'task_name' => 'Write project brief',
            'description' => 'Revised outline with final milestones.',
            'status' => 'completed',
            'due_date' => '2026-09-30',
        ])->assertRedirect('/');

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'status' => 'completed',
        ]);

        $this->delete('/tasks/' . $task->id)->assertRedirect('/');

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }
}
