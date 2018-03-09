<?php


namespace JobListing\Http\Controllers\Manage;


use JobListing\Http\Controllers\Request;
use JobListing\Services\JobPositionManager\JobPositionData;

class JobPositionUpdateRequest extends Request implements JobPositionData
{

    public function getName() {
        return $this->get('name');
    }

    public function getDescription() {
        return $this->get('description');
    }

    public function getStatus() {
        return $this->get('status');
    }
}