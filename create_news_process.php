<?php
    session_start();

    if(!isset($_SESSION['user_id'])) {
        header("Location: " . 'http://' . $_SERVER['HTTP_HOST'] . '/mainpage.php');
        die();
    }

    require_once($_SERVER['DOCUMENT_ROOT'] . '/api/google_oauth2/client_setting.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/lib/mysql_connect.php');

    $sql = 'INSERT INTO news (post_id, user_id, content) '
    . 'VALUES('
    . '"' . $_POST['post_id'] . '", ' 
    . '"' . $_SESSION['user_id'] . '", '
    . '"' . $_POST['content'] . '" '
    . ')';

    $result = mysqli_query($conn, $sql);

    if($result === false) {
        die('error: insert into news');
    }

    header("Location: " . 'http://' . $_SERVER['HTTP_HOST'] . '/read_post.php?id='.$_POST['post_id']);
    die();

?>