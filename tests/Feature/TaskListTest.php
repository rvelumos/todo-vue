<?php

namespace Tests\Feature;

use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TaskListTest extends TestCase
{
    #[Test]
    public function expect_test_user_can_create_task(): void
    {
        $user = User::factory()->create();
        $taskList = TaskList::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user, 'sanctum')
            ->postJson('/api/tasks', [
                'title' => 'New task',
                'task_list_id' => $taskList->id,
            ])
            ->assertStatus(201);

        $this->assertDatabaseHas('tasks', ['title' => 'New task']);
    }

    #[Test]
    public function test_user_cannot_add_task_to_another_users_tasklist(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $taskList = TaskList::factory()->create(['user_id' => $user1->id]);

        $this->actingAs($user2, 'sanctum')
            ->postJson('/api/tasks', [
                'title' => 'Not allowed',
                'task_list_id' => $taskList->id,
            ])
            ->assertStatus(403);
    }

    #[Test]
    public function test_guest_cannot_access_tasks(): void
    {
        $this->getJson('/api/tasks')
            ->assertStatus(401);
    }

    #[Test]
    public function test_user_can_update_task(): void
    {
        $user = User::factory()->create();
        $taskList = TaskList::factory()->create(['user_id' => $user->id]);
        $task = Task::factory()->create(['task_list_id' => $taskList->id]);

        $this->actingAs($user, 'sanctum')
            ->putJson("/api/tasks/{$task->id}", [
                'title' => 'Edit',
                'completed' => true
            ])
            ->assertStatus(200);

        $this->assertDatabaseHas('tasks', ['title' => 'Edit', 'completed' => true]);
    }

    #[Test]
    public function test_user_can_delete_task() :void
    {
        $user = User::factory()->create();
        $taskList = TaskList::factory()->create(['user_id' => $user->id]);
        $task = Task::factory()->create(['task_list_id' => $taskList->id]);

        $this->actingAs($user, 'sanctum')
            ->deleteJson("/api/tasks/{$task->id}")
            ->assertStatus(200);

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
