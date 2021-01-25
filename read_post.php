<?php
    require_once($_SERVER['DOCUMENT_ROOT'] .  "/read_post_process.php");
    require_once($_SERVER['DOCUMENT_ROOT'] .  "/lib/links.php");

    include_once($_SERVER['DOCUMENT_ROOT'] .  "/view/header.php");
?>

<link rel="stylesheet" href="/read_post.css">
<script src="https://cdn.tiny.cloud/1/xvy7v46l3ku3z9ahq8ri2nv0yo4kp1epmg38njljdpvaywk3/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script> 
tinymce.init({
    selector: 'textarea',
    height: "500",
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


<div class="container">


<?php
    if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $post['writer_id']) {
?>
<div class="delete">
    <form action="/delete_post_process.php" method="post">
        <input type="hidden" name="post_id" value="<?=$post['id']?>">
        <input type="hidden" name="writer_id" value="<?=$post['writer_id']?>">
        <input type="submit" value="삭제하기">
    </form>
</div>

<div class="edit">
    <a href="<?=$url_update?>/<?=$post['keyword']?>">edit</a>
</div>
<?php
    }
?>

<div class="information">
    <div class="title">
        <h1><?=$post['title']?></h1>
    </div>
        <div>
            <?=$post['name']?>
        </div>
        <div>
            <?=$post['period']?>
        </div>
</div>

<div class="img-container">
    <img src="<?=$post['image']?>" alt="">
</div>


<div class="content">
    <?=$post['content']?>
</div>


<?php
    foreach($newses as $news) {
?>
<div class="news">
    <?=$news['content']?>
</div>
<?php
    }
?>

<?php
    if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $post['writer_id']) {
?>

<div class="content">
    글 추가 작성
    <form action="/create_news_process.php" method="post">
    <input type="hidden" name="keyword" value="<?=$post['keyword']?>">
    <input type="hidden" name="post_id" value="<?=$post['id']?>">
    <textarea name="content" id="editor"></textarea>
    <input type="submit" id="submit-button" name="submit-button">
    </form>
</div>

<?php
    }
?>

</div>

</body>
</html>
