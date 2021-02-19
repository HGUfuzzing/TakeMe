<?php 
function url_escape($url){
    $url = str_replace(' ', '-', $url);
    return preg_replace('/[^a-zA-Z0-9-]/', '', $url);
}
function error_msg($message){
    echo '<div><p style="color: red; font-weight:bold;">'. $message .'</p>';
    die ('<a href="javascript:history.go(-1)">이전 페이지로 돌아가기</a></div>');
}


$user_id = $_SESSION['user_id'];
$post_id = $_POST['id'];
$link_keyword = $_POST['link-keyword'];
$link_url = $_POST['url-input'];

//DB에 저장
$title = $_POST['title-input'];
$content = $_POST['editor'];
$scope = $_POST['scope'];
$has_chatting = $_POST['has_chatting'];
$begin_date = ($_POST['begin_date'] === '')? null : $_POST['begin_date'];
$end_date = ($_POST['end_date'] === '')? null : $_POST['end_date'];
$updated_at = date('Y-m-d H:i');

if ( (strtotime($begin_date)) > (strtotime($end_date)) )
{
    error_msg('게시 종료 날짜가 게시 시작 날짜보다 앞서있습니다!');
}

$filtered = array(
    'title' => htmlspecialchars($title, ENT_QUOTES),
    'content' => $content, ENT_QUOTES,
    'link_url' => htmlspecialchars($link_url, ENT_QUOTES),
);

$is_temp = 0;
if(isset($_POST['tmp-button']))
    $is_temp = 1;

// 이미지 파일 새로 업로드 하는 경우(서버 blob을 가져와 value로 지정하는게 불가라 따로 처리해줘야함)
if( $_FILES['file-input']['name'] != "" )
{   
    //이미지 경로 저장
    $image_path = '/public/image/post/'. 'user' . $user_id . '__' . $link_keyword . '__' . basename($_FILES['file-input']['name']);
    
    //check image or not
    $check = getimagesize($_FILES['file-input']['tmp_name']);
    if($check === false)
        error_msg('포스터가 이미지 형식이 아닙니다!');

    if (!move_uploaded_file($_FILES['file-input']['tmp_name'], $_SERVER["DOCUMENT_ROOT"] . $image_path))
        die("Upload to server failed");
    
    $post = [
        'title' => $filtered['title'],
        'image_path' => $image_path,
        'content' => $filtered['content'],
        'link' => $filtered['link_url'],
        'is_public' => $scope, 
        'has_chatting' => $has_chatting,
        'begin_date' => $begin_date, 
        'end_date' => $end_date, 
        'updated_at' => $updated_at,
        'is_temporary' => $is_temp
    ];
}
else{
    //기존의 이미지값 보존을 위해 image는 update 하지 않는다.
    $post = [
        'title' => $filtered['title'],
        'content' => $filtered['content'],
        'link' => $filtered['link_url'],
        'is_public' => $scope, 
        'has_chatting' => $has_chatting,
        'begin_date' => $begin_date, 
        'end_date' => $end_date, 
        'updated_at' => $updated_at,
        'is_temporary' => $is_temp
    ];
}

App::get('database')->update('posting', $post, "id = {$post_id}");

header("Location: /@" . $_POST['link-keyword']);
