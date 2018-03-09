<?php


namespace JobListing\Http\Controllers\JobList;


use JobListing\Entities\JobPosition;
use JobListing\Services\CandidateManager;

class CandidateController
{

    public function apply(CandidateApplyRequest $request, JobPosition $position, CandidateManager $manager) {
        if (!$position->isOpen()) {
            throw new \RuntimeException('Position is closed.');
        }

        $manager->apply($position, $request);
        return \Redirect::route('home')
            ->with('status_success',true)
            ->with('Application submitted.');

    }

}