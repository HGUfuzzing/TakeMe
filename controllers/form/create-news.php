<?php
if(!isset($_SESSION['user_id'])) {
    header("Location: /");
    return;
}


$news = array (
    'post_id' => $_POST['post_id'],
    'user_id' => $_SESSION['user_id'],
    'content' => $_POST['content']
);


App::get('database')->insert('news', $news);


//이메일 전송
$post = App::get('database')->selectOne('posting', 'id = ' . $news['post_id']);

$post_title = $post->title;
$post_keyword = $post->link_keyword;

$sql = ''
. 'SELECT email FROM favorite '
. 'LEFT JOIN user ON favorite.user_id = user.id '
. 'where post_id = ' . $news['post_id'];

$rows = App::get('database')->query($sql);


$email_addresses = [];
foreach($rows as $row) {
    $email_addresses[] = $row->email;
}


require_once 'controllers/lib/mail.php';

$short_post_title = $post_title;
$encodes = array('ASCII', 'UTF-8', 'EUC-KR');
$title_encode = mb_detect_encoding($post_title, $encodes); 

if(mb_strlen($short_post_title, $title_encode) > 7) {
    $short_post_title = mb_substr($short_post_title, 0, 7, $title_encode);
    $short_post_title .= '...';
}

$subject = '즐겨찾기 한 게시물 "' . $short_post_title . '" 에 news가 생겼습니다.';
$content = str_replace(array('\\r\\n', '\\r\\n', '\\r', '\\n'),'',$news['content']);
$body = ''
. '즐겨찾기 한 게시물 "' . $post_title . '" 에 news가 생겼습니다. <br><br>'
. '<a href="'. $url_root . '/' . $post_keyword . '"> 바로가기 </a><br>'
. '<br>------------------------------------------------------------------------ <br> '
. '<div> ' . $content. '</div>'
. '<br>------------------------------------------------------------------------ <br> ';
$result = send_mail($email_addresses, $subject, $body);

if($result === false)
    die('<br><br>send_email fail');

header("Location: /read?keyword=" . $_POST['keyword']);