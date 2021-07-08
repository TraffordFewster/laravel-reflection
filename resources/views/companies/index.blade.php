@extends('layouts.app')

@section('content')

    <div class="container">
        @foreach ($companies as $comp)
            <div class='col-12 p-0'>
                <img src="{{$comp->picture ? $comp->picture->link : 'https://cdn.tmonkeyt.dev/i/8m6ne.png' }}" alt="company logo" height="60">
                <a href="/companies/{{$comp->id}}"> {{ $comp->name }} </a>
            </div>
        @endforeach
    </div>
    <div class="container">
        <div class='col-12 p-0 mt-4'>
            {{ $companies->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
    @if (Auth::check())
        <div class='container'>
            <div class='col-12 p-0 mt-4'>
                <a class='btn btn-primary btn-block' href="/companies/create">Create</a>
            </div>
        </div>
    @endif


@endsection