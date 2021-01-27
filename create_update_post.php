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
    require_once($_SERVER['DOCUMENT_ROOT'] . '/lib/mysql_connect.php');

    $post_id = NULL;
    $title = '';
    $image = '';
    $content = '';
    $link_keyword = '';
    $link_url = '';
    $begin_date = '';
    $end_date = '';
    $ispublic = 1;
    $hascomment = 1;
    $process_php = 'create_post_process.php';

    if( isset($_GET['keyword']) ){
        $keyword = $_GET['keyword'];
        //keyword 넘겨받고, 수정 권한 있는지 확인
        $query = ''
        . 'SELECT writer_id FROM posting ' 
        . 'WHERE link_keyword = "' . $keyword . '"';

        $result = mysqli_query($conn, $query);
        if($result === false) {
            echo('<div><p>잘못된 접근입니다!</p>');
            die ('<a href="javascript:history.go(-1)" style="font-size: 1rem;">이전 페이지로 돌아가기</a></div>');
        }
        $row = mysqli_fetch_assoc($result);
        if($_SESSION['user_id'] != $row['writer_id']){
            echo 
            '<style>
                #alarm {display: inline-block; border: 1px solid black; padding: 2rem; justify-content: center; font-size: 2rem; margin:auto}
            </style>';
            echo '<div id = "alarm" style="color: red"><p> 수정 권한이 없습니다.</p>';
            die ('<a id = "alarm-link" style="color: blue" href="javascript:history.go(-1)">이전 페이지로 돌아가기</a></div>');
        }

        // 수정 권한 확인 후에 전체적인 데이터 가져오기
        $query = '  SELECT *,   DATE_FORMAT(begin_date, "%Y-%m-%d") AS e_begin_date, 
                                DATE_FORMAT(end_date, "%Y-%m-%d")  AS e_end_date
                    FROM posting 
                    WHERE link_keyword = "' . $keyword . '"';
        
        $result = mysqli_query($conn, $query);
        if($result === false) {
            echo('<div><p>잘못된 접근입니다!</p>');
            die ('<a href="javascript:history.go(-1)" style="font-size: 1rem;">이전 페이지로 돌아가기</a></div>');
        }

        $row = mysqli_fetch_assoc($result);
        $post_id = $row['id'];
        $title = $row['title'];
        $image = $row['image'];
        $content = $row['content'];
        $link_keyword = $row['link_keyword'];
        // $link_url = $row[''];
        $begin_date = $row['e_begin_date'];
        $end_date = $row['e_end_date'];
        $ispublic = $row['is_public'];
        $hascomment = $row['has_comment'];
        $is_temporary = $row['is_temporary'];
        $process_php = 'update_post_process.php';
    }
?>

    <link rel="stylesheet" href="/create_post.css">
    <script src="https://cdn.tiny.cloud/1/xvy7v46l3ku3z9ahq8ri2nv0yo4kp1epmg38njljdpvaywk3/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="/add_tiny.js"> </script>
    <script src="/create_post.js" defer></script>

        <form enctype="multipart/form-data" id="post-area" method="POST" action="<?php echo $process_php?>">
            <div id="block1" class="col">
                <div id="col1">
                    <div class="input-block">
                        <label class="post-label"><span class="highlight">*</span> 글 제목</label><br/>
                        <input type="text" id="title-input" name="title-input" value="<?php echo "$title"; ?>" required>
                    </div>
                    <div class="input-block">
                        <label class="post-label">링크 키워드</label>
                        <?php 
                            if($link_keyword!='')
                                echo ('<label id="keyword"> '. $link_keyword . '</label>');
                            else
                                echo ('<input type="text" id="link-keyword-input" name="link-keyword-input" placeholder="영어, 숫자, - 가능" required>');
                        ?>
                    </div>
                    <div class = "input-block">
                        <label class="post-label">링크 주소</label><br/>
                        <input type="text" name="url-input" value="<?php echo $link_url ?>">
                    </div>
                    <div class="input-block">
                        <label class="post-label"><span class="highlight">*</span> 행사 시작</label>
                        <input type="date" class="date-input" name="start-date-input" value="<?php echo $begin_date?>">
                    </div>
                    <div class="input-block">
                        <label class="post-label"><span class="highlight">*</span> 행사 종료</label>
                        <input type="date" class="date-input" name="end-date-input" value="<?php echo $end_date?>">
                    </div>
                    <div class="input-block" style="display:flex">
                        <label class="post-label">공개 범위 </label>
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
                    <div class="input-block" style="display:flex">
                        <label class="post-label">1대1 채팅 허용</label>
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
                    <div class="input-block" id="file-upload">
                        <label class="post-label">포스터 업로드 </label>
                        <input type='file' id='file-input' name='file-input' accept="image/*">
                    </div>
                </div>
                    <?php 
                        if($image != ''){
                            echo '<div id = "col2" class="input-block">'
                            . '<span id="preview-img" style= "display:block; text-align:center;">게시글 사이즈 보기</span>' 
                            . '<img id="show-poster" style="background-color:white" src="data:image/jpeg;base64, '.base64_encode($image).'" alt="no-image"/>';
                        }
                        else {
                            echo '<div id="col2" style="visibility:hidden;" class="input-block">'
                            . '<span id="preview-img" style= "display:none; text-align:center;">게시글 사이즈 보기</span>' 
                            . '<img id="show-poster" style= "visibility:hidden;" alt="no img"></img>';
                        }  
                    ?>
                </div>
            </div>
            <div id='block2'>
                <div id="editor-container">
                    <textarea name="editor" id="editor"><?php echo $content;?></textarea>
                </div>
                <div class="row">
                    <input type="submit" id="submit-button" name="submit-button">
                    <input type="submit" id="tmp-button" name="tmp-button" value="임시저장">
                </div>
            </div>
        </form> 
    </body>
</html>
