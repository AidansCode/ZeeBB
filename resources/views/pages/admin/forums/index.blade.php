@extends('layouts.app')

@section('title')
    Admin Panel Home
@endsection

@section('content')
    <ul class="nav nav-tabs nav-justified">
        <li role="presentation"><a href="/admin">Home</a></li>
        <li role="presentation"><a href="/admin/users">Users</a></li>
        <li role="presentation"><a href="/admin/groups">Groups</a></li>
        <li role="presentation" class="active"><a href="/admin/forums">Forums</a></li>
    </ul>

    <a href="/admin/forums/create" class="btn btn-primary pull-right" style="margin-top: 22px;">Create Category/Forum</a>
    <h1>All Forums</h1>

    @foreach($categories as $category)
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3><a href="/admin/forums/edit/{{$category->id}}">{{$category->name}}</a></h3>
                    </div>
                    <div class="panel-body">
                        @foreach($forums as $forum)
                            @if($forum->parent_id == $category->id)
                                <h4><a href="/admin/forums/edit/{{$forum->id}}">{{$forum->name}}</a><br /></h4>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
