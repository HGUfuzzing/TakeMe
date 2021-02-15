<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

//include google api files
$client = new Google_Client();
$client->setApplicationName('php-web-login');
$client->setAuthConfig($_SERVER['DOCUMENT_ROOT'] . '/private/client_secret.json');
$client->addScope(Google_Service_Oauth2::USERINFO_PROFILE);
$client->addScope(Google_Service_Oauth2::USERINFO_EMAIL);

$google_oauthV2 = new Google_Service_Oauth2($client);

// LOGOUT
if (isset($_GET['logout'])) 
{
	unset($_SESSION['user_id']);
	$client->revokeToken();
	header('Location: /main'); //redirect user back to page
	return;
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

	// die(var_dump($user));
	// db에 user data 없으면 넣기.

    $sql = 'SELECT * FROM user WHERE email="'. $googleEmail. '"';
	
	$count = App::get('database')->rowCount($sql);

	// 해당 user의 data가 db에 없을 때
	if($count === 0) {
		$user = [
			'email' => $googleEmail,
			'firstname' => $googleFirstname,
			'lastname' => $googleLastname,
			'picture_url' => $googlePicture
		];

		App::get('database')->insert('user', $user);
	}
	
	//바뀐 데이터가 없는지 확인(TODO) + user id 가져오기
	$sql = ''
	. 'SELECT id FROM user WHERE email = "' . $googleEmail  . '"';

	$user_in_db = App::get('database')->selectOne('user', 'email = "' . $googleEmail . '"');
	//App::get('database')->query($sql);

	$_SESSION['user_id'] = $user_in_db->id;

	header('Location: /main'); //redirect user back to page
	return;
}


// PAGE RELOAD (이미 로그인 되어있을 때)
if (isset($_SESSION['user_id'])) 
{
	header('Location: /main'); //redirect user back to page  
	return;
}


// GOOGLE LOG-IN PAGE
$authUrl = $client->createAuthUrl();
header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));

?>