//navbar hum burger manu clickable
const bar = document.getElementById('bar');
const nav = document.getElementById('navbar');
const closeNavbar = document.getElementById('close');
if (bar) {
  bar.addEventListener('click', () => {
    nav.classList.add('active');
  });
}
if (closeNavbar) {
  closeNavbar.addEventListener('click', () => {
    nav.classList.remove('active');
  });
}
