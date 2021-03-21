<?php

namespace Tests\Feature\Api\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testSuccessfulRegistration()
    {
        Event::fake();

        $payload = [
            'name' => $this->faker->firstName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => $this->faker->password,
        ];

        $this->postJson(route('api.register'), $payload)
            ->assertSuccessful();

        User::where('email', $payload['email'])->firstOrFail();

        $this->assertDatabaseHas('users', [
            'email' => $payload['email'],
        ]);

        Event::assertDispatched(\Illuminate\Auth\Events\Registered::class);
    }
}
