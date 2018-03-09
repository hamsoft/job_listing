<?php


namespace JobListing\Http\Controllers\Manage;


use JobListing\Entities\Candidate;
use JobListing\Entities\JobPosition;
use JobListing\Repositories\JobPositionRepository;
use JobListing\Services\JobPositionManager;

class JobPositionController
{
    /**
     * @var JobPositionRepository
     */
    private $repository;

    public function __construct(JobPositionRepository $repository) {
        $this->repository = $repository;
    }

    public function showFormForNewPosition() {
        return \Response::view('manage.new-job-position');
    }

    public function createNewJobPosition(JobPositionNewRequest $request, JobPositionManager $manager) {
        $jobPosition = $manager->createJobPosition($request->all());
        return \Redirect::route('manage.job-position', ['positionId' => $jobPosition->getId()]);
    }

    public function showJobPositions() {
        return \Response::view('manage.job-positions');
    }

    public function getJobPositions(JobPositionManager $manager) {
        $positions = $manager->getCompanyPositions();
        return \Response::json($this->mappingJobPositions($positions));
    }

    public function showJobPosition($positionId, JobPositionManager $manager) {
        $position = $manager->getCompanyPositionWithCandidates($positionId);
        return \Response::view('manage.job-position', ['position' => $position]);
    }

    public function updateJobPosition($positionId, JobPositionManager $manager, JobPositionUpdateRequest $request) {
        $position = $manager->getCompanyPosition($positionId);
        $manager->updateCompanyPosition($position, $request);
        return \Response::view('manage.job-position', ['position' => $position]);
    }

    private function mappingJobPositions($positions) {
        $mappedPositions = [];
        /** @var JobPosition $position */
        foreach ($positions as $position) {
            $job = new \stdClass();
            $job->name = $position->getName();
            $job->status = $position->getStatus();
            $job->deadline = $position->getDeadline()->format('Y-m-d H:i');
            $job->url = route('manage.job-position', ['id' => $position->getId()]);
            $mappedPositions[] = $job;
        }
        return $mappedPositions;
    }
}