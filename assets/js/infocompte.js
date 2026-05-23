
function slugify(text) {
  return text
    .toLowerCase()
    .normalize('NFD')
    .replace(/[\u0300-\u036f]/g, '')
    .replace(/[^a-z0-9]+/g, '-')
    .replace(/(^-|-$)+/g, '');
}

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
   
document.getElementById("copyright").textContent = "Copyright © " + new Date().getFullYear() + " Togomarket. Tous droits réservés.";

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


