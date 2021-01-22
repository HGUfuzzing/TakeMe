<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/lib/mysql_connect.php");

    if(!isset($_GET['id'])) {
        header("Location: " . 'http://' . $_SERVER['HTTP_HOST'] . '/mainpage.php');
        die();
    }
    
    $post_id = $_GET['id'];
    
    $sql = ''
    . 'SELECT writer_id, user.firstname, user.lastname, title, image, content, link_keyword, begin_date, end_date, created_at, updated_at '
    . 'FROM posting '
    . 'LEFT JOIN user '
    . 'ON posting.writer_id = user.id '
    . 'WHERE posting.id = ' . $post_id;

    $result = mysqli_query($conn, $sql);
    if($result === false) {
        die("select error!");
    }

    $row = mysqli_fetch_array($result);

    $post = array(
        'title' => $row['title'],
        'image' => 'data: image/;base64,' .  base64_encode($row['image']),
        'name' => $row['firstname'] . ' ' . $row['lastname'],
        'period' => $row['begin_date'] . ' ~ ' . $row['end_date'],
        'content' => $row['content'],
        'id' => $post_id,
        'writer_id' => $row['writer_id']
    );


    $sql = ''
    . 'SELECT content, created_at '
    . 'FROM news '
    . 'WHERE post_id = ' . $post_id;

    $result = mysqli_query($conn, $sql);
    
    if($result === false) {
        die('error : select from news');
    }

    $newses = array();
    while($row = mysqli_fetch_array($result)) {
        $news = array(
            'content' => $row['content'],
            'created_at' => $row['created_at']
        );

        array_push($newses, $news);
    }

?>
