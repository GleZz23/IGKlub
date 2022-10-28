// ACCIONES
const actions = document.querySelectorAll('nav button')

actions.forEach((button) => {
  button.addEventListener('click', () => {
    
    switch (button.id) {
      case 'accept-teachers':

        const acceptTeachers = document.querySelector('.'+button.id);

        if (window.getComputedStyle(acceptTeachers).getPropertyValue('display') === "none") {
          acceptTeachers.classList.remove('hidden');
        } else if (window.getComputedStyle(document.querySelector('.'+button.id)).getPropertyValue('display') === "flex") {
          acceptTeachers.classList.add('hidden');
        }
        break;

      case 'accept-books':

        const acceptBooks = document.querySelector('.'+button.id);
      
        if (window.getComputedStyle(acceptBooks).getPropertyValue('display') === "none") {
          acceptBooks.classList.remove('hidden');
        } else if (window.getComputedStyle(acceptBooks).getPropertyValue('display') === "grid") {
          acceptBooks.classList.add('hidden');
        }
        break;
    }
  });
});

// LIBROS
const bookContainer = document.querySelectorAll('.book-container');

bookContainer.forEach((book) => {
  book.addEventListener('mouseover', () => {
    book.style.zIndex = 2;
    book.style.boxShadow = ".5rem .5rem 1rem rgba(0, 0, 0, 0.7)";
    book.firstElementChild.style.transform = "scale(1.5)";
    book.lastElementChild.style.transform = "translateY(0)";
  });

  book.addEventListener('mouseout', () => {
    book.style.zIndex = 1;
    book.style.boxShadow = "none";
    book.firstElementChild.style.transform = "scale(1)";
    book.lastElementChild.style.transform = "translateY(-100%)";
  });
});
