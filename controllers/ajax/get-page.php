<?php
require 'controllers/lib/main.lib.php';

$page_no = $_GET['page_no'];
$no_of_records_per_page = 5;
$offset = ($page_no-1) * $no_of_records_per_page;

$sql = ''
. 'SELECT '
. 'posting.id, image_path, title, begin_date, end_date, '
. 'firstname, lastname, picture_url, link_keyword '
. ' FROM posting '  
. ' LEFT JOIN user ON posting.writer_id=user.id '
. ' WHERE is_approved = 1 '
. ' ORDER BY created_at DESC'
. ' LIMIT ' .  $offset . ', ' . $no_of_records_per_page;


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
