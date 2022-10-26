const reviewForm = document.querySelector('.reviews form');
const reviewButton = document.querySelector('.reviews header button');

reviewButton.addEventListener('click', () => {
  let elementStyle = window.getComputedStyle(reviewForm);
  let styleDisplay = elementStyle.getPropertyValue('display');
  if (styleDisplay === "none") {
    reviewForm.style.display = "flex";
    reviewButton.innerHTML = '<i class="fa-solid fa-x"></i> Komentatu';
  } else if (styleDisplay === "flex") {
    reviewForm.style.display = "none";
    reviewButton.innerHTML = '<i class="fa-solid fa-comment"></i> Komentatu';
  }
});

const comments = document.querySelectorAll('.comments');
const answerButton = document.querySelectorAll('.main-comment header .answer-button');

answerButton.forEach((button) => {
  button.addEventListener('click', () => {
    comments.forEach((comment) => { 
      let elementStyle = window.getComputedStyle(comment.lastElementChild);
      let styleDisplay = elementStyle.getPropertyValue('display');
      if (styleDisplay === "none") {
        comment.lastElementChild.style.display = "flex";
        button.innerHTML = '<i class="fa-solid fa-x"></i> Erantzun';
      } else if (styleDisplay === "flex") {
        comment.lastElementChild.style.display = "none";
        button.innerHTML = '<i class="fa-solid fa-reply"></i> Erantzun';
      }
    });
  });
});