<?php


namespace JobListing\Http\Controllers\Manage;


use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use JobListing\Contracts\CurrentCompany;
use JobListing\Contracts\CurrentUser;
use JobListing\Repositories\CompanyRepository;
use JobListing\Services\CompanyManager;
use JobListing\Services\GoogleService;

class CompanyController
{

    /**
     * @var CompanyRepository
     */
    private $repository;

    public function __construct(CompanyRepository $repository) {
        $this->repository = $repository;
    }

    public function showCompany(CurrentUser $user): Response {

        $company = $this->repository->findUserCompany($user);
        return \Response::view('manage.company', ['company' => $company]);
    }

    public function updateCompanyData(CompanyUpdateRequest $request,
                                      CompanyManager $manager,
                                      CurrentCompany $company): RedirectResponse {

        $manager->updateCompanyData($company, $request);
        $this->repository->save($company);

        return \Redirect::route('manage.company')
            ->with('status', \Lang::get('Company updated.'))
            ->with('status_success', true);

    }

    public function setupDriveAccess(GoogleService $service, CurrentCompany $company) {
        $service->setRedirectURI(route('manage.company.drive.setup'));
        $redirect = $service->createCompanyAccessToken($company, \Request::get('code'));
        if (empty($redirect)) {
            $redirect = route('manage.company');
        }
        return \Redirect::to($redirect);

    }

}