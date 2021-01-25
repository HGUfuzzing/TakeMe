<?php
    session_start();

    require_once($_SERVER['DOCUMENT_ROOT'] . '/lib/links.php');

    if(!isset($_SESSION['user_id'])) {
        header("Location: " . $url_main);
        die();
    }

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

    header("Location: " . $url_root . '/' . $_POST['keyword']);
    die();

?>