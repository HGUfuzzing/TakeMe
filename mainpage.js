'use strict';

const loadingImg = document.querySelector('.loading-img-container img');
const pageNo = document.querySelector('#page_no');
const postContainer = document.querySelector('.posts-container');

//처음 load시 page 가져오기.
document.body.onload = () => {
    if(document.body.scrollHeight <= window.innerHeight)
        get_more_page();
}

//스크롤이 맨 밑으로 내려갔을 때 page 가져오기
window.addEventListener('scroll', (e) => {
    if(document.body.scrollHeight - window.innerHeight <= window.scrollY) {
        get_more_page();
    }
})

function get_more_page() {
    
    // 마지막 페이지면 그냥 종료 
    if(pageNo.value === 'end')
        return;
    
    //loading 이미지 on
    loadingImg.style.display = 'block';

    const req = new XMLHttpRequest();
    req.onreadystatechange = () => {
        if(req.readyState === XMLHttpRequest.DONE) {
            if(req.status === 200) {
                switch(req.responseText) {
                    case 'end':
                        pageNo.value = 'end';
                        break;

                    default :
                        //print page
                        postContainer.innerHTML = postContainer.innerHTML + req.responseText;
                        pageNo.value = parseInt(pageNo.value) + 1;
                }
                
                //loading 이미지 off
                loadingImg.style.display = 'none';
            }
            else {
                alert('request에 뭔가 문제가 있어요.');
            }
        }
    }

    // 동기적으로 가져오기. (같은 페이지 중복 호출 방지)
    req.open('GET', '/ajax/get_page.php?page_no=' + pageNo.value, false);
    req.send();

    // 스크롤이 생길때 까지 로드
    if(document.body.scrollHeight <= window.innerHeight) {
        get_more_page();
    }
}