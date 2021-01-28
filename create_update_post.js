const file = document.getElementById('file-input');
const imgContainer = document.getElementById('col2');
const previewImage = document.getElementById('show-poster');
const previewMessage = document.getElementById('preview-img');
const keywordInput = document.getElementById('link-keyword-input');

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

function check_keyword(keyword) {
    let httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = () => {
        if (httpRequest.readyState === XMLHttpRequest.DONE) {
            if (httpRequest.status === 200) {
              alert(httpRequest.responseText);
            } else {
              alert('request에 뭔가 문제가 있어요.');
            }
          }
    };

    httpRequest.open('GET', '/ajax/check_keyword.php?keyword=' + keyword, true);
    httpRequest.send();
}