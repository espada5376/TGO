document.addEventListener('DOMContentLoaded', () => {

    const content = document.querySelector('.content');
    const loader = document.querySelector('.loader');
    const nbannonce = document.getElementById('nbannonce');

    const searchinput = document.getElementById('searchInput');
    const searchinputf = document.getElementById('searchInputf');

    const path = window.location.pathname;
    const parts = path.split("/");
    const query = decodeURIComponent(parts[2] || "");

    if (searchinput && query) searchinput.value = query;
    if (searchinputf && query) searchinputf.value = query;

    if (!query || query.length < 2) {
        if (content) content.innerHTML = "<div class='no-result'>Aucun mot clé fourni</div>";
        return;
    }

    if (loader) loader.style.display = "block";

    fetch(`/index.php?page=api&action=search&q=${encodeURIComponent(query)}`, {
        headers: { "Accept": "application/json" }
    })
    .then(res => res.json())
    .then(data => {

        if (loader) loader.style.display = "none";
        if (!content) return;

        content.innerHTML = "";
        
        console.log(data)

        if (!data.success || !Array.isArray(data.annonces) || data.annonces.length === 0) {
            content.innerHTML = "<div class='no-result'>Aucun résultat</div>";
            return;
        }

        if (nbannonce) {
            nbannonce.textContent = `${data.total} ${data.total > 1 ? "Annonces trouvées" : "Annonce trouvée"}`;
        }

        const fragment = document.createDocumentFragment();

        for (const item of data.annonces) {
            fragment.appendChild(createAnnonce(item));
        }

        content.appendChild(fragment);
        applyLikes()
    })
    .catch(err => {
        console.error(err);
        if (loader) loader.style.display = "none";
        if (content) content.innerHTML = "<div class='no-result'>Erreur lors de la recherche</div>";
    });

    setupSearch(
        document.getElementById('formr'),
        document.getElementById('searchInput')
    );

    setupSearch(
        document.getElementById('formrf'),
        document.getElementById('searchInputf')
    );
});


function setupSearch(form, input) {
    if (!form || !input) return;

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const query = input.value.trim();

        if (query.length < 2) {
            alert("Veuillez entrer au moins 2 caractères");
            return;
        }

        window.location.href = `/search/${encodeURIComponent(query)}`;
    });
}


const Base_url = window.location.origin + '/';

function createAnnonce(ann) {     
    const container = document.createElement("div");
    container.classList.add("annonce", "photo");
    container.dataset.id = ann.id_annonce;

    const linkImg = document.createElement("a");
    linkImg.classList.add("ann");
    linkImg.href = commandUrl(ann.id_annonce);

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
    linkImg.appendChild(duré)

    const info = document.createElement("div");
    info.classList.add("informationannonce");
    
    
    const priceLink = document.createElement("a");
    priceLink.href = commandUrl(ann.id_annonce);
    priceLink.classList.add("prix");
    priceLink.textContent = `${formatMoney(ann.prix_unitaire_annonce)} FCFA`;


    const nameLink = document.createElement("a");
    nameLink.classList.add('tronqué')
    nameLink.href = commandUrl(ann.id_annonce);
    nameLink.textContent = ann.titre_annonce;

   
    const boutique = document.createElement('div')
    boutique.classList.add('boutique')

    

    const logo = document.createElement('img')
    logo.classList.add('logob')
    logo.src =  `${Base_url}assets/logo_boutique/${ann.logo_boutique}`
	const logodiv = document.createElement('a')
    logodiv.href = boutiqueUrl(ann.id_boutique)
    logodiv.classList.add('logodiv')
    logodiv.appendChild(logo)


    const nomboutique = document.createElement('a')
    nomboutique.href = boutiqueUrl(ann.id_boutique)
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
            window.location.href = commandUrl(ann.id_annonce);
        }        
    }); 
    return container; 
}

function convertirTemps(sec) {
    if (sec < 60) return "Ajouté à l'instant";
    if (sec < 3600) return `${Math.floor(sec / 60)} min`;
    if (sec < 86400) return `${Math.floor(sec / 3600)} h`;
    return `${Math.floor(sec / 86400)} jour`;
}

function formatMoney(amount) {
    return new Intl.NumberFormat('fr-FR', {
        maximumFractionDigits: 0
    }).format(amount).replace(/\s/g, '.');
}

function commandUrl(id) {
    return '/annonce/' + encodeURIComponent(id);
}

function boutiqueUrl(id) {
    return '/profilboutique/' + encodeURIComponent(id);
}


async function applyLikes() {
    try {
        const res = await fetch("index.php?page=api&action=applylike");

        if (!res.ok) throw new Error(`HTTP ${res.status}`);

        const data = await res.json();

        if (!data.success) throw new Error(data.message);

        const likedIds = data.id_annonce.map(Number);

        document.querySelectorAll('.panier').forEach(btn => {
            btn.classList.toggle('like', likedIds.includes(Number(btn.dataset.id)));
        });

        const pani = document.querySelector('.pani');
        if (pani) pani.textContent = `(${data.totallike})`;

    } catch (err) {
        console.error('Erreur applyLikes:', err);
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
            const pani = document.querySelector('.pani');
            if (pani) pani.textContent = `(${data.totallike})`;
        } else {
            if (confirm(data.message)) {
                window.location.href = 'index.php?page=connexion';
            }
            btn.classList.remove('like');
        }

    } catch (err) {
        console.error('Erreur like:', err);
    }
}