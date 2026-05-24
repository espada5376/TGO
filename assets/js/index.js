window.addEventListener("load", () => {
    document.getElementById("loader").style.display = "none";
});

const catSwiper = new Swiper(".swiper", {
  slidesPerView: "auto",
  spaceBetween: 12,
  loop: true,
  autoplay: {
        delay: 3000,             
        disableOnInteraction: false
    },
    speed: 600,
    
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  breakpoints: {
    370: {slidesPerView: 1},
    380: { slidesPerView: 2 },
    534: { slidesPerView: 2 },
    640: { slidesPerView: 3 },
    1024: { slidesPerView: 5 },
  },
  rtl: false,
  direction: 'horizontal',
});


document.getElementById("copyright").textContent = "Copyright © " + new Date().getFullYear() + " Togomarket. Tous droits réservés.";


const Base_url = window.location.origin + '/'


function convertirTemps(duree_secondes) {

    if (duree_secondes < 60) { 
        return "Ajouté à l'instant";
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

function formatMoney(amount) {
    return new Intl.NumberFormat('fr-FR', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(amount).replace(/\s/g, '.');
}



const loadingd = document.querySelector('.loader');
const listeannonce = document.querySelector('#content');
const barre = document.getElementById('search');
const suggdiv = document.getElementById('suggestions');

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

function boutiqueUrl(id, nom) {
    return '/profil-boutique/lome/' + slugify(nom) + '-' + id;
}

function createAnnonce(ann) {     
    const container = document.createElement("div");
    container.classList.add("annonce", "photo");
    container.dataset.id = ann.id_annonce;

    const linkImg = document.createElement("a");
    linkImg.classList.add("ann");
    linkImg.href = commandUrl(ann.id_annonce, ann.titre_annonce);

    const imgWrapper = document.createElement("div");
    imgWrapper.className = "img-wrapper skeleton";
    	
    const img = document.createElement("img");
    img.loading = "lazy";
    img.decoding = "async";
	img.setAttribute("fetchpriority", "low");
    img.src = `${Base_url}assets/product/${ann.photo_annonce}`;
    img.alt = ann.titre_annonce;
    img.classList.add("annonces");
    
    if (img.complete) {
  imgWrapper.classList.remove("skeleton");
  img.classList.add("loaded");
}

 
    img.addEventListener("load", () => {
  imgWrapper.classList.remove("skeleton");
  img.classList.add("loaded");
});

imgWrapper.appendChild(img);
linkImg.appendChild(imgWrapper);
    

    const duré = document.createElement('div')
    duré.innerHTML = `<i class="fa-regular fa-clock"></i> ${convertirTemps(ann.duree_secondes)}`
    duré.classList.add('duré')
    imgWrapper.appendChild(duré)

    const info = document.createElement("div");
    info.classList.add("informationannonce");
    
    
    const priceLink = document.createElement("a");
    priceLink.href = commandUrl(ann.id_annonce, ann.titre_annonce);
    priceLink.classList.add("prix");
    priceLink.textContent = `${formatMoney(ann.prix_unitaire_annonce)} FCFA`;


    const nameLink = document.createElement("a");
    nameLink.classList.add('tronqué')
    nameLink.href = commandUrl(ann.id_annonce, ann.titre_annonce);
    nameLink.textContent = ann.titre_annonce;

   
    const boutique = document.createElement('div')
    boutique.classList.add('boutique')

    

    const logo = document.createElement('img')
    logo.classList.add('logob')
    logo.src =  `${Base_url}assets/logo_boutique/${ann.logo_boutique}`
	const logodiv = document.createElement('a')
    logodiv.href = boutiqueUrl(ann.id_boutique, ann.nom_boutique)
    logodiv.classList.add('logodiv')
    logodiv.appendChild(logo)


    const nomboutique = document.createElement('a')
    nomboutique.href = boutiqueUrl(ann.id_boutique, ann.nom_boutique)
    nomboutique.textContent = `${ann.nom_boutique}`

    boutique.appendChild(logodiv)
    boutique.appendChild(nomboutique)
    
    
    info.appendChild(priceLink);
    info.appendChild(nameLink);
    info.appendChild(boutique)

    const btn = document.createElement("button");
    btn.name = "panier";
    btn.classList.add("like-btn", "panier");
    btn.dataset.id = ann.id_annonce;
    btn.innerHTML = `<i class="fa-solid fa-basket-shopping"></i> Ajouter au panier <span class="panier-count"></span>`;
    btn.dataset.name =ann.titre_annonce
    btn.dataset.category = ann.id_categorie
    btn.dataset.price = ann.prix_unitaire_annonce
    
    btn.addEventListener("click", (e) => {
    e.stopPropagation(); 
    btn.classList.toggle('like');
    applyLikesOnClick(btn);
});

    container.appendChild(linkImg);
    container.appendChild(info);
    container.appendChild(btn);

    container.addEventListener('click', (e) => {
        if (!e.target.classList.contains('panier')) { 
            window.location.href = commandUrl(ann.id_annonce, ann.titre_annonce);
        }        
    }); 
    return container; }
    
    
async function applyLikes() { 
    try {
        const res = await fetch("index.php?page=api&action=applylike", { method: 'GET' });

        if (!res.ok) {
            throw new Error(`Erreur HTTP: ${res.status}`);
        }

        let data;
        try {
            data = await res.json(); 
        } catch (e) {
            throw new Error("Le serveur n’a pas renvoyé du JSON valide");
        }
		
        const pani = document.querySelector('.pani');
        
        if (!data.success)	{
            if (pani) {
            pani.textContent = '';
        	}
            const toast = document.createElement('div');
			toast.textContent = data.message;
            toast.className = 'toast';
            document.body.appendChild(toast);
			
            setTimeout(() => toast.remove(), 5000);
            return
        }

        const likedIds = (data.id_annonce || []).map(id => Number(id));
        document.querySelectorAll('.panier').forEach(btn => {
            const btnId = Number(btn.dataset.id);
            btn.classList.toggle('like', likedIds.includes(btnId));
        });
        
        if (pani) {
            pani.textContent = `(${data.totallike})`;
        }

    } catch (err) {
        console.error('Erreur applyLikes :', err);
    }
}

    


async function applyLikesOnClick(btn) {
    try {
        const res = await fetch("index.php?page=api&action=addlike", {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ photo_id: Number(btn.dataset.id) })
        });        
            
       	const data = await res.json();

        if (data.success) {
            document.querySelector('.pani').textContent = `(${data.totallike})`;
            
            const price = parseFloat(btn.dataset.price);
			const quantity = 1;
            
            gtag('event', 'add_to_cart', {
          	currency: 'XOF',
          	value: price * quantity,
          	items: [{
            item_id: btn.dataset.id,
            item_name: btn.dataset.name,
            item_category: btn.dataset.category,
            price: price,
            quantity: quantity
  }]
});
        } else {
            if(confirm(data.message)){
                window.location.href = Base_url + 'connexion'
            }

            btn.classList.remove('like');
        }

    } catch (err) {
        console.error('Erreur fetch likes:', err);
    }
}


const sectionobservers = {}

function createSection(sectionId, fetchurl, categorie) {
    const section = document.getElementById(sectionId);
    const content = section.querySelector('.content');
    const sentinel = section.querySelector('.sentinel');
    const loader = section.querySelector('.loader');

    if (sectionobservers[sectionId]) {
        const { observer, sentinel: oldSentinel } = sectionobservers[sectionId];
        if (oldSentinel) observer.unobserve(oldSentinel);
        observer.disconnect();
    }

    content.textContent = "";
    let currentPage = 1;
    let totalPages = null;
    let loading = false;
    let backoff = 800;
    const maxBackoff = 6000;

    const observer = new IntersectionObserver((entries) => {
        const entry = entries[0];
        if (entry.isIntersecting && !loading && currentPage < totalPages) {
            loadProducts(currentPage + 1);
        }
    }, {
        threshold: 1,
        rootMargin: "100px"
    });

    async function loadProducts(page = 1) {
        if (loading || document.hidden) return;

        loading = true;
        loader.style.display = "block";
        
        
        try {
            const res = await fetch(`${fetchurl}&pagination=${page}&categorie=${encodeURIComponent(categorie)}`, {
                cache: "no-store"
            });
            


            const pro = await res.json();
			
            if (!pro.success) throw new Error(pro.message);

            totalPages = pro.totalpages;

            if (!pro.annonces || pro.annonces.length === 0) {
                if (page === 1) {
                    const div = document.createElement('div');
                    div.textContent = "Aucune annonce";
                    content.appendChild(div);
                }
                return;
            }
            
            const fragment = document.createDocumentFragment();
            pro.annonces.forEach(ann => fragment.appendChild(createAnnonce(ann)));
            content.appendChild(fragment);
            

            applyLikes();
            currentPage = page;
            totalPages = pro.totalpages;

            if (currentPage >= totalPages) {
                observer.unobserve(sentinel);
            }

            backoff = 800;

        } catch (err) {
            console.error("Erreur load:", err);
            backoff = Math.min(backoff * 2, maxBackoff);
            setTimeout(() => loadProducts(currentPage), backoff);
        } finally {
            loader.style.display = "none";
            loading = false;

        }
    }

    sectionobservers[sectionId] = { observer, sentinel };

    document.addEventListener("visibilitychange", () => {
        if (!document.hidden && content.childNodes.length === 0) {
            loadProducts(currentPage);
        }
    });

    loadProducts(1).then(() => observer.observe(sentinel));
}

function hideAllSections() {
    for (let i = 1; i <= 12; i++) {
        document.getElementById(`section${i}`).style.display = 'none'
    }
}

const slides = document.querySelectorAll('.swiper-slide')

const catégories = Array.from(slides).map(slide => slide.getAttribute('data-value'))

const routes = {};

routes['#/'] = async () => {
    hideAllSections();
    document.getElementById('section1').style.display = 'block';

    createSection(
        'section1',
        'index.php?page=api&action=chargerannonce',
        catégories[0]
    );
};


catégories.forEach((categorie, index) => {

    const routePath = `#/${categorie}`;
    const sectionId = `section${index + 1}`;

    routes[routePath] = async () => {

        hideAllSections();

        const section = document.getElementById(sectionId);
        if (section) {
            section.style.display = 'block';

            createSection(
                sectionId,
                'index.php?page=api&action=chargerannonce',
                categorie
            );
        }
    };

});


function activeLink(){
    const hash = window.location.hash || '#/'
    document.querySelectorAll('.swiper-wrapper a').forEach(link =>{
        if(link.getAttribute('data-route') === hash){
            link.classList.add('active')
        }else{
            link.classList.remove('active')
        }
    })
}


function navigation(path){
    window.location.hash = path

}

window.addEventListener('hashchange', charger)

charger();

async function  charger(){
    activeLink();
    const path = window.location.hash || '#/'
    const route = routes[path]
    if(route){
        await route();
    }else{
        console.log('erreur')
    }
}

document.addEventListener('click', (e) => {
    if(e.target.matches('a[data-route]')){
        e.preventDefault();
        navigation(e.target.getAttribute('data-route'));
    }
});


const main = document.querySelector('.main');
const img = new Image();

img.loading = "eager";
img.decoding = "async";
img.setAttribute("fetchpriority", "high");
img.src = '/assets/ChatGPT\ Image\ 28\ déc.\ 2025\,\ 01_11_27.webp';

img.onload = () => {
  main.classList.add('loaded');
};


const input = document.getElementById('searchInput');
const form = document.getElementById('formr'); 

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const query = input.value.trim();

        if (query.length < 2) {
            alert("Veuillez entrer au moins 2 caractères");
            return;
        }

        // Redirection vers la page de résultats
        window.location.href = `/search/${encodeURIComponent(query)}`;
    });

const inputf = document.getElementById('searchInputf');
const formf = document.getElementById('formrf'); 

    formf.addEventListener('submit', function(e) {
        e.preventDefault();

        const query = inputf.value.trim();

        if (query.length < 2) {
            alert("Veuillez entrer au moins 2 caractères");
            return;
        }

        // Redirection vers la page de résultats
        window.location.href = `/search/${encodeURIComponent(query)}`;
    });









