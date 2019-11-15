<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomeControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    private function migrateUser()
    {
        Artisan::call('migrate:refresh --seed');
    }

    public function testGetUser()
    {
        $this->migrateUser();
        $users =  User::all();
        $response = $this->get(route('get.users'));
        $response
            ->assertViewHas('users',$users)
            ->assertViewIs('welcome');
    }

    public function testCreateUser()
    {
        $this->migrateUser();
        $response = $this->call('POST',route('create.user'),[
            'name' => 'Test Razaq',
            'email' => 'razaqofficial@gmail.com',
            'password' => 'razaqofficial123'
        ]);
        $this->assertDatabaseHas('users',[
            'name' => 'Test Razaq',
            'email' => 'razaqofficial@gmail.com'
        ]);
        $response->assertSessionHas(['success' => 'User created successfully']);
    }

    public function testDeleteUser()
    {
        $this->migrateUser();
        $initialCount = User::count();
        $response = $this->get(route('delete.users',['user_id' => 1]));
        $afterDeleteCount = User::count();
        $this->assertEquals($initialCount, $afterDeleteCount + 1);
        $response->assertSessionHas(['success' => 'User deleted successfully']);
    }

}
