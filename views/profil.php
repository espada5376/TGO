<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Compte TogoMarket</title>
    <link rel="stylesheet" href="<?= ASSETS_URL ?>style/profil.css?v=<?= filemtime(ASSETS_PATH.'style/profil.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="<?= ASSETS_URL ?>file-(1).svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
    <!-- Open Graph -->
  <meta property="og:title" content="TogoMarket – Achetez et vendez au Togo">
  <meta property="og:description" content="Plateforme togolaise de vente et d'achat en ligne.">
  <meta property="og:image" content="https://tg.infinityfreeapp.com/assets/file (1).png">
  <meta property="og:url" content="https://tg.infinityfreeapp.com/">
  <meta property="og:type" content="website">
    
<script>
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
</script>
    
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-8KND21DBNQ"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-8KND21DBNQ');
</script>
        
    
</head>
<body>


    <header>
        <nav>
            <a class='hstatus' href="<?= url() ?>"><i class="fa-solid fa-arrow-left"></i></a>
            <a class='hstatus1' href="<?= url('publier-une-annonce') ?>">Publier une annonce</a>
        </nav>
    </header>
    <div class="profil">
        <div class="profil-box">
            <img loading="lazy" src="../pexels-italo-melo-881954-2379004.jpg" alt="" srcset="">
        </div>
    </div>

    <p class='nom'><?=  htmlspecialchars($_SESSION['nom']) ?></p>
    <div class="options">

        <div class="options">
            <a href="<?= url('boutique') ?>" class="<?php if(empty($hasBoutique)){ echo 'nonvendeur';}else{echo 'vendeur';}?>">Ma boutique<i class="fa-solid fa-arrow-right"></i></a>
                        <a href="<?= url('creer-ma-boutique') ?>" class="<?php if(empty($hasBoutique)){echo 'vendeur' ;}else{echo 'nonvendeur';}?>">Créer ma boutique<i class="fa-solid fa-arrow-right"></i></a>
            <a href="<?= url('mesCommandes') ?>">Mes achats<i class="fa-solid fa-arrow-right"></i></a>
            <a href="<?= url('infoCompte') ?>">Information du compte<i class="fa-solid fa-arrow-right"></i></a>
            <a href="<?= url('deconnexion') ?>">Déconnexion<i class="fa-solid fa-arrow-right"></i></a>
        </div>
    </div>
<br/>
<br/>


</body>
</html>