<?php


namespace JobListing\Http\Controllers\JobList;


use Illuminate\Validation\Rule;
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

    public function rules() {
        $rules = parent::rules();
        $rules['email'] = Rule::unique('candidates')->where(function ($q) {
            $position = $this->route('position');
            $q->where('email', '=', $this->get('email'));
            $q->where('job_position_id', $position->getId());
        });
        $rules['fileCv'] = 'mimes:pdf,txt,docx,doc';
        return $rules;
    }

}