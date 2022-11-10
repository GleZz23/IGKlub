// MODAL FORMULARIO NUEVO LIBRO
const closeButton = document.querySelector('.closeButton');
const changePasswordButton = document.querySelectorAll('#change-password');

changePasswordButton.forEach((button) => {
  button.addEventListener('click', () => {
    window.scrollTo(0,0);
    document.querySelector('body').style.overflowY = "hidden";
    document.querySelector('.change-password').style.display = "flex";
    setTimeout(() => {
      document.getElementById('changePasswordForm').style.transform = "scale(1)";
    }, 10);
  });
});

closeButton.addEventListener('click', () => {
  document.getElementById('changePasswordForm').style.transform = "scale(0)";
  setTimeout(() => {
    document.querySelector('.change-password').style.display = "none";
    document.querySelector('body').style.overflowY = "scroll";
  }, 500);
});

// VALIDACION FORMULARIO
const form = document.getElementById('changePasswordForm');
const inputs = document.querySelectorAll('#changePasswordForm input');
const errors = document.querySelectorAll('.php-error');

const phpError = () => {
  errors.forEach((error) => {error.classList.add('hidden')});
}

const regexs = {
  password: /(?=(.*[0-9]))(?=.*[a-z])(?=(.*[A-Z]))(?=(.*)).{4,}/
}

// Campos del formulario
const campos = {
  password: false,
  password2: false
}

const form_validation = (e) => {
    switch (e.target.name) {

        case "new-password":
            if (regexs.password.test(e.target.value)) {
                document.getElementById('new-password').classList.remove('input_error');
                document.getElementById('password-error').classList.add('hidden');
                campos.password = true;
            } else if (e.target.value === '') {
                document.getElementById('new-password').classList.remove('input_error');
                document.getElementById('password-error').classList.add('hidden');
            } else {
                document.getElementById('new-password').classList.add('input_error');
                document.getElementById('password-error').classList.remove('hidden');
            }
            break;

        case "new-password2":
            let password = document.getElementById('new-password');
            if (password.value === e.target.value) {
                document.getElementById('new-password2').classList.remove('input_error');
                document.getElementById('password2-error').classList.add('hidden');
                campos.password2 = true;
            } else if (e.target.value === '') {
                document.getElementById('new-password2').classList.remove('input_error');
                document.getElementById('password2-error').classList.add('hidden');
                campos.password2 = false;
            } else {
                document.getElementById('new-password2').classList.add('input_error');
                document.getElementById('password2-error').classList.remove('hidden');
                campos.password2 = false;
            }
            break;
    }
}

inputs.forEach((input) => {
    input.addEventListener('keyup', form_validation);
    input.addEventListener('blur', form_validation);
    input.addEventListener('focus', phpError);
});

form.addEventListener('submit', (e) => {
  if(!campos.password || !campos.password2) {
    e.preventDefault();
    document.getElementById('form-error').classList.remove('hidden');
    setTimeout(() => {
      document.getElementById('form-error').classList.add('hidden');
    }, 3500);
  }
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

// PERFIL
const profileButton = document.querySelector('#profile');
const profile = document.querySelector('.profile');
const profileLinks = document.querySelectorAll('.profile a, .profile span');
const closeProfile = document.querySelector('.close-profile');

profileButton.addEventListener('mouseover', () => {
  profileButton.style.transform = 'scale(1.1)';
  profileButton.style.textShadow = ".3rem .3rem .3rem #00000050";
  profileButton.style.cursor = "pointer";
});

profileButton.addEventListener('mouseleave', () => {
  profileButton.style.transform = 'scale(1)';
  profileButton.style.textShadow = "none";
});

profileButton.addEventListener('click', () => {
  profile.style.display = "flex";
  setTimeout(() => {
    profile.style.transform = "translateX(0)";
  }, 10);
});

if (screen.width > 1280) {
  profile.addEventListener('mouseleave', () => {
    profile.style.transform = "translateX(100%)";
    setTimeout(() => {
      profile.style.display = "none";
    }, 500);
  });
} else {
  closeProfile.addEventListener('click', () => {
    profile.style.transform = "translateX(100%)";
    setTimeout(() => {
      profile.style.display = "none";
    }, 500);
  });
}

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
