<?php

namespace Tests\Feature;

use App\Models\TaskList;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Plannr\Laravel\FastRefreshDatabase\Traits\FastRefreshDatabase;
use Tests\TestCase;

class TaskListTest extends TestCase
{
    use FastRefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    #[Test]
    public function expect_test_user_can_create_task_lists(): void
    {

        $response = $this->actingAs($this->user, 'sanctum')
            ->postJson(route('tasklists.create'), [
                'name' => 'New tasklist',
            ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('task_lists', ['Name' => 'New tasklist']);
    }

    #[Test]
    public function expect_guest_cannot_access_tasklists(): void
    {
        $response = $this->getJson('/api/tasklists');
        $response->assertStatus(401);
    }

    #[Test]
    public function expect_test_user_can_update_task_list(): void
    {

        $taskList = TaskList::factory()->create(['user_id' => $this->user->id]);

        $updatedData = ['name' => 'Edited Task List'];

        $this->actingAs($this->user, 'sanctum')
            ->put(route('tasklists.update', $taskList), $updatedData)
            ->assertStatus(200);

        $this->assertDatabaseHas('task_lists', ['id' => $taskList->id, 'name' => 'Edited Task List']);
    }

    #[Test]
    public function expect_user_can_delete_task_list() :void
    {
        $taskList = TaskList::factory()->create(['user_id' => $this->user->id]);

        $this->actingAs($this->user, 'sanctum')
            ->delete(route("tasklists.destroy",$taskList))
            ->assertStatus(200);

        $this->assertDatabaseMissing('task_lists', ['id' => $taskList->id]);
    }
}
