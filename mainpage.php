<?php
    require_once("./lib/mysql_connect.php");
    $query = "SELECT * FROM post";
    $result = mysqli_query($conn, $query);
    $posts = array();
    while($row = mysqli_fetch_array($result)) {
        $post = array(
            'image_path' => $row['image_path'],
            'title' => htmlspecialchars($row['title'])
        );
        array_push($posts, $post);
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
    .posts_container {
        width: 80vw;
        height: 80vh;
        display: flex;
        flex-flow: row wrap;
        justify-content: space-between;
        margin: auto;
    }
    .post {
        margin: 10px;
        display: flex;
        flex-direction: column;
        
    }

    a {
        text-decoration: none;
    }
    .post .title{
        color: gray;
        margin: auto;
        font-size: 1.5em;
    }

    .post .title:hover {
        color: gray;
        text-decoration: underline;
    }

    .post img:hover{
        color: gray;
        text-decoration: underline;
        transform:scale(1.1); 
    }

    img {
        width: 20em; 
        height: auto;
        border-radius: 10%;
        
    }

    </style>
</head>
<body>

    <div class="posts_container">
        <?php
        foreach ($posts as $post){
        ?>
        <div class="post">
        <a href="#">
            <img src="<?=$post['image_path']?>" alt="">
            <div class="title"><?=$post['title']?></div>
        </a>
        </div>

        <?php
        }
        ?>
    </div>

</body>
</html>