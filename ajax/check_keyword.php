<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/lib/mysql_connect.php');

$keyword = $_GET['keyword'];

if(!$keyword) {
    echo 'url로 사용할 키워드를 입력 해주세요';
    return;
}

$sql = ''
. 'SELECT count(*) FROM posting WHERE link_keyword = "' . $keyword . '"';

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

if($row[0] == 0) {
    echo '사용 가능한 키워드입니다.';
}
else {
    echo '사용 불가능한 키워드 입니다.';
}
?>