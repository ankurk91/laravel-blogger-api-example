<?php

namespace Tests\Feature\Api\Auth;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ForgotPasswordControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testSuccessfulSubmission()
    {
        Notification::fake();

        /** @var User $user */
        $user = User::factory()->create();

        $payload = [
            'email' => $user->getEmailForPasswordReset(),
        ];

        $this->postJson(route('api.password.request'), $payload)
            ->assertSuccessful();

        Notification::assertSentTo($user, ResetPassword::class);
    }
}
