<?php
require 'controllers/lib/functions.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: /login/google");
    die();
}

if(!is_valid_keyword($post['link_keyword'])) {
    error_msg('키워드에 영어, 숫자, -(대쉬) 만 가능합니다');
}

$image_path = '';

// 이미지 저장
if(($_FILES['thumbnail']['name'] != ""))
{      
    $image_path = '/public/image/post/user' . $_SESSION['user_id'] . '__' . $post['link_keyword'] . '__' . basename($_FILES['thumbnail']['name']);
    if (!move_uploaded_file($_FILES['thumbnail']['tmp_name'], $_SERVER["DOCUMENT_ROOT"] . $image_path))
        error_msg("fail to upload image");
} else {
    $image_path = '/public/image/noImage.jpg';
}


//DB에 저장
$post['writer_id'] = $_SESSION['user_id'];
$post['content'] = $_POST['content'];
$post['image_path'] = $image_path;
$post['link_keyword'] = $_POST['link_keyword'];
$post['link'] = htmlspecialchars($_POST['link_target']);
$post['begin_date'] = ($_POST['begin_date'] === '')? null : $_POST['begin_date'];
$post['end_date'] = ($_POST['end_date'] === '')? null : $_POST['end_date'];
$post['created_at'] = date('Y-m-d H:i');
$post['updated_at'] = date('Y-m-d H:i');
$post['is_public'] = $_POST['is_public'] === 'true' ? 1 : 0;

if ((strtotime($post['begin_date'])) > (strtotime($post['end_date'])))
{
    error_msg('게시 종료 날짜가 게시 시작 날짜보다 앞서있습니다!');
}

App::get('database')->insert('posting', $post);

header('Location: /');





