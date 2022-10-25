const form = document.getElementById('profileForm');
const inputs = document.querySelectorAll('#profileForm input');

const regexs = {
    nickname: /^[a-zA-Z0-9\_\-]{4,20}$/,
    name: /^([A-ZÁÉÍÓÚ]{1}[a-zñáéíóú]+[\s]*)+$/,
    surnames: /^([A-ZÁÉÍÓÚ a-zñáéíóú]{1,})+$/,
    email: /[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/,
    phone: /^[679]{1}[0-9]{8}/,
    password: /(?=(.*[0-9]))(?=.*[a-z])(?=(.*[A-Z]))(?=(.*)).{4,}/
}


const correct = false;

const form_validation= (e)=>{
    switch (e.target.name) {

        case "password":
            if (regexs.password.test(e.target.value)) {
                document.getElementById('password').classList.remove('input_error');
                document.getElementById('password-error').classList.add('hidden');
                correct = true;
            } else if (e.target.value === '') {
                document.getElementById('password').classList.remove('input_error');
                document.getElementById('password-error').classList.add('hidden');
                correct = false;
            } else {
                document.getElementById('password').classList.add('input_error');
                document.getElementById('password-error').classList.remove('hidden');
                correct = false;
            }
            break;

        case "password2":
            let password = document.getElementById('password');
            if (password.value === e.target.value) {
                document.getElementById('password2').classList.remove('input_error');
                document.getElementById('password2-error').classList.add('hidden');
                correct = true;
            } else if (e.target.value === '') {
                document.getElementById('password2').classList.remove('input_error');
                document.getElementById('password2-error').classList.add('hidden');
                correct = false;
            } else {
                document.getElementById('password2').classList.add('input_error');
                document.getElementById('password2-error').classList.remove('hidden');
                correct = false;
            }
            break;
    }
}

inputs.forEach((input) => {
    input.addEventListener('keyup', form_validation);
    input.addEventListener('blur', form_validation);
});

form.addEventListener('submit', (e) => {
   
    
    if(!correct) {
        e.preventDefault();
        
    }
});
