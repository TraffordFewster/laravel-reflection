@extends('layouts.app')

@section('content')

    <form method='POST' action="/employees">
        <div class='container'>
            <div class='row'>
            @csrf
                <div class='col-12 col-md-6'>
                    <label for="first_name">First Name</label>
                    <input name='first_name' type="text" class="form-control mb-4" id="first_name" placeholder="John" 
                    value="{{old('first_name')}}" required>
                </div>
                <div class='col-12 col-md-6'>
                    <label for="last_name">Last Name</label>
                    <input name='last_name' type="text" class="form-control mb-4" id="last_name" placeholder="Doe" 
                    value="{{old('last_name')}}" required>
                </div>
                <div class='col-12'>
                    <label for="email">Email</label>
                    <input name='email' type="email" class="form-control mb-4" id="email" placeholder="example@example.com" 
                    value="{{old('email')}}">
                </div>
                <div class='col-12'>
                    <label for="phone">Phone Number</label>
                    <input name='phone' type="text" class="form-control mb-4" id="phone" placeholder="0800 000 000" 
                    value="{{old('phone')}}">
                </div>
                <div class="col-12">
                    <select class="custom-select w-100 mb-4" aria-label="Select a company" id='company_id' name='company_id'>
                        <option value="">Choose a company!</option>
                        @foreach ($companies as $comp)
                            <option @if (old('company_id') === $comp->id)
                                selected
                            @endif value="{{$comp->id}}">{{$comp->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class='col-12'>
                    <input class="btn btn-primary btn-block" type="submit" value="Submit">
                </div>
            </div>
        </div>

    </form>

@endsection