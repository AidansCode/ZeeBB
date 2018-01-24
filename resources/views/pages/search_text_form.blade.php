@extends('layouts.app')

@section('title')
    Search All Posts
@endsection

@section('content')
    <h1>Search All Posts</h1>
    {!! Form::open(['action' => 'PageController@textSearch', 'method' => 'GET']) !!}
        <div class="form-group">
            {{Form::label('message', 'Message')}}
            {{Form::text('message', '', ['class' => 'form-control', 'placeholder' => 'Message Content'])}}
        </div>
        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection
