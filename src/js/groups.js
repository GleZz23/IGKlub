// MODAL FORMULARIO NUEVO LIBRO
const closeButton = document.querySelector('.closeButton');
const newBookButton = document.querySelector('#new-group');

newBookButton.addEventListener('click', () => {
  window.scrollTo(0,0);
  document.querySelector('body').style.overflowY = "hidden";
  document.querySelector('.new-group').style.display = "flex";
  setTimeout(() => {
    document.getElementById('newGroupForm').style.transform = "scale(1)";
  }, 10);
});

closeButton.addEventListener('click', () => {
  document.getElementById('newGroupForm').style.transform = "scale(0)";
  setTimeout(() => {
    document.querySelector('.new-group').style.display = "none";
    document.querySelector('body').style.overflowY = "scroll";
  }, 500);
});

// PERFIL
const profileButton = document.querySelector('#profile');
const profile = document.querySelector('.profile');
const profileLinks = document.querySelectorAll('.profile a, .profile span');
const closeProfile = document.querySelector('.close-profile');

profileButton.addEventListener('mouseover', () => {
  profileButton.style.transform = 'scale(1.1)';
  profileButton.style.textShadow = ".3rem .3rem .3rem #00000050";
  profileButton.style.cursor = "pointer";
});

profileButton.addEventListener('mouseleave', () => {
  profileButton.style.transform = 'scale(1)';
  profileButton.style.textShadow = "none";
});

profileButton.addEventListener('click', () => {
  profile.style.display = "flex";
  setTimeout(() => {
    profile.style.transform = "translateX(0)";
  }, 10);
});

if (screen.width > 1280) {
  profile.addEventListener('mouseleave', () => {
    profile.style.transform = "translateX(100%)";
    setTimeout(() => {
      profile.style.display = "none";
    }, 500);
  });
} else {
  closeProfile.addEventListener('click', () => {
    profile.style.transform = "translateX(100%)";
    setTimeout(() => {
      profile.style.display = "none";
    }, 500);
  });
}

profileLinks.forEach((link) => {
  link.addEventListener('mouseover', () => {
    link.style.transform = "translateX(1rem)";
  });

  link.addEventListener('mouseout', () => {
    link.style.transform = "translateX(0)";
  });
});