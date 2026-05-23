/* =======================
IMAGE PREVIEW
======================= */

const divtext = document.getElementById('divtext');
const preview = document.getElementById('preview');
const fileInput = document.getElementById('fileInput');

fileInput.addEventListener("change", () => {
  const file = fileInput.files[0];

  if (file) {
    preview.src = URL.createObjectURL(file);
    preview.style.display = "block";
    divtext.style.display = "none";
  }
});


/* =======================
VARIABLES
======================= */

const BtnLocation = document.getElementById('getLocationBtn');
const Loading = document.querySelector('.loader');
const statusTrue = document.querySelector('.true');

const enregistrerPosition = document.getElementById('enregistrerPosition');
const formPosition = document.getElementById('formPosition');

const nom = document.getElementById('nom');
const adresse = document.getElementById('adresse');
const checkbox = document.getElementById('cgv');
const telInput = document.getElementById('btel');




document.addEventListener("DOMContentLoaded", () => {

    const retour = document.getElementById("back");

    if (retour) {
        retour.addEventListener("click", (e) => {
            e.preventDefault();

            if (document.referrer === "") {
                window.location.href = "/";
            } else {
                window.history.back();
            }
        });
    }

});




const quartiersLomeRegex = /^[A-Za-zÀ-ÿ0-9'’\- ]{3,50}$/;
const regexNum = /^(?:\+228|00228)?[ ]?[279][0-9]{1}(?:[ -]?[0-9]{2}){3}$/;

const coordonnees = {
  longitude: null,
  latitude: null
};


/* =======================
CONFIG GEOLOCATION
======================= */

const GEO_OPTIONS = {
  enableHighAccuracy: true,
  timeout: 10000,
  maximumAge: 30000
};

const TARGET_ACCURACY = 50;
const MAX_ATTEMPTS = 5;
const ATTEMPT_DELAY = 1200;


function getPosition() {
  return new Promise((resolve, reject) => {
    navigator.geolocation.getCurrentPosition(resolve, reject, GEO_OPTIONS);
  });
}


function handleGeolocationError(err) {

  let message = "Erreur inconnue.";

  switch (err.code) {

    case err.PERMISSION_DENIED:
      message = "Permission de localisation refusée.";
      break;

    case err.POSITION_UNAVAILABLE:
      message = "Position indisponible.";
      break;

    case err.TIMEOUT:
      message = "Timeout. Réessayez.";
      break;
  }

  statusTrue.textContent = message;
  statusTrue.style.display = "block";
  Loading.style.display = "none";

  BtnLocation.disabled = false;
}


/* =======================
RECHERCHE MEILLEURE POSITION
======================= */

async function findBestPosition() {

  Loading.style.display = "block";
  statusTrue.style.display = "none";
  BtnLocation.disabled = true;

  let bestPosition = null;

  for (let i = 0; i < MAX_ATTEMPTS; i++) {

    try {

      const pos = await getPosition();
      const accuracy = pos.coords.accuracy;

      console.log(`Tentative ${i + 1} — précision : ${accuracy} m`);

      if (!bestPosition || accuracy < bestPosition.coords.accuracy) {
        bestPosition = pos;
      }

      if (accuracy <= TARGET_ACCURACY) break;

    } catch (err) {
      handleGeolocationError(err);
      return null;
    }

    await new Promise(r => setTimeout(r, ATTEMPT_DELAY));
  }

  Loading.style.display = "none";
  statusTrue.style.display = "block";

  return bestPosition;
}


/* =======================
FLOW GEOLOCATION
======================= */

async function handleLocationRequest() {

  if (!navigator.geolocation) {

    statusTrue.textContent = "Géolocalisation non supportée.";
    statusTrue.style.display = "block";
    return;
  }

  const position = await findBestPosition();

  if (!position) return;

  const { latitude, longitude } = position.coords;

  coordonnees.longitude = longitude;
  coordonnees.latitude = latitude;

  document.getElementById('longitude').value = longitude;
  document.getElementById('latitude').value = latitude;

  statusTrue.textContent = "✔️";
  statusTrue.style.display = "block";

  BtnLocation.disabled = true;
  enregistrerPosition.disabled = false;
}


BtnLocation.addEventListener("click", () => {

  handleLocationRequest().catch(err => {

    console.error("Erreur localisation :", err);

    statusTrue.textContent = "Impossible d’obtenir la localisation.";
    statusTrue.style.display = "block";

    Loading.style.display = "none";
  });

});


formPosition.addEventListener('submit', async (e) => {

  e.preventDefault();

  let valid = true;

  // TEL
  if (!telInput.value || !regexNum.test(telInput.value)) {
    telInput.classList.add('mauvais');
    valid = false;
  } else {
    telInput.classList.remove('mauvais');
  }

  // NOM
  if (nom.value.trim() === '') {
    nom.classList.add('mauvais');
    valid = false;
  } else {
    nom.classList.remove('mauvais');
  }

  // ADRESSE
  if (!adresse.value.trim() || !quartiersLomeRegex.test(adresse.value.trim())) {
    adresse.classList.add('mauvais');
    valid = false;
  } else {
    adresse.classList.remove('mauvais');
  }

  // CGV
  if (!checkbox.checked) {
    checkbox.classList.add('mauvais');
    valid = false;
  } else {
    checkbox.classList.remove('mauvais');
  }

  // COORDONNEES
  if (coordonnees.longitude === null || coordonnees.latitude === null) {
    BtnLocation.classList.add('mauvais');
    valid = false;

    BtnLocation.scrollIntoView({
      behavior: "smooth",
      block: "center"
    });
  } else {
    BtnLocation.classList.remove('mauvais');
  }

  if (!valid) return;

  const otpValid = await getOTP();

  if (!otpValid) {
    enregistrerPosition.disabled = false;
    enregistrerPosition.textContent = 'Confirmer';
    return;
  }
    
formPosition.submit()
    
});



function openOTPModalAndWait() {
    


  return new Promise((resolve) => {

    otpModal.style.display = 'block';
    otpInput.value = '';

    function cleanup() {
      otpModal.style.display = 'none';
      submitOTP.removeEventListener('click', submitHandler);
    }

    function submitHandler() {
      resolve(otpInput.value.trim() || null);
      cleanup();
    }

    submitOTP.addEventListener('click', submitHandler);

    document.querySelector('.close').onclick = () => {
      resolve(null);
      cleanup();
    };

    window.onclick = (e) => {
      if (e.target === otpModal) {
        resolve(null);
        cleanup();
      }
    };

  });

}


async function getOTP() {
  // Désactiver le bouton et afficher l’état
  enregistrerPosition.disabled = true;
  enregistrerPosition.textContent = 'En attente de vérification...';

  try {
    const response = await fetch("index.php?page=api&action=otp", {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ tel: telInput.value, cBoutique: 1 })
    });

    if (!response.ok) throw new Error(`HTTP ${response.status}`);

    const data = await response.json();

    // Vérifie si OTP est requis ou non
    if (data.success === true && data.message === 'Utilisateur connecté, envoi OTP non requis') {
      return true
    }

    // Ouvrir le modal OTP
    const otp = await openOTPModalAndWait();

    if (!otp) {
      showToast("Vérification annulée");
      return false;
    }

    // Vérification OTP
    const verifyResponse = await fetch("index.php?page=api&action=verifyOTP", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ otp })
    });

    if (!verifyResponse.ok) throw new Error(`HTTP ${verifyResponse.status}`);

    const verifyData = await verifyResponse.json();

    if (verifyData.success === true) {
      showToast(verifyData.message);
      enregistrerPosition.textContent = 'Créer ma Boutique';
      return true;
    } else {
      throw new Error(verifyData.message || "Échec vérification OTP");
    }

  } catch (error) {
    console.error(error);
    showToast(error.message || "Erreur réseau. Réessayez.");
    return false;
  } finally {
    // Réactiver le bouton sauf si succès (tu peux ajuster)
    if (enregistrerPosition.textContent !== 'Créer ma Boutique') {
      enregistrerPosition.disabled = false;
      enregistrerPosition.textContent = 'Confirmer';
    }
  }
}


/* =======================
TOAST
======================= */

function showToast(message) {

  const toast = document.createElement('div');

  toast.textContent = message;
  toast.className = 'toast';

  document.body.appendChild(toast);

  setTimeout(() => toast.remove(), 5000);

}


/* =======================
COPYRIGHT
======================= */

document.getElementById("copyright").textContent =
  "Copyright © " +
  new Date().getFullYear() +
  " Togomarket. Tous droits réservés.";