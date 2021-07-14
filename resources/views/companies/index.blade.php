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
            <a href='?order=name' class="btn btn-secondary">
                <input type="radio" name="options" id="option2" autocomplete="off" 
                @if (Request()->input('order') == "name")
                    checked
                @endif>Name
            </a>
        
        </div>

    </div>

    <div class="container">
        @foreach ($companies as $comp)
            <div class='col-12 p-0'>
                <img decoding="async" loading="lazy" src="{{$comp->image()}}" alt="company logo" height="60">
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