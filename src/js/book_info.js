const reviewForm = document.querySelector('.reviews .user-comment');
const reviewButton = document.querySelector('.reviews header button');

reviewButton.addEventListener('click', () => {
  let elementStyle = window.getComputedStyle(reviewForm);
  let styleDisplay = elementStyle.getPropertyValue('display');
  if (styleDisplay === "none") {
    reviewForm.style.display = "flex";
    setTimeout(() => {
      reviewForm.style.opacity = "1";
      reviewForm.style.transform = "translateX(0)";
    }, 10);
    reviewButton.innerHTML = '<i class="fa-solid fa-x"></i> Komentatu';
  } else if (styleDisplay === "flex") {
    reviewForm.style.opacity = "0";
    reviewForm.style.transform = "translateX(100%)";
    setTimeout(() => {
      reviewForm.style.display = "none";
    }, 500);
    reviewButton.innerHTML = '<i class="fa-solid fa-comment"></i> Komentatu';
  }
});

const answerButton = document.querySelectorAll('.main-comment header .answer-button');

answerButton.forEach((button) => {
  button.addEventListener('click', () => {
    const comment = button.parentElement.parentElement;
    let elementStyle = window.getComputedStyle(comment.nextElementSibling);
    let styleDisplay = elementStyle.getPropertyValue('display');
    if (styleDisplay === "none") {
      comment.nextElementSibling.style.display = "flex";
      setTimeout(() => {
        comment.nextElementSibling.style.opacity = "1";
        comment.nextElementSibling.style.transform = "translateX(0)";
      }, 10);
      button.innerHTML = '<i class="fa-solid fa-x"></i> Erantzun';
    } else if (styleDisplay === "flex") {
      comment.nextElementSibling.style.opacity = "0";
      comment.nextElementSibling.style.transform = "translateX(100%)";
      setTimeout(() => {
        comment.nextElementSibling.style.display = "none";
      }, 500);
      button.innerHTML = '<i class="fa-solid fa-reply"></i> Erantzun';
    }
  });
}); 