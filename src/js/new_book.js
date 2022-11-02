// PERFIL
const profileButton = document.querySelector('#profile');
const profile = document.querySelector('.profile');
const profileLinks = document.querySelectorAll('.profile a');

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

// FORMULARIO
const form = document.getElementById('newBookForm');
const inputs = document.querySelectorAll('#newBookForm input');
const errors = document.querySelectorAll('.php-error');

setTimeout(() => {
    errors.forEach((error) => {error.classList.add('hidden')});
}, 5000);

const regexs = {
    title: /^([A-ZÁÉÍÓÚ a-zñáéíóú]{1,})+$/
}

// Campos del formulario
const campos = {
	title: false,
	writter: false,
	sinopsis: false,
	title2: false
}

const form_validation= (e)=>{
    switch (e.target.name) {

        case "title":
            if (regexs.nickname.test(e.target.value)) {
                document.getElementById('nickname').classList.remove('input_error');
                document.getElementById('nickname-error').classList.add('hidden');
                campos.nickname = true;
            } else if (e.target.value === '') {
                document.getElementById('nickname').classList.remove('input_error');
                document.getElementById('nickname-error').classList.add('hidden');
            } else {
                document.getElementById('nickname').classList.add('input_error');
                document.getElementById('nickname-error').classList.remove('hidden');
            }
            break;  

        case "writter":
            if (regexs.email.test(e.target.value)){
                document.getElementById('email').classList.remove('input_error');
                document.getElementById('email-error').classList.add('hidden');
                campos.email = true;
            } else if (e.target.value === '') {
                document.getElementById('email').classList.remove('input_error');
                document.getElementById('email-error').classList.add('hidden');
            } else {
                document.getElementById('email').classList.add('input_error');
                document.getElementById('email-error').classList.remove('hidden');
            }
            break; 

        case "sinopsis":
            if (regexs.name.test(e.target.value)) {
                document.getElementById('name').classList.remove('input_error');
                document.getElementById('name-error').classList.add('hidden');
                campos.name = true;
            } else if (e.target.value === '') {
                document.getElementById('name').classList.remove('input_error');
                document.getElementById('name-error').classList.add('hidden');
            } else {
                document.getElementById('name').classList.add('input_error');
                document.getElementById('name-error').classList.remove('hidden');
            }
            break;

        case "alternative_title":
            if (regexs.surnames.test(e.target.value)) {
                document.getElementById('surnames').classList.remove('input_error');
                document.getElementById('surnames-error').classList.add('hidden');
                campos.surnames = true;
            } else if (e.target.value === '') {
                document.getElementById('surnames').classList.remove('input_error');
                document.getElementById('surnames-error').classList.add('hidden');
            } else {
                document.getElementById('surnames').classList.add('input_error');
                document.getElementById('surnames-error').classList.remove('hidden');
            }
            break;
    }
}

inputs.forEach((input) => {
    input.addEventListener('keyup', form_validation);
    input.addEventListener('blur', form_validation);
});

form.addEventListener('submit', (e) => {    
    if(!campos.title || !campos.writter || !campos.sinopsis || !campos.title2) {
        e.preventDefault();
        document.getElementById('form-error').classList.remove('hidden');
        setTimeout(() => {
			document.getElementById('form-error').classList.add('hidden');
		}, 3500);
    }
});

// IDIOMA ALTERANTIVO
const alternativeButton = document.querySelector('.alternative-button');

alternativeButton.addEventListener('click', (e) => {
  e.preventDefault();
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
