<?php require('partials/header.php'); ?>  

<link rel="stylesheet" href="/public/css/main.css">
<script src="/public/js/main.js" defer></script>

<div class="search-container">
    @
    <input type="text" name="text" placeholder="이동할 이벤트의 키워드를 입력하세요.">
    <button>GO</button>
</div>

<div class="posts-container">

</div>
<div class="loading-img-container">
    <img src="/public/image/loading.gif" alt="">
</div>
<input type="hidden" id="page_no" value="1">

<?php require('partials/footer.php'); ?>