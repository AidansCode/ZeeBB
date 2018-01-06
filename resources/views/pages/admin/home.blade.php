@extends('layouts.app')

@section('title')
    Admin Panel Home
@endsection

@section('content')
    <ul class="nav nav-tabs nav-justified">
        <li role="presentation" class="active"><a href="/admin">Home</a></li>
        <li role="presentation"><a href="/admin/users">Users</a></li>
        <li role="presentation"><a href="/admin/groups">Groups</a></li>
        <li role="presentation"><a href="/admin/forums">Forums</a></li>
    </ul>
@endsection
