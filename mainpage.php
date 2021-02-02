<?php
    require_once($_SERVER['DOCUMENT_ROOT'] .  "/mainpage_process.php");

    include_once ($_SERVER['DOCUMENT_ROOT'] .  "/view/header.php");
?>


    <link rel="stylesheet" href="/mainpage.css">
    <script src="/mainpage.js" defer></script>
    <div class="posts-container">
        
    </div>
    <div class="loading-img-container">
        <img src="/images/loading.gif" alt="">
    </div>
    <input type="hidden" id="page_no" value="1">

</body>
</html>