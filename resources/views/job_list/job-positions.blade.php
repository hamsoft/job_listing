@extends('main_layout')

@section('content')

    <div class="alert alert-light" role="alert">

        <form class="form-inline ">
            <input class="form-control mr-sm-2" type="text" placeholder="Search">
            <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
        </form>
    </div>
    <div>

        <table id="job_positions" class="table table-hover table-bordered table-striped  table-sm">
            <thead class="thead-dark">
            <tr>
                <th class="bg-dark" style="width: 1px" scope="col">#</th>
                <th class="bg-dark" scope="col">Company</th>
                <th class="bg-dark" scope="col">Position</th>
                <th class="bg-dark" style="width: 130px;" scope="col">Deadline</th>
                <th class="bg-dark" style="width: 1px" scope="col"></th>
            </tr>
            </thead>
            <tbody class="">

            </tbody>
        </table>

    </div>

@endsection

@section('scripts')

    <script>
        $(document).ready(function () {
            loadPositions();
        });

        @include('js_var_position_statuses')

        function loadPositions() {
            $.getJSON('{{route('api.jobList.positions')}}', function (data) {
                var table = $('#job_positions tbody');
                table.html('');
                for (var i in data) {
                    var job = data[i];
                    var row = '<tr>' +
                        '<th>' + (parseInt(i) + 1) + '</th>' +
                        '<td>' + job.company + '</td>' +
                        '<td>' + job.name + '</td>' +
                        '<td>' + job.deadline + '</td>' +
                        '<td><a href="' + job.url + '" class="btn btn-dark" >@lang('Show')<\a></td>' +
                        '</tr>';

                    table.append(row);
                }
            });
        }

    </script>

@endsection