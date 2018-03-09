<?php


namespace JobListing\Repositories;


use Illuminate\Database\Eloquent\Model;

abstract class Repository
{

    public function save(Model $company) {
        $company->save();
    }
}