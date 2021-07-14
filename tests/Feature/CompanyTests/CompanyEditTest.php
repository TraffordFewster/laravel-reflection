<?php

namespace Tests\Feature\CompanyTests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Company;

class CompanyEditTest extends TestCase
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

    public function test_edit_company_page_nologin()
    {
        // Create a company and assign it to the $company var
        $company = $this->qComp();
        // Send a get request to the page where you would edit it
        $response = $this->get("/companies/$company->id/edit");
        // Expect it to redirect to the login page as your not logged in
        $response->assertRedirect('/login');
    }

    public function test_edit_company_nologin()
    {
        // Create a company and assign it to the $company var.
        $company = $this->qComp();
        // Send a patch that would edit the post.
        $response = $this->patch("/companies/$company->id/");
        // Expect a redirect as your not allowed without being logged in.
        $response->assertRedirect('/login');
    }

    public function test_edit_valid()
    {
        // Create a company and assign it to the $company var.
        $company = $this->qComp();

        $user = User::first(); // Get admin user to use in request

        $companyData = ['name' => 'editTitle', 'email' => 'email@email.com', 'website'=>'http://website.com'];

        $response = $this->actingAs($user) // send as admin
            ->from("/companies/$company->id/edit") // send from edit page
            ->patch("/companies/$company->id/",$companyData); // send patch request with data defined above
        
        $this->assertDatabaseHas('companies', $companyData); // check data was changed in database
    }

    public function test_edit_nameonly_valid()
    {
        // Create a company and assign it to the $company var.
        $company = $this->qComp();

        $user = User::first(); // Get admin user to use in request

        $companyData = ['name' => 'editTitle', 'email' => null, 'website'=>null];

        $response = $this->actingAs($user) // send as admin
            ->from("/companies/$company->id/edit") // send from edit page
            ->patch("/companies/$company->id/",$companyData); // send patch request with data defined above
        
        $this->assertDatabaseHas('companies', $companyData); // check data was changed in database
    }

    public function test_edit_short_name()
    {
        // Create a company and assign it to the $company var.
        $company = $this->qComp();

        $user = User::first(); // Get admin user to use in request

        $companyData = ['name' => 'ed', 'email' => 'email@email.com', 'website'=>'http://website.com'];

        $response = $this->actingAs($user) // send as admin
            ->from("/companies/$company->id/edit") // send from edit page
            ->patch("/companies/$company->id/",$companyData); // send patch request with data defined above
        
        $response->assertRedirect("/companies/$company->id/edit"); // check its redirecting back on invalid data
    }

    public function test_edit_invalid_email()
    {
        // Create a company and assign it to the $company var.
        $company = $this->qComp();

        $user = User::first(); // Get admin user to use in request

        $companyData = ['name' => 'editTitle', 'email' => 'emailemail.com', 'website'=>'http://website.com'];

        $response = $this->actingAs($user) // send as admin
            ->from("/companies/$company->id/edit") // send from edit page
            ->patch("/companies/$company->id/",$companyData); // send patch request with data defined above
        
        $response->assertRedirect("/companies/$company->id/edit"); // check its redirecting back on invalid data
    }

    public function test_edit_invalid_website()
    {
        // Create a company and assign it to the $company var.
        $company = $this->qComp();

        $user = User::first(); // Get admin user to use in request

        $companyData = ['name' => 'editTitle', 'email' => 'email@email.com', 'website'=>'websitecom'];

        $response = $this->actingAs($user) // send as admin
            ->from("/companies/$company->id/edit") // send from edit page
            ->patch("/companies/$company->id/",$companyData); // send patch request with data defined above
        
        $response->assertRedirect("/companies/$company->id/edit"); // check its redirecting back on invalid data
    }

    public function test_edit_nonexistent()
    {

        $user = User::first(); // Get admin user to use in request

        $companyData = ['name' => 'editTitle', 'email' => 'email@email.com', 'website'=>'websitecom'];

        $response = $this->actingAs($user) // send as admin
            ->from("/companies/1/edit") // send from edit page
            ->patch("/companies/1/",$companyData); // send patch request with data defined above
        
        $response->assertStatus(404); // check it doesn't exist
    }

    public function test_edit_page_nonexistent()
    {

        $user = User::first(); // Get admin user to use in request

        $response = $this->actingAs($user) // send as admin
            ->get("/companies/1/edit"); // send patch request with data defined above
        
        $response->assertStatus(404); // check it doesn't exist
    }

    
}
