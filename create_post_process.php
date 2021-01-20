<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// replace space to '-' and remove all characters except english and number
function url_escape($url){
    $url = str_replace(' ', '-', $url);
    return preg_replace('/[^A-Za-z0-9\-]/', '', $url);
}

$image = NULL;
$image_data = NULL;
$image_name = NULL;


/* TODO: user_id 를 DB에서 따로 세션 id로 가져올것 */
$user_id = 4;

// 따로 서버에 저장할 (이미지) 파일
if(($_FILES['file-input']['name']!=""))
{   
    $image = $_FILES['file-input']['tmp_name'];
    $image_data = addslashes(file_get_contents($image));
    $image_name = addslashes($_FILES['file-input']['name']);
    
    //check whether it is image or not
    $check = getimagesize($_FILES['file-input']['tmp_name']);
    
    if($check === false)
        die("포스터가 이미지 형식이 아닙니다!");

    // Check file size (at most 6 MB)
    if ($_FILES["file-input"]["size"] > 6000000)
        die("파일 크기가 큽니다 (최대 6MB)");
}


//DB에 저장
require_once './lib/mysql_connect.php';

$title = $_POST['title-input'];
$content = $_POST['editor'];
$link_keyword = $_POST['link-keyword-input'];
$begin_date = $_POST['start-date-input'];
$end_date = $_POST['end-date-input'];
$created_at = date('Y-m-d H:i');

if ((strtotime($begin_date)) > (strtotime($end_date)))
{
    die('게시 종료 날짜가 게시 시작 날짜보다 앞서있습니다!');
}

$filtered = array(
    'title' => mysqli_real_escape_string($conn, $title),
    'content' => mysqli_real_escape_string($conn, $content),
    'link_keyword' => mysqli_real_escape_string($conn, $link_keyword),
);

$query = "INSERT INTO posting (writer_id, title, image, content, link_keyword, begin_date, end_date, created_at, updated_at)
            VALUES ({$user_id}, '{$filtered['title']}', '{$image_data}', '{$filtered['content']}',". "'" . url_escape($filtered['link_keyword']) . "', '{$begin_date}', '{$end_date}', '{$created_at}', '{$created_at}')";

$query_run = mysqli_query($conn, $query);


if($query_run){
    echo 
        "<script> 
            alert('Upload Success! Your Keyword: ".url_escape($filtered['link_keyword']) . "');
            window.location.href='mainpage.php';
        </script>";
}
else{
    echo "<script> 
            alert('Upload Failed...');
            history.go(-1);
    </script>";
}

mysqli_close($conn);
?>