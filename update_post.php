<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/view/header.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/update_post_fetch_data.php');
?>

    <link rel="stylesheet" href="/create_post.css">
    <script src="https://cdn.tiny.cloud/1/xvy7v46l3ku3z9ahq8ri2nv0yo4kp1epmg38njljdpvaywk3/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="/add_tiny.js"> </script>
    
        <!-- file post 하기 위해서는 enctype 필수 -->
        <form id="area" enctype="multipart/form-data" method="POST" action="./update_post_process.php">
            <input type="hidden" name="">
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
                <label class="post-label">1대1 채팅 허용: </label>
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