<?php   //included by read_post.php

    session_start();

    $reply_msg = "";


    require_once($_SERVER['DOCUMENT_ROOT'] . "/lib/mysql_connect.php");
    
    $sql = ''
    . 'SELECT reply.id, writer_id, firstname, lastname, content '
    . 'FROM reply '
    . 'LEFT JOIN user ON reply.writer_id = user.id '
    . 'WHERE post_id = ' . $_GET['id'];

    $result = mysqli_query($conn, $sql);

    if($result === false) {
        die("댓글 조회 오류.");
    }

    
    while($row = mysqli_fetch_array($result)){
        $reply_msg .= '<li>' . $row['content'] . '</li>';
    }
    
?>
