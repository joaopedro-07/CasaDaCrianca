const sidebar = document.getElementById('sidebar');
const textos = document.querySelectorAll('.opcao-sidebar p, .logout-button p');
const logo = document.querySelector('.container-logo-sidebar img');

sidebar.addEventListener('mouseenter', () => {
  sidebar.style.width = '250px';

  setTimeout(() => {
    textos.forEach(p => p.style.opacity = '1');
  }, 200);
});

sidebar.addEventListener('mouseleave', () => {
  textos.forEach(p => p.style.opacity = '0');

  setTimeout(() => {
    sidebar.style.width = '60px';
  }, 200);
});

sidebar.addEventListener('mouseenter', () => {
  sidebar.style.width = '250px';
  setTimeout(() => {
    textos.forEach(p => p.style.opacity = '1');
    logo.style.opacity = '1';
  }, 200);
});

sidebar.addEventListener('mouseleave', () => {
  textos.forEach(p => p.style.opacity = '0');
  logo.style.opacity = '0';
  setTimeout(() => sidebar.style.width = '60px', 200);
});