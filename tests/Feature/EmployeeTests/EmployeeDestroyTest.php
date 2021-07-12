<?php

namespace Tests\Feature\EmployeeTests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Employee;

class EmployeeDestroyTest extends TestCase
{
    use RefreshDatabase;


    public function setUp() :void
    {
        parent::setUp();
        $this->seed();
    }

    public function qEmp() // Quick company
    {
        $employee = Employee::factory()->make();
        $employee->save();
        return $employee;
    }

    public function test_destroy_nologin()
    {
        $emp = $this->qEmp(); // make a quick company

        $response = $this->delete("/employees/$emp->id"); // try to delete employee

        $response->assertRedirect('/login'); // expect a redirect to login
    }

    public function test_destroy_valid()
    {
        $user = User::first(); // Get admin user to use in request

        $emp = $this->qEmp(); // make a quick employee
        $this->assertDatabaseHas('employees', ['id' => $emp->id]); // check the employee got added to the database
       
        $response = $this->actingAs($user)
            ->delete("/employees/$emp->id"); // try to delete employee

        $response->assertRedirect('/employees'); // expect a redirect to main employees page
        $this->assertDatabaseMissing('employees', ['id' => $emp->id]); // check the employee got removed from the database
    }

    public function test_destroy_nonexistent()
    {
        $user = User::first(); // Get admin user to use in request

        $response = $this->actingAs($user)
            ->delete("/employees/1"); // try to delete company

        $response->assertStatus(404); // check it 404's
    }
}
