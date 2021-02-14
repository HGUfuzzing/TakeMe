<?php
if(!isset($_SESSION['user_id'])) {
    header("Location: /login/google");
    die();
}

// replace space to '-' and remove all characters except english and number
function url_escape($url){
    return preg_replace('/[^a-zA-Z0-9-]/', '', str_replace(' ', '', $url));
}

function check_keyword($url){
    if(preg_match('/[^A-Za-z0-9-]/', $url)){
        error_msg('키워드에 영어, 숫자, -(대쉬) 만 가능합니다');
    }
}

function error_msg($message){
    echo '<div><p style="color: red; font-weight:bold;">'. $message .'</p>';
    die ('<a href="javascript:history.go(-1)">이전 페이지로 돌아가기</a></div>');
}

$image = NULL;
$image_data = NULL;

$user_id = $_SESSION['user_id'];

// 따로 서버에 저장할 (이미지) 파일
if(($_FILES['file-input']['name'] != ""))
{   
    $image = $_FILES['file-input']['tmp_name'];
    $image_data = base64_encode(file_get_contents($image));
    
    //check whether it is image or not
    $check = getimagesize($_FILES['file-input']['tmp_name']);
    
    if($check === false)
        error_msg('포스터가 이미지 형식이 아닙니다!');

    // Check file size (at most 6 MB)
    if ($_FILES["file-input"]["size"] > 5000000)
        error_msg('포스터 용량이 큽니다 (최대 5MB)');
}


//DB에 저장

$post['writer_id'] = $_SESSION['user_id'];
$post['title'] = htmlspecialchars($_POST['title-input'], ENT_QUOTES);
$post['content'] = $_POST['editor'];
$post['image'] = $image_data;
$post['link_keyword'] = url_escape(htmlspecialchars($_POST['link-keyword-input']));
$post['is_public'] = $_POST['scope'];
$post['has_chatting'] = $_POST['comment'];
$post['begin_date'] = $_POST['begin_date'];
$post['end_date'] = $_POST['end_date'];
$post['created_at'] = date('Y-m-d H:i');
$post['updated_at'] = date('Y-m-d H:i');
$post['is_temporary'] = 0;
if(isset($_POST['tmp-button']))
    $post['is_temporary'] = 1;

if($post['link_keyword'] == '')
    error_msg('키워드를 영어,숫자,"-"만 이용하여 다시 작성해주세요');

check_keyword($post['link_keyword']);

if ((strtotime($post['begin_date'])) > (strtotime($post['end_date'])))
{
    error_msg('게시 종료 날짜가 게시 시작 날짜보다 앞서있습니다!');
}

App::get('database')->insert('posting', $post);

header('Location: /');
