<?php
if(!isset($_GET['page_no'])) 
    return;

require_once($_SERVER['DOCUMENT_ROOT'] . '/lib/mysql_connect.php');

$page_no = $_GET['page_no'];
$no_of_records_per_page = 10;
$offset = ($page_no-1) * $no_of_records_per_page;

$sql = ''
. 'SELECT '
. 'posting.id, image, title, begin_date, end_date, '
. 'firstname, lastname, picture_url, link_keyword '
. ' FROM posting '  
. ' LEFT JOIN user ON posting.writer_id=user.id '
. ' LIMIT ' .  $offset . ', ' . $no_of_records_per_page;


$result = mysqli_query($conn, $sql);

$posts = array();
while($row = mysqli_fetch_array($result)) {
    $post = array(
        'id' => $row['id'],
        'image' => 'data: image/;base64,' .  base64_encode($row['image']),
        'title' => htmlspecialchars($row['title']),
        'period' => $row['begin_date'] . ' ~ ' . $row['end_date'],
        'writer' => $row['lastname'] . ' ' . $row['firstname'],
        'writer_picture_url' => $row['picture_url'],
        'keyword' => $row['link_keyword']
    );

    array_push($posts, $post);
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
            <div class="period"><?=$post['period']?></div>
            <div class="writer-info">
                <div class="picture">
                    <img src="<?=$post['writer_picture_url']?>">
                </div>
                <div class="name">
                    <?=$post['writer']?>
                </div>
            </div>
        </div>
    </div>

<?php
    }
?>