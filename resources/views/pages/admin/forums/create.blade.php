@extends('layouts.app')

@section('title')
    Create New Category/Forum
@endsection

@section('content')
    <a href="/admin/forums/" class="btn btn-default">Back</a>
    <h1>Create New Category/Forum</h1>

    {!! Form::open(['action' => 'AdminController@forumStore']) !!}
        <div class="row">
            <div class="form-group col-md-6">
                {{Form::label('type', 'Type')}}
                {{Form::select('type', ['c' => 'Category', 'f' => 'Forum'], null, ['class' => 'form-control'])}}
            </div>
            <div class="form-group col-md-6">
                {{Form::label('parent_id', 'Parent ID (Leave blank if type is Category)')}}
                {{Form::select('parent_id', $categories, null, ['class' => 'form-control', 'placeholder' => ''])}}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                {{Form::label('name', 'Name')}}
                {{Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Name'])}}
            </div>
            <div class="form-group col-md-6">
                {{Form::label('description', 'Description')}}
                {{Form::text('description', '', ['class' => 'form-control', 'placeholder' => 'Description'])}}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                {{Form::label('closed', 'Closed')}}
                {{Form::checkbox('closed', 1, false, ['class' => 'form-control'])}}
            </div>
        </div>
        {{Form::submit('Create', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection