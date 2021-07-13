@extends('layouts.app')

@section('content')
    <div class="container">
        <div class='row'>
            <div class="col-12 text-center mt-auto mb-auto">
                <h1>{{$employee->first_name}} {{$employee->last_name}}</h1>
                @if ($employee->email)
                    <a href="mailto:{{$employee->email}}">{{$employee->email}}</a><br>
                @endif
                @if ($employee->phone)
                    <a href="tel:{{$employee->phone}}">{{$employee->phone}}</a>
                @endif
            </div>
        </div>
        @if ($employee->company)
            <div class='row bg-white py-4 my-4'>
                <div class='col-12 text-center'><h2>Company</h2></div>
                <div class='col-2'><img class='w-100' src="{{$employee->company->picture ? $employee->company->picture->link : 'https://cdn.tmonkeyt.dev/i/8m6ne.png' }}" alt="company logo"></div>
                <div class="col-8 text-center mt-auto mb-auto"><h4><a href="/companies/{{$employee->company->id}}">{{$employee->company->name}}</a></h4></div>
            </div>
        @endif
        @if (Auth::check())
            <div class='row'>
                <div class='col-8'>
                    <a class="mr-auto btn btn-primary btn-block" href="{{$employee->id}}/edit" role="button">Edit</a>
                </div>
                <div class='col-4'>
                    <form class='' action="/employees/{{$employee->id}}" method="POST">
                        @method('DELETE')
                        @csrf
                        <input class="btn btn-danger btn-block" type="submit" value="Delete">
                    </form>
                </div>
            </div>
        @endif
    </div>
@endsection