<?php 

session_Start();
require_once($_SERVER['DOCUMENT_ROOT'] . "/api/google_oauth2/client_setting.php");
if(!isset($_SESSION['user_id'])) {
    header("Location: " . $callback_url);
    die();
}

// replace space to '-' and remove all characters except english and number
function url_escape($url){
    $url = str_replace(' ', '-', $url);
    return preg_replace('/[^가-힣a-zA-Z0-9-]/', '', $url);
}
?>

<style type="text/css">
    body {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    div {
        border: 1px solid black;
        padding: 2rem;
        justify-content: center;
        font-size: 1rem;
    }
</style>

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
    
    if($check === false){
        echo('<div class="message-console"><p>포스터가 이미지 형식이 아닙니다!</p>');
        die ('<a href="javascript:history.go(-1)" style="font-size: 1rem;">이전 페이지로 돌아가기</a></div>');
    }

    // Check file size (at most 6 MB)
    if ($_FILES["file-input"]["size"] > 5000000){
        echo('<div class="message-console"><p>포스터 용량이 큽니다 (최대 5MB)</p>');
        die ('<a href="javascript:history.go(-1)" style="font-size: 1rem;">이전 페이지로 돌아가기</a></div>');
    }
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
    echo('<div class="message-console"><p> 게시 종료 날짜가 게시 시작 날짜보다 앞서있습니다!</p>');
    die ('<a href="javascript:history.go(-1)" style="font-size: 1rem;">이전 페이지로 돌아가기</a></div>');
}

$filtered = array(
    'title' => htmlspecialchars(mysqli_real_escape_string($conn, $title), ENT_QUOTES),
    'content' => mysqli_real_escape_string($conn, $content),
    'link_keyword' => url_escape(htmlspecialchars(mysqli_real_escape_string($conn, $link_keyword), ENT_QUOTES)),
);

if($filtered['link_keyword'] == ''){
    echo('<div class="message-console"><p>키워드를 영어,한글,숫자,"-"만 이용하여 다시 작성해주세요</p>');
    die ('<a href="javascript:history.go(-1)" style="font-size: 1rem;">이전 페이지로 돌아가기</a></div>');
}

$query = "INSERT INTO posting (writer_id, title, image, content, link_keyword, is_public, has_comment, begin_date, end_date, created_at, updated_at)
            VALUES ({$user_id}, '{$filtered['title']}', '{$image_data}', '{$filtered['content']}',". "'" . $filtered['link_keyword'] . "', {$scope}, {$comment},'{$begin_date}', '{$end_date}', '{$created_at}', '{$created_at}')";

$query_run = mysqli_query($conn, $query);

$is_Keyword_Unique = 1;

$query = $conn->prepare("SELECT link_keyword FROM posting WHERE link_keyword='{$filtered['link_keyword']}';");
$query->execute();
$query->store_result();
$rows = $query->num_rows;

if($rows > 0)
    $is_Keyword_Unique = 0;

if($query_run)
    header("Location: mainpage.php");
else{
    echo '<div> 포스트 업로드에 실패했습니다';
    if($is_Keyword_Unique == 0){
        echo '<p style="color: red; font-weight:bold;">동일한 링크 키워드를 발견했습니다. 검색 링크 키워드를 변경하세요</p>';
    }
    echo '<a href="javascript:history.go(-1)" style="font-size: 1rem;">이전 페이지로 돌아가기</a> </div>';
}

mysqli_close($conn);
?>