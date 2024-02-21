<?php

namespace Tests\Feature;

use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class WebHomeControllerTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function testTheApplicationReturnsSuccessfulResponse(): void
    {
        $response = $this->get('/');

        $response->assertStatus(Response::HTTP_OK);
    }
}
