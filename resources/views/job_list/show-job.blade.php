@extends('main_layout')

@section('content')

    <div class="container">

        <div class="row">

            <div class="col-sm-5">
                <fieldset>
                    <legend>@lang('Position')</legend>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">@lang('Name'):</label>
                        <div class="col-sm-10">
                            <input type="text" readonly="" class="form-control-plaintext"
                                   value="{{$position->getName()}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">@lang('Company'):</label>
                        <div class="col-sm-10">
                            <input type="text" readonly="" class="form-control-plaintext"
                                   value="{{$position->getCompany()->getName()}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">@lang('Deadline'):</label>
                        <div class="col-sm-10">
                            <input type="text" readonly="" class="form-control-plaintext"
                                   value="{{$position->getDeadline()->format('Y-m-d H:i')}}">
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="companyDescription">@lang('Description'):</label>
                        <textarea class="form-control" id="companyDescription" name="description"
                                  rows="3" readonly="">{{$position->getDescription()}}</textarea>
                    </div>
                </fieldset>
            </div>

            <div class="col-sm-5 offset-2 ">
                <form method="post" enctype="multipart/form-data">
                    @csrf
                    <fieldset>
                        <legend>@lang('Candidate')</legend>

                        <div class="form-group">
                            <label for="InputName">@lang('Name')</label>
                            <input class="form-control" placeholder="@lang('Your Name')" id="InputName" name="name"
                                   value="{{old('name')}}" required>
                        </div>

                        <div class="form-group">
                            <label for="InputEmail">@lang('Email')</label>
                            <input class="form-control" required placeholder="@lang('Email')" id="InputEmail"
                                   name="email"
                                   value="{{old('email')}}">
                        </div>

                        <div class="form-group">
                            <label for="InputPhone">@lang('Phone')</label>
                            <input class="form-control" placeholder="@lang('Phone')" id="InputPhone"
                                   name="phone_number"
                                   value="{{old('phone_number')}}">
                        </div>


                        <div class="form-group">
                            <label for="companyDescription">@lang('Cover Letter'):</label>
                            <textarea class="form-control" id="companyDescription" name="cover_letter"
                                      rows="3">{{old('cover_letter')}}</textarea>
                        </div>
                        @if($position->getCompany()->hasGDrive())
                        <div class="form-group">
                            <label for="inputFile">Upload CV</label>
                            <input type="file" class="form-control-file" id="inputFile" name="fileCv"
                                   aria-describedby="fileHelp" required accept=".txt, .docx, .doc, .pdf">
                        </div>
                        @endif


                        @if($position->isOpen())
                            <button type="submit" class="btn btn-primary float-right">@lang('Apply')</button>
                        @endif
                    </fieldset>
                </form>
            </div>
        </div>
    </div>

@endsection


@section('styles')

@endsection