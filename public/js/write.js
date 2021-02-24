'use strict';
const file = document.getElementById('file-input');
const imgContainer = document.getElementById('col2');
const previewImage = document.getElementById('show-poster');
const previewMessage = document.getElementById('preview-img');
const keywordInput = document.querySelector('.link-keyword');
const keywordCheckMsg = document.querySelector('.keyword-check-msg');
const eventDateTime = document.getElementById('eventdatetime-container');
const beginDate = document.getElementById('begin_date');
const endDate = document.getElementById('end_date');
const form = document.querySelector('.form');
const submitBtn = document.querySelector('#submit-button')
const targetInput = document.querySelector('.link-target')
const targetCheckMsg = document.querySelector('.target-check-msg')
submitBtn.addEventListener('click', function() {
    if(keywordInput === null || keywordInput.value !== '' && check_keyword_validation(keywordInput.value) === true) {
        form.submit();
        return;
    }
    alert('keyword가 올바르지 않습니다.');
});

window.onload=function(){
    if(beginDate.value !== ''){
        document.getElementById("set-eventdate").click();  
    }
    else{
        document.getElementById("unset-eventdate").click();  
    }
};

file.addEventListener('change', function(){
    const f = this.files[0];
    if (f){
        const reader = new FileReader();
        previewMessage.style.display = 'block';

        reader.addEventListener('load', function(){
            imgContainer.style.display = 'block';
            previewImage.style.display = 'block';
            previewImage.setAttribute('src', this.result);
        });
        reader.readAsDataURL(f);
    }
});


imgContainer.addEventListener('mouseover', function(){
    previewMessage.style.display = 'none';
})
imgContainer.addEventListener('mouseout', function(){
    previewMessage.style.display = 'block';
})

if(keywordInput !== null) {
    keywordInput.addEventListener('focusout', function(event) {
        check_keyword(event.target.value);
    })
}

targetInput.addEventListener('focusout', function(event) {
    const targetLink = event.target.value;
    if(targetLink.length > 10 && targetLink.substr(0, 8) === 'https://' || targetLink.substr(0, 7) === 'http://') {
        targetCheckMsg.style.color = 'green';
        targetCheckMsg.innerHTML = 'good';
    }
    else {
        targetCheckMsg.style.color = 'red';
        targetCheckMsg.innerHTML = '타겟 주소가 "http://" 혹은 "https://" 로 시작하여야 합니다.';
    }
})

function check_keyword_validation(keyword){
    if(keyword.match(/[^0-9a-zA-Z가-힣-]/)) {
        return false;
    }
    return true;
}

function check_keyword(keyword) {
    if(check_keyword_validation(keyword) === false) {
        keywordCheckMsg.style.color = 'red';
        keywordCheckMsg.innerHTML = '한글, 영어, 숫자, -(Dash) 만 입력할 수 있습니다.';
        keywordInput.focus();
        return;
    }

    const httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = () => {
        if (httpRequest.readyState === XMLHttpRequest.DONE) {
            if (httpRequest.status === 200) {
                inform(httpRequest.responseText);
            } else {
              alert('request에 뭔가 문제가 있어요.');
            }
          }
    };

    httpRequest.open('GET', '/ajax/write/check-keyword?keyword=' + keyword, true);
    httpRequest.send();

    function inform(res) {
        switch(res) {
            case 'empty':
                keywordCheckMsg.style.color = 'red';
                keywordCheckMsg.innerHTML = '키워드를 넣어주세요.';
                break;
            case 'invalid':
                keywordCheckMsg.style.color = 'red';
                keywordCheckMsg.innerHTML = '한글, 영어, 숫자, -(Dash) 만 입력할 수 있습니다..';
                keywordInput.focus();
                break;
            case 'duplicate':
                keywordCheckMsg.style.color = 'red';
                keywordCheckMsg.innerHTML = '해당 keyword는 이미 사용중입니다.';
                keywordInput.focus();
                break;
            case 'good':
                keywordCheckMsg.style.color = 'green';
                keywordCheckMsg.innerHTML = ''
                    + 'good';
                    //+ window.location.host + '/@' + keywordInput.value;
                break;
            default:
                alert('???');
        }
    }
}

function showNone(){
    beginDate.value = '';
    endDate.value = '';
    beginDate.removeAttribute('required');
    endDate.removeAttribute('required');
    eventDateTime.style.display = 'none';

}

function showDate(){
    beginDate.setAttribute('required', '');
    endDate.setAttribute('required', '');
    eventDateTime.style.display = 'block';
}