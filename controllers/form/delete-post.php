<?php
if(isset($_SESSION['user_id']) && $_POST['writer_id'] == $_SESSION['user_id']) {

    //TODO: 해당하는 news도 같이 삭제해야 함.

    App::get('database')->delete('posting', 'id = ' . $_POST['post_id']);
}

header("Location: /");
?>