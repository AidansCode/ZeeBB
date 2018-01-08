@extends('layouts.app')

@section('title')
    Edit User Group
@endsection

@section('content')
    <a href="/admin/groups/" class="btn btn-default">Back</a>
    <h1>Edit Group</h1>

    {!! Form::open(['action' => ['AdminController@groupUpdate', $group->id], 'method' => 'PUT']) !!}
        <div class="row">
            <div class="form-group col-md-6">
                {{Form::label('name', 'Name')}}
                {{Form::text('name', $group->name, ['class' => 'form-control', 'placeholder' => 'Group Name'])}}
            </div>
            <div class="form-group col-md-6">
                {{Form::label('power_level', 'Power Level')}}
                {{Form::number('power_level', $group->power_level, ['class' => 'form-control', 'placeholder' => 'Power Level', 'min' => '0'])}}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                {{Form::label('is_staff_group', 'Is Staff Group')}}
                {{Form::checkbox('is_staff_group', 1, $group->is_staff_group, ['class' => 'form-control'])}}
            </div>
            <div class="form-group col-md-6">
                {{Form::label('is_banned_group', 'Is Banned Group')}}
                {{Form::checkbox('is_banned_group', 1, $group->is_banned_group, ['class' => 'form-control'])}}
            </div>
        </div>
        {{Form::submit('Update', ['class' => 'btn btn-primary pull-left'])}}
    {!! Form::close() !!}

    {!! Form::open(['action' => ['AdminController@groupDestroy', $group->id], 'method' => 'DELETE']) !!}
        {{Form::submit('Delete', ['class' => 'btn btn-danger pull-right'])}}
    {!! Form::close() !!}
@endsection
