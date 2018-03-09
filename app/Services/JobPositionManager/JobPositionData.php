<?php


namespace JobListing\Services\JobPositionManager;


interface JobPositionData
{

    public function getName();

    public function getDescription();

    public function getStatus();
}