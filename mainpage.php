<?php
    session_start();

    require_once("./lib/mysql_connect.php");
    require_once("./api/google_oauth2/client_setting.php");

    $query = "SELECT * FROM posting LEFT JOIN user ON posting.writer_id=user.id";
    $result = mysqli_query($conn, $query);
    $posts = array();
    while($row = mysqli_fetch_array($result)) {
        $post = array(
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

        //print_r($post);
        //die("<br>@<br>");
    }

    $login_message = "";
    if(!isset($_SESSION['user_id'])) {
        $login_message = "<a href=\"" . $callback_url . "\"> 로그인 </a>";
    }
    else {
        $sql = "SELECT firstname, lastname FROM user WHERE id = " . $_SESSION['user_id'];
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        if($result === false) {
            die("fail to get login");
        }
        if(mysqli_num_rows($result) === 0) {
            unset($_SESSION['user_id']);
            header("Location: " . $callback_uri);
        }
        else {
            $login_message = "Hello, " . $row['firstname'] . ' ' . $row['lastname'] . ' ' . '<a href="' . $callback_url . '?logout=1">logout<a>';
        }
    }



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

    <header> <?=$login_message?> </header>
    <div class="posts-container">
        <?php
        foreach ($posts as $post){
        ?>
        <div class="post">
            <div class="img-container"><img src="<?=$post['image']?>" alt=""></div>
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