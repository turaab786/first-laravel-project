@extends('layouts.admin')

@section('content')
    <h3>Create User</h3>
    {!! Form::open(['method'=>'POST', 'action'=>'AdminUsersController@store', 'files'=>true]) !!}
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
             {!! Form::label('name','Name:') !!}
             {!! Form::text('name',null,['class'=>'form-control']) !!}
            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
             {!! Form::label('email','Email:') !!}
             {!! Form::text('email',null,['class'=>'form-control']) !!}
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('role_id') ? ' has-error' : '' }}">
            {!! Form::label('role_id','Role:') !!}
            {!! Form::select('role_id', array('' => 'Choose Options') + $roles, 0,['class'=>'form-control']) !!}
            @if ($errors->has('role_id'))
                <span class="help-block">
                    <strong>{{ $errors->first('role_id') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
             {!! Form::label('is_active','Status:') !!}
            {!! Form::select('is_active', array(1 => 'Active', 0 => 'Not active'), 0,['class'=>'form-control']) !!}
            @if ($errors->has('status'))
                <span class="help-block">
                    <strong>{{ $errors->first('status') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('photo_id') ? ' has-error' : '' }}">
             {!! Form::label('photo_id','Photo:') !!}
             {!! Form::file('photo_id',null,['class'=>'form-control']) !!}
             @if ($errors->has('photo_id'))
                  <span class="help-block">
                        <strong>{{ $errors->first('photo_id') }}</strong>
                  </span>
             @endif
        </div>
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
             {!! Form::label('password','Password:') !!}
             {!! Form::password('password',['class'=>'form-control']) !!}
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group">
             {!! Form::submit('Create User',['class'=>'btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}
@endsection