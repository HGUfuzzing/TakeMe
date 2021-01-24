<?php
    session_start();

    if(!isset($_SESSION['user_id'])) {
        header("Location: " . 'http://' . $_SERVER['HTTP_HOST'] . '/mainpage.php');
        die();
    }

    require_once($_SERVER['DOCUMENT_ROOT'] . '/api/google_oauth2/client_setting.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/lib/mysql_connect.php');


    $filtered = array (
        'post_id' => $_POST['post_id'],
        'user_id' => $_SESSION['user_id'],
        'content' => mysqli_real_escape_string($conn, $_POST['content'])
    );

    $sql = 'INSERT INTO news (post_id, user_id, content) '
    . 'VALUES('
    . '"' . $filtered['post_id'] . '", ' 
    . '"' . $filtered['user_id'] . '", '
    . '"' . $filtered['content'] . '" '
    . ')';

    $result = mysqli_query($conn, $sql);

    if($result === false) {
        die('error: insert into news');
    }

    header("Location: " . 'http://' . $_SERVER['HTTP_HOST'] . "/post/" . $_POST['keyword']);
    die();

?>