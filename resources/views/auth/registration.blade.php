@extends('main_layout')

@section('content')

    <div class="row">
        <div class="col-sm-6 offset-sm-3">
            <div class="bs-component">
                <form method="post">
                    <fieldset>
                        <legend>@lang('Sign Up')</legend>
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="InputEmail">@lang('Name')</label>
                            <input class="form-control" placeholder="Enter Name"
                                   id="InputName" name="name" value="{{old('name')}}">
                            @if($errors->has('name'))
                                <small class="form-text text-danger">{{$errors->get('name')[0]}}</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="InputEmail">@lang('Email address')</label>
                            <input type="email" class="form-control" placeholder="Enter email"
                                   id="InputEmail" name="email" value="{{old('email')}}">
                            @if($errors->has('email'))
                                <small class="form-text text-danger">{{$errors->get('email')[0]}}</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="InputPassword1">@lang('Password')</label>
                            <input type="password" class="form-control" placeholder="Password"
                                   id="InputPassword1" name="password">
                            @if($errors->has('password'))
                                <small class="form-text text-danger">{{$errors->get('password')[0]}}</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="InputPassword2">@lang('Confirm Password')</label>
                            <input type="password" class="form-control" id="InputPassword2"
                                   placeholder="Password" name="password_confirmation">
                        </div>
                        <div class="form-group">
                            <label for="InputCompany">@lang('Company Name')</label>
                            <input class="form-control" placeholder="Enter Company Name"
                                   id="InputCompany" name="company">
                            <small class="form-text text-danger"></small>
                        </div>

                        <button type="submit" class="btn btn-primary">@lang('Submit')</button>
                    </fieldset>
                </form>
            </div>
        </div>

    </div>

@endsection