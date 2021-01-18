<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if(isset($_POST['wp-submit-button']))
{   
    // 따로 서버에 저장할 (이미지) 파일
    if(($_FILES['wp-file-input']['name']!=""))
    {   

        /* TODO: user_id 를 DB에서 따로 세션 id로 가져올것 */
        $user_id = 4;
        $target_file = $_SERVER['DOCUMENT_ROOT'].'/eventapp/images/post/'.'user_'.$user_id . '_' . basename($_FILES['wp-file-input']['name']);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION)); // string escape 하기

        $uploadOk = 1;

        //check whether it is image or not
        $check = getimagesize($_FILES['wp-file-input']['tmp_name']);
        
        if($check !== false){
            $uploadOk = 1;
        }
        else{
            echo "<p>File is not image</p>";
            die();
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "<p>Sorry, file already exists.</p>";
            die();
            $uploadOk = 0;
        }

        // Check file size (at most 6 MB)
        if ($_FILES["wp-file-input"]["size"] > 6000000) {
            echo "<p>Sorry, your file is too large (최대 6MB)</p>";
            die();
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            echo "<p>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</p>";
            die();
            $uploadOk = 0;
        }

        if($uploadOk == 0){
            echo "<p>Upload fail</p>";
            die();
        }
        else{
            // uploads 폴더의 chmod 확인할것 (733)
            if (move_uploaded_file($_FILES['wp-file-input']['tmp_name'], $target_file)){}
            else{
                echo "<p>Sorry, there was an error uploading your file.</p>";
                die();
            }
        }
    }


    //DB에 저장
    require_once './lib/mysql_connect.php';

    $relative_loc = '/eventapp/images/post/'.'user_'.$user_id . '_' . basename($_FILES['wp-file-input']['name']);

    $title = $_POST['wp-title-input'];
    $link_keyword = $_POST['wp-link-keyword-input'];
    $begin_date = $_POST['wp-start-date-input'];
    $end_date = $_POST['wp-end-date-input'];
    $content = $_POST['wp-body-textarea'];
    $created_at = date('Y-m-d H:i');

    $filtered = array(
        'title' => mysqli_real_escape_string($conn, $title),
        'image_path' => mysqli_real_escape_string($conn, $target_file),
        'link_keyword' => mysqli_real_escape_string($conn, $link_keyword),
    );

    $query = "INSERT INTO post (writer_id, title, image_path, link_keyword, begin_date, end_date, created_at)
                VALUES ({$user_id}, '{$filtered['title']}', '{$relative_loc}', '{$filtered['link_keyword']}', '{$begin_date}', '{$end_date}', '{$created_at}')";
    
    $query_run = mysqli_query($conn, $query);
    if($query_run){
        echo "<script>alert('Upload Success!');</script>";
    }
    else{
        echo "<script>alert('Upload Failed');</script>";
        die($query_run);
    }
    mysqli_close($conn);
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
        <form enctype="multipart/form-data" id="wp-area" method="POST" action="./writing-post.php"> 
            <div id="wp-title"> <label class="post-label">* 글 제목:</label> <input type="text" id="wp-title-input" name="wp-title-input" required></div>
            <div id="wp-link-keyword"> <label>* 검색 링크 키워드 <br>(* Unique Keyword):</label>  <input type="text" id="wp-link-keyword-input" name="wp-link-keyword-input" required></div>
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