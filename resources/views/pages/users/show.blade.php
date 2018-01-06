@extends('layouts.app')

@section('title')
    {{$user->name}}'s Profile
@endsection

@section('content')
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active">Profile of {{$user->name}}</li>
    </ul>

    <div class="row">
        <div class="col-md-2">
            <p class="text-center">{{$user->name}}</p>
            <img class="center-block" src="http://via.placeholder.com/150x150">
        </div>
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">Summary</div>
                <div class="panel-body">
                    <p>Group: {{$user->group->name}}</p>
                    <p>Date Joined: {{ Carbon\Carbon::parse($user->created_at)->format('m/d/Y') }}</p>
                    <p>Threads: {{$user->threads()->count()}} (<a href="/search/{{$user->id}}?type=thread">All Threads</a>)</p>
                    <p>Posts: {{$user->posts()->count()}} (<a href="/search/{{$user->id}}?type=post">All Posts</a>)</p>
                </div>
            </div>
        </div>
    </div>
@endsection
