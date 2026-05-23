const form = document.querySelector('form')
const tel = document.getElementById('num')
const mdp = document.getElementById('mdp')
const regextel = /^(?:\+228|00228)?[ ]?[279][0-9]{1}(?:[ -]?[0-9]{2}){3}$/

form.addEventListener('submit', function verification(e){
    e.preventDefault()

    let valid = true
    if(tel.value === '' || !regextel.test(tel.value)){
        tel.classList.add('erreur')
        valid = false
    }else{
        tel.classList.remove('erreur')
    }
    
    if(mdp.value === ''){
        mdp.classList.add('erreur')
        valid = false
    }else{
        mdp.classList.remove('erreur')
    }
    if(valid){
        form.submit()
    }
} 
)