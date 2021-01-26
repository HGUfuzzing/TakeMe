<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/lib/mysql_connect.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/lib/links.php');

$sql = ''
. 'SELECT user_id FROM news WHERE id = ' . $_GET['news_id'];

$result = mysqli_query($conn, $sql);

if($result === false) {
    die('error: select from news');
}

$row = mysqli_fetch_array($result);

if(!isset($_SESSION['user_id']) || $row['user_id'] != $_SESSION['user_id']) {
    header('Location: ' . $url_main);
    die();
}

$sql = ''
. 'DELETE FROM news WHERE id = ' . $_GET['news_id'];

$result = mysqli_query($conn, $sql);

if($result === false) {
    die('error: select from news');
}

header('Location: ' . $url_root . '/' . $_GET['keyword']);
die();
?>

