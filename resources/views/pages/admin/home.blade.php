@extends('layouts.app')

@section('title')
    Admin Panel Home
@endsection

@section('content')
    <ul class="nav nav-tabs nav-justified">
        <li role="presentation" class="active"><a href="/admin">Home</a></li>
        <li role="presentation"><a href="/admin/users">Users</a></li>
        <li role="presentation"><a href="/admin/groups">Groups</a></li>
        <li role="presentation"><a href="/admin/forums">Forums</a></li>
    </ul>

    {!! Form::open(['action' => ['AdminController@settingUpdate', $adminNotes->id], 'method' => 'PUT']) !!}
        <div class="form-group">
            {{Form::label('value', $adminNotes->title)}}
            {{Form::textarea('value', $adminNotes->value, ['class' => 'form-control', 'placeholder' => $adminNotes->description])}}
        </div>
        {{Form::submit('Save', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection
