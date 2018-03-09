var jobPositionStatuses = [];
@foreach(\JobListing\Entities\JobPosition::$statuses as $key => $status)
    jobPositionStatuses['{{$key}}'] = '{{$status}}'
@endforeach
;
