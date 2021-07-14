<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Company;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{

    public $validationChecks = [
        'first_name' => 'required|max:255|min:3',
        'last_name' => 'required|max:255|min:3',
        'email' => 'email|nullable',
        'phone' => 'nullable|min:10',
        'company_id' => 'nullable|exists:companies,id'
    ];

    public $validOrders = [
        'id','first_name','last_name','company_id'
    ];

    public function __construct()
    {
        $this->middleware('auth')->except(['index','show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees;
        $direction = 'asc';
        if (Request()->input('dir') == "desc"){
            $direction = 'desc';
        }
        if (!Request()->input('order')){
            $employees = Employee::orderBy('id',$direction)->paginate(10);
        } else {
            if (!in_array(Request()->input('order'), $this->validOrders))
            {
                return redirect('/employees');
            }
            $employees = Employee::orderBy(Request()->input('order'),$direction)->paginate(10);
        };
        $employees->appends(request()->query());
        return view('employees.index',compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::all('id','name');
        return view('employees.create',compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->validationChecks);
        $newEmployee = Employee::create($validated);
        session()->flash('success', 'Company Created!');
        return redirect("/employees/$newEmployee->id");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        return view('employees.view', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        $companies = Company::all('id','name');
        return view('employees.edit',compact('employee','companies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate($this->validationChecks);
        $employee->update($validated);
        session()->flash('success', 'Edit successful!');
        return redirect("/employees/$employee->id");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        session()->flash('success', 'Employee Deleted!');
        return redirect("/employees");
    }
}
