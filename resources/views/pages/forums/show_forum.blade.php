@extends('layouts.app')

@section('title')
    {{$forum->name}}
@endsection

@section('content')
    {!! Form::open(['action' => 'ThreadController@create', 'method' => 'GET']) !!}
        {{Form::hidden('forum', $forum->id)}}
        {{Form::submit('Create Thread', ['class' => 'btn btn-primary btn-sm pull-right'])}}
    {!! Form::close() !!}
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><a href="/forums/{{$parent->id}}/">{{$parent->name}}</a></li>
        <li class="active">{{$forum->name}}</li>
    </ul>
    @if(count($threads) > 0)
        @foreach($threads as $thread)
            <div class="well well-sm">
                <h4><a href="/thread/{{$thread->id}}/">{{$thread->subject}}</a></h4>
                Author: {{$thread->last_poster_name}}
            </div>
        @endforeach
    @else
        <h3 class="text-center">
            There are currently no threads in this forum.<br />
            Why not start one yourself?
        </h3>
    @endif
@endsection
