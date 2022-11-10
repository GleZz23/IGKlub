// MODAL FORMULARIO NUEVO LIBRO
const closeButton = document.querySelector('.closeButton');
const newBookButton = document.querySelector('#new-group');

newBookButton.forEach((button) => {
  button.addEventListener('click', () => {
    window.scrollTo(0,0);
    document.querySelector('body').style.overflowY = "hidden";
    document.querySelector('.new-group').style.display = "flex";
    setTimeout(() => {
      document.getElementById('newGroupForm').style.transform = "scale(1)";
    }, 10);
  });
});

closeButton.addEventListener('click', () => {
  document.getElementById('newGroupForm').style.transform = "scale(0)";
  setTimeout(() => {
    document.querySelector('.new-group').style.display = "none";
    document.querySelector('body').style.overflowY = "scroll";
  }, 500);
});