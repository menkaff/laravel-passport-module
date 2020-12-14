<?php

namespace Modules\Passport\Tests;

use Laravel\Passport\Passport;
use Tests\TestCase;

class TokenTest extends TestCase
{
    /** @test */
    public function a_user_can_see_its_tokens()
    {
        $api_logged_user_model = config('app.api_logged_user_model');
        $api_logged_user_guard = config('app.api_logged_user_guard');
        $api_logged_user_scope = config('app.api_logged_user_scope');

        $api_logged_user_object = $api_logged_user_model::first();
        Passport::actingAs(
            $api_logged_user_object,
            [$api_logged_user_scope],
            $api_logged_user_guard
        );

        $response = $this->json('GET', '/api/passport/v1/token');

        $response->assertStatus(200);

        $response->assertJson([
            'is_successful' => true,
        ]);
    }

    /** @test */
    public function a_user_can_see_its_current_token()
    {
        $api_logged_user_model = config('app.api_logged_user_model');
        $api_logged_user_guard = config('app.api_logged_user_guard');
        $api_logged_user_scope = config('app.api_logged_user_scope');

        $api_logged_user_object = $api_logged_user_model::first();
        Passport::actingAs(
            $api_logged_user_object,
            [$api_logged_user_scope],
            $api_logged_user_guard
        );

        $response = $this->json('GET', '/api/passport/v1/token/current');

        $response->assertStatus(200);

        $response->assertJson([
            'is_successful' => true,
        ]);
    }

    /** @test */
    public function a_user_can_delete_its_token_with_id()
    {
        $api_logged_user_model = config('app.api_logged_user_model');
        $api_logged_user_guard = config('app.api_logged_user_guard');
        $api_logged_user_scope = config('app.api_logged_user_scope');

        $api_logged_user_object = $api_logged_user_model::first();
        Passport::actingAs(
            $api_logged_user_object,
            [$api_logged_user_scope],
            $api_logged_user_guard
        );

        $current_token = $api_logged_user_object->token();
        if ($current_token) {
            $token_to_delete = $api_logged_user_object->tokens()->where('id', '!=', $current_token->id)->first();
            if ($token_to_delete) {
                $response = $this->json('GET', '/api/passport/v1/token/delete', [
                    'id' => $token_to_delete->id,
                ]);

                $response->assertStatus(200);

                $response->assertJson([
                    'is_successful' => true,
                ]);
            }
        }
    }
}
