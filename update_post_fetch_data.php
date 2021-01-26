<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . "/api/google_oauth2/client_setting.php");
if(!isset($_SESSION['user_id'])) {
    header("Location: " . $callback_url);
    die();
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/lib/mysql_connect.php');

if(!isset($_GET['keyword'])) {
     //잘못된 접근입니다.
     echo('<div><p>잘못된 접근입니다!</p>');
     die ('<a href="javascript:history.go(-1)" style="font-size: 1rem;">이전 페이지로 돌아가기</a></div>');
}

$post_keyword = $_GET['keyword'];
$query = ''
. 'SELECT writer_id FROM posting ' 
. 'WHERE link_keyword = "' . $post_keyword . '"';


$result = mysqli_query($conn, $query);

if($result === false) {
    //잘못된 접근입니다.
    echo('<div><p>잘못된 접근입니다!</p>');
    die ('<a href="javascript:history.go(-1)" style="font-size: 1rem;">이전 페이지로 돌아가기</a></div>');
}

$row = mysqli_fetch_assoc($result);
if($_SESSION['user_id'] != $row['writer_id']){
    echo 
    '<style>
        body{display: flex; text-align: center; align-items: center; justify-content: center;}
        div {display: block; border: 1px solid black; padding: 2rem; justify-content: center; font-size: 2rem;}
    </style>';
    echo '<div style="color: red"><p> 수정 권한이 없습니다.</p>';
    die ('<a href="javascript:history.go(-1)">이전 페이지로 돌아가기</a></div>');
}


$query = 'SELECT *, DATE_FORMAT(begin_date, "%Y-%m-%d") AS e_begin_date, 
                    DATE_FORMAT(end_date, "%Y-%m-%d")  AS e_end_date
          FROM posting 
          WHERE link_keyword = "' . $post_keyword . '"';

$result = mysqli_query($conn, $query);

if($result === false) {
    //잘못된 접근입니다.
    echo('<div><p>잘못된 접근입니다!</p>');
    die ('<a href="javascript:history.go(-1)" style="font-size: 1rem;">이전 페이지로 돌아가기</a></div>');
}


$row = mysqli_fetch_assoc($result);
$title = $row['title'];
$image = $row['image'];
$content = $row['content'];
$link_keyword = $row['link_keyword'];
$begin_date = $row['e_begin_date'];
$end_date = $row['e_end_date'];
$ispublic = $row['is_public'];
$hascomment = $row['has_comment'];
$post_id = $row['id'];

?>