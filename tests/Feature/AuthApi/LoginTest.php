<?php

namespace Tests\Feature\AuthApi;

//use App\Constants\DbTables;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function setUp():void
    {
        parent::setUp();
    }

    /**
     * @var mixed|\Tests\Collection|\Tests\Model
     */
    protected User $authUser;

    public function test_login_api_is_not_protected()
    {
        $route = Route::getRoutes()->getByName('api.login');

        $middlewares = $route->middleware();

        $this->assertNotContains('auth:sanctum', $middlewares, 'Route has unexpected auth middleware');
    }

    public function test_login_api_requires_email_and_password_field()
    {
        $this->postJson(route("api.login"), [])->assertStatus(422)
            ->assertJsonValidationErrors(["email", "password"])
            ->assertJsonValidationErrors([
                "email"    => "The email field is required.",
                "password" => "The password field is required.",
            ]);
    }

    public function test_login_api_requires_valid_email_and_password_field()
    {
        $this->postJson(route("api.login"), [
            "email"    => "this is not a valid email address.",
            "password" => "password",
        ])->assertStatus(422)
            ->assertJsonValidationErrors(["email"])
            ->assertJsonValidationErrors([
                "email" => "The email field must be a valid email address.",
            ]);
    }

    public function test_invalid_login_credential_is_rejected()
    {
        $this->postJson(route("api.login", [
            "email"    => "asd@asd.com",
            "password" => "asd",
        ]))->assertStatus(404)->assertJson([
            "message" => __("auth.failed"),
            "status"  => false,
        ]);
    }
//
    public function test_login_is_only_valid_using_verified_credential()
    {
        $email    = "sita@bootcamper.com";
        $password = "password";

        User::factory()->create([
                                    "email"    => $email,
                                    "password" => $password,
                                ]);

        $this->postJson(route("api.login", [
            "email"    => $email,
            "password" => $password,
        ]))->assertOk()
            ->assertJsonStructure([
                    "token",
            ]);
    }

        public function test_token_is_generated_when_logged_in_using_valid_credential()
    {
        $email    = "asd@asd.com";
        $password = "password";
        User::factory()->create([
                                    "email"    => $email,
                                    "password" => $password,
                                ]);
        $this->assertDatabaseHas("users", [
            "email" => $email,
        ])->assertDatabaseCount("users", 1)
            ->assertDatabaseEmpty("personal_access_tokens");

        $response = $this->postJson(route("api.login", [
            "email"    => $email,
            "password" => $password,
        ]))->assertOk()
            ->assertJsonStructure([
                    "token",
            ]);
        $this->assertDatabaseCount("personal_access_tokens", 1)
            ->assertDatabaseHas("personal_access_tokens", [
                "tokenable_type" => "App\Models\User",
                "tokenable_id"   => auth()->user()->id,
            ]);
    }

    public function test_me_route_is_protected()
    {
        $email    = "me@user.com";
        $password = "password";
        $user = User::factory()->create([
                                            "email"    => $email,
                                            "password" => $password,
                                        ]);
        $this->assertDatabaseHas("users", [
            "email" => $email,
        ])->assertDatabaseCount("users", 1);

        $this->postJson(route("api.me") )
             ->assertJson(["message"=>"Unauthenticated."]);
    }

    public function test_me_route_should_return_details_of_logged_in_user()
    {
        $email    = "me@user.com";
        $password = "password";
        $user = User::factory()->create([
                                    "email"    => $email,
                                    "password" => $password,
                                ]);
        $this->assertDatabaseHas("users", [
            "email" => $email,
        ])->assertDatabaseCount("users", 1);

        Sanctum::actingAs($user);

        $this->postJson(route("api.me") )
             ->assertJsonStructure([
                                       "id",
                                       "name",
                                       "email"
                                   ])->assertJson([
                                                              "id"=>$user->id,
                                                              "name"=>$user->name,
                                                              "email"=>$user->email
                                                          ]);
    }
}
