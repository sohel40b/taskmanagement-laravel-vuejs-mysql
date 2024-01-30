<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_authenticated_user_can_create_task()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'title' => $this->faker->name,
            'description' => $this->faker->paragraph,
            'status' => 2,
        ];

        $response = $this->post(route('tasks.store'), $data);

        $this->assertDatabaseHas('tasks', array_merge($data, ['user_id' => $user->id]));
        $response->assertStatus(201);
    }

    public function test_authenticated_user_can_update_task()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $task = Task::factory()->create(['user_id' => $user->id]);

        $data = [
            'status' => 1,
        ];

        $response = $this->put(route('tasks.update', $task->id), $data);

        $this->assertDatabaseHas('tasks', $data);
        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_delete_task()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->delete(route('tasks.destroy', $task->id));

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);

        $response->assertStatus(204);
    }

    public function test_authenticated_user_validation_rules_for_creating_task()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            
        ];

        $response = $this->post(route('tasks.store'), $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('title');
    }
}
