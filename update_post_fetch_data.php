<?php

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