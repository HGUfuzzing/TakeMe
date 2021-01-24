
<?php
session_start();

require_once("./api/google_oauth2/client_setting.php");

if(!isset($_SESSION['user_id'])) {
    header("Location: " . $callback_url);
    die();
}

?>


<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/view/header.php');
?>

        <link rel="stylesheet" href="./create_post.css">
        <script src="https://cdn.tiny.cloud/1/xvy7v46l3ku3z9ahq8ri2nv0yo4kp1epmg38njljdpvaywk3/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
        <script src="/add_tiny.js"> </script>
        
    <body>
        <form enctype="multipart/form-data" id="area" method="POST" action="./create_post_process.php"> 
            <div id="title"> <label class="post-label">* 글 제목:</label> <input type="text" id="title-input" name="title-input" required></div>
            <div id="link-keyword"> 
                <label class="post-label">* 검색 링크 키워드:</label>  
                <input type="text" id="link-keyword-input" name="link-keyword-input" placeholder="영어, 한글, 숫자, 띄어쓰기만 가능" required>
                <label id="live-check"></label>
            </div>
            <div id = "setting-date-area">
                <div id="start-date"><label class="post-label">* 게시 시작 기간:</label><input type="datetime-local" class="date-input" name="start-date-input" required></div> 
                <div id="end-date"><label class="post-label">* 게시 종료 기간:</label><input type="datetime-local" class="date-input" name="end-date-input" required> </div>
            </div>
            <div id="scope-option">
                <label class="post-label">공개 범위: </label>
                <input type="radio" id="public" name="scope" value="1" checked> <label class="option">전체 공개</label>
                <input type="radio" id="private" name="scope" value="0"> <label class="option">한동대 학생만</label>
            </div>
            <div id="comment-option">
                <label class="post-label">1대1 채팅 허용: </label>
                <input type="radio" id="allow" name="comment" value="1" checked> <label class="option">허용</label>
                <input type="radio" id="disallow" name="comment" value="0"> <label class="option">비허용</label>
            </div>
            <div id="file-upload"><label class="post-label">포스터 업로드: </label><input type="file" id="file-input" name="file-input"></div>
            <div id="body">
                <label class="post-label">본문: </label>
                <div id="editor-container"> <textarea name="editor" id="editor"></textarea> </div>
            </div>
            <div id="button-area">
                <input type="submit" id="submit-button" name="submit-button">
            </div>
        </form>
    </body>
</html>