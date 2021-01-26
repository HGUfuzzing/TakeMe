const toggleIcon = document.querySelector('#toggle');
const tooltip = document.querySelector('.post__header__setting .tooltip');


toggleIcon.addEventListener('click', () => {
    tooltip.classList.toggle('active');
});