@extends('layouts.app')

@section('title')
    Create New Group
@endsection

@section('content')
    <a href="/admin/groups/" class="btn btn-default">Back</a>
    <h1>Create New Group</h1>

    {!! Form::open(['action' => 'AdminController@groupStore']) !!}
        <div class="row">
            <div class="form-group col-md-6">
                {{Form::label('name', 'Name')}}
                {{Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Group Name'])}}
            </div>
            <div class="form-group col-md-6">
                {{Form::label('power_level', 'Power Level')}}
                {{Form::number('power_level', null, ['class' => 'form-control', 'placeholder' => 'Power Level', 'min' => '0'])}}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                {{Form::label('is_staff_group', 'Is Staff Group')}}
                {{Form::checkbox('is_staff_group', 1, false, ['class' => 'form-control'])}}
            </div>
            <div class="form-group col-md-6">
                {{Form::label('is_banned_group', 'Is Banned Group')}}
                {{Form::checkbox('is_banned_group', 1, false, ['class' => 'form-control'])}}
            </div>
        </div>
        {{Form::submit('Create', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection
