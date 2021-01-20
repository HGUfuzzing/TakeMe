<?php
    require_once("./lib/mysql_connect.php");
    require_once("./api/google_oauth2/client_setting.php");

    $query = "SELECT * FROM posting LEFT JOIN user ON posting.writer_id=user.id";
    $result = mysqli_query($conn, $query);
    $posts = array();
    while($row = mysqli_fetch_array($result)) {
        $post = array(
            'id' => $row['id'],
            'image' => 'data: image/;base64,' .  base64_encode($row['image']),
            'title' => htmlspecialchars($row['title']),
            'period' => $row['begin_date'] . ' ~ ' . $row['end_date'],
            'writer' => $row['lastname'] . ' ' . $row['firstname'],
            'writer_picture_url' => $row['picture_url']
        );
        if(mb_strlen($post['title'], "UTF-8") > 19) {
            $post['title'] = substr($post['title'], 0, 18) . ' ...'; 
        }

        array_push($posts, $post);
    }
?>


<?php
    include_once ($_SERVER['DOCUMENT_ROOT'] .  "/view/header.php");
?>


    <link rel="stylesheet" href="./mainpage.css">

    <div class="posts-container">
        <?php
        foreach ($posts as $post){
        ?>
        
        <div class="post">

            
            <div class="img-container">
            
                <img src="<?=$post['image']?>" alt="">
            
            </div>

            <div class="post-info">                
                <div class="title"><?=$post['title']?></div>
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