<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/view/header.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/update_post_fetch_data.php');
?>

    <link rel="stylesheet" href="/create_post.css">
    <script src="https://cdn.tiny.cloud/1/xvy7v46l3ku3z9ahq8ri2nv0yo4kp1epmg38njljdpvaywk3/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="/add_tiny.js"> </script>
    <script src="/create_post.js" defer></script>
    <body>
        <!-- file post 하기 위해서는 enctype 필수 -->
        <form id="post-area" enctype="multipart/form-data" method="POST" action="/update_post_process.php">
                    <div id='block1' class="col">
                        <div id='col1'>
                            <div class="input-block">
                                <label class="post-label"><span class="highlight">*</span> 글 제목</label><br/>
                                <input type="text" id="title-input" name="title-input" value="<?php echo $title; ?>" required>
                            </div>
                            <div class="input-block">
                                <label class="post-label">링크 키워드</label>
                                <label id='keyword'><?php echo $link_keyword; ?></label>
                            </div>
                            <div class = "input-block">
                                <label class="post-label">링크 주소</label><br/>
                                <input type="text" name="url-input">
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
                                <label class="post-label">1대1 채팅 허용 </label>
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
                                <input type='file' id='file-input' name='file-input'>
                            </div>
                        </div>
                        <div id = 'col2' class='input-block'>
                            <span id="preview-img" style= 'display:block; text-align:center;'>게시글 사이즈 보기</span>
                            <?php echo '<img id="show-poster" style="background-color:white" src="data:image/jpeg;base64, '.base64_encode( $image).'" alt="no-image"/>';?>
                        </div>
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