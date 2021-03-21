<?php

namespace Tests\Feature\Api\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Lang;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testSuccessfulLogin()
    {
        Event::fake();

        /** @var User $user */
        $user = User::factory()->create();

        $payload = [
            'email' => $user->getEmailForPasswordReset(),
            'password' => 'password',
            'device_name' => $this->faker->userAgent,
        ];

        $this->postJson(route('api.login'), $payload)
            ->assertSuccessful()
            ->assertJsonStructure([
                'token_type',
                'access_token',
            ]);

        $this->assertAuthenticatedAs($user, 'sanctum');
        Event::assertDispatched(Login::class);
    }

    public function testInvalidCredentials()
    {
        Event::fake();

        /** @var User $user */
        $user = User::factory()->create();

        $payload = [
            'email' => $user->getEmailForPasswordReset(),
            'password' => 'random@123',
            'device_name' => $this->faker->userAgent,
        ];

        $this->postJson(route('api.login'), $payload)
            ->assertSee(Lang::get('auth.failed'))
            ->assertStatus(422);

        Event::assertNotDispatched(Login::class);
    }
}
