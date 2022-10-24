// LIBROS
const bookContainer = document.querySelectorAll('.book-container');

bookContainer.forEach((book) => {
  book.addEventListener('mouseover', () => {
    book.style.transform = "scale(1.2)";
    book.style.zIndex = 2;
    book.style.boxShadow = ".5rem .5rem 1rem rgba(0, 0, 0, 0.7)";
    book.firstElementChild.style.transform = "scale(1.5)";
    book.lastElementChild.style.transform = "translateY(0)";
  });

  book.addEventListener('mouseout', () => {
    book.style.transform = "scale(1)";
    book.style.zIndex = 1;
    book.style.boxShadow = "none";
    book.firstElementChild.style.transform = "scale(1)";
    book.lastElementChild.style.transform = "translateY(-100%)";
  });
});

// FILTROS
const filtersButton = document.querySelector('#filters');
const filters = document.querySelector('.filters');

filtersButton.addEventListener('mouseover', () => {
  filtersButton.style.transform = 'rotate(-10deg)';
  filtersButton.style.textShadow = ".3rem .3rem .3rem #00000050";
  filtersButton.style.cursor = "pointer";
});

filtersButton.addEventListener('mouseleave', () => {
  filtersButton.style.transform = 'rotate(0)';
  filtersButton.style.textShadow = "none";
});

filtersButton.addEventListener('click', () => {
  filters.style.transform = "translateX(0)";
});

filters.addEventListener('mouseleave', () => {
  filters.style.transform = "translateX(-100%)";
})

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