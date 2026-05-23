const form = document.querySelector('form')
const nom = document.getElementById('nom')
const tel = document.getElementById('num')
const email = document.getElementById('email')
const mdp = document.getElementById('mdp')
const confirmemdp = document.getElementById('confirmemdp')
const checkbox = document.getElementById('cgv')

const regexemail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
const regextel = /^(?:\+228|00228)?[ ]?[279][0-9]{1}(?:[ -]?[0-9]{2}){3}$/

form.addEventListener('submit', function verification(e){
    e.preventDefault();

    let valid = true;

    // Téléphone
    if(tel.value === '' || !regextel.test(tel.value)){
        tel.classList.add('erreur');
        valid = false;
    } else {
        tel.classList.remove('erreur');
    }

    // Email
    if(email.value === '' || !regexemail.test(email.value)){
        email.classList.add('erreur');
        valid = false;
    } else {
        email.classList.remove('erreur');
    }

    // Mot de passe
    if(mdp.value === '' || confirmemdp.value === '' || mdp.value !== confirmemdp.value){
        confirmemdp.classList.add('erreur');
        mdp.classList.add('erreur');
        valid = false;
    } else {
        confirmemdp.classList.remove('erreur');
        mdp.classList.remove('erreur');
    }

    // Checkbox CGV
    if(!checkbox.checked){
        valid = false;
    }

    // Soumission
    if(valid){
        form.submit();
    }
});
