const form = document.getElementById('singupForm');
const inputs = document.querySelectorAll('#singupForm input');
const errors = document.querySelectorAll('.php-error');

setTimeout(() => {
    errors.forEach((error) => {error.classList.add('hidden')});
}, 5000);

const regexs = {
    nickname: /^[a-zA-Z0-9\_\-]{4,20}$/,
    name: /^([A-ZÁÉÍÓÚ]{1}[a-zñáéíóú]+[\s]*)+$/,
    surnames: /^([A-ZÁÉÍÓÚ a-zñáéíóú]{1,})+$/,
    email: /[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/,
    phone: /^[679]{1}[0-9]{8}/,
    password: /(?=(.*[0-9]))(?=.*[a-z])(?=(.*[A-Z]))(?=(.*)).{4,}/
}

// Campos del formulario
const campos = {
	nickname: false,
	email: false,
	name: false,
	surnames: false,
	phone: false,
	date: false,
    password: false,
    password2: false
}

const form_validation= (e)=>{
    switch (e.target.name) {

        case "nickname":
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

        case "email":
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

        case "name":
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

        case "surnames":
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

        case "phone":
            if (regexs.phone.test(e.target.value)) {
                document.getElementById('phone').classList.remove('input_error');
                document.getElementById('phone-error').classList.add('hidden');
                campos.phone = true;
            } else if (e.target.value === '') {
                document.getElementById('phone').classList.remove('input_error');
                document.getElementById('phone-error').classList.add('hidden');
            } else {
                document.getElementById('phone').classList.add('input_error');
                document.getElementById('phone-error').classList.remove('hidden');
            }
            break;

        case "date":
            // Guardar la fecha actual
            const fechaActual = new Date();
            // Separar la fecha actual en año, mes y dia
            const anoActual = parseInt(fechaActual.getFullYear());
            const mesActual = parseInt(fechaActual.getMonth()) + 1;
            const diaActual = parseInt(fechaActual.getDay());

            // Guardar la fecha introducida en el formulario
            const fechaNacimiento = e.target.value;
            // Separar la fecha en año, mes y dia
            const anoNacimiento = parseInt(String(fechaNacimiento).substring(0, 4));
            const mesNacimiento = parseInt(String(fechaNacimiento).substring(5, 7));
            const diaNacimiento = parseInt(String(fechaNacimiento).substring(8, 10));

            // Comprobar que la diferencia del año actual con el introducisa es 18 o mas
            let edad = anoActual - anoNacimiento;
            if (mesActual < mesNacimiento) {
                edad--;
            } else if (mesActual === mesNacimiento) {
                if (diaActual < diaNacimiento) {
                    edad--;
                }
            }

            if (edad < 0) {
                document.getElementById('date').classList.add('input_error');
                document.getElementById('date-error').classList.remove('hidden');
            } else if (fechaNacimiento === '') {
                document.getElementById('date').classList.remove('input_error');
                document.getElementById('date-error').classList.add('hidden');
            } else {
                document.getElementById('date').classList.remove('input_error');
                document.getElementById('date-error').classList.add('hidden');
                campos.date = true;
            }
            break;

        case "password":
            if (regexs.password.test(e.target.value)) {
                document.getElementById('password').classList.remove('input_error');
                document.getElementById('password-error').classList.add('hidden');
                campos.password = true;
            } else if (e.target.value === '') {
                document.getElementById('password').classList.remove('input_error');
                document.getElementById('password-error').classList.add('hidden');
            } else {
                document.getElementById('password').classList.add('input_error');
                document.getElementById('password-error').classList.remove('hidden');
            }
            break;

        case "password2":
            let password = document.getElementById('password');
            if (password.value === e.target.value) {
                document.getElementById('password2').classList.remove('input_error');
                document.getElementById('password2-error').classList.add('hidden');
                campos.password2 = true;
            } else if (e.target.value === '') {
                document.getElementById('password2').classList.remove('input_error');
                document.getElementById('password2-error').classList.add('hidden');
            } else {
                document.getElementById('password2').classList.add('input_error');
                document.getElementById('password2-error').classList.remove('hidden');
            }
            break;
    }
}

inputs.forEach((input) => {
    input.addEventListener('keyup', form_validation);
    input.addEventListener('blur', form_validation);
});

form.addEventListener('submit', (e) => {
    const termns = document.getElementById('termns');
    
    if(!campos.nickname || !campos.name || !campos.surnames || !campos.email || !campos.phone || !campos.date || !campos.password || !campos.password2 || !termns.checked) {
        e.preventDefault();
        document.getElementById('form-error').classList.remove('hidden');
        setTimeout(() => {
			document.getElementById('form-error').classList.add('hidden');
		}, 3500);
    }
});
