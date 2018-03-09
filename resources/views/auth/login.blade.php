@extends('main_layout')

@section('content')

    <div class="row">
        <div class="col-sm-6 offset-sm-3">
            <div class="bs-component">
                <form method="post">
                    {{ csrf_field() }}
                    <fieldset>
                        <legend>Login</legend>
                        <div class="form-group">
                            <label for="inputEmail">Email address</label>
                            <input type="email" class="form-control" id="inputEmail"
                                   name="email" placeholder="Enter email" value="{{old('email')}}">
                            @if($errors->has('email'))
                                <small class="form-text text-danger">{{$errors->get('email')[0]}}</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="inputPassword">Password</label>
                            <input type="password" class="form-control" id="inputPassword"
                                   name="password" placeholder="Password">
                            @if($errors->has('password'))
                                <small class="form-text text-danger">{{$errors->get('password')[0]}}</small>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </fieldset>
                </form>
            </div>
        </div>

    </div>


@endsection