<?php


namespace JobListing\Services;


use JobListing\Contracts\CurrentCompany;
use JobListing\Contracts\CurrentUser;
use JobListing\Entities\Candidate;
use JobListing\Entities\JobPosition;
use JobListing\Exceptions\JobPositionNotFound;
use JobListing\Repositories\JobPositionRepository;
use JobListing\Services\JobPositionManager\JobPositionData;

class JobPositionManager
{
    /**
     * @var JobPositionRepository
     */
    private $repository;
    /**
     * @var CurrentCompany
     */
    private $company;
    /**
     * @var CurrentUser
     */
    private $user;

    public function __construct(JobPositionRepository $repository, CurrentCompany $company, CurrentUser $user) {
        $this->repository = $repository;
        $this->company = $company;
        $this->user = $user;
    }

    public function createJobPosition(array $data) {
        $jobPosition = new JobPosition($data);
        $jobPosition->setManager($this->user);
        $jobPosition->setCompany($this->company);
        $jobPosition->setStatusOpen();
        $this->repository->save($jobPosition);
        return $jobPosition;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|JobPosition[]
     */
    public function getCompanyPositions() {
        return $this->repository->findCompanyPositions($this->company);
    }

    /**
     * @param $positionId
     * @return JobPosition
     * @throws \JobListing\Exceptions\JobPositionNotFound
     */
    public function getCompanyPosition($positionId): JobPosition {
        try {
            $position = $this->repository->findPosition($positionId);
            if ($position->getCompanyId() === $this->company->getId()) {
                return $position;
            }
        } catch (\RuntimeException $e) {
        }
        throw new JobPositionNotFound();
    }

    public function updateCompanyPosition(JobPosition $position, JobPositionData $data) {
        $position->setName($data->getName());
        $position->setDescription($data->getDescription());
        $this->repository->save($position);
    }

    public function getCompanyPositionWithCandidates($positionId) {
        try {
            $position = $this->repository->findPositionWithCandidates($positionId);
            if ($position->getCompanyId() === $this->company->getId()) {
                return $position;
            }
        } catch (\RuntimeException $e) {
        }
        throw new JobPositionNotFound();
    }

    public function closePosition(JobPosition $position) {
        $position->setStatusDone();
        $this->repository->save($position);
    }

}