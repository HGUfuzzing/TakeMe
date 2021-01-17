<?php
require_once __DIR__ . '/../../vendor/autoload.php';

$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/eventapp/api/google_oauth2/callback.php';
$index_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/eventapp/index.php';

$client = new Google_Client();
$client->setApplicationName('php-web-login');
$client->setAuthConfig(__DIR__ . '/client_secret.json');
$client->addScope(Google_Service_Oauth2::USERINFO_PROFILE);
$client->addScope(Google_Service_Oauth2::USERINFO_EMAIL);

$google_oauthV2 = new Google_Service_Oauth2($client);
?>