<?php
if(!isset($_SESSION['user_id'])) {
    header("Location: /main");
    return;
}

$post = [
    'post_id' => NULL,
    'title' => '',
    'image' => '',
    'image_path' => '',
    'content' => '',
    'link_keyword' => '',
    'link' => '',
    'begin_date' => '',
    'end_date' => '',
];
$post = (object)$post;

$action = 'post/create';

if(isset($_GET['keyword']) ){
    $keyword = $_GET['keyword'];
    //keyword 넘겨받고, 수정 권한 있는지 확인
    $sql = ''
    . 'SELECT writer_id FROM posting ' 
    . 'WHERE link_keyword = "' . $keyword . '"';

    $row = App::get('database')->query($sql)[0];

    if($_SESSION['user_id'] != $row->writer_id){
        echo 
        '<style>
            #alarm {display: inline-block; border: 1px solid black; padding: 2rem; justify-content: center; font-size: 2rem; margin:auto}
        </style>';
        echo '<div id = "alarm" style="color: red"><p> 수정 권한이 없습니다.</p>';
        die ('<a id = "alarm-link" style="color: blue" href="javascript:history.go(-1)">이전 페이지로 돌아가기</a></div>');
    }

    // 수정 권한 확인 후에 전체적인 데이터 가져오기
    $sql = '  SELECT *,   DATE_FORMAT(begin_date, "%Y-%m-%d") AS e_begin_date, 
                            DATE_FORMAT(end_date, "%Y-%m-%d")  AS e_end_date
                FROM posting 
                WHERE link_keyword = "' . $keyword . '"';
    
    $post = App::get('database')->query($sql)[0];

    $action = 'post/edit';
}

require('views/write.view.php');