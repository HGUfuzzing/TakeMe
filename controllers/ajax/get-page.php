<?php

$page_no = $_GET['page_no'];
$no_of_records_per_page = 5;
$offset = ($page_no-1) * $no_of_records_per_page;

$sql = ''
. 'SELECT '
. 'posting.id, image, image_path, title, begin_date, end_date, '
. 'firstname, lastname, picture_url, link_keyword '
. ' FROM posting '  
. ' LEFT JOIN user ON posting.writer_id=user.id '
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








function get_event_state($begin_date, $end_date){
    if($begin_date === null || $end_date === null)
        return ['status' => null];
    
    $cur = date_create(date("Y-m-d"));
    $begin = date_create($begin_date);
    $end = date_create($end_date);

    $diff_started = date_diff($begin, $cur);
    $diff_ended = date_diff($end, $cur);

    $has_started = ($diff_started->format('%R%a') >= 0)? true : false;
    $has_ended = ($diff_ended->format('%R%a') >= 0)? true: false;

    if($has_started && $has_ended){
        return ['status' => 'end'];
    }
    else if($has_started && !$has_ended){
        return ['status' => 'running', 'remain_date' => abs($diff_ended->format('%R%a'))];
    }
    else if(!$has_started && !$has_ended){
        return ['status' => 'upcomming', 'remain_date' => $diff_started->format('%R%a')];
    }
    
    return '<span>잘못된 날짜</span>';
}


function print_star_icon($post_id) {
    global $conn;

    if(!isset($_SESSION['user_id'])) {
        return;
    }

    $sql = ''
    . 'SELECT id '
    . 'FROM favorite '
    . 'WHERE post_id = ' . $post_id . ' and user_id = ' . $_SESSION['user_id'];

    $count = App::get('database')->rowCount($sql);

    if($count === 0) {
        return false;
    }

    return true;
}