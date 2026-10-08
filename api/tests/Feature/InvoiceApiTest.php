<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_cannot_list_invoices(): void
    {
        $response = $this->getJson('/api/v1/invoices');
        $response->assertStatus(401);
    }
}
