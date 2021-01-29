<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/lib/mysql_connect.php');

$status = $_GET['status'];
$keyword = $_GET['keyword'];

if($keyword === '') {
    echo 'no keyword';
    return;
}

$sql = 'SELECT id
        FROM posting
        WHERE link_keyword = "' . $keyword . '";';

$result = mysqli_query($conn, $sql);
if($result === false) {
    echo 'error';
    return;
}

session_start();

$row = mysqli_fetch_assoc($result);
$post_id = $row['id'];
$user_id = $_SESSION['user_id'];

// set -> unset
if($status === 'true'){
    $sql = 'DELETE FROM favorite
            WHERE user_id = "' . $user_id . '" AND
                  post_id = "' . $post_id . '";';

    $result = mysqli_query($conn, $sql);
    if($result === false) {
        echo 'error';
        return;
    }           
    echo 'unset';
}
//unset -> set
else{
    $sql = 'INSERT INTO favorite (user_id, post_id, link_keyword)
            VALUES (' . $user_id . ', ' . $post_id . ', "' . $keyword . '");';
    $result = mysqli_query($conn, $sql);
    if($result === false) {
        echo 'error';
        return;
    }  

    echo 'set';
}
?>