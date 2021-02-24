<?php require('partials/header.php'); ?>

<link rel="stylesheet" href="/public/css/write.css">
<script src="https://cdn.tiny.cloud/1/xvy7v46l3ku3z9ahq8ri2nv0yo4kp1epmg38njljdpvaywk3/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script src="/public/js/add_tiny.js"> </script>
<script src="/public/js/write.js" defer></script>

<form enctype="multipart/form-data" id="post-area" class="form" method="POST" action="/<?=$action?>">
    <?php if($action == 'post/edit'): ?>
        <input type='text' style='display:none' name="id" value="<?=$post->id?>">
        <input type='text' style='display:none' name="link-keyword" value="<?=$post->link_keyword?>">
    <?php endif; ?>

    <div id="block1" class="col">
        <div id="col1">
            <div class="links-container ">
                <div class="keyword_check_msg"> </div>

                <div class="link-keyword-wrapper">
                    <span class="highlight">*</span> 
                    <div class="link-keyword-container">
                        <?php if($action === 'post/edit'): ?>
                            <label id="keyword"><?=$_SERVER['HTTP_HOST']?>/@<?=$post->link_keyword?></label>
                        <?php else: ?>
                            <?=$_SERVER['HTTP_HOST']?>/@<input type="text" class="link-keyword" name="link-keyword-input" placeholder="키워드 입력 (한글, 영어, 숫자, - 가능)" required>
                        <?php endif; ?>
                    </div>
                </div>

                
                <div class="arrow">
                    <i class="fas fa-arrow-down"></i>
                </div>
                
                <div class="link-target-wrapper">
                    <span class="highlight">*</span> 
                    <div class="link-target-container">
                        <input type="text" class="link-target" name="url-input" value="<?=$post->link?>" placeholder="연결할 타겟 링크 입력  ex) https://www.naver.com" required>
                    </div>
                </div>

                
            </div>
            
            <div class="input-block" id="file-upload">
                <label for="file-input" class="file-upload-button">썸네일 이미지 업로드</label>
                <input type="file" id="file-input" class="file-input" accept="image/*" >
            </div>
            <br><br>
            <div class="input-block">
                <input type="radio" id="set-eventdate" name="eventdate" onclick="showDate()" <?php if($post->begin_date !== null) echo "checked"?>> <label class="option">유효 기간 설정</label>
                <input type="radio" id="unset-eventdate" name="eventdate" onclick="showNone()" <?php if($post->begin_date === null) echo "checked"?>> <label class="option">유효 기간 미설정</label>
                
                <div id="eventdatetime-container">
                    <label class="post-label"><span class="highlight">*</span> 시작</label>
                    <input type="date" class="date-input" id="begin_date" name="begin_date" value="<?=$post->e_begin_date?>" required> <br>
                    <label class="post-label"><span class="highlight">*</span> 종료</label>
                    <input type="date" class="date-input" id="end_date" name="end_date" value="<?=$post->e_end_date?>" required>
                </div>
            </div>
        </div>
        <?php if($post->image_path != ''): ?>
            <div id = "col2" class="input-block">
                <span id="preview-img" style= "display:block; text-align:center;">게시글 사이즈 보기</span>
                <img id="show-poster" style="background-color:white" src="<?=$post->image_path?>" alt="no-image"/>
            </div>
        <?php else: ?>
            <div id="col2" style="display:none;" class="input-block">
                <span id="preview-img" style= "display:none; text-align:center;">게시글 사이즈 보기</span>
                <img id="show-poster" style= "display:none;" alt="no img"></img>
            </div>
        <?php endif; ?>
        
    </div>
    <div id='block2'>
        <div id="editor-container">
            <textarea name="editor" id="editor"><?=$post->content?></textarea>
        </div>
        <div class="row">
            <button type="button" id="submit-button">심플 링크 만들기</button>
            <!-- <input type="submit" id="tmp-button" name="tmp-button" value="임시저장"> -->
        </div>
    </div>
</form> 

<? require('partials/footer.php'); ?>