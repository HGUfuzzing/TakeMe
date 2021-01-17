<?php
    require_once "client_setting.php";

    
    $client->authenticate($_GET['code']);
    $access_token = $client->getAccessToken();
    //$client->setAccessToken($access_token);       //이거 이용하는 법을 모르겠음 .ㅠㅠ
    
    $q = 'https://www.googleapis.com/oauth2/v1/userinfo?access_token=' . $access_token["access_token"];
    $json = file_get_contents($q);
    
    
    $userInfoArray = json_decode($json,true);
    $googleId = $userInfoArray['id'];
    $googleEmail = $userInfoArray['email'];
    $googleFirstName = $userInfoArray['given_name'];
    $googleLastName = $userInfoArray['family_name'];
    $googlePicture = $userInfoArray['picture'];
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
</body>
</html>

