<?php
    require_once("./lib/mysql_connect.php");

    $query = "SELECT * FROM post LEFT JOIN user ON post.writer_id=user.id";
    $result = mysqli_query($conn, $query);
    $posts = array();
    while($row = mysqli_fetch_array($result)) {
        $post = array(
            'image_path' => $row['image_path'],
            'title' => htmlspecialchars($row['title']),
            'period' => $row['begin_date'] . ' ~ ' . $row['end_date'],
            'writer' => $row['lastname'] . ' ' . $row['firstname'],
            'writer_picture_url' => $row['picture_url']
        );
        if(mb_strlen($post['title'], "UTF-8") > 19) {
            $post['title'] = substr($post['title'], 0, 18) . ' ...'; 
        }
        array_push($posts, $post);
        //var_dump($post);
        //echo "<br><br>";
    }
    //die();




?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="./mainpage.css">
    
</head>
<body>

    <div class="posts-container">
        <?php
        foreach ($posts as $post){
        ?>
        <div class="post">
            <div class="img-container"><img src="<?=$post['image_path']?>" alt=""></div>
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