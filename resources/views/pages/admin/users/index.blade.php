@extends('layouts.app')

@section('title')
    Admin Panel Home
@endsection

@section('content')
    <ul class="nav nav-tabs nav-justified">
        <li role="presentation"><a href="/admin">Home</a></li>
        <li role="presentation" class="active"><a href="/admin/users">Users</a></li>
        <li role="presentation"><a href="/admin/groups">Groups</a></li>
        <li role="presentation"><a href="/admin/forums">Forums</a></li>
        <li role="presentation"><a href="/admin/settings">Settings</a></li>
    </ul>

    <a href="/admin/users/create" class="btn btn-primary pull-right" style="margin-top: 22px;">Create User</a>
    <h1>All Users</h1>

    <div class="row">
        @foreach($users as $user)
            <div class="col-md-5 @if($loop->index % 2 != 0) col-md-offset-2 @endif">
                <div class="well">
                    <a href="/admin/users/edit/{{$user->id}}">{{$user->name}}</a> ({{$user->group->name}})<br />
                    Email: <a href="mailto:{{$user->email}}">{{$user->email}}</a><br />
                    Registered: {{\Carbon\Carbon::parse($user->created_at)->format('m/d/Y')}}
                </div>
            </div>
        @endforeach
    </div>

    {{$users->render()}}
@endsection
