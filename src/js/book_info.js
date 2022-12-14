// SINOPSIS - FICHA TECNICA
const infoHeader = document.querySelector('.info-container header');
const infoContainer = document.querySelector('.info-container .container');

infoHeader.firstElementChild.style.transform = "scale(1.5)";
infoHeader.lastElementChild.style.opacity = ".7";

infoHeader.addEventListener('click', () => {

  let elementStyle = window.getComputedStyle(infoContainer);
  let styleTranlate = elementStyle.getPropertyValue('transform');

  if (styleTranlate === "none") {
    infoContainer.style.transform = "translateX(-50%)";
    infoHeader.lastElementChild.style.transform = "scale(1.5)";
    infoHeader.lastElementChild.style.opacity = "1";
    infoHeader.firstElementChild.style.transform = "scale(1)";
    infoHeader.firstElementChild.style.opacity = ".7";
  } else {
    infoContainer.style.transform = "";
    infoHeader.firstElementChild.style.transform = "scale(1.5)";
    infoHeader.firstElementChild.style.opacity = "1";
    infoHeader.lastElementChild.style.transform = "scale(1)";
    infoHeader.lastElementChild.style.opacity = ".7";
  }
});

// COMENTARIO
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

// ESTRELLAS
const stars = document.querySelectorAll('.stars-container label');
const note = document.querySelector('.stars-container #note');

stars.forEach((star) => {
  star.addEventListener('click', () => {
    note.value = star.htmlFor;
  });
});

// FORMULARIO VALORAR LIBRO
const form = document.getElementById('rateBookForm');
const inputs = document.querySelectorAll('#rateBookForm input, #rateBookForm select, #rateBookForm textarea');
const errors = document.querySelectorAll('.php-error');

setTimeout(() => {
    errors.forEach((error) => {error.classList.add('hidden')});
}, 5000);

// Campos del formulario
const campos = {
	note: false,
	age: false,
  language: false,
  opinion: false
}

const form_validation= (e) => {
  switch (e.target.name) {

    case "age":
      if (e.target.value > 5 || e.target.value < 70){
        document.getElementById('age').classList.remove('input_error');
        document.getElementById('age-error').classList.add('hidden');
        campos.age = true;
      } else {
        document.getElementById('age').classList.add('input_error');
        document.getElementById('age-error').classList.remove('hidden');
        campos.age = false;
      }
      break;

    case "opinion":
      if (e.target.value === '') {
        document.getElementById('opinion').classList.remove('input_error');
        document.getElementById('opinion-error').classList.add('hidden');
        campos.opinion = false;
      } else {
        document.getElementById('opinion').classList.remove('input_error');
        document.getElementById('opinion-error').classList.add('hidden');
        campos.opinion = true;
      }
      break;
    }
}

inputs.forEach((input) => {
  input.addEventListener('keyup', form_validation);
  input.addEventListener('blur', form_validation);
});

form.addEventListener('submit', (e) => { 
  
  if (inputs[7].value > 5 || inputs[7].value < 70){
    document.getElementById('language').classList.remove('input_error');
    document.getElementById('language-error').classList.add('hidden');
    campos.language = true;
  } else {
    document.getElementById('language').classList.add('input_error');
    document.getElementById('language-error').classList.remove('hidden');
    campos.language = false;
  }

  if (inputs[5].value > 0) {
    document.getElementById('note').classList.remove('input_error');
    document.getElementById('note-error').classList.add('hidden');
    campos.note = true;
  } else {
    document.getElementById('note').classList.add('input_error');
    document.getElementById('note-error').classList.remove('hidden');
    campos.note = false;
  }
  
  if (!campos.note || !campos.age || !campos.language || !campos.opinion) {
    e.preventDefault();
    document.getElementById('form-error').classList.remove('hidden');
    setTimeout(() => {
			document.getElementById('form-error').classList.add('hidden');
      document.getElementById('note-error').classList.add('hidden');
      document.getElementById('language-error').classList.add('hidden');
		}, 3500);
  }
});

// RESPUESTA
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

const newLanguageButton = document.querySelector('.new-language-button');
const closeButtonNewLanguage = document.querySelector('.new-language button');

newLanguageButton.addEventListener('click', () => {
  window.scrollTo(0,0);
  document.querySelector('body').style.overflowY = "hidden";
  document.querySelector('.new-language').style.display = "flex";
  setTimeout(() => {
    document.getElementById('newLanguageForm').style.transform = "scale(1)";
  }, 10);
});

closeButtonNewLanguage.addEventListener('click', () => {
  document.getElementById('newLanguageForm').style.transform = "scale(0)";
  setTimeout(() => {
    document.querySelector('.new-language').style.display = "none";
    document.querySelector('body').style.overflowY = "scroll";
  }, 500);
});

// IDIOMA NUEVO - ALTERANTIVO
const optionsNewLanguage = document.querySelector('#newLanguageForm select')
const newLanguage = document.querySelector('.new-language-section');

optionsNewLanguage.addEventListener('input', (e) => {
  if (e.target.value === 'other') {
    newLanguage.style.display = "flex";
    setTimeout(() => {
      newLanguage.style.opacity = "1";
      newLanguage.style.transform = "translateX(0)";
    }, 10);
  } else {
    newLanguage.style.opacity = "0";
    newLanguage.style.transform = "translateX(100%)";
    setTimeout(() => {
      newLanguage.style.display = "none";
    }, 500);
  }
});

// MODAL FORMULARIO VALORAR LIBRO - FORMULARIO NUEVO IDIOMA
const rateBookButton = document.querySelector('.rateBookButton');
const closeButtonRateBook = document.querySelector('.rate-book button');

rateBookButton.addEventListener('click', () => {
  window.scrollTo(0,0);
  document.querySelector('body').style.overflowY = "auto";
  document.querySelector('.rate-book').style.display = "flex";
  setTimeout(() => {
    document.getElementById('rateBookForm').style.transform = "scale(1)";
  }, 10);
});

closeButtonRateBook.addEventListener('click', () => {
  document.getElementById('rateBookForm').style.transform = "scale(0)";
  setTimeout(() => {
    document.querySelector('.rate-book').style.display = "none";
    document.querySelector('body').style.overflowY = "scroll";
  }, 500);
});