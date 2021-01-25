<?php
session_start();
require_once($_SERVER["DOCUMENT_ROOT"] . "/lib/mysql_connect.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/lib/links.php");

$login_message = '';
$mainpage_ancher = '<a href="' . $url_main . '"> 메인페이지 </a>';
$create_post_ancher = '';


if(!isset($_SESSION['user_id'])) {
    $login_message = "<a href=\"" . $url_google_callback . "\"> 로그인 </a>";
}
else {
    $create_post_ancher = '<a href="' . $url_write . '"> 글쓰기 </a>';

    //세션에 등록된 user의 정보 가져오기.
    $sql = "SELECT firstname, lastname FROM user WHERE id = " . $_SESSION['user_id'];
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    if($result === false) {
        die("fail to get login");
    }
    if(mysqli_num_rows($result) === 0) {
        unset($_SESSION['user_id']);
        header("Location: " . $url_google_callback);
    }
    else {
        $login_message = "Hello, " . $row['firstname'] . ' ' . $row['lastname'] . ' ' . '<a href="' . $url_google_callback . '?logout=1">logout<a>';
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
</head>
<body>
    <link rel="stylesheet" href="/view/header.css">
    <header>
        
        <?=$login_message?> 
    
        <?=$mainpage_ancher?>
        <?=$create_post_ancher?>

    </header>