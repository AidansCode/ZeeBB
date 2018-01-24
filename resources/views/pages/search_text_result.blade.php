@extends('layouts.app')

@section('title')
    Search All Posts
@endsection

@section('content')
    @if(count($posts) == 0)
        <h1 class="text-center">The query returned 0 results.</h1>
    @else
        <h2>Search All Posts:</h2>
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Timestamp</th>
                    <th>Subject</th>
                    <th>Content</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                    <tr>
                        <td>{!! formatUsernameLink($post->user_id) !!}</td>
                        <td>{{Carbon\Carbon::parse($post->created_at)->format('m/d/Y g:i a')}}</td>
                        <td><a href="/thread/{{$post->thread_id}}#post{{$post->id}}">{{$post->subject}}</a></td>
                        <td>{{formatPostContent($post->message)}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    {{$posts->appends(['message' => $msg])->render()}}
@endsection
