<?php
session_start();


$login_message = "";
    if(!isset($_SESSION['user_id'])) {
        $login_message = "<a href=\"" . $callback_url . "\"> 로그인 </a>";
    }
    else {
        $sql = "SELECT firstname, lastname FROM user WHERE id = " . $_SESSION['user_id'];
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        if($result === false) {
            die("fail to get login");
        }
        if(mysqli_num_rows($result) === 0) {
            unset($_SESSION['user_id']);
            header("Location: " . $callback_uri);
        }
        else {
            $login_message = "Hello, " . $row['firstname'] . ' ' . $row['lastname'] . ' ' . '<a href="' . $callback_url . '?logout=1">logout<a>';
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

    <header> <?=$login_message?> </header>