<?php


namespace JobListing\Http\Controllers\Manage;


use JobListing\Entities\Candidate;
use JobListing\Entities\JobPosition;
use JobListing\Services\CandidateManager;

class CandidateController
{

    public function acceptCandidate(JobPosition $position, Candidate $candidate, CandidateManager $manager){
        $manager->acceptJobPosition($position, $candidate);
        return \Redirect::route('manage.job-position', ['positionId' => $position->getId()]);
    }

}