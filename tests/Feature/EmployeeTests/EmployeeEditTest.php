<?php

namespace Tests\Feature\EmployeeTests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Employee;
use App\Models\Company;

class EmployeeEditTest extends TestCase
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

    public function qEmp() // Quick company
    {
        $employee = Employee::factory()->make();
        $employee->save();
        return $employee;
    }

    public function test_edit_employee_page_nologin()
    {
        $emp = $this->qEmp(); // get an employee
        //send get to create page
        $response = $this->get("/employees/$emp->id/edit");
        //check it redirects to login
        $response->assertRedirect('/login');
    }

    public function test_edit_employee_nologin()
    {
        $emp = $this->qEmp(); // get an employee
        //send post to create page
        $response = $this->patch("/employees/$emp->id");
        //check it redirects to login
        $response->assertRedirect('/login');
    }

    public function test_create_justname_employee()
    {
        $user = User::first(); //get admin user
        $emp = $this->qEmp(); // get an employee
        //send post as admin user to create a employee
        $response = $this->actingAs($user)
                    ->patch("/employees/$emp->id",['first_name' => 'john', 'last_name' => 'doe', 'email' => '', 'phone' => '']);

        // check employee in database
        $this->assertDatabaseHas('employees', [
            'first_name' => 'john',
            'last_name' => 'doe',
        ]);
        // check redirected to company page
        $response->assertRedirect("/employees/$emp->id");
    }

    public function test_create_full_employee()
    {
        $user = User::first(); //get admin user
        $emp = $this->qEmp(); // get an employee
        $com = $this->qComp(); // get a dummy company
        //send post as admin user to create a employee
        $empData = ['first_name' => 'john', 'last_name' => 'doe', 'email' => 'email@email.com', 'phone' => '11312231231', 'company_id'=>$com->id];
        $response = $this->actingAs($user)
                    ->patch("/employees/$emp->id",$empData);

        // check employee in database
        $this->assertDatabaseHas('employees', $empData);
        // check redirected to company page
        $response->assertRedirect("/employees/$emp->id");
    }
}
