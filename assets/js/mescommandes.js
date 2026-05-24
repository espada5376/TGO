const BASE_URL = window.__BASE_URL || (window.location.origin + '/')

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


function CommandeCard(data){

const commande = document.createElement('div');
commande.className = 'commande';

const info = document.createElement('div');
info.className = 'info';

const div = document.createElement('div');

    const imgWrapper = document.createElement("div");
imgWrapper.className = "img-wrapper skeleton";
    
const img = document.createElement('img')
img.src = `${BASE_URL}assets/product/${data.photo_annonce}`
img.alt = `${data.titre_annonce}`

img.loading = "lazy";
img.decoding = "async";
img.setAttribute("fetchpriority", "low");
        
    img.addEventListener("load", () => {
        imgWrapper.style.setProperty('background', 'white', 'important');
  imgWrapper.classList.remove("skeleton");
  img.classList.add("loaded");
});

img.addEventListener("error", () => {
  imgWrapper.classList.remove("skeleton");
  img.classList.add("error");
});

imgWrapper.appendChild(img);

    const duré = document.createElement('div')
    duré.innerHTML = `<i class="fa-regular fa-clock"></i> ${convertirTemps(data.duree_secondes)}`
    duré.classList.add('duré')
    imgWrapper.appendChild(duré)



const p5 = document.createElement('a');
        p5.href = `profil-boutique/lome/${slugify(data.nom_boutique)}-${data.id_boutique}`;
  p5.textContent = `${data.nom_boutique}`
  info.appendChild(p5);
    
  tellivreur = document.createElement('a')
  tellivreur.textContent = `${data.tel_livreur}(Livreur)`
  tellivreur.href = `tel:${data.tel_livreur}`
  
const p4 = document.createElement('p');
  p4.innerHTML = `Il y'a <strong>${convertirTemps(data.duree_secondesc)}</strong>`
  info.appendChild(p4);

const p6 = document.createElement('p');
    p6.classList.add('tronqué')
  p6.textContent = `(x${data.quantite_commande}) ${data.titre_annonce}`
  info.appendChild(p6);
    

        

  if(data.client_validation_commande === 0 && data.livreur_validation_commande === 0 && data.status_commande === 'livreur en route'){

    p4.remove()
    tellivreur.remove()

    const validationBtn = document.createElement('button')
    validationBtn.textContent = 'livraison recue'
    validationBtn.setAttribute("type", "button");
    info.appendChild(validationBtn)

    validationBtn.addEventListener('click', async () => {
        if(confirm('vous confirmez avoir recu votre commande')){
try {
  const response = await fetch(`index.php?page=api&action=updateDelivery`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id_commande: data.id_commande })
        });

  if (!response.ok) {
    throw new Error("Erreur serveur");
  }

  const result = await response.json();
  alert(result.message);
  validationBtn.disabled = true

} catch (e) {
  alert("Connexion perdue. Réessayez.");
}
        }
    })
}
    
    if(data.tel_livreur !== '' && data.status_commande === 'livreur en route'){
       p5.remove() 
        info.appendChild(tellivreur) 
    }
    
    if(data.client_validation_commande === 1 && data.livreur_validation_commande === 1 && data.status_commande === 'produit livré'){
        tellivreur.remove()
    }

        

div.appendChild(imgWrapper)
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
        loader.style.display = 'block';
        cmd.innerHTML = '';
        try {
            const response = await fetch(`index.php?page=api&action=listecommandes&status=${status1}`);
            if (!response.ok) throw new Error(`Erreur serveur (${response.status})`);
            const data = await response.json();
            loader.style.display = 'none';
            if (data.success && data.data.length > 0) {
                data.data.forEach(commande => CommandeCard(commande));
            } else {
                emptyState(cmd, 'Aucune commande en attente pour le moment.');
            }
        } catch (err) {
            loader.style.display = 'none';
            errorState(cmd, err.message, () => charger());
        }
    },

    '#/cours': async () => {
        loader.style.display = 'block';
        cmd.innerHTML = '';
        try {
            const response = await fetch(`index.php?page=api&action=listecommandes&status=${status2}`);
            if (!response.ok) throw new Error(`Erreur serveur (${response.status})`);
            const data = await response.json();
            loader.style.display = 'none';
            if (data.success && data.data.length > 0) {
                data.data.forEach(commande => CommandeCard(commande));
            } else {
                emptyState(cmd, 'Aucune commande en cours pour le moment.');
            }
        } catch (err) {
            loader.style.display = 'none';
            errorState(cmd, err.message, () => charger());
        }
    },

    '#/finish': async () => {
        loader.style.display = 'block';
        cmd.innerHTML = '';
        try {
            const response = await fetch(`index.php?page=api&action=listecommandes&status=${status3}`);
            if (!response.ok) throw new Error(`Erreur serveur (${response.status})`);
            const data = await response.json();
            loader.style.display = 'none';
            if (data.success && data.data.length > 0) {
                data.data.forEach(commande => CommandeCard(commande));
            } else {
                emptyState(cmd, 'Aucune commande livrée et payée pour le moment.');
            }
        } catch (err) {
            loader.style.display = 'none';
            errorState(cmd, err.message, () => charger());
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


document.getElementById("copyright").textContent = "Copyright © " + new Date().getFullYear() + " Togomarket. Tous droits réservés.";