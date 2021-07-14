@extends('layouts.app')

@section('content')

    <div class="container text-center px-0">
        <div class="col-12"><h4>Order By</h4></div>
        <div class="btn-group btn-group-toggle col-12" data-toggle="buttons">
            <a href='?order=id' class="btn btn-secondary">
                <input type="radio" name="options" id="option1" autocomplete="off"
                @if (Request()->input('order') == "id" || !Request()->input('order'))
                    checked
                @endif>Id
            </a>
            <a href='?order=first_name' class="btn btn-secondary">
                <input type="radio" name="options" id="option2" autocomplete="off" 
                @if (Request()->input('order') == "first_name")
                    checked
                @endif>First Name
            </a>
            <a href='?order=last_name' class="btn btn-secondary">
                <input type="radio" name="options" id="option3" autocomplete="off"
                @if (Request()->input('order') == "last_name")
                    checked
                @endif>Last Name
            </a>
            <a href='?order=company_id' class="btn btn-secondary">
                <input type="radio" name="options" id="option3" autocomplete="off"
                @if (Request()->input('order') == "company_id")
                    checked
                @endif>Company
            </a>
        </div>

    </div>

    <div class="container text-center">
        @foreach ($employees as $emp)
            <div class='col-12 px-0 py-1 card mb-1'>
                <div class='card-body'>
                    <h3 class='card-title'><a href="/employees/{{$emp->id}}">{{ $emp->first_name }} {{ $emp->last_name }}</a></h3>
                    @if ($emp->company)
                        <h5 class='card-subtitle'><a href="/companies/{{$emp->company->id}}">{{$emp->company->name}}</a></h5>
                    @endif
                    @if ($emp->email)
                        <a class='card-link' href="mailto:{{$emp->email}}">{{$emp->email}}</a>
                    @endif
                    @if ($emp->phone)
                        <a class='card-link' href="tel:{{$emp->phone}}">{{$emp->phone}}</a>
                    @endif
                    @if (Auth::check())
                        <br><a href="/employees/{{$emp->id}}/edit" class="btn btn-primary">Edit Employee</a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    <div class="container">
        <div class='col-12 p-0 mt-4'>
            {{ $employees->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
    @if (Auth::check())
        <div class='container'>
            <div class='col-12 p-0 mt-4'>
                <a class='btn btn-success btn-block' href="/employees/create">Create</a>
            </div>
        </div>
    @endif


@endsection