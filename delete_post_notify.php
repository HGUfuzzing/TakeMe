<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/lib/links.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/view/header.php');
?>

<style>
    .delete-message {
        position: absolute;
        top: 30%;
        left: 30%;
        padding: 5em;
        border: 1px solid black
    }

</style>

<div class="delete-message">
    삭제가 완료되었습니다. <br>
    <a href="<?=$url_main?>">메인페이지로 돌아가기</a>
</div>
