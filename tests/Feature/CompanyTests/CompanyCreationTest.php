<?php

namespace Tests\Feature\CompanyTests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class CompanyCreationTests extends TestCase
{
    use refreshDatabase;

    public function setUp() :void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_create_company_page_nologin()
    {
        //send get to create page
        $response = $this->get('/companies/create');
        //check it redirects to login
        $response->assertRedirect('/login');
    }

    public function test_create_company_nologin()
    {
        //send post to company page
        $response = $this->post('/companies');
        //check it redirects to login
        $response->assertRedirect('/login');
    }

    public function test_create_justname_company()
    {
        $user = User::first(); //get admin user

        //send post as admin user to create a company
        $response = $this->actingAs($user)
                    ->post('/companies',['name' => 'exampleCompany', 'email' => '', 'website' => '']);

        // check company in database
        $this->assertDatabaseHas('companies', [
            'name' => 'exampleCompany'
        ]);
        // check redirected to company page
        $response->assertRedirect('/companies/1');
    }

    public function test_create_tooshort_company()
    {
        $user = User::first(); //get admin user

        $response = $this->actingAs($user) // send as admin
                    ->from('/companies/create') // send from create page
                    ->post('/companies',['name' => 'ex']); // send too short of a name
        // check redirectes back to the creation page
        $response->assertRedirect('/companies/create');
    }

    public function test_create_noname_company()
    {
        $user = User::first(); //get admin user

        $response = $this->actingAs($user) // send as admin
                    ->from('/companies/create') // send from create page
                    ->post('/companies',['email' => 'admin@admin.com']); // send with no name
        // check redirectes back to the creation page
        $response->assertRedirect('/companies/create');
    }

    public function test_create_invalid_email_company()
    {
        $user = User::first(); //get admin user

        $response = $this->actingAs($user) // send as admin
                    ->from('/companies/create') // send from create page
                    ->post('/companies',['name' => 'exampleTwo', 'email' => 'adminadmin.com']); // send with an invalid email
        // check redirectes back to the creation page
        $response->assertRedirect('/companies/create');
    }

    public function test_create_duplicate_company()
    {
        $user = User::first(); //get admin user

        $response = $this->actingAs($user) // send as admin
                    ->from('/companies/create') // send from create page
                    ->post('/companies',['name' => 'exampleCompany']); // send with a name
        $responsetwo = $this->actingAs($user) // send as admin
                    ->from('/companies/create') // send from create page
                    ->post('/companies',['name' => 'exampleCompany']); // send with a duplicate name
        
        $response->assertRedirect('/companies/1'); // check first company was created
        $responsetwo->assertRedirect('/companies/create'); // check it redirected due to error
    }

    public function test_create_full_company()
    {
        $user = User::first(); //get admin user

        // setup company data
        $companyData = [
                        'name' => 'exampleCompany',
                        'email' => 'email@example.com',
                        'website' => 'https://testmcteston.com',
        ];

        $response = $this->actingAs($user) // send as admin
                    ->post('/companies',$companyData); // send post to create with the company data

        // check company in database
        $this->assertDatabaseHas('companies', $companyData);
        // check redirected to company page
        $response->assertRedirect('/companies/1');
    }
}
