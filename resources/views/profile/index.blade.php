@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Profile</div>
                <div class="card-body">

                    @if(session('alert'))
                        <div class="alert alert-success" role="alert">
                            {{ session('alert') }}
                        </div>
                    @endif

                    <div class="row ">
                        <div class="col-sm-12 col-lg-6">
                            <div class="card">
                                <div class="card-header">Avatar</div>
                                <div class="card-body">

                                    {!! Form::open(['route' => 'profile.changeAvatar', 'class' => 'form-horizontal', 'files' => 'true']) !!}

                                    <div class="form-group row">
                                        {!! Form::label('avatar', 'Avatar:', ['class' => 'col-sm-4 col-form-label text-right']) !!}
                                        <div class="col-sm-8">
                                            @if ($user->avatar)
                                                <div>
                                                    <img src="{{ asset($user->avatar) }}" />
                                                    <p><a href="{{ route('profile.removeAvatar') }}">Remove avatar</a></p>
                                                </div>
                                            @endif
                                            {!! Form::file('avatar', ['class' => 'form-control-plaintext', 'accept' => 'image/*', 'required' => 'required']) !!}
                                            {!! $errors->first('avatar', '<div class="invalid-feedback">:message</div>') !!}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-12 text-right">
                                            {!! Form::submit('Change Avatar', ['class' => 'btn btn-info']) !!}
                                        </div>
                                    </div>

                                    {!! Form::close() !!}

                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-lg-6">
                            <div class="card">
                                <div class="card-header">Information</div>
                                <div class="card-body">

                                    {!! Form::model($user, ['route' => 'profile.changeProfile', 'class' => 'form-horizontal']) !!}

                                    <div class="form-group row">
                                        {!! Form::label('email', 'Email:', ['class' => 'col-sm-4 col-form-label text-right']) !!}
                                        <div class="col-sm-8">
                                            {!! Form::text('email', $user->email, ['class' => 'form-control-plaintext', 'readonly']) !!}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        {!! Form::label('name', 'Name:', ['class' => 'col-sm-4 col-form-label text-right']) !!}
                                        <div class="col-sm-8">
                                            {!! Form::text('name', $user->name, ['class' => $errors->has('name') ? 'form-control is-invalid' : 'form-control', 'required' => 'required']) !!}
                                            {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-12 text-right">
                                            {!! Form::submit('Change Information', ['class' => 'btn btn-info']) !!}
                                        </div>
                                    </div>

                                    {!! Form::close() !!}

                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row" style="padding-top: 25px">

                        <div class="col-sm-12 col-lg-6">
                            <div class="card">
                                <div class="card-header">Password</div>
                                <div class="card-body">

                                    {!! Form::open(['route' => 'profile.changePassword', 'class' => 'form-horizontal']) !!}

                                    <div class="form-group row">
                                        {!! Form::label('password', 'Password:', ['class' => 'col-sm-4 col-form-label text-right']) !!}
                                        <div class="col-sm-8">
                                            {!! Form::password('password', ['class' => $errors->has('password') ? 'form-control is-invalid' : 'form-control', 'required' => 'required']) !!}
                                            {!! $errors->first('password', '<div class="invalid-feedback">:message</div>') !!}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        {!! Form::label('password_confirmation', 'Confirm Password:', ['class' => 'col-sm-4 col-form-label text-right']) !!}
                                        <div class="col-sm-8">
                                            {!! Form::password('password_confirmation', ['class' => $errors->has('password_confirmation') ? 'form-control is-invalid' : 'form-control', 'required' => 'required']) !!}
                                            {!! $errors->first('password_confirmation', '<div class="invalid-feedback">:message</div>') !!}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-12 text-right">
                                            {!! Form::submit('Change Password', ['class' => 'btn btn-info']) !!}
                                        </div>
                                    </div>

                                    {!! Form::close() !!}

                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
