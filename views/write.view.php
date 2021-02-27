<?php require('partials/header.php'); ?>

<link rel="stylesheet" href="/public/css/write.css">
<script src="https://cdn.tiny.cloud/1/xvy7v46l3ku3z9ahq8ri2nv0yo4kp1epmg38njljdpvaywk3/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script src="/public/js/add_tiny.js"> </script>
<script src="/public/js/write.js" defer></script>

<form enctype="multipart/form-data" id="post-area" class="form" method="POST" action="/<?=$action?>">
    <div class="left-input-container">
        <div class="links-container">
            <?php if($action !== 'post/edit'): ?>
                <div class="keyword-check-msg">
                    생성할 심플 링크의 키워드를 입력해주세요.
                </div>
            <?php endif; ?>

            <div class="link-keyword-wrapper">
                <span class="highlight">*</span> 
                <div class="link-keyword-container">
                    <?php if($action === 'post/edit'): ?>
                        <input type='hidden' name="id" value="<?=$post->id?>">
                        <input type='hidden' name="link_keyword" value="<?=$post->link_keyword?>">
                        <label id="keyword"><?=$_SERVER['HTTP_HOST']?>/@<?=$post->link_keyword?></label>
                        
                    <?php else: ?>
                        <?=$_SERVER['HTTP_HOST']?>/@<input type="text" class="link-keyword" name="link_keyword" placeholder="키워드 입력 (한글, 영어, 숫자, - 가능)" required>
                    <?php endif; ?>
                </div>
            </div>

        
            <div class="arrow">
                <i class="fas fa-arrow-down"></i>
            </div>
            
            <div class="target-check-msg">
                연결할 타겟 주소를 입력해주세요.
            </div>
            <div class="link-target-wrapper">
                <span class="highlight">*</span> 
                <div class="link-target-container">
                    <input type="text" class="link-target" name="link_target" value="<?=$post->link?>" placeholder="ex) https://us02web.zoom.us/j/156852521239" required>
                </div>
            </div>
        </div>
        
        <div class="settings-container">
            <input type="radio" name="is_public" value="true" <?=$post->is_public ? 'checked' : ''?>> 
            <label>공개</label>
            <input type="radio" name="is_public" value="false" <?=$post->is_public ? '' : 'checked'?>> 
            <label>비공개</label>
            <br><br>

            <input type="radio" id="set-eventdate" name="eventdate" onclick="showDate()" <?=$post->begin_date ? 'checked' : ''?>> 
            <label class="option">유효 기간 설정</label>
            <input type="radio" id="unset-eventdate" name="eventdate" onclick="showNone()" <?=$post->begin_date ? '' : 'checked'?>> 
            <label class="option">유효 기간 미설정</label>

            <div id="eventdatetime-container">
                <label class="post-label"><span class="highlight">*</span> 시작</label>
                <input type="date" class="date-input" id="begin_date" name="begin_date" value="<?=$post->begin_date?>" required> <br>
                <label class="post-label"><span class="highlight">*</span> 종료</label>
                <input type="date" class="date-input" id="end_date" name="end_date" value="<?=$post->end_date?>" required>
            </div>
        
            <br><br><br>
            <div id="file-upload">
                <label for="file-input" class="file-upload-button">썸네일 이미지 업로드</label>
                <input type="file" id="file-input" name="thumbnail" class="file-input" accept="image/*" >
            </div>
            <br>
            <div class="thumbnail-box">
                <span id="preview-img" style= "display:block;">&nbsp; 게시글 사이즈 보기</span>
                <img id="show-poster" style="background-color:white" 
                    src="<?=$post->image_path ? $post->image_path : 'public/image/noImage.jpg' ?>" alt="no-image"/>
            </div>
        </div>
    </div>

    <div class="right-input-container">
        <div class="editor-container">
            <textarea name="content" id="editor"><?=$post->content?></textarea>
        </div>
        <div class="submit-button-container">
            <button type="button" class="submit-button">심플 링크 만들기</button>
        </div>
    </div>
</form> 

<? require('partials/footer.php'); ?>