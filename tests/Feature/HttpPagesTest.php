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

    public function test_login_page(): void
    {
        $response = $this->get('login');

        $response->assertStatus(200);
    }

    public function test_register_page(): void
    {
        $response = $this->get('register');

        $response->assertStatus(200);
    }

    public function test_user_store()
    {
        $response = $this->post(route('users.store'), [
            'name' => 'johnsmith',
            'email' => 'johnsmith@example.com',
            'password' => 'qwerty',
            'password_confirmation' => 'qwerty',
        ]);

        $response->assertRedirect(route('dashboard'));
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

    public function test_create_group()
    {
        $user = HttpPagesTest::create_user();

        $response = $this->actingAs($user)->post(route('groups.store'), [
            'title' => 'test',
            'members' => '',
        ]);

        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHasNoErrors();

    }

    public function test_user_can_get_group()
    {
        $user = HttpPagesTest::create_user();

        $this->actingAs($user)->post(route('groups.store'), [
            'title' => 'test',
            'members' => '',
        ]);

        $response = $this->actingAs($user)->get(route('groups.show', ['group' => 1]));
        $response->assertOk();

    }

    public function test_user_cannot_get_group()
    {
        $user = HttpPagesTest::create_user();

        Group::create([
            'title' => 'test',
        ]);

        $response = $this->actingAs($user)->get(route('groups.show', ['group' => 1]));
        $response->assertStatus(403);

    }
}
