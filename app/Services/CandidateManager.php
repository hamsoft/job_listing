<?php


namespace JobListing\Services;


use JobListing\Contracts\CurrentCompany;
use JobListing\Entities\Candidate;
use JobListing\Entities\JobPosition;
use JobListing\Repositories\CandidateRepository;
use JobListing\Services\CandidateManager\CandidateAccepted;
use JobListing\Services\CandidateManager\NewCandidateData;

class CandidateManager
{
    /**
     * @var CandidateRepository
     */
    private $repository;

    public function __construct(CandidateRepository $repository) {
        $this->repository = $repository;
    }

    public function acceptJobPosition(JobPosition $position, Candidate $candidate) {
        $this->checkIncomingData($position, $candidate);
        $candidate->acceptToPosition();
        $this->repository->save($candidate);

        event(new CandidateAccepted($candidate));
    }

    public function apply(JobPosition $position, NewCandidateData $data) {
        try {
            \DB::beginTransaction();

            $candidate = $this->createCandidate($position, $data);
            if($position->getCompany()->hasGDrive()){
                $this->saveCV($position, $data, $candidate);
            }
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
    }

    /**
     * @param JobPosition $position
     * @param NewCandidateData $data
     * @param $candidate
     */
    private function saveCV(JobPosition $position, NewCandidateData $data, Candidate $candidate) {
        /** @var GoogleService $googleService */
        $googleService = \App::make(GoogleService::class);

        $cv = $googleService->uploadCandidateCVForJobPosition($position, $candidate, $data->getCv());
        $candidate->setCv($cv);
        $this->repository->save($candidate);
    }

    /**
     * @param JobPosition $position
     * @param NewCandidateData $data
     * @return Candidate
     */
    private function createCandidate(JobPosition $position, NewCandidateData $data): Candidate {
        $candidate = new Candidate($data->getCandidateData());
        $candidate->setPosition($position);
        $this->repository->save($candidate);
        return $candidate;
    }

    /**
     * @param JobPosition $position
     * @param Candidate $candidate
     */
    private function checkIncomingData(JobPosition $position, Candidate $candidate) {
        if ($position->getCompanyId() !== \App::make(CurrentCompany::class)->getId()) {
            throw new \RuntimeException(\Lang::get('Position not exists.'));
        }

        if ($candidate->gerJobPositionId() !== $position->getId()) {
            throw new \RuntimeException(\Lang::get('Candidate is not apply to this position.'));
        }

        if (!$position->isOpen()) {
            throw new \RuntimeException('Position isn\'t open');
        }
    }


}