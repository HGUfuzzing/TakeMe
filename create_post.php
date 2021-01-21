
<?php
session_start();

require_once("./api/google_oauth2/client_setting.php");

if(!isset($_SESSION['user_id'])) {
    header("Location: " . $callback_url);
    die();
}

?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>This is for creating posts</title>
        <link rel="stylesheet" href="./create_post.css">
        <script src="https://cdn.tiny.cloud/1/xvy7v46l3ku3z9ahq8ri2nv0yo4kp1epmg38njljdpvaywk3/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
        <script>
            tinymce.init({
                selector: 'textarea',
                height: "500",
                // invalid_elements : "script",
                plugins: [
                    'advlist autolink link image code lists charmap hr anchor pagebreak',
                    'searchreplace wordcount visualblocks visualchars code fullscreen nonbreaking',
                    'table emoticons template paste'
                ],
                toolbar: 
                    'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | ' +
                    'bullist numlist outdent indent | link image code|' +
                    'forecolor backcolor emoticons',
                menubar: 'favs file edit view insert format tools table',
                content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
                // images_upload_url: 'upload.php',
                // images_upload_handler: function(blobInfo, success, failure){
                //     var xhr, formData;

                // }
            });
        </script>
    </head>
    <body>
        <form enctype="multipart/form-data" id="area" method="POST" action="./create_post_process.php"> 
            <div id="title"> <label class="post-label">* 글 제목:</label> <input type="text" id="title-input" name="title-input" required></div>
            <div id="link-keyword"> <label>* 검색 링크 키워드:</label>  <input type="text" id="link-keyword-input" name="link-keyword-input" placeholder="특수문자 제외한 영어로 작성하세요" required></div>
            <div id = "setting-date-area">
                <div id="start-date"><label>* 게시 시작 기간:</label><input type="date" id="start-date-input" name="start-date-input" required></div> 
                <div id="end-date"><label>* 게시 종료 기간:</label><input type="date" id="end-date-input" name="end-date-input" required> </div>
            </div>
            <div id="file-upload"><label>포스터 업로드: </label><input type="file" id="file-input" name="file-input"></div>
            <div id="body">
                <label>본문: </label>
                <div id="editor-container"> <textarea name="editor" id="editor"></textarea> </div>
            </div>
            <div id="button-area">
                <input type="submit" id="submit-button" name="submit-button">
            </div>
        </form>
    </body>
</html>