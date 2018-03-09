<?php


namespace JobListing\Http\Controllers;


use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{

    public function authorize() {
        return true;
    }

    public function rules() {
        return [];
    }

}