<?php 

session_Start();
require_once($_SERVER['DOCUMENT_ROOT'] . "/lib/links.php");
if(!isset($_SESSION['user_id'])) {
    header("Location: " . $url_google_callback);
    die();
}

echo 
'<style>
    body{display: flex; text-align: center; align-items: center; justify-content: center;}
    div {display: block; border: 1px solid black; padding: 2rem; justify-content: center; font-size: 1.5rem;}
</style>';

// replace space to '-' and remove all characters except english and number
function url_escape($url){
    $url = str_replace(' ', '-', $url);
    return preg_replace('[^a-zA-Z0-9-]/', '', $url);
}

function error_msg($message){
    echo '<div><p style="color: red; font-weight:bold;">'. $message .'</p>';
    die ('<a href="javascript:history.go(-1)">이전 페이지로 돌아가기</a></div>');
}
?>


<?php
$image = NULL;
$image_data = NULL;
$image_name = NULL;

$user_id = $_SESSION['user_id'];

// 따로 서버에 저장할 (이미지) 파일
if(($_FILES['file-input']['name']!=""))
{   
    $image = $_FILES['file-input']['tmp_name'];
    $image_data = addslashes(file_get_contents($image));
    $image_name = addslashes($_FILES['file-input']['name']);
    
    //check whether it is image or not
    $check = getimagesize($_FILES['file-input']['tmp_name']);
    
    if($check === false)
        error_msg('포스터가 이미지 형식이 아닙니다!');

    // Check file size (at most 6 MB)
    if ($_FILES["file-input"]["size"] > 5000000)
        error_msg('포스터 용량이 큽니다 (최대 5MB)');
}


//DB에 저장
require_once './lib/mysql_connect.php';

$title = $_POST['title-input'];
$content = $_POST['editor'];
$link_keyword = $_POST['link-keyword-input'];
$scope = $_POST['scope'];
$comment = $_POST['comment'];
$begin_date = $_POST['start-date-input'];
$end_date = $_POST['end-date-input'];
$created_at = date('Y-m-d H:i');

if ((strtotime($begin_date)) > (strtotime($end_date)))
{
    mysqli_close($conn);
    error_msg('게시 종료 날짜가 게시 시작 날짜보다 앞서있습니다!');
}

$filtered = array(
    'title' => htmlspecialchars(mysqli_real_escape_string($conn, $title), ENT_QUOTES),
    'content' => mysqli_real_escape_string($conn, $content),
    'link_keyword' => url_escape(htmlspecialchars(mysqli_real_escape_string($conn, $link_keyword), ENT_QUOTES)),
);

if($filtered['link_keyword'] == '')
    error_msg('키워드를 영어,숫자,"-"만 이용하여 다시 작성해주세요');


$is_temp = 0;
if(isset($_POST['tmp-button']))
    $is_temp = 1;

$query =   "INSERT INTO posting (writer_id, title, image, content, link_keyword, is_public, has_comment, begin_date, end_date, created_at, updated_at, is_temporary)
            VALUES ({$user_id}, '{$filtered['title']}', '{$image_data}', '{$filtered['content']}',". "'" . $filtered['link_keyword'] . "', {$scope}, {$comment},'{$begin_date}', '{$end_date}', '{$created_at}', '{$created_at}', {$is_temp})";

$query_run = mysqli_query($conn, $query);

// check link keyword is unique or not
$is_Keyword_Unique = 1;

$query = $conn->prepare("SELECT link_keyword FROM posting WHERE link_keyword='{$filtered['link_keyword']}';");
$query->execute();
$query->store_result();
$rows = $query->num_rows;

if($rows > 0)
    $is_Keyword_Unique = 0;

if($query_run)
    header("Location: " . $url_root . '/' . $link_keyword);
else{
    echo '<div> 포스트 업로드에 실패했습니다';
    if($is_Keyword_Unique == 0){
        echo '<p style="color: red; font-weight:bold;">동일한 링크 키워드를 발견했습니다. 검색 링크 키워드를 변경하세요</p>';
    }
    echo '<a href="javascript:history.go(-1)" style="font-size: 1rem;">이전 페이지로 돌아가기</a> </div>';
}

mysqli_close($conn);
?>