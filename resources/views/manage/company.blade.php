@extends('main_layout')
<?php /** @var \JobListing\Entities\Company $company */ ?>
@section('content')
    <div class="row">
        <div class="col-sm-6 offset-sm-3">
            <div class="bs-component">
                <form method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="PUT">
                    <fieldset>
                        <legend>Company</legend>

                        <div class="form-group row">
                            <label for="companyName" class="col-sm-2 col-form-label">@lang('Name'):</label>
                            <div class="col-sm-10">
                                <input readonly="" class="form-control-plaintext" id="companyName"
                                       value="{{$company->getName()}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="companyDescription">Description</label>
                            <textarea class="form-control" id="companyDescription" name="description"
                                      rows="3">{{$company->getDescription()}}</textarea>
                        </div>

                        <a href="{{route('manage.company.drive.setup')}}" class="btn btn-primary">Google Access</a>

                        <button type="submit" class="btn btn-primary">@lang('Update')</button>
                    </fieldset>
                </form>
            </div>
        </div>

    </div>

@endsection


@section('styles')
@endsection

@section('scripts')
    <script>
        @if (session('status_success'))
            notifySuccess('{{ session('status') }}');
        @endif
        @if (session('status_error'))
            notifyError('{{ session('status') }}');
        @endif

    </script>
@endsection