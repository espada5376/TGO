const cordonnees = { longitude: null, latitude: null };

document.addEventListener('DOMContentLoaded', () => {
    
  const formCommand = document.getElementById('formcommand');
  const btnCommander = document.getElementById('btn');
  const envoiCommandeBtn = document.getElementById('envoicommande');
  const nomInput = document.getElementById('nom');
  const telInput = document.getElementById('paiement');
  const quantiteInput = document.getElementById('qte');
  const totalInput = document.getElementById('total');
  const prixInput = document.getElementById('prix');
  const plusBtn = document.getElementById('plus');
  const moinsBtn = document.getElementById('moins');
  const idAnnonceInput = document.querySelector('.idannonce');
  const instructionsInput = document.getElementById('instructions');
  const paiementLabel = document.getElementById('paiementdiv');
  const modePaiementSelect = document.getElementById('Modepaiement');
  const checkboxCGV = document.getElementById('cgv');
  const btnLocation = document.getElementById('getLocationBtn');
  const statusTrue = document.querySelector('.true');
  const loader = document.querySelector('.loader');
  const shareBtn = document.getElementById('shareBtn');
  const h2Element = document.getElementById('h2');
  
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
    
  if (!formCommand || !btnCommander || !nomInput) return;

  const annonceImgs = document.querySelectorAll('.annonceimg');
  annonceImgs.forEach(img => {
    const wrapper = document.createElement('div');
    wrapper.className = 'img-wrapper skeleton';
    img.classList.add('annonces');
    img.loading = 'eager';
    img.decoding = 'async';
    img.setAttribute('fetchpriority', 'high');
    img.parentNode.replaceChild(wrapper, img);
    wrapper.appendChild(img);

    const onLoad = () => {
      wrapper.classList.remove('skeleton');
      img.classList.add('loaded');
    };
    img.complete ? onLoad() : img.addEventListener('load', onLoad);
  });

  btnCommander.addEventListener('click', () => {
    formCommand.style.display = 'block';
    if (h2Element) {
      h2Element.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  });
    
    function formatMoney(amount) {
    return new Intl.NumberFormat('fr-FR', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(amount).replace(/\s/g, '.');
}
    
if (prixInput && totalInput && quantiteInput) {
  let qt = 1;
  const maxQty = parseInt(quantiteInput.getAttribute('max')) || 10;

  const updateTotal = async () => {
    const prix = parseInt(prixInput.value) || 0;
    const total = qt * prix;

    if (total <= 0) return;

    const data = await fetchFrais(total);

    if (data && data.success) {
      totalInput.value = `${formatMoney(total)} + ${formatMoney(data.data)} + ${formatMoney(1000)} = ${formatMoney(total + data.data + 1000)} FCFA`
    }
  };

  quantiteInput.value = qt;
  updateTotal();

  plusBtn?.addEventListener('click', async () => {
    if (qt < maxQty) {
      qt++;
      quantiteInput.value = qt;
      await updateTotal();
    }
  });

  moinsBtn?.addEventListener('click', async () => {
    if (qt > 1) {
      qt--;
      quantiteInput.value = qt;
      await updateTotal();
    }
  });
}
    
let timeout;

function debounceUpdate() {
  clearTimeout(timeout);
  timeout = setTimeout(updateTotal, 300);
}

quantiteInput.addEventListener('input', debounceUpdate);

  const GEO_OPTIONS = { enableHighAccuracy: true, timeout: 10000, maximumAge: 30000 };
  const TARGET_ACCURACY = 50;
  const MAX_ATTEMPTS = 5;
  const ATTEMPT_DELAY = 1200;

  async function getPosition() {
    return new Promise((resolve, reject) => {
      navigator.geolocation.getCurrentPosition(resolve, reject, GEO_OPTIONS);
    });
  }

  function handleGeolocationError(err) {
    let message = "Erreur inconnue.";
    switch (err.code) {
      case err.PERMISSION_DENIED: message = "Permission de localisation refusée."; break;
      case err.POSITION_UNAVAILABLE: message = "Position indisponible."; break;
      case err.TIMEOUT: message = "↻ Réessayer"; break;
    }
    statusTrue.textContent = message;
    statusTrue.style.display = 'block';
    loader.style.display = 'none';
    btnLocation.disabled = false;
  }

  async function findBestPosition() {
    loader.style.display = 'block';
    statusTrue.style.display = 'none';
    btnLocation.disabled = true;

    let bestPos = null;
    for (let i = 0; i < MAX_ATTEMPTS; i++) {
      try {
        const pos = await getPosition();
        if (!bestPos || pos.coords.accuracy < bestPos.coords.accuracy) bestPos = pos;
        if (pos.coords.accuracy <= TARGET_ACCURACY) break;
      } catch (err) {
        handleGeolocationError(err);
        return null;
      }
      await new Promise(r => setTimeout(r, ATTEMPT_DELAY));
    }

    loader.style.display = 'none';
    statusTrue.style.display = 'block';
    return bestPos;
  }

  async function handleLocationRequest() {
    if (!navigator.geolocation) {
      statusTrue.textContent = "La géolocalisation n’est pas supportée.";
      statusTrue.style.display = 'block';
      return;
    }
    const pos = await findBestPosition();
    if (!pos) return;
    cordonnees.latitude = pos.coords.latitude;
    cordonnees.longitude = pos.coords.longitude;
    statusTrue.textContent = "✔️";
    btnLocation.disabled = true;
  }

  btnLocation?.addEventListener('click', () => handleLocationRequest().catch(console.error));


  modePaiementSelect?.addEventListener('input', () => {
    if (modePaiementSelect.value === 'Liquidité') {
      paiementLabel?.remove();
    }
  });


  shareBtn.addEventListener('click', async () => {
    btnCommander.disabled = true;
    if (navigator.share) {
      try {
        await navigator.share({
          title: "Partager sur mon statut",
          text: "Salut, visite cette annonce, elle pourrait t'intéresser",
          url: window.location.href
        });
      } catch (err) {
        console.error("Partage annulé", err);
      }
    } else {
      alert("Le partage n'est pas supporté sur ce navigateur.");
    }
  });
   

  const swiper = new Swiper(".swiper", {
  loop: true,
  spaceBetween: 10,
  slidesPerView: 1,

  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
      
  autoplay: {
    delay: 3000,
    disableOnInteraction: true,
  },

});


  const otpModal = document.getElementById('otpModal');
  const otpInput = document.getElementById('otpInput');
  const submitOTP = document.getElementById('submitOTP');
  const closeBtn = document.querySelector('.close');

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

      closeBtn.onclick = () => { resolve(null); cleanup(); };
      window.onclick = (e) => { if (e.target === otpModal) { resolve(null); cleanup(); } };
    });
  }


  const regexNum = /^(?:\+228|00228)?[ ]?[279][0-9]{1}(?:[ -]?[0-9]{2}){3}$/;

  formCommand.addEventListener('submit', async (e) => {
    e.preventDefault();
    let valid = true;

    // Nom
    if (!nomInput.value || nomInput.value.length < 2) { nomInput.classList.add('mauvais'); valid = false; } 
    else { nomInput.classList.remove('mauvais'); }

    // Quantité
    const qtValue = Number(quantiteInput.value);
    const maxQty = parseInt(quantiteInput.getAttribute('max'));
    if (qtValue < 1 || qtValue > maxQty) { quantiteInput.classList.add('mauvais'); valid = false; 
     const offset = 120;
    const elementPosition = quantiteInput.getBoundingClientRect().top + window.pageYOffset;
    const offsetPosition = elementPosition - offset;
    window.scrollTo({
        top: offsetPosition,
        behavior: 'smooth'
    });
                                         } 
    else { quantiteInput.classList.remove('mauvais'); }

    // Paiement

      if (!telInput.value || !regexNum.test(telInput.value)) { telInput.classList.add('mauvais'); valid = false; } 
      else { telInput.classList.remove('mauvais'); }


    // CGV
    if (!checkboxCGV.checked) { checkboxCGV.classList.add('mauvais'); valid = false; } 
    else { checkboxCGV.classList.remove('mauvais'); }

    // Géolocalisation
    if (!cordonnees.longitude || !cordonnees.latitude) {
      valid = false;
      btnLocation.classList.add('mauvais');
     
	const offset = 120;
    const elementPosition = btnLocation.getBoundingClientRect().top + window.pageYOffset;
    const offsetPosition = elementPosition - offset;

    window.scrollTo({
        top: offsetPosition,
        behavior: 'smooth'
    });

    } else {
      btnLocation.classList.remove('mauvais');
    }

    if (!valid) return;

    // OTP
    const otpValid = await getOTP();
    if (!otpValid) { envoiCommandeBtn.disabled = false; envoiCommandeBtn.textContent = 'Confirmer'; return; }

    // Envoi commande
    envoiCommandeBtn.textContent = 'Envoi de la commande...';
    await envoyerCommande();
  });
   
    
   
  async function getOTP() {
    // Désactive le bouton et affiche un message
    envoicommande.disabled = true;
    envoicommande.textContent = 'En attente de vérification...';

    try {
        // Envoi du numéro pour demander l'OTP
        const response = await fetch("index.php?page=api&action=otp", {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ tel: telInput.value })
        });

        if (!response.ok) throw new Error("Erreur HTTP : " + response.status);

        const data = await response.json();
        console.log('Réponse OTP :', data);

        // Cas : utilisateur déjà connecté, pas besoin d'OTP
        if (data.success === true && data.message === 'Utilisateur connecté, envoi OTP non requis') {
            return true;
        }

        // Cas : OTP requis
        if (data.success === true) {
            const otp = await openOTPModalAndWait(); // Attente de la saisie utilisateur
            if (!otp) {
                alert("Vérification annulée");
                envoicommande.disabled = false;
                envoicommande.textContent = 'Confirmer';
                return false;
            }

            // Vérification de l'OTP saisi
            const response1 = await fetch("index.php?page=api&action=verifyOTP", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ otp })
            });

            if (!response1.ok) throw new Error("Erreur HTTP : " + response1.status);

            const data1 = await response1.json();
            console.log('Résultat vérification OTP :', data1);

            if (data1.success === true) {
                const toast = document.createElement('div');
			toast.textContent = data1.message;
            toast.className = 'toast';
            document.body.appendChild(toast);

            setTimeout(() => toast.remove(), 5000);

                envoicommande.textContent = 'Confirmé';
                return true;
            } else {
                const toast = document.createElement('div');
			toast.textContent = "Échec vérification OTP : " + data1.message;
            toast.className = 'toast';
            document.body.appendChild(toast);

            setTimeout(() => toast.remove(), 5000);
                envoicommande.disabled = false;
                envoicommande.textContent = 'Confirmer';
                return false;
            }
        } else {
            const toast = document.createElement('div');
			toast.textContent = "Échec envoi OTP : " + data.message;
            toast.className = 'toast';
            document.body.appendChild(toast);

            setTimeout(() => toast.remove(), 5000);
            envoicommande.disabled = false;
            envoicommande.textContent = 'Confirmer';
            return false;
        }

    } catch (error) {
       	const toast = document.createElement('div');
			toast.textContent = "Erreur réseau. Veuillez réessayer.";
            toast.className = 'toast';
            document.body.appendChild(toast);

            setTimeout(() => toast.remove(), 5000);

        envoicommande.disabled = false;
        envoicommande.textContent = 'Reéssayer';
        return false;
    }
}

async function fetchFrais(montant) {
  try {
    const response = await fetch('index.php?page=api&action=frais', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ montant })
    });

    if (!response.ok) throw new Error("Erreur serveur");

    return await response.json();

  } catch (err) {
    console.error("Erreur fetch frais:", err);
    return null;
  }
}  
    
  async function envoyerCommande() {
    try {
      envoiCommandeBtn.disabled = true;
      const response = await fetch('index.php?page=api&action=commande', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          nom: nomInput.value,
          tel: telInput.value,
          longitude: cordonnees.longitude,
          latitude: cordonnees.latitude,
          quantite: quantiteInput.value,
          instruction: instructionsInput.value,
          mode_paiement: modePaiementSelect.value,
          idannonce: idAnnonceInput.value
        })
      });

      if (!response.ok) throw new Error("Erreur communication serveur");

      const data = await response.json();
      if (data.success) {
        envoiCommandeBtn.textContent = data.message;
        envoiCommandeBtn.disabled = true;
        window.location.href = `index.php?page=apresCommande&id=${idAnnonceInput.value}`;
      } else {
        alert(data.message);
        envoiCommandeBtn.textContent = 'Confirmer';
        envoiCommandeBtn.disabled = false;
      }
    } catch (err) {
      console.error("Erreur envoi commande:", err);
    }
  }

  const copyrightEl = document.getElementById("copyright");
  if (copyrightEl) {
    copyrightEl.textContent = `Copyright © ${new Date().getFullYear()} Togomarket. Tous droits réservés.`;
  }
    
});


