<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/lib/mysql_connect.php');

$keyword = $_GET['keyword'];

if($keyword === '') {
    echo 'empty';
    return;
}

if(preg_match('/^[0-9a-zA-Z-]+$/', $keyword) == false) {
    echo 'invalid';
    return;
}


$sql = ''
. 'SELECT count(*) FROM posting WHERE link_keyword = "' . $keyword . '"';

$result = mysqli_query($conn, $sql);
if($result === false) {
    echo 'error';
    return;
}

$row = mysqli_fetch_array($result);

$count = $row[0];

if($count == 0) {
    echo 'good';
}
else {
    echo 'duplicate';
}
?>