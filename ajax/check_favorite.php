<?php
session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . '/lib/mysql_connect.php');

$status = $_GET['status'];
$post_id = $_GET['post_id'];

if($post_id === '') {
    echo 'no post_id';
    return;
}

$user_id = $_SESSION['user_id'];

// set -> unset
if($status === 'true'){
    $sql = ''
    . 'DELETE FROM favorite '
    . 'WHERE user_id = ' . $user_id . ' AND post_id = ' . $post_id ;
    // die($sql);

    $result = mysqli_query($conn, $sql);
    if($result === false) {
        echo 'error';
        return;
    }           
    echo 'unset';
}
//unset -> set
else{
    $sql = ''
    . 'INSERT INTO favorite (user_id, post_id) '
    . 'VALUES (' . $user_id . ', ' . $post_id . ')';
    // die($sql);


    $result = mysqli_query($conn, $sql);
    if($result === false) {
        echo 'error';
        return;
    }  

    echo 'set';
}
?>