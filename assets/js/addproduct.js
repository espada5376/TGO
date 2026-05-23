// =======================
// SÉLECTION DES ÉLÉMENTS
// =======================
const prixcard = document.querySelector('.prix');
const nomcard = document.querySelector('.tronqué')
const imgCard = document.querySelector('.annonces'); // image principale carte
const nomp = document.getElementById('nom_produit');
const prix = document.getElementById('prix_du_produit');
const inputQte = document.getElementById('qte');


const fileInput = document.getElementById('fileInput');
const preview = document.getElementById('preview');
const divtext = document.getElementById('divtext');

const fileInput1 = document.getElementById('fileInput1');
const preview1 = document.getElementById('preview1');
const divtext1 = document.getElementById('divtext1');

const form = document.getElementById('form');
const retour = document.getElementById('back');

// =======================
// BOUTON RETOUR
// =======================
if (retour) {
    retour.addEventListener("click", () => {
        if (document.referrer === "") {
            window.location.href = "/";
        } else {
            window.history.back();
        }
    });
}

// =======================
// PREVIEW IMAGE
// =======================
function handleImagePreview(input, previewEl, textEl) {
    if (!input) return;

    input.addEventListener("change", () => {
        const file = input.files[0];

        if (file && file.type.startsWith("image/")) {
            previewEl.src = URL.createObjectURL(file);
            previewEl.style.display = "block";
            textEl.style.display = "none";
        }
    });
}

function formatMoney(amount) {
    return new Intl.NumberFormat('fr-FR', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(amount).replace(/\s/g, '.');
}

handleImagePreview(fileInput, preview, divtext);
handleImagePreview(fileInput1, preview1, divtext1);
handleImagePreview(fileInput, imgCard, divtext)

// =======================
// SYNCHRO PRIX
// =======================
if (prix && prixcard) {
    prix.addEventListener('input', () => {
        prixcard.textContent = `${formatMoney(prix.value)} FCFA`;
    });
}

if (nomp && nomcard) {
    nomp.addEventListener('input', () => {
        nomcard.textContent = `${nomp.value}`;
    });
}

// =======================
// GESTION QUANTITÉ
// =======================
if (inputQte) {
    document.getElementById('plus')?.addEventListener('click', () => {
        inputQte.value = parseInt(inputQte.value || 1) + 1;
    });

    document.getElementById('moins')?.addEventListener('click', () => {
        let val = parseInt(inputQte.value || 1);
        if (val > 1) inputQte.value = val - 1;
    });
}

// =======================
// VALIDATION
// =======================
function isNameValid() {
    return nomp && nomp.value.trim() !== '';
}

function isPriceValid() {
    const value = parseInt(prix.value, 10);
    return !isNaN(value) && value >= 500;
}

function updateValidationUI() {
    // Nom
    if (nomp) {
        nomp.classList.toggle('mauvais', !isNameValid());
    }

    // Prix
    if (prix) {
        prix.classList.toggle('mauvais', !isPriceValid());
    }
}

function isFormValid() {
    return isNameValid() && isPriceValid();
}

// =======================
// EVENTS VALIDATION
// =======================
nomp?.addEventListener('input', updateValidationUI);
prix?.addEventListener('input', updateValidationUI);

// =======================
// SUBMIT FORMULAIRE
// =======================
if (form) {
    form.addEventListener('submit', (e) => {
        e.preventDefault();

        updateValidationUI();

        if (!isFormValid()) {
            return;
        }

        form.submit();
    });
}