const toggle = document.querySelector('.toggle');
const tooltip = document.querySelector('.tooltip');
const newsForm = document.querySelector('.form-news form');
const newsSubmitBtn = document.querySelector('#news-submit-button');
const loadingImg = document.querySelector('.loading-img-container img');



if(toggle !== null){
    toggle.addEventListener('click', () => {
        tooltip.classList.toggle('active');
    });
}

if(newsForm !== null) {
    newsForm.addEventListener('submit', () => {
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
        else{
            alert("둘다 아님.. " + isFavorite);
        }
    });
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
    
    httpRequest.open('GET', '/ajax/check_favorite.php?post_id=' + post_id + '&status=' + status, true);
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
                alert('즐겨찾기 해제');
                break;
            case 'set':
                alert('즐겨찾기 설정');
                break;
            default:
                alert(res);
                //alert('?????');
        }
    }

    return true;
}