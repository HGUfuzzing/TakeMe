</DOCTYPE! html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="./create_post.css">
    </head>
    <body>
        <form enctype="multipart/form-data" id="area" method="POST" action="./create_post_process.php"> 
            <div id="title"> <label class="post-label">* 글 제목:</label> <input type="text" id="title-input" name="title-input" required></div>
            <div id="link-keyword"> <label>* 검색 링크 키워드:</label>  <input type="text" id="link-keyword-input" name="link-keyword-input" placeholder="특수문자 제외한 영어로 작성하세요" required></div>
            <div id = "setting-date-area">
                <div id="start-date"><label>* 게시 시작 기간:</label><input type="date" id="start-date-input" name="start-date-input" required></div> 
                <div id="end-date"><label>* 게시 종료 기간:</label><input type="date" id="end-date-input" name="end-date-input" required> </div>
            </div>
            <div id="file-upload"><label>포스터 업로드: </label><input type="file" id="file-input" name="file-input"></div>
            <div id="body"><label>본문: </label><textarea id="body-textarea" name="body-textarea"></textarea></div>
            <div id="button-area">
                <input type="submit" id="submit-button" name="submit-button">
            </div>
        </form>
    </body>
</html>