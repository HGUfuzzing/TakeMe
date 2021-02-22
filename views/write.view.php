<?php require('partials/header.php'); ?>

<link rel="stylesheet" href="/public/css/write.css">
<script src="https://cdn.tiny.cloud/1/xvy7v46l3ku3z9ahq8ri2nv0yo4kp1epmg38njljdpvaywk3/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script src="/public/js/add_tiny.js"> </script>
<script src="/public/js/write.js" defer></script>

<form enctype="multipart/form-data" id="post-area" method="POST" action="/<?=$action?>">
    <?php if($action == 'post/edit'): ?>
        <input type='text' style='display:none' name="id" value="<?=$post->id?>">
        <input type='text' style='display:none' name="link-keyword" value="<?=$post->link_keyword?>">
    <?php endif; ?>

    <div id="block1" class="col">
        <div id="col1">
            <div class="input-block">
                <?php if($action === 'post/edit'): ?>
                    <label class="post-label">
                        포스트 주소
                    </label>
                    <label id="keyword">http://gohandong.cafe24.com/@<?=$post->link_keyword?></label>
                <?php else: ?>
                    <label class="post-label">
                        <span class="highlight">*</span> 키워드
                    </label><br>
                    @<input type="text" id="link-keyword-input" name="link-keyword-input" placeholder="한글, 영어, 숫자, - 가능" required>
                <?php endif; ?>

                <div class="keyword_check_msg"></div>
            </div>
            <div class = "input-block">
                <label class="post-label">타겟 링크</label><br/>
                <input type="text" name="url-input" value="<?=$post->link?>" placeholder="Zoom, Youtube 링크 등..">
            </div>
            <div class="input-block">
                <label class="post-label">유효 기간</label>
                <input type="radio" id="set-eventdate" name="eventdate" onclick="showDate()" <?php if($post->begin_date !== null) echo "checked"?>> <label class="option">설정</label>
                <input type="radio" id="unset-eventdate" name="eventdate" onclick="showNone()" <?php if($post->begin_date === null) echo "checked"?>> <label class="option">미설정</label>
                
                <div id="eventdatetime-container">
                    <label class="post-label"><span class="highlight">*</span> 시작</label>
                    <input type="date" class="date-input" id="begin_date" name="begin_date" value="<?=$post->e_begin_date?>" required> <br><br>
                    <label class="post-label"><span class="highlight">*</span> 종료</label>
                    <input type="date" class="date-input" id="end_date" name="end_date" value="<?=$post->e_end_date?>" required>
                </div>
            </div>
            <div class="input-block" id="file-upload">
                <label class="post-label">이미지 업로드 </label>
                <input type='file' id='file-input' name='file-input' accept="image/*">
            </div>
        </div>
            <?php if($post->image_path != ''): ?>
                <div id = "col2" class="input-block">
                <span id="preview-img" style= "display:block; text-align:center;">게시글 사이즈 보기</span>
                <img id="show-poster" style="background-color:white" src="<?=$post->image_path?>" alt="no-image"/>
            <?php else: ?>
                <div id="col2" style="visibility:hidden;" class="input-block">
                <span id="preview-img" style= "display:none; text-align:center;">게시글 사이즈 보기</span>
                <img id="show-poster" style= "visibility:hidden;" alt="no img"></img>
            <?php endif; ?>
        </div>
    </div>
    <div id='block2'>
        <div id="editor-container">
            <textarea name="editor" id="editor"><?=$post->content?></textarea>
        </div>
        <div class="row">
            <input type="submit" id="submit-button" name="submit-button">
            <input type="submit" id="tmp-button" name="tmp-button" value="임시저장">
        </div>
    </div>
</form> 

<? require('partials/footer.php'); ?>