<?php foreach ($posts as $post): ?>
        <div class="post">
            <div class="img-container">
                <a href="/@<?=$post->link_keyword?>">
                <img src="<?=$post->image_path?>" alt="">
                </a>
            </div>

            <div class="post-info">
                <a class="title" href="/@<?=$post->link_keyword?>">
                    @<?=$post->link_keyword?>
                </a>
                <div class="period">
                    
                    <?php if($post->status === 'running'): ?>
                        <span class="event-info" style="color: blue"> [진행중] <?=$post->remain_date?>일 남음 </span>

                    <?php elseif($post->status === 'lastday'): ?>
                        <span class="event-info" style="color: red; font-weight:bold;">[진행중] 오늘 마감</span>

                    <?php elseif($post->status === 'upcomming'): ?>
                        <span class="event-info" style="color: green">시작까지 Day <?=$post->remain_date?>일</span>

                    <?php elseif($post->status === 'end'): ?>
                        <span class="event-info" style="color: gray">끝난 이벤트</span>
                    
                    <?php endif; ?>
                </div>
                <div class="bottom">
                    <?php if(isset($_SESSION['user_id'])): ?>
                    <a class="favorite" post_id="<?=$post->id?>" status="<?=$post->is_favorite?>">
                        <?php if($post->is_favorite): ?>
                            <i class="fas fa-star"></i>
                        <?php endif; ?>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>