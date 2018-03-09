@extends('main_layout')

<?php /** @var \JobListing\Entities\JobPosition $position */ ?>
@section('content')
    <div class="container">

        <div class="row">

            <div class="col-sm-5">
                <div class="bs-component">
                    <form method="post">
                        {{ csrf_field() }}
                        @method('PUT')
                        <fieldset>
                            <legend>@lang('Position')</legend>

                            <div class="form-group">
                                <label for="InputEmail">@lang('Name')</label>
                                <input class="form-control" placeholder="Enter Name"
                                       id="InputName" name="name" value="{{$position->getName()}}">
                                @if($errors->has('name'))
                                    <small class="form-text text-danger">{{$errors->get('name')[0]}}</small>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="InputDeadline">@lang('Deadline')</label>
                                <input type="datetime-local" class="form-control" placeholder="Enter Name"
                                       id="InputDeadline" name="deadline"
                                       value="{{$position->getDeadline()->format('Y-m-d\TH:i')}}">
                                @if($errors->has('deadline'))
                                    <small class="form-text text-danger">{{$errors->get('deadline')[0]}}</small>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="companyDescription">Description</label>
                                <textarea class="form-control" id="companyDescription" name="description"
                                          rows="3">{{$position->getDescription()}}</textarea>
                                @if($errors->has('description'))
                                    <small class="form-text text-danger">{{$errors->get('description')[0]}}</small>
                                @endif
                            </div>

                            @if($position->isOpen())
                                <button type="submit" class="btn btn-primary">@lang('Update')</button>
                            @endif
                        </fieldset>
                    </form>
                </div>
            </div>

            <div class="col-sm-7">
                <div>

                    <table class="table table-hover table-bordered table-striped  table-sm">
                        <thead class="thead-dark">
                        <tr>
                            <th class="bg-dark" style="width: 1px" scope="col">#</th>
                            <th class="bg-dark" scope="col">Name</th>
                            <th class="bg-dark" scope="col">Contact</th>
                            <th class="bg-dark" style="width: 10px;" scope="col">CV</th>
                            <th class="bg-dark" style="width: 1px" scope="col"></th>
                        </tr>
                        </thead>
                        <tbody class="">
                        @foreach($position->getCandidates() as $candidate)
                            <tr class="">
                                <th scope="row">1</th>
                                <td>{{$candidate->getName()}}</td>
                                <td>
                                    <a href="mailto:{{$candidate->getEmail()}}"
                                       target="_blank">{{$candidate->getEmail()}}</a><br/>
                                    <a href="tel:{{$candidate->getPhoneNumber()}}">{{$candidate->getPhoneNumber()}}</a>
                                </td>
                                @if($candidate->hasCv())
                                    <td><a href="{{$candidate->getCv()}}" target="_blank"
                                           class="btn btn-primary">Download</a>
                                    </td>
                                @else
                                    <td></td>
                                @endif
                                @if($position->isOpen())
                                    <td>
                                        <form method="post"
                                              action="{{route('manage.job-position.accept',
                                              [$position->getId(), $candidate->getId()])}}">
                                            @csrf
                                            <input type="submit" class="btn btn-dark" value="@lang('Accept')">
                                        </form>
                                    </td>
                                @elseif($candidate->isAccepted())
                                    <td><input type="button" href="#" class="btn btn-success" disabled
                                               value="@lang('Accepted')">
                                    </td>
                                @else
                                    <td></td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

@endsection


@section('styles')

@endsection