<?php

namespace Tests\Feature\Auth;

use App\Mail\AccountRequestMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AccountRequestTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seedDefaults();
    }

    public function test_account_request_api_is_not_protected()
    {
        return;
        $resourceRoutes = ['index'];

        foreach ($resourceRoutes as $route) {
            $this->assertRouteHasMiddleware("api.clusters.$route", ['auth:sanctum', 'api']);
        }
    }

    public function test_account_request_api_has_proper_validation()
    {
        $this->postJson(route("api.account_request"))->assertStatus(422)
            ->assertJsonValidationErrors([
                "firstname" => "The firstname field is required.",
                "lastname"  => "The lastname field is required.",
                "email"     => "The email field is required.",
                "phone"     => "The phone field is required.",
                "role"      => "The role field is required.",
            ]);
    }

    /**
     * Test successful account request submission.
     */
    public function test_account_request_is_sent_successfully()
    {
        // Mock the Mail facade
        Mail::fake();

        // Define valid request data
        $data = [
            'company'   => 'Fixlio',
            'firstname' => 'John',
            'lastname'  => 'Doe',
            'email'     => 'johndoe@example.com',
            'phone'     => '+1234567890',
            'role'      => 'Admin',
        ];

        // Send a POST request to the controller's endpoint
        $response = $this->postJson(route('api.account_request'), $data);

        // Assert the response is successful
        $response->assertStatus(200)
            ->assertJson([
                "data"    => [],
                "message" => "Account request sent successfully",
                "status"  => true,
            ]);

        // Assert the email was sent
        Mail::assertSent(AccountRequestMail::class, function ($mail) use ($data) {
            return $mail->hasTo('hallo@fixlio.com') && $mail->data === $data;
        });
    }
}
