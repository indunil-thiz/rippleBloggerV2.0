document.addEventListener('DOMContentLoaded', function () {
  let navItems = document.querySelector('.nav_items');
  let openNavBtn = document.querySelector('#open_nav_btn');
  let closeNavBtn = document.querySelector('#close_nav_btn');

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

  let sidebar = document.querySelector('aside');
  let showSidebarBtn = document.getElementById('show_sidebar');
  let hideSidebarBtn = document.getElementById('hide_sidebar');

  if (showSidebarBtn) {
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
  }
});
