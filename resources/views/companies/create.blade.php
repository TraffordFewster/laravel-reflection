@extends('layouts.app')

@section('content')

    <form method='POST' action="/companies">
        <div class='container'>
            @csrf

            <label for="name">Company Name</label>
            <input name='name' type="text" class="form-control mb-4" id="name" placeholder="SuperCompany Inc" 
            value="{{old('name')}}" required>
            
            <label for="email">Company Email</label>
            <input name='email' type="email" class="form-control mb-4" id="email" placeholder="example@example.com" 
            value="{{old('email')}}">
            
            <label for="website">Company Website</label>
            <input name='website' type="text" class="form-control mb-4" id="website" placeholder="https://google.com" 
            value="{{old('website')}}">
            
            <input class="btn btn-primary btn-block" type="submit" value="Submit">
        </div>

    </form>

@endsection