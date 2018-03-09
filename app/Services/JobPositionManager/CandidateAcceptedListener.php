<?php


namespace JobListing\Services\JobPositionManager;


use JobListing\Services\CandidateManager\CandidateAccepted;
use JobListing\Services\JobPositionManager;

class CandidateAcceptedListener
{
    /**
     * @var JobPositionManager
     */
    private $manager;

    public function __construct(JobPositionManager $manager) {
        $this->manager = $manager;
    }

    public function handle(CandidateAccepted $event){
        $this->manager->closePosition($event->getCandidate()->getPosition());
    }
}