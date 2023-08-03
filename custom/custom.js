
  document.addEventListener('DOMContentLoaded', function () {
    const currentUrl = window.location.href;

    const homeLink = document.getElementById('home-link');
    const friendsLink = document.getElementById('friends-link');
    const createAlbumLink = document.getElementById('create-album-link');
    const loginLink = document.getElementById('login-link');

    if (currentUrl.includes('index.php')) {
      homeLink.classList.add('active');
    } else if (currentUrl.includes('friends.php')) {
      friendsLink.classList.add('active');
    } else if (currentUrl.includes('create_album.php')) {
      createAlbumLink.classList.add('active');
    } else if (currentUrl.includes('login.php')) {
      loginLink.classList.add('active');
    }
  });

