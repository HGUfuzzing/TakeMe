<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/view/header.php');
$mainpage_url = 'http://' . $_SERVER['HTTP_HOST'] . '/mainpage.php';
?>

<style>
    div {
        position: absolute;
        top: 30%;
        left: 30%;
        padding: 5em;
        border: 1px solid black
    }

</style>

<div>
    삭제가 완료되었습니다. <br>
    <a href="<?=$mainpage_url?>">메인페이지로 돌아가기</a>
</div>
