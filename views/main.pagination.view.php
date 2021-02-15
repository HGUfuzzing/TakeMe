<?php foreach ($posts as $post): ?>
        <div class="post">
            <div class="img-container">
                <a href="/read?keyword=<?=$post->link_keyword?>">
                <img src="data: image;base64, <?=$post->image?>" alt="">
                </a>
            </div>

            <div class="post-info">
                <a class="title" href="/read?keyword=<?=$post->link_keyword?>">
                    <?=$post->title?>
                </a>
                <div class="period">
                    
                    <?php if($post->status === 'running'): ?>
                        <span class="event-info" style="color: blue"> [진행중] <?=$post->remain_date?>일 남음 </span>

                    <?php elseif($post->status === 'upcomming'): ?>
                        <span class="event-info" style="color: green">시작까지 Day <?=$post->remain_date?>일</span>
                    
                    <?php elseif($post->status === 'end'): ?>
                        <span class="event-info" style="color: red">끝난 이벤트</span>
                    
                    <?php endif; ?>
                </div>
                <div class="bottom">
                    <div class="writer-info">
                        <div class="picture">
                            <img src="<?=$post->picture_url?>">
                        </div>
                        <div class="name">
                            <?=$post->firstname . ' ' . $post->lastname ?>
                        </div>
                    </div>

                    <a class="favorite" post_id="<?=$post->id?>" status="<?=$post->is_favorite?>">
                        <?php if($post->is_favorite): ?>
                            <i class="fas fa-star"></i>
                        <?php else: ?>
                            <i class="far fa-star"></i>
                        <?php endif; ?>
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>