<?php

namespace Tests\Feature\CompanyTests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Company;

class CompanyDestroyTest extends TestCase
{

    use RefreshDatabase;

    public function setUp() :void
    {
        parent::setUp();
        $this->seed();
        
    }

    public function qComp() // Quick company
    {
        $company = Company::factory()->make();
        $company->save();
        return $company;
    }


    public function test_destroy_nologin()
    {
        $company = $this->qComp(); // make a quick company

        $response = $this->delete("/companies/$company->id"); // try to delete company

        $response->assertRedirect('/login'); // expect a redirect to login
    }

    public function test_destroy_valid()
    {
        $user = User::first(); // Get admin user to use in request

        $company = $this->qComp(); // make a quick company
        $this->assertDatabaseHas('companies', ['id' => $company->id]); // check the company got added to the database
       
        $response = $this->actingAs($user)
            ->delete("/companies/$company->id"); // try to delete company

        $response->assertRedirect('/companies'); // expect a redirect to main companies page
        $this->assertDatabaseMissing('companies', ['id' => $company->id]); // check the company got removed from the database
    }

    public function test_destroy_nonexistent()
    {
        $user = User::first(); // Get admin user to use in request

        $response = $this->actingAs($user)
            ->delete("/companies/1"); // try to delete company

        $response->assertStatus(404); // check it 404's
    }

}
