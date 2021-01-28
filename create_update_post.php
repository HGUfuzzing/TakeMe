<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/create_update_post_fetch.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/view/header.php');
?>

    <link rel="stylesheet" href="/create_update_post.css">
    <script src="https://cdn.tiny.cloud/1/xvy7v46l3ku3z9ahq8ri2nv0yo4kp1epmg38njljdpvaywk3/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="/add_tiny.js"> </script>
    <script src="/create_update_post.js" defer></script>

        <form enctype="multipart/form-data" id="post-area" method="POST" action="<?php echo $process_php?>">
            <?php 
                if($process_php == '/update_post_process.php'){
                    echo "<input type='text' style='display:none' name='id' value='". $post_id ."'>";
                    echo "<input type='text' style='display:none' name='link-keyword' value='". $link_keyword ."'>";
                }
            ?>
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
                                echo ('<br/><input type="text" id="link-keyword-input" name="link-keyword-input" placeholder="영어, 숫자, - 가능" required>');
                        ?>
                    </div>
                    <div class = "input-block">
                        <label class="post-label">링크 주소</label><br/>
                        <input type="text" name="url-input" value="<?php echo $link_url ?>">
                    </div>
                    <div class="input-block">
                        <label class="post-label"><span class="highlight">*</span> 행사 시작</label>
                        <input type="date" class="date-input" name="start-date-input" value="<?php echo $begin_date?>" required>
                    </div>
                    <div class="input-block">
                        <label class="post-label"><span class="highlight">*</span> 행사 종료</label>
                        <input type="date" class="date-input" name="end-date-input" value="<?php echo $end_date?>" required>
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
