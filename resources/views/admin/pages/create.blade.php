@extends('admin.layout')

@section('title', 'Create Page')

@section('content')

    <div class="row">
        <div class="col-12 d-flex align-items-center mb-3">
            <h1>Create Page</h1>
        </div>
    </div>

    <form action="{{ route('page.store') }}" method="POST">
        {!! csrf_field() !!}

        @include('admin.pages._form-fields')

        <button class="btn btn-primary" type="submit">Save</button>
    </form>

@endsection