
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

        <link rel="stylesheet" href="/create_post.css">
        <script src="https://cdn.tiny.cloud/1/xvy7v46l3ku3z9ahq8ri2nv0yo4kp1epmg38njljdpvaywk3/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
        <script src="/add_tiny.js"> </script>
        
        <form enctype="multipart/form-data" id="post-area" method="POST" action="/create_post_process.php"> 
                <div id='block1' class='col'>
                    <div id='col1'>
                        <div class="input-block"> 
                            <label class="post-label"><span class="highlight">*</span> 글 제목</label><br/>
                            <input type="text" id="title-input" name="title-input" required>
                        </div>
                        <div class="input-block"> 
                            <label class="post-label"><span class="highlight">*</span> 링크 키워드</label><br/>
                            <input type="text" id="link-keyword-input" name="link-keyword-input" placeholder="영어, 숫자, - 가능" required>
                        </div>
                        <div class = "input-block">
                            <label class="post-label">링크 주소</label><br/>
                            <input type="text" name="link-input">
                        </div>
                        <div class = "input-block">
                            <label class="post-label"><span class="highlight">*</span> 게시 시작</label>
                            <input type="date" class="date-input" name="start-date-input" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        <div class="input-block">
                            <label class="post-label"><span class="highlight">*</span> 게시 종료</label>
                            <input type="date" class="date-input" name="end-date-input" required> 
                        </div>
                        <div class="input-block" style="display:flex">
                            <label class="post-label">공개 범위 </label>
                            <input type="radio" id="public" name="scope" value="1" checked> <label class="option">전체 공개</label>
                            <input type="radio" id="private" name="scope" value="0"> <label class="option">한동대 학생만</label>
                        </div>
                        <div class="input-block" id="comment-option" style="display:flex">
                            <label class="post-label">1대1 채팅 허용 </label>
                            <input type="radio" id="allow" name="comment" value="1" checked> <label class="option">허용</label>
                            <input type="radio" id="disallow" name="comment" value="0"> <label class="option">비허용</label>
                        </div>
                        <div class="input-block">
                            <label class="post-label">포스터 업로드 </label><input type="file" id="file-input" name="file-input">
                        </div>
                    </div>
                    <div id='col2' class="input-block">
                        <img id="show-poster" src="/images/google-logo.png" alt="no img"></img>
                    </div>
                </div>
                <div id='block2'>
                    <div id="editor-container"> 
                        <textarea name="editor" id="editor"></textarea> 
                    </div>
                    <div class="row">
                        <input type="submit" id="submit-button" name="submit-button">
                        <input type="submit" id="tmp-button" name="tmp-button" value="임시저장">
                    </div>
                </div>
        </form>
    </body>
</html>