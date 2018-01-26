@extends('layouts.app')

@section('title')
    Search All Posts
@endsection

@section('content')
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active">Search Posts</li>
    </ul>
    <h1>Search All Posts</h1>
    {!! Form::open(['action' => 'PageController@textSearch', 'method' => 'GET']) !!}
        <div class="form-group row">
            <div class="col-md-6">
                {{Form::label('message', 'Message')}}
                {{Form::text('message', '', ['class' => 'form-control', 'placeholder' => 'Message Content'])}}
            </div>
        </div>
        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection
