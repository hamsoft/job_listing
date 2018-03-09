@extends('main_layout')

@section('content')
    <div class="row">
        <div class="col-sm-6 offset-sm-3">
            <div class="bs-component">
                <form method="post">
                    {{ csrf_field() }}
                    <fieldset>
                        <legend>@lang('New Position')</legend>

                        <div class="form-group">
                            <label for="InputEmail">@lang('Name')</label>
                            <input class="form-control" placeholder="Enter Name"
                                   id="InputName" name="name" value="{{old('name')}}">
                            @if($errors->has('name'))
                                <small class="form-text text-danger">{{$errors->get('name')[0]}}</small>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="InputDeadline">@lang('Deadline')</label>
                            <input type="datetime-local" class="form-control" placeholder="Enter Name"
                                   id="InputDeadline" name="deadline"
                                   value="{{old('deadline')}}" required>
                            @if($errors->has('deadline'))
                                <small class="form-text text-danger">{{$errors->get('deadline')[0]}}</small>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="companyDescription">Description</label>
                            <textarea class="form-control" id="companyDescription" name="description"
                                      rows="3">{{old('description')}}</textarea>
                            @if($errors->has('description'))
                                <small class="form-text text-danger">{{$errors->get('description')[0]}}</small>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary">@lang('Create')</button>
                    </fieldset>
                </form>
            </div>
        </div>

    </div>

@endsection


@section('styles')
@endsection