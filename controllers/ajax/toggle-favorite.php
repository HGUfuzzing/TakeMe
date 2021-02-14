<?php
$status = $_GET['status'];
$post_id = $_GET['post_id'];

if($post_id === '') {
    echo 'no post_id';
    return;
}

$user_id = $_SESSION['user_id'];

// set -> unset
if($status === 'true'){
    App::get('database')->delete('favorite', "user_id = {$user_id} AND post_id = {$post_id}");

    echo 'unset';
}
//unset -> set
else{
    $sql = ''
    . 'INSERT INTO favorite (user_id, post_id) '
    . 'VALUES (' . $user_id . ', ' . $post_id . ')';
    // die($sql);

    $data = [
        'user_id' => $user_id,
        'post_id' => $post_id
    ];

    App::get('database')->insert('favorite', $data);

    echo 'set';
}
?>