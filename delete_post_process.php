<?php
session_start();

if(isset($_SESSION['user_id']) && $_POST['writer_id'] == $_SESSION['user_id']) {
    require_once($_SERVER['DOCUMENT_ROOT'] . '/lib/mysql_connect.php');

    //TODO: 해당하는 news도 같이 삭제해야 함.

    $sql = ''
    . 'DELETE from posting '
    . 'WHERE id = ' . $_POST['post_id'];


    $result = mysqli_query($conn, $sql);

    var_dump($result);
    if($result === false) {
        die('error : DELETE form posting');
    }
}

header("Location: http://" . $_SERVER['HTTP_HOST'] . '/delete_post_notify.php');
?>