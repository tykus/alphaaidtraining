<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SendEnquiryTest extends TestCase
{
    /** @test */
    function guest_can_send_an_enquiry()
    {
        $this->withoutExceptionHandling();
        $response = $this->json('POST', 'api/enquiries', $this->validParams());

        $response->assertStatus(200);
        $response->assertJson([
            'message' => "Thank you"
        ]);
    }

    /** @test */
    function cannot_send_enquiry_without_a_name()
    {
        $response = $this->json('POST', 'api/enquiries', $this->validParams(['name' => '']));

        $response->assertStatus(422);
        $response->assertJsonHasErrors('name');
    }

    /** @test */
    function cannot_send_enquiry_without_a_body()
    {
        $response = $this->json('POST', 'api/enquiries', $this->validParams(['body' => '']));

        $response->assertStatus(422);
        $response->assertJsonHasErrors('body');
    }

    /** @test */
    function cannot_send_enquiry_without_an_email()
    {
        $response = $this->json('POST', 'api/enquiries', $this->validParams(['email' => '']));

        $response->assertStatus(422);
        $response->assertJsonHasErrors('email');
    }

    /** @test */
    function cannot_send_enquiry_without_a_valid_email_address()
    {
        $response = $this->json('POST', 'api/enquiries', $this->validParams(['email' => 'joe-at-example-com']));

        $response->assertStatus(422);
        $response->assertJsonHasErrors('email');
    }

    private function validParams($overrides = [])
    {
        return array_merge([
            'name' => 'Joe Bloggs',
            'email' => 'joe@example.com',
            'body' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.'
        ], $overrides);
    }
}
