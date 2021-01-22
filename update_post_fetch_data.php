<?php
//TODO: 
// read-page로부터 post_id, writer_id 넘겨 받기
// 현재 로그인한 유저의 세션 id와 해당 writer_id 가 같으면 수정페이지로 넘어가게! 아니면 에러 페이지
// 또한
// mainpage로부터 post_id를 넘겨받아서 해당 post의 writer_id와 현재 세션의 user_id가 다르면 접근 불가
// $post_id = 97;
$post_id = $_GET['post_id'];

require_once($_SERVER['DOCUMENT_ROOT'] . '/lib/mysql_connect.php');
$query = 'SELECT *, DATE_FORMAT(begin_date, "%Y-%m-%dT%H:%i") AS e_begin_date, 
                    DATE_FORMAT(end_date, "%Y-%m-%dT%H:%i")  AS e_end_date
          FROM posting 
          WHERE id=' . $post_id;
$query_run = mysqli_query($conn, $query);

if($query_run){
    $result = mysqli_fetch_assoc($query_run);
    $title = $result['title'];
    $image = $result['image'];
    $content = $result['content'];
    $link_keyword = $result['link_keyword'];
    $begin_date = $result['e_begin_date'];
    $end_date = $result['e_end_date'];
    $ispublic = $result['is_public'];
    $hascomment = $result['has_comment'];
}
else{
    //잘못된 접근입니다.
    echo('<div><p>잘못된 접근입니다</p>');
    die ('<a href="javascript:history.go(-1)" style="font-size: 1rem;">이전 페이지로 돌아가기</a></div>');
}

?>