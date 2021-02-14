<?php

$news = App::get('database')->selectOne('news', 'id = ' . $_POST['news_id']);

if(!isset($_SESSION['user_id']) || $news->user_id != $_SESSION['user_id']) {
    header('Location: /');
    die();
}

App::get('database')->delete('news', 'id = ' . $_POST['news_id']);

header('Location: /read?keyword=' . $_POST['keyword']);


