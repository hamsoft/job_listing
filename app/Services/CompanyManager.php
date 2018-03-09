<?php


namespace JobListing\Services;


use JobListing\Entities\Company;
use JobListing\Services\CompanyManager\CompanyData;

class CompanyManager
{

    public function updateCompanyData(Company $company, CompanyData $data){
        $company->setDescription($data->getDescription());
    }

}