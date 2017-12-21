@extends('layouts.app')

@section('title')
    Home
@endsection

@section('content')
    <ul class="breadcrumb">
        <li class="active">Home</li>
    </ul>
    @foreach($forums as $category)
        @if($category->type=='c')
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3><a href="/forums/{{$category->id}}/">{{$category->name}}</a></h3>
                            {{$category->description}}
                        </div>
                        <div class="panel-body">
                            @foreach($forums as $forum)
                                @if($forum->type== 'f' && $forum->parent_id==$category->id)
                                    <a href="/forums/{{$forum->id}}/">{{$forum->name}}</a> ({{$forum->description}})<br />
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
@endsection
