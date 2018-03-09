<?php


namespace JobListing\Http\Controllers\Manage;



use JobListing\Http\Controllers\Request;
use JobListing\Services\CompanyManager\CompanyData;

class CompanyUpdateRequest extends Request implements CompanyData
{

    public function getDescription(): string {
        return $this->get('description')?? '';
    }

}