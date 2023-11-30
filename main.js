const navItems = document.querySelector('.nav_items');
const openNavBtn = document.querySelector('#open_nav_btn');
const closeNavBtn = document.querySelector('#close_nav_btn');

const sidebar = document.querySelector('aside');
const showSidebarBtn = document.querySelector('#show_sidebar');
const hideSidebarBtn = document.querySelector('#hide_sidebar');

const openNav = () => {
  navItems.style.display = 'flex';
  openNavBtn.style.display = 'none';
  closeNavBtn.style.display = 'inline-block';
};

const closeNav = () => {
  navItems.style.display = 'none';
  openNavBtn.style.display = 'inline-block';
  closeNavBtn.style.display = 'none';
};
openNavBtn.addEventListener('click', openNav);
closeNavBtn.addEventListener('click', closeNav);

const showSideBar = () => {
  sidebar.style.left = '0';
  showSidebarBtn.style.display = 'none';
  hideSidebarBtn.style.display = 'inline-block';
};

const hideSideBar = () => {
  sidebar.style.left = '-100%';
  showSidebarBtn.style.display = 'inline-block';
  hideSidebarBtn.style.display = 'none';
};

showSidebarBtn.addEventListener('click', showSideBar);
hideSidebarBtn.addEventListener('click', hideSideBar);
