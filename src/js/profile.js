// PERFIL
const profileButton = document.querySelector('#profile');
const profile = document.querySelector('.profile');

profileButton.addEventListener('mouseover', () => {
  profileButton.style.transform = 'rotate(-10deg)';
  profileButton.style.textShadow = ".3rem .3rem .3rem #00000050";
  profileButton.style.cursor = "pointer";
});

profileButton.addEventListener('mouseleave', () => {
  profileButton.style.transform = 'rotate(0)';
  profileButton.style.textShadow = "none";
});

profileButton.addEventListener('click', () => {
  profile.style.transform = "translateX(0)";
});

profile.addEventListener('mouseleave', () => {
  profile.style.transform = "translateX(100%)";
})