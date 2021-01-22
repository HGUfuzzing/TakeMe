<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL|E_WARNING);

function url_escape($url){
    $url = str_replace(' ', '-', $url);
    return preg_replace('/[^가-힣a-zA-Z0-9-]/', '', $url);
}
function error_msg($message){
    echo '<p style="color: red; font-weight:bold;">'. $message .'</p>';
    die ('<a href="javascript:history.go(-1)" style="font-size: 1rem;">이전 페이지로 돌아가기</a></div>');
}
?>

<style type="text/css">
    body {
        /* display: flex; */
        /* align-items: center;
        justify-content: center; */
    }
    div {
        /* border: 1px solid black; */
        /* padding: 2rem;
        justify-content: center;
        font-size: 1rem; */
    }
</style>

<?php
$image = NULL;
$image_data = NULL;
$image_name = NULL;

/* TODO: user_id 를 DB에서 따로 세션 id로 가져올것 */
$user_id = 7;
$post_id = $_POST['post-id'];


//DB에 저장
require_once './lib/mysql_connect.php';

$title = $_POST['title-input'];
$content = $_POST['editor'];
$link_keyword = $_POST['link-keyword-input'];
$scope = $_POST['scope'];
$comment = $_POST['comment'];
$begin_date = $_POST['start-date-input'];
$end_date = $_POST['end-date-input'];
$updated_at = date('Y-m-d H:i');

if ( (strtotime($begin_date)) > (strtotime($end_date)) )
{
    mysqli_close($conn);
    error_msg('게시 종료 날짜가 게시 시작 날짜보다 앞서있습니다!');
}

$filtered = array(
    'title' => htmlspecialchars(mysqli_real_escape_string($conn, $title), ENT_QUOTES),
    'content' => mysqli_real_escape_string($conn, $content),
    'link_keyword' => url_escape(htmlspecialchars(mysqli_real_escape_string($conn, $link_keyword), ENT_QUOTES)),
);

if($filtered['link_keyword'] == ''){
    error_msg('키워드를 영어,한글,숫자,"-"만 이용하여 다시 작성해주세요');
}

// 이미지 파일 새로 업로드 하는 경우(서버 blob을 가져와 value로 지정하는게 불가라 따로 처리해줘야함)
if( $_FILES['file-input']['name'] != "" )
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



    $query = "  UPDATE posting
                SET title = '{$filtered['title']}', 
                    image = '{$image_data}', 
                    content = '{$filtered['content']}', 
                    link_keyword = '{$filtered['link_keyword']}',
                    is_public = {$scope}, 
                    has_comment = {$comment},
                    begin_date = '{$begin_date}', 
                    end_date = '{$end_date}', 
                    updated_at = '{$updated_at}'
                WHERE id={$post_id}";
}
else{
    //기존의 이미지값 보존을 위해 image는 update 하지 않는다.
    $query = "  UPDATE posting
                SET title = '{$filtered['title']}', 
                    content = '{$filtered['content']}', 
                    link_keyword = '{$filtered['link_keyword']}',
                    is_public = {$scope}, 
                    has_comment = {$comment},
                    begin_date = '{$begin_date}', 
                    end_date = '{$end_date}', 
                    updated_at = '{$updated_at}'
                WHERE id={$post_id}";
}

$query_run = mysqli_query($conn, $query);

$is_Keyword_Unique = 1;

$query = $conn->prepare("SELECT link_keyword FROM posting WHERE link_keyword='{$filtered['link_keyword']} AND id != {$post_id}';");
$query->execute();
$query->store_result();
$rows = $query->num_rows;

if($rows > 0)
    $is_Keyword_Unique = 0;

if($query_run)
    header("Location: /read_post.php");
else{
    // die("".mysqli_error($conn));
    echo '<div> 포스트 업로드에 실패했습니다<br/>';
    if($is_Keyword_Unique == 0){
        echo '<p style="color: red; font-weight:bold;">동일한 링크 키워드를 발견했습니다. 검색 링크 키워드를 변경하세요</p>';
    }
    echo '<a href="javascript:history.go(-1)" style="font-size: 1rem;">이전 페이지로 돌아가기</a> </div>';
}

mysqli_close($conn);
?>