<?php


namespace JobListing\Http\Controllers\JobList;


use JobListing\Http\Controllers\Request;
use JobListing\Services\CandidateManager\NewCandidateData;

class CandidateApplyRequest extends Request implements NewCandidateData
{

    public function getCandidateData() {
        return $this->all(['name', 'email', 'phone_number', 'cover_letter']);
    }

    public function getCv() {
        return $this->file('fileCv');
    }
}