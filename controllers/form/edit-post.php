<?php 
require 'controllers/lib/functions.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: /login/google");
    die();
}

$post_id = $_POST['id'];
$post['writer_id'] = $_SESSION['user_id'];
$post['content'] = $_POST['content'];
$post['link_keyword'] = $_POST['link_keyword'];
$post['link'] = htmlspecialchars($_POST['link_target']);
$post['begin_date'] = ($_POST['begin_date'] === '')? null : $_POST['begin_date'];
$post['end_date'] = ($_POST['end_date'] === '')? null : $_POST['end_date'];
$post['created_at'] = date('Y-m-d H:i');
$post['updated_at'] = date('Y-m-d H:i');
$post['is_public'] = $_POST['is_public'] === 'true' ? 1 : 0;
$post['updated_at'] = date('Y-m-d H:i');

if (strtotime($post['begin_date']) > strtotime($post['end_date']))
{
    error_msg('게시 종료 날짜가 게시 시작 날짜보다 앞서있습니다!');
}

// 이미지 저장
if(($_FILES['thumbnail']['name'] != ""))
{   
    $image_path = '/public/image/post/user' . $_SESSION['user_id'] . '__' . $post['link_keyword'] . '__' . basename($_FILES['thumbnail']['name']);
    if (!move_uploaded_file($_FILES['thumbnail']['tmp_name'], $_SERVER["DOCUMENT_ROOT"] . $image_path))
        error_msg("fail to upload image");
    
    $post['image_path'] = $image_path;
}

App::get('database')->update('posting', $post, "id = {$post_id}");

header("Location: /@" . $_POST['link_keyword']);
