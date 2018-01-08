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
                @if($forum->last_post_id != 0)
                    Last Post:
                    <a href="/thread/{{$forum->lastPost->thread->id}}#post{{$forum->last_post_id}}">
                        {{$forum->lastPost->subject}}
                    </a>
                    by {!! formatUsernameLink($forum->last_poster_id) !!}
                @else
                    No Posts
                @endif
            </h5>
            <h4><a href="/forums/{{$forum->id}}/">{{$forum->name}}</a></h4>
            {{$forum->description}}
        </div>
    @endforeach
@endsection
