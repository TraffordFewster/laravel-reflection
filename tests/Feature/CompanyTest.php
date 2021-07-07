<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CompanyTests extends TestCase
{
    use refreshDatabase;
    /**
     * Tests if it 403's when not authed
     */
    public function test_create_company_page_nologin()
    {
        $response = $this->get('/company/create');

        $response->assertStatus(302);
    }

    public function test_create_company_nologin()
    {
        $response = $this->post('/company/create');

        $response->assertStatus(405);
    }
}
