<?php

namespace Tests\Feature\Api\Account;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class MeControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testMeEndpoint()
    {
        /** @var User $user */
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $this->getJson(route('api.me'))
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'email',
                ],
            ])
            ->assertSee($user->getEmailForPasswordReset());
    }
}
