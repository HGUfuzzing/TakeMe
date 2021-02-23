<?php require('partials/header.php'); ?>  

<link rel="stylesheet" href="/public/css/read.css">
<script src="https://cdn.tiny.cloud/1/xvy7v46l3ku3z9ahq8ri2nv0yo4kp1epmg38njljdpvaywk3/tinymce/5/tinymce.min.js" 
referrerpolicy="origin"></script>
<script src="/public/js/add_tiny.js"> </script>
<script src="/public/js/read.js" defer> </script>

<div class="container">
    <section class="img-container">
        <img src="<?=$post->image_path?>" alt="">
    </section>

    <section class="post-container">
        <header class="post__header">
            <div class="post__header__header">
                <div class="link_keyword" data-tooltip-text="주소 복사">
                    @<?=$post->link_keyword?>
                </div>
                <div class="buttons">
                     <i class="link-copy far fa-clipboard" data-tooltip-text="주소 복사"></i>
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <div id='favorite' post_id="<?= $post_id?>" status="<?=$favorite_status ? 'true' : 'false' ?>">
                            <?php if($favorite_status): ?>
                                <i id="star-icon" class="fas fa-star"></i>
                            <?php else: ?>
                                <i id="star-icon" class="far fa-star"></i>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $post->writer_id): ?>
                        <div class="buttons__setting">
                            <a class="toggle" id="toggle">
                                <i class="fas fa-ellipsis-h"></i>
                            </a>
                            <div class="tooltip">
                                <div class="delete">
                                    <form action="/post/delete" method="post">
                                        <input type="hidden" name="post_id" value="<?=$post_id?>">
                                        <input type="hidden" name="writer_id" value="<?=$post->writer_id?>">
                                        <input type="submit" value="delete" id="delete-button">
                                    </form>
                                </div>
                                <div class="edit">
                                    <a href="/write?keyword=<?=$post->link_keyword?>" id="edit-button">edit</a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="post__header__info">
                <div class="target_link" onclick="window.open('<?=$post->link?>', '_blank').focus();">
                    <h4>Click!!</h4>
                    <h5>타겟 링크 주소로 이동</h5>
                    <ul>
                        <li>
                            <a href="<?= $post->link ?>" target="_blank">
                                <?= $post->link ?>
                            </a> 
                        </li>
                    </ul>
                </div>
                <div class="writer">
                    <img src="<?=$post->picture_url?>" alt="">
                    <div class="name"><?=$post->firstname?> <?=$post->lastname?></div>
                </div>
                <div class="create_date">
                    생성일 : <?=$post->created_at?>
                </div>
            </div>
        </header>
        
        <article class="contents-container">
            <div class="content">
                <?=$post->content?>
            </div>
            <?php foreach($newses as $news): ?>
                <div class="news-container">
                    <div class="news">
                        <div class="news__writer">
                            <img src="<?=$post->picture_url?>" alt="">
                            <div class="name"><?=$post->firstname?> <?=$post->lastname?></div>
                        </div>
                        <div class="news__create_date">
                            생성일 : <?=$news->created_at?>
                        </div>
                        <div class="news__content">
                            <?=$news->content?>
                        </div>
                    </div>
                    <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $post->writer_id): ?>
                    <form class="news-delete-form" action="/news/delete" method="post">
                        <input type="hidden" name="keyword" value="<?=$post->link_keyword?>">
                        <input type="hidden" name="news_id" value="<?=$news->id?>">
                        <a class = "news__delete" onclick="this.parentNode.submit(); return false;">
                            <i class="fas fa-times"></i>
                        </a>
                    </form>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>

            <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $post->writer_id): ?>
                <div class="form-news">
                    <form action="/news/create" method="post">
                        <input type="hidden" name="keyword" value="<?=$post->link_keyword?>">
                        <input type="hidden" name="post_id" value="<?=$post_id?>">
                        <textarea name="content" id="editor"></textarea>
                        <input type="submit" id="news-submit-button">
                    </form>
                </div>

                <div class="loading-img-container">
                    <img src="/public/image/loading.gif" alt="">
                </div>
            <?php endif; ?>
        </article>
    </section>

</div>

<?php require('partials/footer.php'); ?>