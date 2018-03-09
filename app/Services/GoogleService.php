<?php


namespace JobListing\Services;


use Illuminate\Http\UploadedFile;
use JobListing\Entities\Candidate;
use JobListing\Entities\Company;
use JobListing\Entities\JobPosition;

class GoogleService
{
    public $gClient;

    public function __construct() {
        $google_redirect_url = route('home');

        $this->gClient = new \Google_Client();
        $this->gClient->setApplicationName(env('GOOGLE_APP_NAME'));
        $this->gClient->setClientId(env('GOOGLE_CLIENT_ID'));
        $this->gClient->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $this->gClient->setRedirectUri($google_redirect_url);
        $this->gClient->setDeveloperKey(env('GOOGLE_API_KEY'));
        $this->gClient->setScopes(array(
            'https://www.googleapis.com/auth/drive.file',
            'https://www.googleapis.com/auth/drive'
        ));
        $this->gClient->setAccessType("offline");
        $this->gClient->setApprovalPrompt("force");
    }

    public function setRedirectURI($uri) {
        $this->gClient->setRedirectUri($uri);
    }

    public function createCompanyAccessToken(Company $company, $code = null) {

        $google_oauthV2 = new \Google_Service_Oauth2($this->gClient);
        if ($code) {
            $this->gClient->authenticate($code);
            session()->put('token', $this->gClient->getAccessToken());
        }

        if (session()->get('token')) {
            $this->gClient->setAccessToken(session()->get('token'));
        }

        if ($this->gClient->getAccessToken()) {

            $company->access_token = json_encode(session()->get('token'));
            $company->save();

            return '';
        }

        return $this->gClient->createAuthUrl();
    }


    public function uploadCandidateCVForJobPosition(JobPosition $position, Candidate $candidate, UploadedFile $file) {
        $service = new \Google_Service_Drive($this->gClient);
        $company = $position->getCompany();

        $this->gClient->setAccessToken(json_decode($company->access_token, true));
        if ($this->gClient->isAccessTokenExpired()) {
            $this->refrestAccessToken($company);
        }

        $fileMetadata = new \Google_Service_Drive_DriveFile(array(
            'name' => env('JobListenerCV', 'JobListenerCV'),
            'mimeType' => 'application/vnd.google-apps.folder'));
        $folder = $service->files->create($fileMetadata, array(
            'fields' => 'id'));

        $fileData = new \Google_Service_Drive_DriveFile(array(
            'name' => $this->generateName($position, $candidate, $file),
            'parents' => array($folder->id)
        ));

        $result = $service->files->create($fileData, array(
            'data' => file_get_contents($file->getRealPath()),
            'mimeType' => 'application/octet-stream',
            'uploadType' => 'media'
        ));

        return 'https://drive.google.com/open?id=' . $result->id;

    }

    private function generateName(JobPosition $position, Candidate $candidate, UploadedFile $file) {
        $fileName = $position->getId();
        $fileName .= '-';
        $fileName .= $candidate->getId();
        $fileName .= '-';
        $fileName .= str_replace(' ', '_', $candidate->getName());
        $fileName .= '.' . $file->extension();
        return $fileName;
    }

    /**
     * @param $company
     */
    private function refrestAccessToken(Company $company) {
        // save refresh token to some variable
        $refreshTokenSaved = $this->gClient->getRefreshToken();
        // update access token
        $this->gClient->fetchAccessTokenWithRefreshToken($refreshTokenSaved);
        // // pass access token to some variable
        $updatedAccessToken = $this->gClient->getAccessToken();
        // // append refresh token
        $updatedAccessToken['refresh_token'] = $refreshTokenSaved;
        //Set the new acces token
        $this->gClient->setAccessToken($updatedAccessToken);

        $company->setAccessToken(json_encode($updatedAccessToken));
        $company->save();
    }

}