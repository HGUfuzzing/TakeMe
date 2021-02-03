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
                <div class="create_date">
                    생성일 : <?=$post['created_at']?>
                </div>
            </div>

            <div id='favorite' post_id="<?= $post['id']?>" status="<?=$favorite_status ?>">
                <?php
                    if(isset($_SESSION['user_id'])) {
                        if($favorite_status === 'true')
                            echo ("<i id='star-icon' class='fa fa-star checked'></i>");
                        else if ($favorite_status === 'false')
                            echo ("<i id='star-icon' class='fa fa-star-o' aria-hidden='true'></i>");
                    }
                ?>
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
                        <a href="<?=$url_update?>/<?=$post['keyword']?>" id="edit-button">edit</a>
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
            <div class="news-container">
                <div class="news">
                    <div class="news__writer">
                        <img src="<?=$post['picture_url']?>" alt="">
                        <div class="name"><?=$post['name']?></div>
                    </div>
                    <div class="news__create_date">
                        생성일 : <?=$news['created_at']?>
                    </div>
                    <div class="news__content">
                        <?=$news['content']?>
                    </div>
                </div>
                <?php
                    if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $post['writer_id']) {
                ?>
                <a href = "<?=$url_root?>/delete_news_process.php/?keyword=<?=$post['keyword']?>&news_id=<?=$news['id']?>" class = "news__delete">
                    <i class="fas fa-times"></i>
                </a>
                <?php
                    }
                ?>

            </div>
            <?php
                }
            ?>

            <?php
                if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $post['writer_id']) {
            ?>

            <div class="form-news">
                <form action="/create_news_process.php" method="post">
                <input type="hidden" name="keyword" value="<?=$post['keyword']?>">
                <input type="hidden" name="post_id" value="<?=$post['id']?>">
                <textarea name="content" id="editor"></textarea>
                <input type="submit" id="news-submit-button">
                </form>
            </div>

            <div class="loading-img-container">
                <img src="/images/loading.gif" alt="">
            </div>
            

            <?php
                }
            ?>
        </article>
    </section>

</div>

</body>
</html>
