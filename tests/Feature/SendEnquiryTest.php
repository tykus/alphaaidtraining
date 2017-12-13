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

    private function validParams($overrides = [])
    {
        return array_merge([
            'name' => 'Joe Bloggs'
        ], $overrides);
    }
}
