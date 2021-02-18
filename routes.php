<?php

//For pages
$router->get('', 'controllers/main.php');
$router->get('main', 'controllers/main.php');
$router->get('write', 'controllers/write.php');

$router->get('login/google', 'controllers/google-login.php');
$router->get('read', 'controllers/read.php');


//For Form(post method)
$router->post('post/create', 'controllers/form/create-post.php');
$router->post('post/edit', 'controllers/form/edit-post.php');
$router->post('post/delete', 'controllers/form/delete-post.php');

$router->post('news/create', 'controllers/form/create-news.php');
$router->post('news/delete', 'controllers/form/delete-news.php');


//For ajax
$router->get('ajax/write/check-keyword', 'controllers/ajax/check-keyword.php');
$router->get('ajax/main/search-keyword', 'controllers/ajax/search-keyword.php');
$router->get('ajax/main/get-page', 'controllers/ajax/get-page.php');
$router->get('ajax/read/toggle-favorite', 'controllers/ajax/toggle-favorite.php');



//$router->get('test', 'controllers/test.php');