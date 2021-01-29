<!-- check favorite -->
<?php
    session_start();

    if(isset($_SESSION['user_id'])) {
        $keyword = $_GET['keyword'];
        $sql = 'SELECT count(*) FROM favorite 
                WHERE link_keyword = "'. $keyword . '" AND ' .
                'user_id = ' . $_SESSION['user_id'] . ';';

        $result = mysqli_query($conn, $sql);
        if($result === false) {
            die ('<a href="javascript:history.go(-1)" style="color: red;">이전 페이지로 돌아가기</a>');
        }

        $row = mysqli_fetch_array($result);
        $count = $row[0];
        $favorite_status = "";

        if($count > 0)
            $favorite_status = "true";
        else if ($count == 0)
            $favorite_status = "false";
        else 
            die('whhhaaat');
        }
?>