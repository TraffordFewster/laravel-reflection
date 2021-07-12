<?php

namespace Tests\Feature\EmployeeTests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class EmployeeCreationTest extends TestCase
{
    use RefreshDatabase;


    public function setUp() :void
    {
        parent::setUp();
        $this->seed();
    }
    
    public function test_create_employee_page_nologin()
    {
        //send get to create page
        $response = $this->get('/employees/create');
        //check it redirects to login
        $response->assertRedirect('/login');
    }

    public function test_create_employee_nologin()
    {
        //send post to create page
        $response = $this->post('/employees');
        //check it redirects to login
        $response->assertRedirect('/login');
    }

    public function test_create_justname_employee()
    {
        $user = User::first(); //get admin user

        //send post as admin user to create a employee
        $response = $this->actingAs($user)
                    ->post('/employees',['first_name' => 'john', 'last_name' => 'doe', 'email' => '', 'phone' => '']);

        // check employee in database
        $this->assertDatabaseHas('employees', [
            'first_name' => 'john',
            'last_name' => 'doe',
        ]);
        // check redirected to company page
        $response->assertRedirect('/employees/1');
    }

    public function test_create_full_employee()
    {
        $user = User::first(); //get admin user
        //send post as admin user to create a employee
        $empData = [
            'first_name' => 'first_name',
            'last_name' => 'last_name',
            'email' => 'email@email.com',
            'phone' => '01632 960653',
        ];
        $response = $this->actingAs($user)
                    ->post('/employees',$empData);

        // check employee in database
        $response->assertRedirect('/employees/1');
        $this->assertDatabaseHas('employees', $empData);
        // check redirected to company page
        $response->assertRedirect('/employees/1');
    }

    public function test_create_tooshort_firstname_user()
    {
        $user = User::first(); //get admin user
        $empData = [
            'first_name' => 'fi',
            'last_name' => 'last_name',
            'email' => 'email@email.com',
            'phone' => '01632 960653',
        ];
        $response = $this->actingAs($user) // send as admin
                    ->from('/employees/create') // send from create page
                    ->post('/employees',$empData); // send too short of a name
        // check redirectes back to the creation page
        $response->assertRedirect('/employees/create');
    }

    public function test_create_no_lastname_user()
    {
        $user = User::first(); //get admin user
        $empData = [
            'first_name' => 'first',
            'last_name' => '',
            'email' => 'email@email.com',
            'phone' => '01632 960653',
        ];
        $response = $this->actingAs($user) // send as admin
                    ->from('/employees/create') // send from create page
                    ->post('/employees',$empData); // send too short of a name
        // check redirectes back to the creation page
        $response->assertRedirect('/employees/create');
    }

    public function test_create_invalid_email_user()
    {
        $user = User::first(); //get admin user
        $empData = [
            'first_name' => 'first',
            'last_name' => 'last',
            'email' => 'emailemailcom',
            'phone' => '01632 960653',
        ];
        $response = $this->actingAs($user) // send as admin
                    ->from('/employees/create') // send from create page
                    ->post('/employees',$empData); // send too short of a name
        // check redirectes back to the creation page
        $response->assertRedirect('/employees/create');
    }
}
