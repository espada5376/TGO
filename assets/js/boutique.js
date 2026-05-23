const BASE_URL = window.location.origin + '/'

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

function slugify(text) {
  return text
    .toLowerCase()
    .normalize('NFD')
    .replace(/[\u0300-\u036f]/g, '')
    .replace(/[^a-z0-9]+/g, '-')
    .replace(/(^-|-$)+/g, '');
}

function commandUrl(id, titre) {
    return `/annonce/lome/${slugify(titre)}-${id}`;
}
   

function convertirTemps(duree_secondes) {

    if (duree_secondes < 60) { 
        return "l'instant";
    } 
    else if (duree_secondes < 3600) { 
        const minutes = Math.floor(duree_secondes / 60);
        return `${minutes} min`;
    } 
    else if (duree_secondes < 86400) { 
    const heures = Math.floor(duree_secondes / 3600);
    return heures > 1 ? `${heures} heures` : `${heures} heure`;
    }
    else {
        const jours = Math.floor(duree_secondes / 86400);
        return jours > 1 ? `${jours} jours` : `${jours} jour`;
    }
}




const cmd = document.querySelector('#cmd');

const loader = document.querySelector('.loader')


function CommmandeCard(data){

const commande = document.createElement('div');
commande.className = 'commande';

const info = document.createElement('div');
info.className = 'info';

const div = document.createElement('div');
    
const imgWrapper = document.createElement("div");
imgWrapper.className = "img-wrapper skeleton";

const img = document.createElement('img')
img.src = `${BASE_URL}/assets/product/${data.photo_annonce}`
img.alt = `${data.titre_annonce}`
img.loading = "lazy";
img.decoding = "async";
img.setAttribute("fetchpriority", "low");
    
img.addEventListener("load", () => {
    imgWrapper.style.setProperty('background', 'white', 'important');
  imgWrapper.classList.remove("skeleton");
  img.classList.add("loaded");
});

imgWrapper.appendChild(img);
div.appendChild(imgWrapper);


    const duré = document.createElement('div')
    duré.innerHTML = `<i class="fa-regular fa-clock"></i> ${convertirTemps(data.duree_secondes)}`
    duré.classList.add('duré')
    imgWrapper.appendChild(duré)

  const p5 = document.createElement('p');
  p5.classList.add('ca')
  p5.textContent = "Commission = 0Francs"
  info.appendChild(p5);
    
    
    const p6 = document.createElement('p');
  p6.innerHTML = `Il y'a <strong>${convertirTemps(data.duree_secondesc)}</strong>`
  info.appendChild(p6);

const p7 = document.createElement('p');
p7.classList.add('tronqué')
  p7.textContent = `(x${data.quantite_commande}) ${data.titre_annonce}`
  info.appendChild(p7);

commande.appendChild(div)
commande.appendChild(info);

cmd.appendChild(commande);
}


function activeLink(){
    const hash = window.location.hash || '#/'
    document.querySelectorAll('.swiper-slide').forEach(link =>{
        if(link.getAttribute('data-route') === hash){
            link.classList.add('active')
        }else{
            link.classList.remove('active')
        }
    })
}
    

const status1 = 'nouvelle commande';
const status2 = 'livreur en route';
const status3 = 'produit livré et payé';




const routes = {
    '#/': async () => {
    loader.style.display = 'block'

    const response = await fetch(
        `index.php?page=api&action=listecommandesboutique&status=${status1}`
    )
    const data = await response.json()

    loader.style.display = 'none'

    // ✅ Nettoyage systématique
    cmd.innerHTML = ''

    if (data.success && data.data.length > 0) {
        data.data.forEach(commande => {
            CommmandeCard(commande)
        })
    } else {
        const p = document.createElement('p')
        p.textContent = 'Aucune nouvelle commande pour le moment.'
        p.classList.add('aucune')
        cmd.appendChild(p)
    }
}
,
    '#/cours': async () => {
        loader.style.display = 'block'
        const response = await fetch(`index.php?page=api&action=listecommandesboutique&status=${status2}`);
        const data = await response.json();
        loader.style.display = 'none'

        cmd.innerHTML = ''

        if(data.success && data.data.length > 0){
            
            data.data.forEach(commande => {
                CommmandeCard(commande);
            });
        }else{
                        const p = document.createElement('p')
            p.textContent = 'Aucune nouvelle commande pour le moment.';
            p.classList.add('aucune')
            cmd.appendChild(p)
        }  
    },
    '#/finish': async () => {
        loader.style.display = 'block'
        const response = await fetch(`index.php?page=api&action=listecommandesboutique&status=${status3}`);
        const data = await response.json();
        loader.style.display = 'none'

        cmd.innerHTML = ''
        

        if(data.success && data.data.length > 0){

            let CA = 0

            data.data.forEach(commande => {
                CommmandeCard(commande);
                CA += commande.prix_unitaire_annonce * commande.quantite_commande;
            });
            document.querySelector('.cda').innerHTML = `Chiffres d'Affaires: <strong>${CA} FCFA</strong>`;
        }else{
                        const p = document.createElement('p')
            p.textContent = 'Aucune nouvelle commande pour le moment.';
            p.classList.add('aucune')
            cmd.appendChild(p)
        }   
    }
}

function navigation(path){
    window.location.hash = path;
    charger()
}

 async function charger(){

    activeLink()
    const path = window.location.hash || '#/';
    const route = routes[path];
    if(route){
        await route();
    }else{
        cmd.innerHTML = 'Page non trouvée';
    }
}

document.addEventListener('click', (e) => {
    if(e.target.matches('a[data-route]')){
        e.preventDefault();
        navigation(e.target.getAttribute('data-route'));
    }
});

window.onpopstate = charger;

charger();

document.getElementById("shareBtn").addEventListener("click", async () => {

  if (navigator.share) {
    try {
      await navigator.share({
        title: "Partager sur mon statut",
        text: "Salut, visite ma boutique en cliquant ici",
        url: `profil-boutique/lome/${slugify(document.getElementById('nom_boutique').value)}-${document.getElementById('id_boutique').value}`
      });
    } catch (err) {
      console.error("Partage annulé", err);
    }
  } else {
    alert("Le partage n'est pas supporté sur ce navigateur.");
  }
});


document.getElementById("copyright").textContent = "Copyright © " + new Date().getFullYear() + " Togomarket. Tous droits réservés.";