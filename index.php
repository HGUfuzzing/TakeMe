<?php
require_once __DIR__ . "/api/google_oauth2/client_setting.php";


session_start();

if(!isset($_SESSION['token'])) {
    header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}
$access_token = $_SESSION['token'];
$client->setAccessToken($access_token);

if($client->isAccessTokenExpired()){
    unset($_SESSION['token']);
    $client->revokeToken();
    header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}

$user = $google_oauthV2->userinfo->get();

$googleId = $user['id'];
$googleEmail = filter_var($user['email'], FILTER_SANITIZE_EMAIL);
$googleFirstName = filter_var($user['givenName'], FILTER_SANITIZE_SPECIAL_CHARS);
$googleLastName = filter_var($user['family_name'], FILTER_SANITIZE_SPECIAL_CHARS);
$googlePicture = filter_var($user['picture'], FILTER_VALIDATE_URL);
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>로그인 성공</title>
</head>
<body>

    <p>성 : <?=$googleLastName?></p>
    <p>이름 : <?=$googleFirstName?></p>
    <p>이메일 : <?=$googleEmail?></p>
    <p>사진 : <img src="<?=$googlePicture?>" alt="프로필 사진"></p>
    <p>ID : <?=$googleId?></p>
    <?php
    echo '<br /><a class="logout" href="'. $redirect_uri . '?logout=1">Logout</a>';
    ?>
</body>
</html>
