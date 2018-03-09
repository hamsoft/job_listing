<?php


namespace JobListing\Http\Controllers\JobList;


use JobListing\Entities\JobPosition;
use JobListing\Http\Controllers\Controller;
use JobListing\Repositories\JobPositionRepository;

class JobPositionController extends Controller
{
    public function getPage() {
        return \Response::view('job_list.job-positions');
    }

    public function getPositions(JobPositionRepository $repository) {
        $positions = $repository->getOpenPositionsWithCompanies();

        return \Response::json($this->mappingPositions($positions));
    }

    private function mappingPositions($positions) {
        $mappedPositions = [];
        /** @var JobPosition $position */
        foreach ($positions as $position) {
            $job = new \stdClass();
            $job->name = $position->getName();
            $job->company = $position->getCompany()->getName();
            $job->deadline = $position->getDeadline()->format('Y-m-d H:i');
            $job->url = route('jobList.position', [$position->getId()]);
            $mappedPositions[] = $job;
        }
        return $mappedPositions;
    }

    public function getPosition(JobPosition $position) {
        $position->load('company');
        return \Response::view('job_list.show-job',['position' => $position]);
    }

}