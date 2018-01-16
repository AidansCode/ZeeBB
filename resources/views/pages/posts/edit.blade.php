@extends('layouts.app')

@section('title')
    Edit Post
@endsection

@section('content')
    <a href="/thread/{{$post->thread_id}}#post{{$post->id}}" class="btn btn-default">Back</a>
    <h1>Edit Post</h1>
    {!! Form::open(['action' => ['PostController@update', $post->id], 'method' => 'PUT']) !!}
        <div class="form-group">
            {{Form::label('message', 'Your Response')}}
            {{Form::textarea('message', $post->message, ['class' => 'form-control', 'id' => 'ckeditor'])}}
        </div>
        {{Form::submit('Update', ['class' => 'btn btn-primary pull-left'])}}
    {!! Form::close() !!}

    @if(Auth::user()->group->is_staff_group && $post->thread->first_post_id != $post->id)
        {!! Form::open(['action' => ['PostController@destroy', $post->id], 'method' => 'DELETE']) !!}
            {{Form::submit('Delete', ['class' => 'btn btn-danger pull-right'])}}
        {!! Form::close() !!}
    @endif
@endsection
