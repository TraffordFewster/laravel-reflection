@extends('layouts.app')

@section('content')

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