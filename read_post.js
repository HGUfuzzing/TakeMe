const toggle = document.querySelector('.toggle');
const tooltip = document.querySelector('.tooltip');

toggle.addEventListener('click', () => {
    tooltip.classList.toggle('active');
});