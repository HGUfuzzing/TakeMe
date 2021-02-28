<?php
require 'controllers/lib/functions.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: /login/google");
    return;
}

//default (write 일 경우)
$post = (object)[
    'post_id' => null,
    'title' => null,
    'image' => null,
    'image_path' => null,
    'content' => null,
    'link_keyword' => null,
    'link_target' => null,
    'begin_date' => null,
    'end_date' => null,
    'is_public' => true
];
$action = 'post/create';

//edit 일 경우.
if(isset($_GET['keyword']) ){
    $keyword = $_GET['keyword'];
    //keyword 넘겨받고, 수정 권한 있는지 확인
    $sql = ''
    . 'SELECT writer_id FROM posting ' 
    . 'WHERE link_keyword = "' . $keyword . '"';

    $row = App::get('database')->query($sql)[0];
    
    if($_SESSION['user_id'] != $row->writer_id){
        error_msg('수정 권한이 없습니다.');
    }

    // 수정 권한 확인 후에 전체적인 데이터 가져오기
    
    $post = App::get('database')->selectOne('posting', 'link_keyword = "' . $keyword . '"');
    $action = 'post/edit';
}

require('views/write.view.php');