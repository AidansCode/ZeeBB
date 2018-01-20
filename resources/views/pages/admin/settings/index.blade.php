@extends('layouts.app')

@section('title')
    Admin Panel Home
@endsection

@section('content')
    <ul class="nav nav-tabs nav-justified">
        <li role="presentation"><a href="/admin">Home</a></li>
        <li role="presentation"><a href="/admin/users">Users</a></li>
        <li role="presentation"><a href="/admin/groups">Groups</a></li>
        <li role="presentation"><a href="/admin/forums">Forums</a></li>
        <li role="presentation" class="active"><a href="/admin/settings">Settings</a></li>
    </ul>

    @foreach($settings as $setting)
        <div class="row" style="margin-top: 15px;">
            <div class="col-md-offset-2 col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{$setting->title}}
                        <a href="#" data-toggle="tooltip" title="{{$setting->description}}" class="pull-right">
                            <span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span>
                        </a>
                    </div>
                    <div class="panel-body">
                        {!! Form::open(['action' => ['AdminController@settingUpdate', $setting->id], 'method' => 'PUT']) !!}
                            @if($setting->type == 'textarea')
                                {{Form::textarea('value', $setting->value, ['class' => 'form-control', 'placeholder' => $setting->description])}}
                            @elseif($setting->type == 'text')
                                {{Form::text('value', $setting->value, ['class' => 'form-control', 'placeholder' => $setting->description])}}
                            @elseif($setting->type == 'number')
                                {{Form::number('value', $setting->value, ['class' => 'form-control', 'placeholder' => $setting->description, 'min' => '0'])}}
                            @endif
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('jscript')
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection
