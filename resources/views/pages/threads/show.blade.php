@extends('layouts.app')

@section('title')
    {{$thread->subject}}
@endsection

@section('content')
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><a href="/forums/{{$category->id}}">{{$category->name}}</a></li>
        <li><a href="/forums/{{$forum->id}}">{{$forum->name}}</a></li>
        <li class="active">{{$thread->subject}}</li>
    </ul>
    @foreach($posts as $post)
        <div class="well well-sm">
            <p style="padding-left: 15px;">{{$post->subject}}</p>
            <hr>
            <div class="row" style="min-height: 128px">
                <div class="col-md-1" style="height: 100%; border-right: 2px solid #EEEEEE">
                    <p class="text-center">{{$post->user->name}}</p>
                </div>
                <div class="col-md-11" style="height: 100%;">
                    <p>{!!nl2br($post->message)!!}</p>
                </div>
            </div>
        </div>
    @endforeach
    <hr>
    {!! Form::open(['action' => 'PostController@store', 'method' => 'POST']) !!}
        <div class="form-group">
            {{Form::label('message', 'Your Response')}}
            {{Form::textarea('message', '', ['class' => 'form-control'])}}
        </div>
        {{Form::hidden('thread', $thread->id)}}
        <div class="pull-right">
            {{Form::submit('Submit', ['class' => 'btn btn-primary', 'style' => 'margin-bottom: 15px; margin-right: 15px;'])}}
            <a href="#" class="btn btn-default pull-right">Preview</a>
        </div>
    {!! Form::close() !!}
    {{$posts->render()}}
@endsection
