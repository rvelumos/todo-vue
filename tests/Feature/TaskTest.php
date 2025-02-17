<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\TaskList;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Plannr\Laravel\FastRefreshDatabase\Traits\FastRefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{

    use FastRefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->user2 = User::factory()->create();
    }

    #[Test]
    public function expect_test_user_can_create_task(): void
    {

        $taskList = TaskList::factory()->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user, 'sanctum')
            ->postJson(route('tasks.create'), [
                'title' => 'New task',
                'task_list_id' => $taskList->id,
            ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('tasks', ['title' => 'New task']);
    }

    #[Test]
    public function expect_test_user_can_update_task(): void
    {
        $taskList = TaskList::factory()->create(['user_id' => $this->user->id]);
        $task = Task::factory()->create(['task_list_id' => $taskList->id]);

        $updatedData = [
            'title' => 'Edit',
            'completed' => true
        ];

        $this->actingAs($this->user, 'sanctum')
            ->put(route('tasks.update',$task), $updatedData)
            ->assertStatus(200);

        $this->assertDatabaseHas('tasks', ['title' => 'Edit', 'completed' => true]);
    }

    #[Test]
    public function expect_user_cannot_add_task_to_another_users_tasklist(): void
    {
        $taskList = TaskList::factory()->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user2, 'sanctum')
            ->post(route('tasks.create'), [
                'title' => 'Not allowed',
                'task_list_id' => $taskList->id,
            ]);

        $response->assertStatus(403);
    }

    #[Test]
    public function expect_guest_cannot_access_tasks(): void
    {
        $response = $this->getJson('/api/tasks');
        $response->assertStatus(401);
    }

    #[Test]
    public function expect_user_can_delete_tasks() :void
    {
        $taskList = TaskList::factory()->create(['user_id' => $this->user->id]);
        $task = Task::factory()->create(['task_list_id' => $taskList->id]);

        $this->actingAs($this->user, 'sanctum')
            ->delete(route("tasks.destroy",$task))
            ->assertStatus(200);

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
