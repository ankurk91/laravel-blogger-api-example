<?php

namespace Tests\Feature\Api\Auth;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class ResetPasswordControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testSuccessfulSubmission()
    {
        Event::fake();

        /** @var User $user */
        $user = User::factory()->create();

        $token = Password::createToken($user);

        $payload = [
            'token' => $token,
            'email' => $user->getEmailForPasswordReset(),
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ];

        $this->postJson(route('api.password.update'), $payload)
            ->assertSuccessful();

        Event::assertDispatched(PasswordReset::class);
    }
}
