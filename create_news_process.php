<?php
    session_start();

    require_once($_SERVER['DOCUMENT_ROOT'] . '/lib/links.php');

    if(!isset($_SESSION['user_id'])) {
        header("Location: " . $url_main);
        die();
    }

    require_once($_SERVER['DOCUMENT_ROOT'] . '/lib/mysql_connect.php');


    $filtered = array (
        'post_id' => $_POST['post_id'],
        'user_id' => $_SESSION['user_id'],
        'content' => mysqli_real_escape_string($conn, $_POST['content'])
    );

    $sql = 'INSERT INTO news (post_id, user_id, content) '
    . 'VALUES('
    . '"' . $filtered['post_id'] . '", ' 
    . '"' . $filtered['user_id'] . '", '
    . '"' . $filtered['content'] . '" '
    . ')';

    $result = mysqli_query($conn, $sql);

    if($result === false) {
        die('error: insert into news');
    }


    //이메일 전송
    $sql = ''
    . 'SELECT title, link_keyword '
    . 'FROM posting '
    . 'WHERE id = ' . $filtered['post_id'];

    $result = mysqli_query($conn, $sql);
    if($result === false) {
        die('error : select from posting');
    }
    $row = mysqli_fetch_array($result);
    $post_title = $row['title'];
    $post_keyword = $row['link_keyword'];

    $sql = ''
    . 'SELECT email FROM favorite '
    . 'LEFT JOIN user ON favorite.user_id = user.id '
    . 'where post_id = ' . $filtered['post_id'];

    $result = mysqli_query($conn, $sql);

    if(result === false) {
        die('error : select from email');
    }

    $email_addresses = array();
    while($row = mysqli_fetch_array($result)) {
        array_push($email_addresses, $row['email']);
    }
    
    require_once($_SERVER['DOCUMENT_ROOT'] . '/lib/mail.php');

    $short_post_title = $post_title;
    $encodes = array('ASCII', 'UTF-8', 'EUC-KR');
    $title_encode = mb_detect_encoding($post_title, $encodes); 
    
    if(mb_strlen($short_post_title, $title_encode) > 7) {
        $short_post_title = mb_substr($short_post_title, 0, 7, $title_encode);
        $short_post_title .= '...';
    }

    $subject = '즐겨찾기 한 게시물 "' . $short_post_title . '" 에 news가 생겼습니다.';
    $content = str_replace(array('\\r\\n', '\\r\\n', '\\r', '\\n'),'',$filtered['content']);
    $body = ''
    . '즐겨찾기 한 게시물 "' . $post_title . '" 에 news가 생겼습니다. <br><br>'
    . '<a href="'. $url_root . '/' . $post_keyword . '"> 바로가기 </a><br>'
    . '<br>------------------------------------------------------------------------ <br> '
    . '<div> ' . $content. '</div>'
    . '<br>------------------------------------------------------------------------ <br> ';
    $result = send_mail($email_addresses, $subject, $body);

    if($result === false)
        die('<br><br>send_email fail');
    
    header("Location: " . $url_root . '/' . $_POST['keyword']);
    die();
?>