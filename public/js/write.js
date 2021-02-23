'use strict';
const file = document.getElementById('file-input');
const imgContainer = document.getElementById('col2');
const previewImage = document.getElementById('show-poster');
const previewMessage = document.getElementById('preview-img');
const keywordInput = document.getElementById('link-keyword-input');
const keywordCheckMessage = document.querySelector('.keyword_check_msg');
const eventDateTime = document.getElementById('eventdatetime-container');
const beginDate = document.getElementById('begin_date');
const endDate = document.getElementById('end_date');
const form = document.querySelector('.form');
const submitBtn = document.querySelector('#submit-button')

submitBtn.addEventListener('click', function() {
    if(keywordInput.value !== '' && check_keyword_validation(keywordInput.value) === true) {
        form.submit();
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
            imgContainer.style.visibility = 'visible';
            previewImage.style.visibility = 'visible';
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

keywordInput.addEventListener('focusout', function(event) {
    check_keyword(event.target.value);
})

function check_keyword_validation(keyword){
    if(keyword.match(/[^0-9a-zA-Z가-힣-]/)) {
        return false;
    }
    return true;
}

function check_keyword(keyword) {
    if(check_keyword_validation(keyword) === false) {
        keywordCheckMessage.style.fontSize = '0.75em';
        keywordCheckMessage.style.color = 'red';
        keywordCheckMessage.innerHTML = '한글, 영어, 숫자, -(Dash) 만 입력할 수 있습니다.';
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
        keywordCheckMessage.style.fontSize = '0.75em';
        switch(res) {
            case 'empty':
                keywordCheckMessage.style.color = 'red';
                keywordCheckMessage.innerHTML = 'link keyword를 넣어주세요';
                break;
            case 'invalid':
                keywordCheckMessage.style.color = 'red';
                keywordCheckMessage.innerHTML = '한글, 영어, 숫자, -(Dash) 만 입력할 수 있습니다..';
                keywordInput.focus();
                break;
            case 'duplicate':
                keywordCheckMessage.style.color = 'red';
                keywordCheckMessage.innerHTML = '해당 keyword는 이미 사용중입니다.';
                keywordInput.focus();
                break;
            case 'good':
                keywordCheckMessage.style.color = 'green';
                keywordCheckMessage.innerHTML = ''
                    + '생성될 링크 주소 : '
                    + window.location.host + '/@' + keywordInput.value;
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