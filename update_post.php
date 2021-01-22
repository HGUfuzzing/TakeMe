<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . "/api/google_oauth2/client_setting.php");
if(!isset($_SESSION['user_id'])) {
    header("Location: " . $callback_url);
    die();
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/lib/mysql_connect.php');
$post_id = $_GET['id'];
$query = "SELECT writer_id FROM posting WHERE id = {$post_id};";
$query_run = mysqli_query($conn, $query);
$result = mysqli_fetch_assoc($query_run);
if($_SESSION['user_id'] != $result['writer_id']){
    echo 
    '<style>
        body{display: flex; text-align: center; align-items: center; justify-content: center;}
        div {display: block; border: 1px solid black; padding: 2rem; justify-content: center; font-size: 2rem;}
    </style>';
    echo '<div style="color: red"><p> 수정 권한이 없습니다.</p>';
    die ('<a href="javascript:history.go(-1)">이전 페이지로 돌아가기</a></div>');
}
?>

<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/view/header.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/update_post_fetch_data.php');
?>
        <link rel="stylesheet" href="/create_post.css">
        <script src="https://cdn.tiny.cloud/1/xvy7v46l3ku3z9ahq8ri2nv0yo4kp1epmg38njljdpvaywk3/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
        <script>
            tinymce.init({
                selector: 'textarea',
                height: '500',
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
            });
        </script>
    </head>
    <body>
        <!-- file post 하기 위해서는 enctype 필수 -->
        <form id="area" enctype="multipart/form-data" method="POST" action="./update_post_process.php">
            <input type="text" name='id' value="<?php echo $post_id; ?>" style="display: none">
            <div id="title"> 
                <label class="post-label">* 글 제목:</label> 
                <input type="text" id="title-input" name="title-input" value="<?php echo $title; ?>" required>
            </div>
            <div id="link-keyword"> 
                <label class="post-label">* 검색 링크 키워드:</label>
                <label ><?php echo $link_keyword; ?></label>  
            </div>
            <div id = "setting-date-area">
                <div id="start-date"><label class="post-label">* 게시 시작 기간:</label><input type="datetime-local" class="date-input" name="start-date-input" value="<?php echo $begin_date?>" required></div> 
                <div id="end-date"><label class="post-label">* 게시 종료 기간:</label><input type="datetime-local" class="date-input" name="end-date-input" value="<?php echo $end_date?>" required> </div>
            </div>
            <div id="scope-option">
                <label class="post-label">공개 범위: </label>
                <?php 
                    if($ispublic == 1){
                        echo 
                        '<input type="radio" id="public" name="scope" value="1" checked> <label class="option">전체 공개</label>
                        <input type="radio" id="private" name="scope" value="0"> <label class="option">한동대 학생만</label>';
                    }
                    else{
                        echo 
                        '<input type="radio" id="public" name="scope" value="1"> <label class="option">전체 공개</label>
                        <input type="radio" id="private" name="scope" value="0" checked> <label class="option">한동대 학생만</label>';
                    }
                ?>
            </div>
            <div id="comment-option">
                <label class="post-label">댓글 허용: </label>
                <?php 
                    if($hascomment == 1){
                        echo 
                        '<input type="radio" id="allow" name="comment" value="1" checked> <label class="option">허용</label>
                        <input type="radio" id="disallow" name="comment" value="0"> <label class="option">비허용</label>';
                    }
                    else{
                        echo 
                        '<input type="radio" id="allow" name="comment" value="1"> <label class="option">허용</label>
                        <input type="radio" id="disallow" name="comment" value="0" checked> <label class="option">비허용</label>';
                    }
                ?>
            </div>
            <div id="file-upload">
                <label class="post-label">포스터 업로드: </label>
                <?php 
                    echo '<img style="width:100px;height:100px" src="data:image/jpeg;base64, '.base64_encode( $image).'" alt="no-image"/>';
                ?>
                <input type='file' id='file-input' name='file-input'>
            </div>
            <div id="body">
                <label class="post-label">본문: </label>
                <div id="editor-container"> 
                    <textarea name="editor" id="editor">
                        <?php echo $content; ?>
                    </textarea>
                </div>
            </div>
            <div id="button-area">
                <input type="submit" id="submit-button" name="submit-button">
            </div>
        </form>
    </body>
</html>