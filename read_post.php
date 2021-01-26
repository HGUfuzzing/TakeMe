<?php
    require_once($_SERVER['DOCUMENT_ROOT'] .  "/read_post_process.php");
    require_once($_SERVER['DOCUMENT_ROOT'] .  "/lib/links.php");

    include_once($_SERVER['DOCUMENT_ROOT'] .  "/view/header.php");
?>

<link rel="stylesheet" href="/read_post.css">
<script src="https://cdn.tiny.cloud/1/xvy7v46l3ku3z9ahq8ri2nv0yo4kp1epmg38njljdpvaywk3/tinymce/5/tinymce.min.js" 
referrerpolicy="origin"></script>
<script src="/add_tiny.js"> </script>
<script src="/read_post.js" defer> </script>

<div class="container">
    <section class="img-container">
        <img src="<?=$post['image']?>" alt="">
    </section>


    <section class="post-container">

        <header class="post__header">
            <div class="post__header__info">
                <div class="title">
                    <h1><?=$post['title']?></h1>
                </div>
                <div class="writer">
                    <img src="<?=$post['picture_url']?>" alt="">
                    <div class="name"><?=$post['name']?></div>
                </div>
                <div class="period">
                    <?=$post['period']?>
                </div>
            </div>

            <?php
                if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $post['writer_id']) {
            ?>
            <div class="post__header__setting">
                <a class="toggle" id="toggle">
                    <i class="fas fa-ellipsis-h"></i>
                </a>
                <div class="tooltip">
                    <div class="delete">
                        <form action="/delete_post_process.php" method="post">
                            <input type="hidden" name="post_id" value="<?=$post['id']?>">
                            <input type="hidden" name="writer_id" value="<?=$post['writer_id']?>">
                            <input type="submit" value="delete" id="delete-button">
                        </form>
                    </div>

                    <div class="edit">
                        <a href="<?=$url_update?>/<?=$post['keyword']?>">edit</a>
                    </div>
                </div>
            </div>
            <?php
                }
            ?>
        </header>
        

        <article class="contents-container">
    
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

            <div class="news-form">
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
        </article>
    </section>

</div>

</body>
</html>
