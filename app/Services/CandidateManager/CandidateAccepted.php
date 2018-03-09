<?php


namespace JobListing\Services\CandidateManager;


use JobListing\Entities\Candidate;

class CandidateAccepted
{
    /**
     * @var Candidate
     */
    private $candidate;

    public function __construct(Candidate $candidate) {
        $this->candidate = $candidate;
    }

    public function getCandidate(): Candidate {
        return $this->candidate;
    }

}