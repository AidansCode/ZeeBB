@extends('layouts.app')

@section('title')
    Create a Thread
@endsection

@section('content')
    <h1>
        Create a Thread
        @if(isset($default))
            <a href="/forums/{{$default}}" class="btn btn-default pull-right">Back</a>
        @endif
    </h1>
    {!! Form::open(['action' => 'ThreadController@store', 'method' => 'post']) !!}
        <div class="form-group">
            {{Form::label('forum', 'Forum ')}}
            {{Form::select('forum', $forums, isset($default) ? $default : null, ['class' => 'form-control'])}}
        </div>
        <div class="form-group">
            {{Form::label('subject', 'Subject')}}
            {{Form::text('subject', '', ['class' => 'form-control', 'placeholder' => 'Subject'])}}
        </div>
        <div class="form-group">
            {{Form::label('message', 'Message')}}
            {{Form::textarea('message', '', ['class' => 'form-control', 'placeholder' => 'Message'])}}
        </div>
        {{Form::submit('Create Post', ['class' => 'btn btn-primary', 'style' => 'margin-bottom: 15px;'])}}
    {!! Form::close() !!}
@endsection
