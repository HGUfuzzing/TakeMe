'use strict';

const morePageButton = document.querySelector('.more-page-btn');
const pageNo = document.querySelector('#page_no');
const postContainer = document.querySelector('.posts-container');

morePageButton.addEventListener('click', () => {
    get_more_page();
});

function get_more_page() {
    const req = new XMLHttpRequest();
    req.onreadystatechange = () => {
        if(req.readyState === XMLHttpRequest.DONE) {
            if(req.status === 200) {
                print_page(req.responseText);
                pageNo.value = parseInt(pageNo.value) + 1;
            }
            else {
                alert('request에 뭔가 문제가 있어요.');
            }
        }
    }

    req.open('GET', '/ajax/get_page.php?page_no=' + pageNo.value);
    req.send();

    function print_page(text) {
        postContainer.innerHTML = postContainer.innerHTML + text;
    }
}