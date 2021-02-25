<?php

function get_event_state($begin_date, $end_date){
    if($begin_date === null || $end_date === null){
        return ['status' => null];
    }

    $cur = date_create(date("Y-m-d"));
    $begin = date_create($begin_date);
    $end = date_create($end_date);

    $diff_started = date_diff($begin, $cur);
    $diff_ended = date_diff($end, $cur);

    $has_started = ($diff_started->format('%R%a') >= 0)? true : false;
    $has_ended = ($diff_ended->format('%R%a') > 0)? true: false;
    $is_lastday = ($diff_ended->format('%R%a') == 0)? true: false;

    if($has_started && $has_ended){
        return ['status' => 'end'];
    }
    else if($has_started && !$has_ended && $is_lastday){
        return ['status' => 'lastday', 'remain_date' => 0];
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