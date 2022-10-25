const reviewForm = document.querySelector('.reviews form');
const reviewButton = document.querySelector('.reviews header button');

reviewButton.addEventListener('click', () => {
  let elementStyle = window.getComputedStyle(reviewForm);
  let styleDisplay = elementStyle.getPropertyValue('display');
  if (styleDisplay === "none") {
    reviewForm.style.display = "flex";
    reviewButton.innerHTML = 'Komentatu <i class="fa-solid fa-arrow-up"></i>';
  } else if (styleDisplay === "flex") {
    reviewForm.style.display = "none";
    reviewButton.innerHTML = 'Komentatu <i class="fa-solid fa-arrow-down"></i>';
  }
});
