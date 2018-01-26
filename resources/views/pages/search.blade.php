@extends('layouts.app')

@section('title')
    Search User {{$type}}
@endsection

@section('content')
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><a href="/user/{{$user->id}}">Profile of {{$user->name}}</a></li>
        <li class="active">{{$type}}</li>
    </ul>

    @if(count($results) == 0)
        <h1 class="text-center">The query returned 0 results.</h1>
    @else
        <h2>{{$user->name}}'s {{$type}}</h2>
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>Timestamp</th>
                    <th>Subject</th>
                    <th>Content</th>
                </tr>
            </thead>
            <tbody>
                @foreach($results as $result)
                    <tr>
                        <td>{{Carbon\Carbon::parse($result->created_at)->format('m/d/Y g:i a')}}</td>
                        @if($type == 'Threads')
                            <td><a href="/thread/{{$result->id}}">{{$result->subject}}</a></td>
                            <td>{{formatPostContent(App\Post::find($result->first_post_id)->message)}}</td>
                        @else
                            <td><a href="/thread/{{$result->thread_id}}#post{{$result->id}}">{{$result->subject}}</a></td>
                            <td>{{formatPostContent($result->message)}}</td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    {{$results->appends(['type' => $type == 'Threads' ? 'thread' : 'post'])->render()}}
@endsection
