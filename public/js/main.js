'use strict';

const loadingImg = document.querySelector('.loading-img-container img');
const pageNo = document.querySelector('#page_no');
const postContainer = document.querySelector('.posts-container');

const searchInputTxt = document.querySelector('.search-container input');

searchInputTxt.addEventListener('input', (e) => {
    if(searchInputTxt.value === '') {
        pageNo.value = '1';
        postContainer.innerHTML = '';
        get_more_page();
    } else {
        fetch('/ajax/main/search-keyword?keyword=' + searchInputTxt.value)
        .then((res) => {
            pageNo.value = 'end'
            console.log(res);
            res.text().then((text) => {
                switch(text) {
                    case 'end':
                        if(searchInputTxt.value === '') {
                            pageNo.value = '1';
                            postContainer.innerHTML = '';
                            get_more_page();
                        } else {
                            postContainer.innerHTML = '"' + searchInputTxt.value + '" 로 검색한 결과가 없습니다.';
                        }
                        break;

                    default :
                        postContainer.innerHTML = text;
                }
            })
        });
    }
});

searchInputTxt.addEventListener('keypress', (e) => {
    if(e.which === 13) {
        const firstPost = document.querySelector('.posts-container > .post .post-info a');
        window.location.href = firstPost.getAttribute('href');
    }
})


//처음 load시 page 가져오기.
document.body.onload = () => {
    if(document.body.scrollHeight <= window.innerHeight)
        get_more_page();
};

//스크롤이 맨 밑으로 내려갔을 때 page 가져오기
window.addEventListener('scroll', (e) => {
    if(document.body.scrollHeight <= window.scrollY + window.innerHeight + 1 ) {
        get_more_page();
    }
});






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
                alert('request에 뭔가 문제가 있어요.!');
            }
        }
    }

    // 동기적으로 가져오기. (같은 페이지 중복 호출 방지)
    req.open('GET', '/ajax/main/get-page?page_no=' + pageNo.value, false);
    req.send();

    // 스크롤이 생길때 까지 로드
    if(document.body.scrollHeight <= window.innerHeight) {
        get_more_page();
    }
}