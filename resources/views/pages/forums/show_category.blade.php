@extends('layouts.app')

@section('title')
    {{$category->name}}
@endsection

@section('content')
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active">{{$category->name}}</li>
    </ul>
    @foreach($forums as $forum)
        <div class="well well-sm">
            <h5 class="pull-right">
                Last Post:
                <a href="/thread/{{$forum->lastPost->thread->id}}">
                    {{$forum->lastPost->subject}}
                </a>
                by {{$forum->last_poster_name}}
            </h5>
            <h4><a href="/forums/{{$forum->id}}/">{{$forum->name}}</a></h4>
            {{$forum->description}}
        </div>
    @endforeach
@endsection
