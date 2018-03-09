<?php


namespace JobListing\Repositories;


use JobListing\Entities\Company;
use JobListing\Entities\User;

class CompanyRepository extends Repository
{
    public function findUserCompany(User $user): Company {
        return Company::where('manager_id', '=', $user->getId())->first();
    }


}