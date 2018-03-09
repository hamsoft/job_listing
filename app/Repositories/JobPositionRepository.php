<?php


namespace JobListing\Repositories;


use JobListing\Entities\Company;
use JobListing\Entities\JobPosition;

class JobPositionRepository extends Repository
{
    public function findCompanyPositions(Company $company) {
        $query = JobPosition::query();
        $query->where('company_id', $company->getId());
        return $query->get();
    }

    /**
     * @param $positionId
     * @return JobPosition
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findPosition($positionId): JobPosition {
        return JobPosition::whereId($positionId)->firstOrFail();
    }

    public function findPositionWithCandidates($positionId) {
        return JobPosition::whereId($positionId)->with('candidates')->firstOrFail();
    }

    public function getOpenPositionsWithCompanies() {
        return JobPosition::whereOpenPositions()->with('company')->get();
    }
}