<?php
session_start();

if(!isset($_GET['page_no'])) 
    return;

require_once($_SERVER['DOCUMENT_ROOT'] . '/lib/mysql_connect.php');

$page_no = $_GET['page_no'];
$no_of_records_per_page = 5;
$offset = ($page_no-1) * $no_of_records_per_page;

$sql = ''
. 'SELECT '
. 'posting.id, image, title, begin_date, end_date, '
. 'firstname, lastname, picture_url, link_keyword '
. ' FROM posting '  
. ' LEFT JOIN user ON posting.writer_id=user.id '
. ' ORDER BY created_at DESC'
. ' LIMIT ' .  $offset . ', ' . $no_of_records_per_page;


$result = mysqli_query($conn, $sql);

$posts = array();
while($row = mysqli_fetch_array($result)) {
    $post = array(
        'id' => $row['id'],
        'image' => 'data: image/;base64,' .  base64_encode($row['image']),
        'title' => htmlspecialchars($row['title']),
        'begin_date' => $row['begin_date'],
        'end_date' => $row['end_date'],
        'writer' => $row['lastname'] . ' ' . $row['firstname'],
        'writer_picture_url' => $row['picture_url'],
        'keyword' => $row['link_keyword']
    );

    array_push($posts, $post);
}

if(count($posts) === 0) {
    echo 'end';
    return;
}

function show_event_day($begin_date, $end_date){
    $cur = date_create(date("Y-m-d"));
    $begin = date_create($begin_date);
    $end = date_create($end_date);

    $diff_started = date_diff($begin, $cur);
    $diff_ended = date_diff($end, $cur);

    $has_started = ($diff_started->format('%R%a') >= 0)? true : false;
    $has_ended = ($diff_ended->format('%R%a') >= 0)? true: false;

    if($has_started && $has_ended){
        return '<span class="event-info" style="color: red">끝난 이벤트</span>';
    }
    else if($has_started && !$has_ended){
        return '<span class="event-info" style="color: blue">[진행중] ' . abs($diff_ended->format('%R%a')) . '일 남음</span>';
    }
    else if(!$has_started && !$has_ended){
        return '<span class="event-info" style="color: green">시작까지 Day ' . $diff_started->format('%R%a') . '일</span>';
    }
    
    return '<span>잘못된 날짜</span>';
}


function print_star_icon($post_id) {
    global $conn;

    if(!isset($_SESSION['user_id'])) {
        return;
    }

    $sql = ''
    . 'SELECT * '
    . 'FROM favorite '
    . 'WHERE post_id = ' . $post_id . ' and user_id = ' . $_SESSION['user_id'];

    $result = mysqli_query($conn, $sql);
    if($result === false) {
        die('error : select from favorite');
    }

    if(mysqli_num_rows($result) === 0) {
        return '<i class="fa fa-star-o"></i>';
    }

    return '<i class="fa fa-star checked"></i>';
}
?>


<?php
    foreach ($posts as $post){
?>
    
    <div class="post">

        <div class="img-container">
            <a href="/<?=$post['keyword']?>">
            <img src="<?=$post['image']?>" alt="">
            </a>
        </div>

        <div class="post-info">
            <a class="title" href="/<?=$post['keyword']?>">
                <?=$post['title']?>
            </a>
            <div class="period">
                <?=show_event_day($post['begin_date'], $post['end_date']);?>
            </div>
            <div class="bottom">
                <div class="writer-info">
                    <div class="picture">
                        <img src="<?=$post['writer_picture_url']?>">
                    </div>
                    <div class="name">
                        <?=$post['writer']?>
                    </div>
                </div>
                <a class="favorite">
                    <?php echo print_star_icon($post['id'])?>
                </a>
            </div>
        </div>
    </div>

<?php
    }
?>