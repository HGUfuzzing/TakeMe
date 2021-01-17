<?php

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);


//start session
session_start();

//include google api files
require_once __DIR__ . "/client_setting.php";

// LOGOUT?
if (isset($_REQUEST['logout'])) 
{
	unset($_SESSION['token']);
	$client->revokeToken();
	header('Location: ' . filter_var($index_uri, FILTER_SANITIZE_URL)); //redirect user back to page
}



// GOOGLE CALLBACK?
if (isset($_GET['code'])) 
{
	$client->authenticate($_GET['code']);
	$_SESSION['token'] = $client->getAccessToken();
	header('Location: ' . filter_var($index_uri, FILTER_SANITIZE_URL)); //redirect user back to page
    return;
}

// PAGE RELOAD?
if (isset($_SESSION['token'])) 
{
	
	$client->setAccessToken($_SESSION['token']);
	header('Location: ' . filter_var($index_uri, FILTER_SANITIZE_URL)); //redirect user back to page  
}


// LOGGED IN?
$authUrl = $client->createAuthUrl();
header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));


?>