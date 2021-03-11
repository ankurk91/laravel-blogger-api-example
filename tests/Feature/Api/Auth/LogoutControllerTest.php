<?php

namespace Tests\Feature\Api\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LogoutControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testSuccessfulLogout()
    {
        Event::fake();

        /** @var User $user */
        $user = User::factory()->create();

        Sanctum::actingAs($user);
        $response = $this->postJson(route('api.logout'));
        $response->assertSuccessful();

        Event::assertDispatched(\Illuminate\Auth\Events\Logout::class);
    }

    public function testFailedLogout()
    {
        Event::fake();

        $response = $this->postJson(route('api.logout'));
        $response->assertUnauthorized();

        Event::assertNotDispatched(\Illuminate\Auth\Events\Logout::class);
    }
}
