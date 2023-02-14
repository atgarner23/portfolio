const openBtn = document.querySelector('#mobileOpen');
const closeBtn = document.querySelector('#mobileClose');
const modal = document.querySelector('#overlay');
const mobileNav = document.querySelector('#mobileNav');

openBtn.addEventListener('click', () => {
    modal.classList.toggle('hidden');
});
closeBtn.addEventListener('click', () => {
    modal.classList.toggle('hidden');
});
mobileNav.addEventListener('click', () => {
    modal.classList.toggle('hidden');
});