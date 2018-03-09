<?php


namespace JobListing\Http\Controllers;

use Illuminate\Http\Request;
use JobListing\Http\Controllers\Controller;
use JobListing\Entities\User;


class GoogleController
{

    public $gClient;

    public function __construct() {
        $google_redirect_url = route('glogin');

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

    public function googleLogin(Request $request) {


        $google_oauthV2 = new \Google_Service_Oauth2($this->gClient);
        if ($request->get('code')) {
            $this->gClient->authenticate($request->get('code'));
            $request->session()->put('token', $this->gClient->getAccessToken());
        }

        if ($request->session()->get('token')) {
            $this->gClient->setAccessToken($request->session()->get('token'));
        }

        if ($this->gClient->getAccessToken()) {
            //For logged in user, get details from google using acces
            $user = User::find(1);
            $user->access_token = json_encode($request->session()->get('token'));
            $user->save();
            dd("Successfully authenticated");
        } else {
            //For Guest user, get google login url
            $authUrl = $this->gClient->createAuthUrl();

            return redirect()->to($authUrl);
        }
    }

    public function uploadFileUsingAccessToken() {
        $service = new \Google_Service_Drive($this->gClient);
        $user = User::find(1);
        $this->gClient->setAccessToken(json_decode($user->access_token, true));
        if ($this->gClient->isAccessTokenExpired()) {

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

            $user->access_token = $updatedAccessToken;
            $user->save();
        }

        $fileMetadata = new \Google_Service_Drive_DriveFile(array(
            'name' => 'ExpertPHP',
            'mimeType' => 'application/vnd.google-apps.folder'));
        $folder = $service->files->create($fileMetadata, array(
            'fields' => 'id'));
        printf("Folder ID: %s\n", $folder->id);


        $file = new \Google_Service_Drive_DriveFile(array(
            'name' => 'cdrfile.jpg',
            'parents' => array($folder->id)
        ));
        $result = $service->files->create($file, array(
            'data' => file_get_contents(public_path('images/myimage.jpg')),
            'mimeType' => 'application/octet-stream',
            'uploadType' => 'media'
        ));
        // get url of uploaded file
        $url = 'https://drive.google.com/open?id=' . $result->id;
        dd($result);

    }

}