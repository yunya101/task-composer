<?php

namespace Tests\Feature;

use App\Models\Group;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HttpPagesTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */


    public function test_login_page(): void
    {
        $response = $this->get('login');

        $response->assertStatus(200);
    }

    public function test_account_page()
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('account'))
            ->assertOk();
    }

    public function test_dashboard_page()
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('dashboard'))
            ->assertOk();
    }

    public function test_register_page(): void
    {
        $response = $this->get('register');

        $response->assertStatus(200);
    }


    public function test_user_store_error()
    {
        $response = $this->post(route('users.store'), []);

        $response->assertSessionHasErrors();
    }

    public function test_user_store_password_confirm_error()
    {
        $response = $this->post(route('users.store'), [
            'name' => 'michael',
            'email' => 'michael@test.com',
            'password' => 'qwe123rty',
            'password_confirmation' => 'wrong',
        ]);

        $response->assertSessionHasErrors();
    }

    public function test_authentication_user()
    {
        User::create([
            'name' => 'test',
            'password' => bcrypt('testtest'),
            'email' => 'test@test.com',
        ]);

        $response = $this->post(route('authentication'), [
            'email' => 'test@test.com',
            'password' => 'testtest',
        ]);

        $response->assertRedirect(route('dashboard'));
    }

    public function test_authentication_user_wrong_password()
    {
        User::create([
            'name' => 'test',
            'password' => bcrypt('testtest'),
            'email' => 'test@test.com',
        ]);

        $response = $this->post(route('authentication'), [
            'email' => 'test@test.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors();

    }

    public function test_user_can_get_group()
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('groups.store'), [
            'title' => 'test',
            'members' => '',
        ]);

        $response = $this->actingAs($user)->get(route('groups.show', ['group' => 1]));
        $response->assertOk();

    }

    public function test_user_cannot_get_group()
    {
        $user = User::factory()->create();

        Group::create([
            'title' => 'test',
        ]);

        $response = $this->actingAs($user)->get(route('groups.show', ['group' => 1]));
        $response->assertStatus(403);

    }

    public function test_creating_task()
    {
        $user = User::factory()->create();
        $group = Group::factory()->create();

        $group->users()->attach($user->id);

        $this->actingAs($user)->post("$group->id/tasks", [
            'title' => 'test',
            'deadline' => now(),
            'description' => 'test',
        ]);

        $this->assertDatabaseHas('tasks', ['id' => 1, 'title' => 'test']);

    }

    public function test_user_can_get_task()
    {
        $user = User::factory()->create();
        $group = Group::factory()->create();

        $group->users()->attach($user->id);

        $this->actingAs($user)->post("$group->id/tasks", [
            'title' => 'test',
            'deadline' => now(),
            'description' => 'test',
        ]);

        $this->actingAs($user)->get("$group->id/tasks/1")
            ->assertOk();

    }

    public function test_user_cannot_get_task()
    {
        $user = User::factory()->create();
        $group = Group::factory()->create();

        $group->users()->attach($user->id);

        $anotherUser = User::factory()->create();

        $this->actingAs($user)->post("$group->id/tasks", [
            'title' => 'test',
            'deadline' => now(),
            'description' => 'test',
        ]);

        $this->actingAs($anotherUser)->get("$group->id/tasks/1")
            ->assertStatus(403);
    }

    public function test_change_task()
    {
        $user = User::factory()->create();
        $group = Group::factory()->create();

        $group->users()->attach($user->id);

        $this->actingAs($user)->post("$group->id/tasks", [
            'title' => 'test',
            'deadline' => now(),
            'description' => 'test',
        ]);

        $this->actingAs($user)->put("$group->id/tasks/1/edit", [
            'title' => 'changed',
            'deadline' => now(),
            'executor' => $user->id,
        ]);

        $this->assertDatabaseHas('tasks', ['id' => 1, 'title' => 'changed']);
    }

    public function test_delete_task()
    {
        $user = User::factory()->create();
        $group = Group::factory()->create();

        $group->users()->attach($user->id);

        $this->actingAs($user)->post("$group->id/tasks", [
            'title' => 'test',
            'deadline' => now(),
            'description' => 'test',
        ]);

        $this->actingAs($user)->delete("$group->id/tasks/1");

        $this->assertDatabaseMissing('tasks', ['id' => 1]);

    }
    
    public function test_user_cannot_delete_task()
    {
        $user = User::factory()->create();
        $group = Group::factory()->create();

        $group->users()->attach($user->id);

        $anotherUser = User::factory()->create();

        $this->actingAs($user)->post("$group->id/tasks", [
            'title' => 'test',
            'deadline' => now(),
            'description' => 'test',
        ]);

        $this->actingAs($anotherUser)->delete("$group->id/tasks/1");

        $this->assertDatabaseHas('tasks', ['id' => 1]);

    }

    public function test_create_comment()
    {
        $user = User::factory()->create();
        $group = Group::factory()->create();

        $group->users()->attach($user->id);

        $this->actingAs($user)->post("$group->id/tasks", [
            'title' => 'test',
            'deadline' => now(),
            'description' => 'test',
        ]);

        $this->actingAs($user)->post("$group->id/tasks/1/comments", [
            'text' => 'hello world!',
        ]);

        $this->assertDatabaseHas('comments', ['id' => 1, 'text' => 'hello world!', 'user_id' => $user->id, 'task_id' => 1]);
    }
}
