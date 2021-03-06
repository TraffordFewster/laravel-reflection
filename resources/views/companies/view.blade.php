@extends('layouts.app')

@section('content')
    <div class="container">
        <div class='row'>
            <div class='col-2'><img decoding="async" class='w-100' loading="lazy" src="{{$company->image()}}" alt="company logo"></div>
            <div class="col-10 text-center mt-auto mb-auto">
                <h1>{{$company->name}}</h1>
                @if ($company->email)
                    <a href="mailto:{{$company->email}}">{{$company->email}}</a><br>
                @endif
                @if ($company->website)
                    <a href="{{$company->website}}">Website</a>
                @endif
            </div>
        </div>
        @if ($employees->count())
            <div class='row text-center mt-4'>
                <div class='col-12 p-0'><h3>Employees</h3></div>
                @foreach ($employees as $emp)
                    <div class='col-12 p-0'>
                        <a href="/employees/{{$emp->id}}">{{ $emp->first_name }} {{ $emp->last_name }}</a>
                    </div>
                @endforeach
                <div class="container">
                    <div class='col-12 p-0 mt-4 mx-auto d-block'>
                        {{ $employees->links('vendor.pagination.bootstrap-4') }}
                    </div>
                </div>
            </div>
        @endif
        @if (Auth::check())
            <div class='row mt-4'>
                <div class='col-8'>
                    <a class="mr-auto btn btn-primary btn-block" href="{{$company->id}}/edit" role="button">Edit</a>
                </div>
                <div class='col-4'>
                    <form class='' action="/companies/{{$company->id}}" method="POST">
                        @method('DELETE')
                        @csrf
                        <input class="btn btn-danger btn-block" type="submit" value="Delete">
                    </form>
                </div>
            </div>
        @endif
    </div>
@endsection