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



// replace space to '-' and remove all characters except english and number
// function url_escape($url){
//     return preg_replace('/[^a-zA-Z0-9가-힣-]/', '', str_replace(' ', '', $url));
// }

function is_valid_keyword($url){
    if(preg_match('/[^A-Za-z0-9가-힣-]/', $url)){
        return false;
    }
    return true;
}

function error_msg($message){
    echo '<div><p style="color: red; font-weight:bold;">'. $message .'</p>';
    die ('<a href="javascript:history.go(-1)">이전 페이지로 돌아가기</a></div>');
}



function auto_link($contents) {
	$pattern = '/(http|https|ftp|mms):\/\/[0-9a-z-]+(\.[_0-9a-z-]+)+(:[0-9]{2,4})?\/?';
	$pattern .= '([\.~_0-9a-z-]+\/?)*';
	$pattern .= '(\S+\.[_0-9a-z]+)?';
	$pattern .= '(\?[_0-9a-z#%&=\-\+]+)*/i';
	$replacement = '<a href="\\0" target="_blank">\\0</a>';
	return preg_replace($pattern, $replacement, $contents, -1);
}
