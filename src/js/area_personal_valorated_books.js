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