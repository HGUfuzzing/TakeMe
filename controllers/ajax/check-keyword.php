<?php
$keyword = $_GET['keyword'];

if($keyword === '') {
    echo 'empty';
    return;
}

if(preg_match('/^[0-9a-zA-Z가-힣-]+$/', $keyword) == false) {
    echo 'invalid';
    return;
}

$sql = ''
. 'SELECT * FROM posting WHERE link_keyword = "' . $keyword . '"';

$count = App::get('database')->rowCount($sql);

if($count == 0) {
    echo 'good';
}
else {
    echo 'duplicate';
}
?>