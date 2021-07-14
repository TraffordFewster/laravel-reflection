<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{

    public $validationChecks = [
        'name' => 'required|max:255|min:3',
        'email' => 'email|nullable',
        'website' => 'max:255|url|nullable'
    ];

    public $validOrders = [
        'id','name','updated_at'
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
        $companies;
        $direction = 'asc';
        if (Request()->input('dir') == "desc"){
            $direction = 'desc';
        }
        if (!Request()->input('order')){
            $companies = Company::orderBy('id',$direction)->paginate(10);
        } else {
            if (!in_array(Request()->input('order'), $this->validOrders))
            {
                return redirect('/companies');
            }
            $companies = Company::orderBy(Request()->input('order'),$direction)->paginate(10);
        };
        $companies->appends(request()->query());
        return view('companies.index',compact('companies'));
        // $companies = Company::orderBy('name')->paginate(10);
        // return view('companies.index',compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('companies.create');
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
        $newCompany = Company::create($validated);
        session()->flash('success', 'Company Created!');
        return redirect("/companies/$newCompany->id");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        // $employees = $company->employees->paginate(10);
        $employees = Employee::where('company_id',$company->id)->paginate(10);
        return view('companies.view', compact('company','employees'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        return view('companies.edit',compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $validated = $request->validate($this->validationChecks);
        $company->update($validated);
        session()->flash('success', 'Changes saved!');
        return redirect("/companies/$company->id");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $company->delete();
        session()->flash('success', 'Company was deleted!');
        return redirect("/companies");
    }
}
