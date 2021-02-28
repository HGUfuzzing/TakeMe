<?php
if(!isset($_GET['keyword'])) {
    header("Location: " . $url_main);
    die();
}

$sql = ''
. 'SELECT id FROM posting WHERE link_keyword = "' . $_GET['keyword'] . '"';

$count = App::get('database')->rowCount($sql);

if($count === 0) {
    die("해당 게시글이 없습니다.");
}

$row = App::get('database')->query($sql);

$post_id = $row[0]->id;


$sql = ''
. 'SELECT writer_id, user.firstname, user.lastname, picture_url, link, '
. 'title, image_path, content, link_keyword, begin_date, end_date, created_at, updated_at '
. 'FROM posting '
. 'LEFT JOIN user '
. 'ON posting.writer_id = user.id '
. 'WHERE posting.id = ' . $post_id;

$post = App::get('database')->query($sql)[0];
$newses = App::get('database')->selectAll('news', 'post_id = ' . $post_id);

// favorite  설정

if(isset($_SESSION['user_id'])) 
{
    $sql = ''
    . 'SELECT * FROM favorite '
    . 'WHERE post_id = "'. $post_id . '" AND user_id = ' . $_SESSION['user_id'];

    $count = App::get('database')->rowCount($sql);
    $favorite_status = "";

    if($count === 0)
        $favorite_status = false;
    else
        $favorite_status = true;
}

if($post->link && substr($post->link, 0, 4) !== 'http' && substr($post->link, 0, 2) !== '//')
    $post->link = '//' . $post->link;

require 'views/read.view.php';