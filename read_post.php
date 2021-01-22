<?php
    require_once($_SERVER['DOCUMENT_ROOT'] .  "/read_post_process.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/read_reply_process.php");

    include_once($_SERVER['DOCUMENT_ROOT'] .  "/view/header.php");
?>

<h1>제목 : <?=$post['title']?></h1>
<h2>글쓴이 : <?=$post['name']?></h2>
<h2>기간 : <?=$post['period']?></h2>
<h2>내용 :</h2> 
<?=$post['content']?>


<h2>reply list</h2>
<?=$reply_msg?>
<form method="GET" action="/update_post.php">
    <input type="text" style="display:none" name="post_id" value="<?=$post_id?>">
    <input type="submit" value="수정">
</form>
</body>
</html>
