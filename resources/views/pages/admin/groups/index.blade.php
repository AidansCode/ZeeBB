@extends('layouts.app')

@section('title')
    Admin Panel Home
@endsection

@section('content')
    <ul class="nav nav-tabs nav-justified">
        <li role="presentation"><a href="/admin">Home</a></li>
        <li role="presentation"><a href="/admin/users">Users</a></li>
        <li role="presentation" class="active"><a href="/admin/groups">Groups</a></li>
        <li role="presentation"><a href="/admin/forums">Forums</a></li>
        <li role="presentation"><a href="/admin/settings">Settings</a></li>
    </ul>

    <a href="/admin/groups/create" class="btn btn-primary pull-right" style="margin-top: 22px;">Create Group</a>
    <h1>All Groups</h1>

    <div class="row">
        @foreach($groups as $group)
            <div class="col-md-5 @if($loop->index % 2 != 0) col-md-offset-2 @endif">
                <div class="well">
                    <a href="/admin/groups/edit/{{$group->id}}">{{$group->name}}</a> (Power Level: {{$group->power_level}})<br />
                    Staff Group: {!! $group->is_staff_group ? "<strong>YES</strong>" : "No" !!}<br />
                    Banned Group: {!! $group->is_banned_group ? "<strong>YES</strong>" : "No" !!}
                </div>
            </div>
        @endforeach
    </div>

    {{$groups->render()}}
@endsection
