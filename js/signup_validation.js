const formulario = document.getElementById('formularioRegistrar');
const inputs = document.querySelectorAll('#formularioRegistrar input');

const expresiones = {
    nickname: /^[a-zA-Z0-9\_\-]{4,20}$/,
    name: /^[a-zA-Z]{1,40}$/,
    surnames: /^[a-zA-Z]{1,40}$/,
    email:/^[a-zA-Z0-9_.+-]+@[a-z-A-Z0-9]+\.[a-zA-Z0-9-.]+$/, 
    password: /^.{4,20}$/,
    password2: /^.{4,20}$/,
}
const validarFormulario= (e)=>{
    switch (e.target.name) {
        case "nickname":
            if(expresiones.nickname.test(e.target.value)){
                document.getElementById('nickname').classList.remove('input_incorrecto');
                document.getElementById('nickname').classList.add('input_correcto');
            }else{
                document.getElementById('nickname').classList.add('input_incorrecto');
                document.getElementById('nickname').classList.remove('input_correcto');
            }
            break;  
        case "email":
            if(expresiones.email.test(e.target.value)){
                document.getElementById('email').classList.remove('input_incorrecto');
                document.getElementById('email').classList.add('input_correcto');
            }else{
                document.getElementById('email').classList.add('input_incorrecto');
                document.getElementById('email').classList.remove('input_correcto');
            }
            break;  
        case "name":
            if(expresiones.name.test(e.target.value)){
                document.getElementById('name').classList.remove('input_incorrecto');
                document.getElementById('name').classList.add('input_correcto');
            }else{
                document.getElementById('name').classList.add('input_incorrecto');
                document.getElementById('name').classList.remove('input_correcto');
            }
            break;  
        case "surnames":
            if(expresiones.surnames.test(e.target.value)){
                document.getElementById('surnames').classList.remove('input_incorrecto');
                document.getElementById('surnames').classList.add('input_correcto');
            }else{
                document.getElementById('surnames').classList.add('input_incorrecto');
                document.getElementById('surnames').classList.remove('input_correcto');
            }
            break;  
        case "date":
            if(expresiones.date.test(e.target.value)){
                document.getElementById('date').classList.remove('input_incorrecto');
                document.getElementById('date').classList.add('input_correcto');
            }else{
                document.getElementById('date').classList.add('input_incorrecto');
                document.getElementById('date').classList.remove('input_correcto');
            }
            break;  
        case "password":
            if(expresiones.password.test(e.target.value)){
                document.getElementById('password').classList.remove('input_incorrecto');
                document.getElementById('password').classList.add('input_correcto');
            }else{
                document.getElementById('password').classList.add('input_incorrecto');
                document.getElementById('password').classList.remove('input_correcto');
            }
            break;  
        case "password2":
            if(expresiones.password2.test(e.target.value)){
                document.getElementById('password2').classList.remove('input_incorrecto');
                document.getElementById('password2').classList.add('input_correcto');
            }else{
                document.getElementById('password2').classList.add('input_incorrecto');
                document.getElementById('password2').classList.remove('input_correcto');
            }
            break;  

    }
}

inputs.forEach((input) => {
input.addEventListener('keyup', validarFormulario);
input.addEventListener('blur', validarFormulario);

});

formulario.addEventListener('submit', (e) => {
    e.preventDefault();
});


