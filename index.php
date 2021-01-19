<?php
require_once __DIR__ . "/api/google_oauth2/client_setting.php";


session_start();

if(!isset($_SESSION['token'])) {
    header('Location: ' . filter_var($callback_uri, FILTER_SANITIZE_URL));
}
$access_token = $_SESSION['token'];
$client->setAccessToken($access_token);

if($client->isAccessTokenExpired()){
    unset($_SESSION['token']);
    $client->revokeToken();
    header('Location: ' . filter_var($callback_uri, FILTER_SANITIZE_URL));
}

$user = $google_oauthV2->userinfo->get();

$googleId = $user['id'];
$googleEmail = filter_var($user['email'], FILTER_SANITIZE_EMAIL);
$googleFirstname = filter_var($user['givenName'], FILTER_SANITIZE_SPECIAL_CHARS);
$googleLastname = filter_var($user['family_name'], FILTER_SANITIZE_SPECIAL_CHARS);
$googlePicture = filter_var($user['picture'], FILTER_VALIDATE_URL);


// db에 user data 없으면 넣기.
require_once("./lib/mysql_connect.php");


$filtered = array(
    "email" => mysqli_real_escape_string($conn, $googleEmail),
    "firstname" => mysqli_real_escape_string($conn, $googleFirstname),
    "lastname" => mysqli_real_escape_string($conn, $googleLastname),
    "picture_url" => mysqli_real_escape_string($conn, $googlePicture),
);


$sql = 'SELECT * FROM user WHERE email="'. $filtered['email']. '"';
$result = mysqli_query($conn, $sql);

if($result === false) {
    die("select error : 관리자에게 문의하세요.");
}

if(mysqli_num_rows($result) === 0) {
    $sql = 'INSERT INTO user (email, firstname, lastname, picture_url) 
    VALUES("' 
    . $filtered['email'] . '", "'
    . $filtered['firstname'] . '", "'
    . $filtered['lastname'] . '", "'
    . $filtered['picture_url']. '")';
    
    $result = mysqli_query($conn, $sql);
    if($result === false) {
        die("insert error : 관리자에게 문의하세요.");
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>로그인 성공</title>
</head>
<body>

    <p>성 : <?=$googleLastname?></p>
    <p>이름 : <?=$googleFirstname?></p>
    <p>이메일 : <?=$googleEmail?></p>
    <p>사진 : <img src="<?=$googlePicture?>" alt="프로필 사진"></p>
    <p>ID : <?=$googleId?></p>
    <?php
    echo '<br /><a class="logout" href="'. $callback_uri . '?logout=1">Logout</a>';
    ?>
</body>
</html>
