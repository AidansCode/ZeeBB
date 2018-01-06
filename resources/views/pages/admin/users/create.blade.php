@extends('layouts.app')

@section('title')
    Create New User
@endsection

@section('content')
    <a href="/admin/users/" class="btn btn-default">Back</a>
    <h1>Create New User</h1>

    {!! Form::open(['action' => 'AdminController@userStore']) !!}
        <div class="row">
            <div class="form-group col-md-6">
                {{Form::label('name', 'Name')}}
                {{Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Username'])}}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                {{Form::label('email', 'Email')}}
                {{Form::text('email', '', ['class' => 'form-control', 'placeholder' => 'Email'])}}
            </div>
            <div class="form-group col-md-6">
                {{Form::label('group', 'User Group')}}
                {{Form::select('group', $groups, null, ['class' => 'form-control'])}}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                {{Form::label('password', 'Password')}}
                {{Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password'])}}
            </div>
            <div class="form-group col-md-6">
                {{Form::label('password2', 'Password (Confirm)')}}
                {{Form::password('password2', ['class' => 'form-control', 'placeholder' => 'Password'])}}
            </div>
        </div>
        {{Form::submit('Update', ['class' => 'btn btn-primary pull-left'])}}
    {!! Form::close() !!}
@endsection
