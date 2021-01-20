<?php

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

//start session
session_start();

//include google api files
require_once __DIR__ . "/client_setting.php";


// LOGOUT
if (isset($_REQUEST['logout'])) 
{
	unset($_SESSION['user_id']);
	$client->revokeToken();
	header('Location: ' . filter_var($page_url, FILTER_SANITIZE_URL)); //redirect user back to page
	die();
}



// GOOGLE CALLBACK
if (isset($_GET['code']))
{
	$client->authenticate($_GET['code']);
	$token = $client->getAccessToken();
	$client->setAccessToken($token);

	$user = $google_oauthV2->userinfo->get();

	$googleId = $user['id'];
	$googleEmail = filter_var($user['email'], FILTER_SANITIZE_EMAIL);
	$googleFirstname = filter_var($user['givenName'], FILTER_SANITIZE_SPECIAL_CHARS);
	$googleLastname = filter_var($user['family_name'], FILTER_SANITIZE_SPECIAL_CHARS);
	$googlePicture = filter_var($user['picture'], FILTER_VALIDATE_URL);

	// db에 user data 없으면 넣기.
	require_once(__DIR__ . '/../../lib/mysql_connect.php');

	$cur_data = array(
		"email" => mysqli_real_escape_string($conn, $googleEmail),
		"firstname" => mysqli_real_escape_string($conn, $googleFirstname),
		"lastname" => mysqli_real_escape_string($conn, $googleLastname),
		"picture_url" => mysqli_real_escape_string($conn, $googlePicture),
	);

	$sql = 'SELECT * FROM user WHERE email="'. $cur_data['email']. '"';
	$result = mysqli_query($conn, $sql);

	if($result === false) {
		die("select error : 관리자에게 문의하세요.");
	}


	// 해당 user의 data가 db에 없을 때
	if(mysqli_num_rows($result) === 0) {
		$sql = 'INSERT INTO user (email, firstname, lastname, picture_url) 
		VALUES("' 
		. $cur_data['email'] . '", "'
		. $cur_data['firstname'] . '", "'
		. $cur_data['lastname'] . '", "'
		. $cur_data['picture_url']. '")';
		
		$result = mysqli_query($conn, $sql);
		if($result === false) {
			die("insert error : 관리자에게 문의하세요.");
		}
	}
	
	//바뀐 데이터가 없는지 확인 + user id 가져오기
	$row = mysqli_fetch_array($result);

	$db_data = array(
		"id" => $row['id'],
		"email" => $row['email'],
		"firstname" => $row['firstname'],
		"lastname" => $row['lastname'],
		"picture_url" => $row['picture_url'],
	);
	
	$set = "";

	foreach($cur_data as $key => $val) {
		if($db_data[$key] != $val) {
			$set .= strval($key) . '=' . '"' .  strval($val) . '"' . ', ';
			$updated[$key] = $val;
		}
	}


	if(!empty($set)) {
		$set = substr($set, 0, -2);
		$sql = "UPDATE user SET ". $set . " WHERE id = " . $db_data['id'];
		$result = mysqli_query($conn, $sql);
		if($result === false) {
			die("update error!");
		}
	}

	

	$_SESSION['user_id'] = $db_data['id'];


	header('Location: ' . filter_var($page_url, FILTER_SANITIZE_URL)); //redirect user back to page
	die();
}


// PAGE RELOAD (이미 로그인 되어있을 때)
if (isset($_SESSION['user_id'])) 
{
	header('Location: ' . filter_var($page_url, FILTER_SANITIZE_URL)); //redirect user back to page  
	die();
}


// GOOGLE LOG-IN PAGE
$authUrl = $client->createAuthUrl();
header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));

?>