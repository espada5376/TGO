const sup = document.querySelectorAll('.sup')
const mod = document.querySelectorAll('.mod')

const imgs = document.querySelectorAll('.annonce img');

const retour = document.getElementById("back");
    
if (retour) {
    retour.addEventListener("click", () => {
        if (document.referrer === "") {
            window.location.href = "/";
        } else {
            window.history.back();
        }

    });
}
   
imgs.forEach((img) => {

  // Création du wrapper
  const wrapper = document.createElement('div');
  wrapper.className = 'img-wrapper skeleton';

  // Optimisation image
  img.decoding = 'async';
  img.loading = 'lazy';
  img.setAttribute('fetchpriority', 'low');

  // Insérer le wrapper à la place de l’image
  const parent = img.parentNode;
  parent.insertBefore(wrapper, img);
  wrapper.appendChild(img);

  // Quand l’image est chargée
  img.addEventListener('load', () => {
    wrapper.classList.remove('skeleton');
    img.classList.add('loaded');
  });

  // Cas image déjà en cache
  if (img.complete) {
    wrapper.classList.remove('skeleton');
    img.classList.add('loaded');
  }
});


sup.forEach((supp) => {
    supp.addEventListener("click", () => suprimerAnnonce(supp));
});

mod.forEach((modd) => {
    modd.addEventListener("click", () => modifierAnnonce(modd));
});


function modifierAnnonce(modd){
    const id_annonce = modd.value
    window.location.href = `index.php?page=modifier-annonce&id=${id_annonce}`
}


async function suprimerAnnonce(supp){

    const suprimer = confirm('Voulez vous supprimer cette annonce')

    if(!suprimer){
        return;
    }

    const response = await fetch('index.php?page=api&action=delete', {method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id_annonce: supp.value })}
        )

    const data = await response.json()

    if(data.success){
        location.reload();
        return;
    }
}


document.getElementById("copyright").textContent = "Copyright © " + new Date().getFullYear() + " Togomarket. Tous droits réservés.";