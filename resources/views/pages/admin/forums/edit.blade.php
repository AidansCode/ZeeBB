@extends('layouts.app')

@section('title')
    Edit Category/Forum
@endsection

@section('content')
    <a href="/admin/forums/" class="btn btn-default">Back</a>
    <h1>Edit Category/Forum</h1>

    {!! Form::open(['action' => ['AdminController@forumUpdate', $forum->id], 'method' => 'PUT']) !!}
        {{Form::hidden('type', $forum->type)}}
        @if($forum->type == 'f')
            <div class="row">
                <div class="form-group col-md-6">
                    {{Form::label('parent_id', 'Parent ID')}}
                    {{Form::select('parent_id', $categories, $forum->parent_id, ['class' => 'form-control'])}}
                </div>
            </div>
        @endif
        <div class="row">
            <div class="form-group col-md-6">
                {{Form::label('name', 'Name')}}
                {{Form::text('name', $forum->name, ['class' => 'form-control', 'placeholder' => 'Name'])}}
            </div>
            <div class="form-group col-md-6">
                {{Form::label('description', 'Description')}}
                {{Form::text('description', $forum->description, ['class' => 'form-control', 'placeholder' => 'Description'])}}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                {{Form::label('closed', 'Closed')}}
                {{Form::checkbox('closed', 1, $forum->closed, ['class' => 'form-control'])}}
            </div>
            <div class="col-md-6">
                <div class="alert alert-warning">
                    <strong>Careful!</strong> Deleting a category or forum will delete all of its children, threads, and posts!
                </div>
            </div>
        </div>
        {{Form::submit('Update', ['class' => 'btn btn-primary pull-left'])}}
    {!! Form::close() !!}

    {!! Form::open(['action' => ['AdminController@forumDestroy', $forum->id], 'method' => 'DELETE']) !!}
        {{Form::submit('Delete', ['class' => 'btn btn-danger pull-right'])}}
    {!! Form::close() !!}
@endsection
