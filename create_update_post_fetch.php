<?php
session_start();
require_once("./api/google_oauth2/client_setting.php");

if(!isset($_SESSION['user_id'])) {
    header("Location: " . $callback_url);
    die();
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/lib/mysql_connect.php');

$post_id = NULL;
$title = '';
$image = '';
$content = '';
$link_keyword = '';
$link_url = '';
$begin_date = date('Y-m-d');
$end_date = '';
$ispublic = 1;
$hascomment = 1;
$process_php = '/create_post_process.php';

if(isset($_GET['keyword']) ){
    $keyword = $_GET['keyword'];
    //keyword 넘겨받고, 수정 권한 있는지 확인
    $query = ''
    . 'SELECT writer_id FROM posting ' 
    . 'WHERE link_keyword = "' . $keyword . '"';

    $result = mysqli_query($conn, $query);
    if($result === false) {
        echo('<div><p>잘못된 접근입니다!</p>');
        die ('<a href="javascript:history.go(-1)" style="font-size: 1rem;">이전 페이지로 돌아가기</a></div>');
    }
    $row = mysqli_fetch_assoc($result);
    if($_SESSION['user_id'] != $row['writer_id']){
        echo 
        '<style>
            #alarm {display: inline-block; border: 1px solid black; padding: 2rem; justify-content: center; font-size: 2rem; margin:auto}
        </style>';
        echo '<div id = "alarm" style="color: red"><p> 수정 권한이 없습니다.</p>';
        die ('<a id = "alarm-link" style="color: blue" href="javascript:history.go(-1)">이전 페이지로 돌아가기</a></div>');
    }

    // 수정 권한 확인 후에 전체적인 데이터 가져오기
    $query = '  SELECT *,   DATE_FORMAT(begin_date, "%Y-%m-%d") AS e_begin_date, 
                            DATE_FORMAT(end_date, "%Y-%m-%d")  AS e_end_date
                FROM posting 
                WHERE link_keyword = "' . $keyword . '"';
    
    $result = mysqli_query($conn, $query);
    if($result === false) {
        echo('<div><p>잘못된 접근입니다!</p>');
        die ('<a href="javascript:history.go(-1)" style="font-size: 1rem;">이전 페이지로 돌아가기</a></div>');
    }

    $row = mysqli_fetch_assoc($result);
    $post_id = $row['id'];
    $title = $row['title'];
    $image = $row['image'];
    $content = $row['content'];
    $link_keyword = $row['link_keyword'];
    // $link_url = $row[''];
    $begin_date = $row['e_begin_date'];
    $end_date = $row['e_end_date'];
    $ispublic = $row['is_public'];
    $hascomment = $row['has_comment'];
    $is_temporary = $row['is_temporary'];
    $process_php = '/update_post_process.php';
}
?>