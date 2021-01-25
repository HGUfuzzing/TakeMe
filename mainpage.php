<?php
    require_once($_SERVER['DOCUMENT_ROOT'] .  "/mainpage_process.php");

    include_once ($_SERVER['DOCUMENT_ROOT'] .  "/view/header.php");
?>


    <link rel="stylesheet" href="/mainpage.css">

    <div class="posts-container">
        <?php
        foreach ($posts as $post){
        ?>
        
        <div class="post">

            <div class="img-container">
                <a href="/<?=$post['keyword']?>">
                <img src="<?=$post['image']?>" alt="">
                </a>
            
            </div>

            <div class="post-info">
            <a href="/<?=$post['keyword']?>" class="title">
                <?=$post['title']?>
            </a>
                <div class="period"><?=$post['period']?></div>
                <div class="writer-info">
                    <div class="picture"><img src="<?=$post['writer_picture_url']?>"></div>
                    <div class="name"><?=$post['writer']?></div>
                </div>
            </div>
        </div>

        <?php
        }
        ?>
    </div>

</body>
</html>