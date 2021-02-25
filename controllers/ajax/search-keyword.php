<?php
require 'controllers/lib/main.lib.php';

$keyword = $_GET['keyword'];

$sql = ''
. 'SELECT '
. 'posting.id, image, image_path, begin_date, end_date, '
. 'firstname, lastname, picture_url, link_keyword '
. 'FROM posting ' 
. 'LEFT JOIN user ON posting.writer_id=user.id '
. 'WHERE link_keyword like "%' . $keyword . '%" '
. 'AND is_approved = 1 '
. 'ORDER BY CHAR_LENGTH(link_keyword) ';


$posts = App::get('database')->query($sql);

if(count($posts) === 0) {
    echo 'end';
    return;
}


foreach($posts as $post) 
{
    $event = get_event_state($post->begin_date, $post->end_date);
    $post->status = $event['status'];
    $post->remain_date = $event['remain_date'];
    $post->is_favorite = print_star_icon($post->id);
}

require 'views/main.pagination.view.php';