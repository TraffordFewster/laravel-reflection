<?php

namespace Tests\Feature\CompanyTests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class CompanyCreationTests extends TestCase
{
    //use refreshDatabase;
    use DatabaseMigrations;

    public function setUp() :void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_create_company_page_nologin()
    {
        //send get to create page
        $response = $this->get('/company/create');
        //check it redirects to login
        $response->assertRedirect('/login');
    }

    public function test_create_company_nologin()
    {
        //send post to company page
        $response = $this->post('/company');
        //check it redirects to login
        $response->assertRedirect('/login');
    }

    public function test_create_justname_company()
    {
        $user = User::all()->first(); //get admin user

        //send post as admin user to create a company
        $response = $this->actingAs($user)
                    ->post('/company',['name' => 'exampleCompany']);

        // check company in database
        $this->assertDatabaseHas('companies', [
            'name' => 'exampleCompany'
        ]);
        // check redirected to company page
        $response->assertRedirect('/companies/1');
    }

    public function test_create_tooshort_company()
    {
        $user = User::all()->first(); //get admin user

        $response = $this->actingAs($user) // send as admin
                    ->from('/company/create') // send from create page
                    ->post('/company',['name' => 'ex']); // send too short of a name
        // check redirectes back to the creation page
        $response->assertRedirect('/company/create');
    }

    public function test_create_noname_company()
    {
        $user = User::all()->first(); //get admin user

        $response = $this->actingAs($user) // send as admin
                    ->from('/company/create') // send from create page
                    ->post('/company',['email' => 'admin@admin.com']); // send with no name
        // check redirectes back to the creation page
        $response->assertRedirect('/company/create');
    }

    public function test_create_invalid_email_company()
    {
        $user = User::all()->first(); //get admin user

        $response = $this->actingAs($user) // send as admin
                    ->from('/company/create') // send from create page
                    ->post('/company',['name' => 'exampleTwo', 'email' => 'adminadmin.com']); // send with an invalid email
        // check redirectes back to the creation page
        $response->assertRedirect('/company/create');
    }

    public function test_create_duplicate_company()
    {
        $user = User::all()->first(); //get admin user

        $response = $this->actingAs($user) // send as admin
                    ->from('/company/create') // send from create page
                    ->post('/company',['name' => 'exampleCompany']); // send with a name
        $responsetwo = $this->actingAs($user) // send as admin
                    ->from('/company/create') // send from create page
                    ->post('/company',['name' => 'exampleCompany']); // send with a duplicate name
        
        $response->assertRedirect('/companies/1'); // check first company was created
        $responsetwo->assertRedirect('/company/create'); // check it redirected due to error
    }

    public function test_create_full_company()
    {
        $user = User::all()->first(); //get admin user

        // setup company data
        $companyData = [
                        'name' => 'exampleCompany',
                        'email' => 'email@example.com',
                        'website' => 'testmcteston.com',
        ];

        $response = $this->actingAs($user) // send as admin
                    ->post('/company',$companyData); // send post to create with the company data

        // check company in database
        $this->assertDatabaseHas('companies', $companyData);
        // check redirected to company page
        $response->assertRedirect('/companies/1');
    }
}
