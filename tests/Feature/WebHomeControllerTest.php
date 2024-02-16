<?php

namespace Tests\Feature;

use Tests\TestCase;

class WebHomeControllerTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function testTheApplicationReturnsSuccessfulResponse(): void
    {
        $response = $this->get(route('web.index'));

        $response->assertStatus(302);
    }
}
