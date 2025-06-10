<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DatabaseTest extends TestCase
{
    use RefreshDatabase;

    private static function create_user()
    {
        $user =  User::create([
            'name' => 'testing',
            'email' => 'test@test.com',
            'password' => bcrypt('testtest'),
        ]);

        $user->markEmailAsVerified();
        return $user;
    }

    public function test_soft_delete_user()
    {
        $user = DatabaseTest::create_user();

        $this->actingAs($user)->delete(route('users.delete'));

        $this->assertSoftDeleted('users', ['id' => 1]);
    }

    public function test_edit_username()
    {
        $user = DatabaseTest::create_user();
        $user->name = 'newname';

        $this->actingAs($user)->put(route('users.edit', ['name' => $user->name]));

        $this->assertDatabaseHas('users', ['name' => $user->name]);
    }


    public function test_user_store()
    {
        $response = $this->post(route('users.store'), [
            'name' => 'johnsmith',
            'email' => 'johnsmith@example.com',
            'password' => 'qwerty',
            'password_confirmation' => 'qwerty',
        ]);

        $this->assertDatabaseHas('users', ['email' => 'johnsmith@example.com']);
    }

    public function test_create_group()
    {
        $user = DatabaseTest::create_user();

        $this->actingAs($user)->post(route('groups.store'), [
            'title' => 'test',
            'members' => '',
        ]);

        $this->assertDatabaseHas('groups', ['title' => 'test']);

    }
}

