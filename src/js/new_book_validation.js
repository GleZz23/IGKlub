const form = document.getElementById('add_book_form');
const inputs = document.querySelectorAll('.input_container input');



const correct = false;

const form_validation= (e)=>{
    switch (e.target.name) {

        case "title":
            if (e.target.value === '') {
                document.getElementById('title').classList.remove('input_error');
                document.getElementById('title-error').classList.add('hidden');
                correct = false;
            } else 
                document.getElementById('title').classList.remove('input_error');
                document.getElementById('title-error').classList.add('hidden');
                correct = true;
            break;  

            case "writter":
                if (e.target.value === '') {
                    document.getElementById('writter').classList.remove('input_error');
                    document.getElementById('writter-error').classList.add('hidden');
                    correct = false;
                } else 
                    document.getElementById('writter').classList.remove('input_error');
                    document.getElementById('writter-error').classList.add('hidden');
                    correct = true;
                break; 

            case "sinopsis":
                if (e.target.value === '') {
                    document.getElementById('sinopsis').classList.remove('input_error');
                    document.getElementById('sinopsis-error').classList.add('hidden');
                    correct = false;
                } else 
                    document.getElementById('sinopsis').classList.remove('input_error');
                    document.getElementById('sinopsis-error').classList.add('hidden');
                    correct = true;
                break;  

        case "language":
            if (e.target.value === '') {
                document.getElementById('language').classList.remove('input_error');
                document.getElementById('language-error').classList.add('hidden');
                correct = false;
            } else 
                document.getElementById('language').classList.remove('input_error');
                document.getElementById('language-error').classList.add('hidden');
                correct = true;
            break;  

    }
}

inputs.forEach((input) => {
    input.addEventListener('keyup', form_validation);
    input.addEventListener('blur', form_validation);
});

form.addEventListener('submit', (e) => {
    const termns = document.getElementById('termns');
    
    if(!correct) {
        e.preventDefault();
        document.getElementById('form-error').classList.remove('hidden');
        setTimeout(() => {
			document.getElementById('form-error').classList.add('hidden');
		}, 3500);
    }
});