@extends('layouts.admin')

@section('content')
    <h3>Update User</h3>
    <div class="col-sm-3">
        <img src="{{ ($user->photo) ? $user->photo->file : "/images/400x400.png" }}" alt="No image found" class="img-responsive img-rounded">
    </div>
    <div class="col-sm-9">
        {!! Form::model($user,['method'=>'PATCH', 'action'=>['AdminUsersController@update',$user->id], 'files'=>true]) !!}
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
            {!! Form::select('role_id', $roles, null,['class'=>'form-control']) !!}
            @if ($errors->has('role_id'))
                <span class="help-block">
                        <strong>{{ $errors->first('role_id') }}</strong>
                    </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('is_active') ? ' has-error' : '' }}">
            {!! Form::label('is_active','Status:') !!}
            {!! Form::select('is_active', array(1 => 'Active', 0 => 'Not active'), null,['class'=>'form-control']) !!}
            @if ($errors->has('is_active'))
                <span class="help-block">
                        <strong>{{ $errors->first('is_active') }}</strong>
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
    </div>
@endsection