const toggle = document.querySelector('.toggle');
const tooltip = document.querySelector('.tooltip');
const newsCreateForm = document.querySelector('.form-news form');
const newsSubmitBtn = document.querySelector('#news-submit-button');
const loadingImg = document.querySelector('.loading-img-container img');
const linkCopyBtn = document.querySelector('.link-copy');
const linkKeyword = document.querySelector('.link_keyword');

if(toggle !== null){
    toggle.addEventListener('click', () => {
        tooltip.classList.toggle('active');
    });
}

if(newsCreateForm !== null) {
    newsCreateForm.addEventListener('submit', () => {
        loadingImg.style.display = 'block';
        newsSubmitBtn.style.display = 'none';
    });
}


const favorite = document.getElementById('favorite');

if(favorite !== null) {
    favorite.addEventListener('click', function (event){
        let post_id = favorite.getAttribute('post_id');
        let isFavorite = favorite.getAttribute('status');
        let icon = document.getElementById('star-icon');
        if(isFavorite == 'true'){
            if(set_unset_favorite(post_id, isFavorite)){
                favorite.setAttribute('status', 'false');
                icon.className = 'far fa-star';
            }
        }
        else if(isFavorite == 'false'){
            if(set_unset_favorite(post_id, isFavorite)){
                favorite.setAttribute('status', 'true');
                icon.className = 'fas fa-star';
            }
        }
    });
}

linkCopyBtn.addEventListener('click', (e) => {
    const keyword = linkKeyword.innerHTML;
    copyText(window.location.host + '/' + keyword);
    //alert('주소가 복사되었습니다.');
})

linkKeyword.addEventListener('click', (e) => {
    const keyword = linkKeyword.innerHTML.trim();
    copyText(window.location.host + '/' + keyword);
    //alert('주소가 복사되었습니다.');
})

function copyText(text) {
    const tmpElem = document.createElement('textarea');
    tmpElem.value = text;
    document.body.appendChild(tmpElem);

    tmpElem.select();
    document.execCommand('copy');
    document.body.removeChild(tmpElem);
}

function set_unset_favorite(post_id, status){
    let httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = () => 
    {
        if(httpRequest.readyState === XMLHttpRequest.DONE)
        {
            if (httpRequest.status === 200){
                inform(httpRequest.responseText);
            }
            else 
                alert('request에 뭔가 문제가 있어요.');
        }
    };
    
    httpRequest.open('GET', '/ajax/read/toggle-favorite?post_id=' + post_id + '&status=' + status, true);
    httpRequest.send();

    function inform(res){
        switch(res){
            case 'no post_id':
                alert('post_id 전달 안됨');
                break;
            case 'error':
                alert('쿼리 오류');
                break;
            case 'unset':
                //alert('즐겨찾기 해제');
                break;
            case 'set':
                //alert('즐겨찾기 설정');
                break;
            default:
                alert(res);
                //alert('?????');
        }
    }

    return true;
}