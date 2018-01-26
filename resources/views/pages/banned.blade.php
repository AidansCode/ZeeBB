@extends('layouts.app')

@section('title')
    Your Account is Banned
@endsection

@section('content')
    <div class="text-center">
        <h1>Your account is banned and cannot access this page.</h1>
        <h3>
            Reason: {{$ban->reason}}<br />
            Length: {{getBanLengths()[$ban->length]}}<br />
            Banned: {{$ban->created_at}}
        </h3>
    </div>
@endsection
