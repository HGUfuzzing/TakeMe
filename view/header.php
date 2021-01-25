<?php
session_start();
require_once($_SERVER["DOCUMENT_ROOT"] . "/lib/mysql_connect.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/lib/links.php");

$is_logged_in = false;
$name = '';
$login_anchor = '<a href="' . $url_google_callback . '"> <i class="fab fa-google"></i> Login</a>';

$logout_anchor = '<a href="' . $url_google_callback . '?logout=1"> <i class="fas fa-sign-out-alt"></i> Logout</a>';

if(isset($_SESSION['user_id'])) {
    $is_logged_in = true;

    //세션에 등록된 user의 정보 가져오기.
    $sql = "SELECT firstname, lastname FROM user WHERE id = " . $_SESSION['user_id'];
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    if($result === false) {
        die("fail to get user data");
    }
    if(mysqli_num_rows($result) === 0) {
        unset($_SESSION['user_id']);
        header("Location: " . $url_google_callback);
        die();
    }
    
    $name = $row['firstname'] . ' ' . $row['lastname'];
    
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="/view/header.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/304f4c0bb6.js" crossorigin="anonymous"></script>
    <script src="/view/header.js" defer></script>
    <title>Document</title>
</head>
<body>
    <nav class="navbar">
        <div class="navbar__logo">
            <i class="far fa-paper-plane"></i>
            <a href="<?=$url_main?>"> POST.HANDONG</a>
        </div>

        <ul class="navbar__menu">
            <li>
            <a href="<?=$url_main?>"> 
                <i class="fas fa-home"></i> 
                Main 
            </a>

            </li>
            <li>
                <a href="<?=$url_write?>"> 
                <i class="fas fa-pencil-alt"></i> 
                    write 
                </a>
            </li>
        </ul>
        
        <ul class="navbar__user">
            <li>
                <?=$name?>
            </li>
            
            <li>
                <?php
                    if($is_logged_in) 
                        echo $logout_anchor;
                    else   
                        echo $login_anchor;
                ?>
            </li>
        </ul>

        <a href="#" class="navbar__toggleBtn">
            <i class="fas fa-bars"></i>
        </a>
    </nav>
