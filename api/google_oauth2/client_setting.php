<?php
$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/eventapp/api/google_oauth2/callback.php';
require_once '../../vendor/autoload.php';

$client = new Google_Client();
$client->setAuthConfig('client_secret.json');
$client->addScope("https://www.googleapis.com/auth/userinfo.email");
$client->addScope("https://www.googleapis.com/auth/userinfo.profile");
//$client->addScope("openid");

$client->setRedirectUri($redirect_uri);
// offline access will give you both an access and refresh token so that
// your app can refresh the access token without user interaction.
$client->setAccessType('offline');
// Using "consent" ensures that your application always receives a refresh token.
// If you are not using offline access, you can omit this.
//$client->setApprovalPrompt("consent");
$client->setIncludeGrantedScopes(true);   // incremental auth


?>