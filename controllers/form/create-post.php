<?php
if(!isset($_SESSION['user_id'])) {
    header("Location: /login/google");
    die();
}

// replace space to '-' and remove all characters except english and number
function url_escape($url){
    return preg_replace('/[^a-zA-Z0-9가-힣-]/', '', str_replace(' ', '', $url));
}

function check_keyword($url){
    if(preg_match('/[^A-Za-z0-9가-힣-]/', $url)){
        error_msg('키워드에 영어, 숫자, -(대쉬) 만 가능합니다');
    }
}

function error_msg($message){
    echo '<div><p style="color: red; font-weight:bold;">'. $message .'</p>';
    die ('<a href="javascript:history.go(-1)">이전 페이지로 돌아가기</a></div>');
}

$image_path = '/public/image/';
$link_keyword = url_escape(htmlspecialchars($_POST['link-keyword-input']));

$user_id = $_SESSION['user_id'];

// 따로 서버에 저장할 (이미지) 파일
if(($_FILES['file-input']['name'] != ""))
{      
    $image_path = $image_path . 'post/user' . $user_id . '__' . $link_keyword . '__' . basename($_FILES['file-input']['name']);
    
    //check whether it is image or not
    $check = getimagesize($_FILES['file-input']['tmp_name']);
    
    if($check === false)
        error_msg('포스터가 이미지 형식이 아닙니다!');

    if (!move_uploaded_file($_FILES['file-input']['tmp_name'], $_SERVER["DOCUMENT_ROOT"] . $image_path))
        die("Upload failed");   
} else {
    $image_path .= 'noImage.jpg';
}


//DB에 저장
$post['writer_id'] = $_SESSION['user_id'];
$post['title'] = htmlspecialchars($_POST['title-input'], ENT_QUOTES);
$post['content'] = $_POST['editor'];
$post['image_path'] = $image_path;
$post['link_keyword'] = $link_keyword;
$post['link'] = htmlspecialchars($_POST['url-input']);
$post['begin_date'] = ($_POST['begin_date'] === '')? null : $_POST['begin_date'];
$post['end_date'] = ($_POST['end_date'] === '')? null : $_POST['end_date'];
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
