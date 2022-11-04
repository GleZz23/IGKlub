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
  filters.style.display = "flex";
  setTimeout(() => {
    filters.style.transform = "translateX(0)";
  }, 10);
});

filters.addEventListener('mouseleave', () => {
  filters.style.transform = "translateX(-100%)";
  setTimeout(() => {
    filters.style.display = "none";
  }, 500);
})

// PERFIL
const profileButton = document.querySelector('#profile');
const profile = document.querySelector('.profile');
const profileLinks = document.querySelectorAll('.profile a, .profile span');

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
  profile.style.display = "flex";
  setTimeout(() => {
    profile.style.transform = "translateX(0)";
  }, 10);
});

profile.addEventListener('mouseleave', () => {
  profile.style.transform = "translateX(100%)";
  setTimeout(() => {
    profile.style.display = "none";
  }, 500);
})

profileLinks.forEach((link) => {
  link.addEventListener('mouseover', () => {
    link.style.color = "black";
    link.style.transform = "translateX(1rem)";
  });

  link.addEventListener('mouseout', () => {
    link.style.color = "gray";
    link.style.transform = "translateX(0)";
  });
});

// POPUP FORMULARIO NUEVO LIBRO
const newBookButton = document.querySelector('.newBookButton');
const closeButton = document.querySelector('.closeButton');

newBookButton.addEventListener('click', () => {
  document.querySelector('body').style.overflowY = "hidden";
  document.querySelector('.new-book').style.display = "flex";
  setTimeout(() => {
    document.getElementById('newBookForm').style.transform = "scale(1)";
  }, 10);
});

closeButton.addEventListener('click', () => {
  document.getElementById('newBookForm').style.transform = "scale(0)";
  setTimeout(() => {
    document.querySelector('.new-book').style.display = "none";
    document.querySelector('body').style.overflowY = "scroll";
  }, 500);
});

// FORMULARIO
const form = document.getElementById('newBookForm');
const inputs = document.querySelectorAll('#newBookForm input, textarea');
const errors = document.querySelectorAll('.php-error');

setTimeout(() => {
    errors.forEach((error) => {error.classList.add('hidden')});
}, 5000);

const regexs = {
    title: /^([A-Za-zÀ-ÖØ-öø-ÿ0-9.,:;\- ]{1,})+$/,
    writter: /^([A-Za-zÀ-ÖØ-öø-ÿ., ]{1,})+$/
}

// Campos del formulario
const campos = {
	title: false,
	writter: false,
  sinopsis: false,
  title2:false
}

const form_validation= (e)=>{
  switch (e.target.name) {

    case "title":
      if (regexs.title.test(e.target.value)) {
        document.getElementById('title').classList.remove('input_error');
        document.getElementById('title-error').classList.add('hidden');
        campos.title = true;
      } else if (e.target.value === '') {
        document.getElementById('title').classList.remove('input_error');
        document.getElementById('title-error').classList.add('hidden');
        campos.title = false;
      } else {
        document.getElementById('title').classList.add('input_error');
        document.getElementById('title-error').classList.remove('hidden');
        campos.title = false;
      }
      break;

    case "writter":
      if (regexs.writter.test(e.target.value)){
        document.getElementById('writter').classList.remove('input_error');
        document.getElementById('writter-error').classList.add('hidden');
        campos.writter = true;
      } else if (e.target.value === '') {
        document.getElementById('writter').classList.remove('input_error');
        document.getElementById('writter-error').classList.add('hidden');
        campos.writter = false;
      } else {
        document.getElementById('writter').classList.add('input_error');
        document.getElementById('writter-error').classList.remove('hidden');
        campos.writter = false;
      }
      break;

    case "sinopsis":
      if (e.target.value === '') {
        document.getElementById('sinopsis').classList.remove('input_error');
        document.getElementById('sinopsis-error').classList.add('hidden');
        campos.sinopsis = false;
      } else {
        document.getElementById('sinopsis').classList.remove('input_error');
        document.getElementById('sinopsis-error').classList.add('hidden');
        campos.sinopsis = true;
      }
      break;

    case "alternative-title":
      if (regexs.title.test(e.target.value)) {
        document.getElementById('alternative-title').classList.remove('input_error');
        document.getElementById('alternative-title-error').classList.add('hidden');
        campos.title2 = true;
      } else if (e.target.value === '') {
        document.getElementById('alternative-title').classList.remove('input_error');
        document.getElementById('alternative-title-error').classList.add('hidden');
        campos.title2 = false;
      } else {
        document.getElementById('alternative-title').classList.add('input_error');
        document.getElementById('alternative-title-error').classList.remove('hidden');
        campos.title2 = false;
      }
      break;
    }
}

inputs.forEach((input) => {
  input.addEventListener('keyup', form_validation);
  input.addEventListener('blur', form_validation);
});

form.addEventListener('submit', (e) => {    
  if (!campos.title || !campos.writter || !campos.sinopsis) {
    e.preventDefault();
    document.getElementById('form-error').classList.remove('hidden');
    setTimeout(() => {
			document.getElementById('form-error').classList.add('hidden');
		}, 3500);
  }
});

// IDIOMA ALTERANTIVO
const alternativeButton = document.querySelector('.alternative-button');

alternativeButton.addEventListener('click', () => {
  const alternative = document.querySelector('.alternative');

  if (window.getComputedStyle(alternative).getPropertyValue('display') === "none") {
    alternativeButton.innerHTML = '<i class="fa-solid fa-xmark"></i> Liburu hau beste hizkuntzan irakurri dut';
    alternative.classList.remove('hidden');
    setTimeout(() => {
      alternative.style.opacity = "1";
      alternative.style.transform = "translateX(0)";
    }, 10);
  } else if (window.getComputedStyle(alternative).getPropertyValue('display') === "flex") {
    alternativeButton.innerHTML = '<i class="fa-solid fa-arrow-down"></i> Liburu hau beste hizkuntzan irakurri dut';
    alternative.style.opacity = "0";
    alternative.style.transform = "translateX(100%)";
    setTimeout(() => {
      alternative.classList.add('hidden');
    }, 500);
  }
});