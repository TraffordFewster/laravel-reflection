@extends('layouts.app')

@section('content')

    <form method='POST' action="/companies/{{$company->id}}">
        <div class='container'>
            @method('PATCH')
            @csrf

            <label for="name">Company Name</label>
            <input name='name' type="text" class="form-control mb-4" id="name" placeholder="SuperCompany Inc" 
            value="{{old('name') ? old('name') : $company->name}}" required>
            
            <label for="email">Company Email</label>
            <input name='email' type="email" class="form-control mb-4" id="email" placeholder="example@example.com" 
            value="{{old('email') ? old('email') : $company->email}}">
            
            <label for="website">Company Website</label>
            <input name='website' type="text" class="form-control mb-4" id="website" placeholder="https://google.com" 
            value="{{old('website') ? old('website') : $company->website}}">
            
            <input class="btn btn-primary btn-block" type="submit" value="Submit">
        </div>
    </form>
    <form method="POST" action="/companies/{{$company->id}}/image" enctype="multipart/form-data">
        @csrf
        <div class='container'>
            <div class="row">

                <div class="col-12 mt-4">
                    <h4 class='text-center'>Upload Logo</h4>
                </div>
    
                <div class="col-md-10 mt-4">
                    <input type="file" name="image" id="image" class="">
                </div>
     
                <div class="col-md-2 mt-4 w-100">
                    <button type="submit" class="btn btn-success btn-block">Upload</button>
                </div>
     
            </div>
        </div>
        
    </form>

@endsection