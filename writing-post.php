<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(isset($_POST['wp-submit-button']))
{   
    $image = "";
    $image_data = "";
    $image_name = "";

    /* TODO: user_id 를 DB에서 따로 세션 id로 가져올것 */
    $user_id = 4;

    // 따로 서버에 저장할 (이미지) 파일
    if(($_FILES['wp-file-input']['name']!=""))
    {   
        $image = $_FILES['wp-file-input']['tmp_name'];
        $image_data = addslashes(file_get_contents($image));
        $image_name = addslashes($_FILES['wp-file-input']['name']);
        
        //check whether it is image or not
        $check = getimagesize($_FILES['wp-file-input']['tmp_name']);
        
        if($check === false)
            die("포스터가 이미지 형식이 아닙니다!");

        // Check file size (at most 6 MB)
        if ($_FILES["wp-file-input"]["size"] > 6000000)
            die("파일 크기가 큽니다 (최대 6MB)");
    }


    //DB에 저장
    require_once './lib/mysql_connect.php';

    $title = $_POST['wp-title-input'];
    $content = $_POST['wp-body-textarea'];
    $link_keyword = $_POST['wp-link-keyword-input'];
    $begin_date = $_POST['wp-start-date-input'];
    $end_date = $_POST['wp-end-date-input'];
    $created_at = date('Y-m-d H:i');

    if ((strtotime($begin_date)) > (strtotime($end_date)))
    {
        die('게시 종료 날짜가 게시 시작 날짜보다 앞서있습니다!');
    }

    $filtered = array(
        'title' => mysqli_real_escape_string($conn, $title),
        'image' => mysqli_real_escape_string($conn, $image_data),
        'content' => mysqli_real_escape_string($conn, $content),
        'link_keyword' => mysqli_real_escape_string($conn, $link_keyword),
    );

    $query = "INSERT INTO posting (writer_id, title, image, content, link_keyword, begin_date, end_date, created_at, updated_at)
               VALUES ({$user_id}, '{$filtered['title']}', '{$filtered['image']}', '{$filtered['content']}',". "'" . url_escape($filtered['link_keyword']) . "', '{$begin_date}', '{$end_date}', '{$created_at}', '{$created_at}')";
    
    $query_run = mysqli_query($conn, $query);
    if($query_run)
        echo "<script>alert('Upload Success! Your Keyword: ".url_escape($filtered['link_keyword']) . "');</script>";
    else
        echo "<script>alert('Upload Failed...');</script>";

    mysqli_close($conn);
}

// replace space to '-' and remove all characters except english and number
function url_escape($url){
    $url = str_replace(' ', '-', $url);
    return preg_replace('/[^A-Za-z0-9\-]/', '', $url);
}

?>

</DOCTYPE! html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="./writing-post.css">
    </head>
    <body>
        <!-- wp == writing-post -->
        <form enctype="multipart/form-data" id="wp-area" method="POST" action="./db-writing-post.php"> 
            <div id="wp-title"> <label class="post-label">* 글 제목:</label> <input type="text" id="wp-title-input" name="wp-title-input" required></div>
            <div id="wp-link-keyword"> <label>* 검색 링크 키워드:</label>  <input type="text" id="wp-link-keyword-input" name="wp-link-keyword-input" placeholder="특수문자 제외한 영어로 작성하세요" required></div>
            <div id = "wp-setting-date-area">
                <div id="wp-start-date"><label>* 게시 시작 기간:</label><input type="date" id="wp-start-date-input" name="wp-start-date-input" required></div> 
                <div id="wp-end-date"><label>* 게시 종료 기간:</label><input type="date" id="wp-end-date-input" name="wp-end-date-input" required> </div>
            </div>
            <div id="wp-file-upload"><label>포스터 업로드: </label><input type="file" id="wp-file-input" name="wp-file-input"></div>
            <div id="wp-body"><label>본문: </label><textarea id="wp-body-textarea" name="wp-body-textarea"></textarea></div>
            <div id="wp-button-area">
                <input type="submit" id="wp-submit-button" name="wp-submit-button">
            </div>
        </form>
    </body>
</html>