@extends('layouts.app')

@section('title')
    Create User Ban
@endsection

@section('content')
    <a href="/admin/users/edit/{{$user->id}}" class="btn btn-default">Back</a>
    <h1>Ban User: {{$user->name}} (ID: {{$user->id}})</h1>

    {!! Form::open(['action' => ['AdminController@userBan', $user->id], 'method' => 'POST']) !!}
        <div class="row">
            <div class="form-group col-md-6">
                {{Form::label('reason', 'Reason')}}
                {{Form::text('reason', '', ['class' => 'form-control', 'placeholder' => 'Ban Reason'])}}
            </div>
            <div class="form-group col-md-6">
                {{Form::label('length', 'Length')}}
                {{Form::select('length', getBanLengths(), null, ['class' => 'form-control'])}}
            </div>
        </div>
        {{Form::submit('Ban', ['class' => 'btn btn-danger'])}}
    {!! Form::close() !!}
@endsection
