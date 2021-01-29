<?php
    require_once($_SERVER['DOCUMENT_ROOT'] .  "/mainpage_process.php");

    include_once ($_SERVER['DOCUMENT_ROOT'] .  "/view/header.php");
?>


    <link rel="stylesheet" href="/mainpage.css">
    <script src="/mainpage.js" defer></script>
    <div class="posts-container">
        
    </div>
    
    <div class="more-page">
        <button class="more-page-btn"> 더보기 </button>
    </div>
    <input type="hidden" id="page_no" value="1">

</body>
</html>