<?php
    require_once("./lib/mysql_connect.php");
    require_once("./api/google_oauth2/client_setting.php");

    $query = ''
    . 'SELECT '
    . 'posting.id, image, title, begin_date, end_date, '
    . 'firstname, lastname, picture_url, link_keyword '
                . ' FROM posting '  
                . ' LEFT JOIN user ON posting.writer_id=user.id';
    
    $result = mysqli_query($conn, $query);
    $posts = array();
    while($row = mysqli_fetch_array($result)) {
        $post = array(
            'id' => $row['id'],
            'image' => 'data: image/;base64,' . $row['image'],
            'title' => htmlspecialchars($row['title']),
            'period' => $row['begin_date'] . ' ~ ' . $row['end_date'],
            'writer' => $row['lastname'] . ' ' . $row['firstname'],
            'writer_picture_url' => $row['picture_url'],
            'keyword' => $row['link_keyword']
        );

        array_push($posts, $post);
    }
?>