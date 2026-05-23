<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link
  rel="stylesheet"
  href="/assets/style/panier.css?v=<?= filemtime($_SERVER['DOCUMENT_ROOT'] . '/assets/style/panier.css') ?>"
/>

<link
  rel="stylesheet"
  href="/assets/style/annonce.css?v=<?= filemtime($_SERVER['DOCUMENT_ROOT'] . '/assets/style/annonce.css') ?>"
/>

        <script
  src="/assets/js/panier.js?v=<?= filemtime($_SERVER['DOCUMENT_ROOT'] . '/assets/js/panier.js') ?>"
  defer>
</script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Panier TogoMarket</title>

    <link rel="icon" type="image/svg+xml" href="assets/file (1).svg">
    
    
      <!-- Open Graph -->
  <meta property="og:title" content="Togomarket – Achetez et vendez au Togo">
  <meta property="og:description" content="Plateforme togolaise de vente et d’achat en ligne.">
  <meta property="og:image" content="https://tg.infinityfreeapp.com/assets/file (1).png">
  <meta property="og:url" content="https://tg.infinityfreeapp.com/">
  <meta property="og:type" content="website">
    
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-8KND21DBNQ"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-8KND21DBNQ');
</script>
</head>
<body>
<header id="ancien">
    <nav>
        <a class='hstatus' id='back' ><img src='/assets/left-arrow-svgrepo-com (1).svg' width='20px'/></a>
        <a class='hstatus1' href="<?= isset($_SESSION['id']) ? '/profil' : '/connexion' ?>">
            <?= isset($_SESSION['id']) 
                ? '<svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 16 16" fill="none">
<path d="M8 7C9.65685 7 11 5.65685 11 4C11 2.34315 9.65685 1 8 1C6.34315 1 5 2.34315 5 4C5 5.65685 6.34315 7 8 7Z" fill="#000000"/>
<path d="M14 12C14 10.3431 12.6569 9 11 9H5C3.34315 9 2 10.3431 2 12V15H14V12Z" fill="#000000"/>
</svg> Profil' : "Connexion" ?>
        </a>
    </nav>
</header>

<section>
<div class="content">

<?php if (!empty($panier['ids'])): ?>
    <?php foreach ($panier['ids'] as $i => $id): ?>
        <div id='annonce' class="annonce photo">
            <a class='ann' href="<?= url('annonce/lome/' . slugifyBoutique($panier['noms'][$i]) . '-' . $id) ?>">
                <img src="/assets/product/<?= htmlspecialchars($panier['photos'][$i]) ?>" class="annonces" loading="lazy" alt="<?= htmlspecialchars($panier['noms'][$i]) ?>">
            </a>
            <div class="informationannonce">
                <a href="<?= url('annonce/lome/' . slugifyBoutique($panier['noms'][$i]) . '-' . $id) ?>" class="prix"><?= formatMoney($panier['prix'][$i]) ?> FCFA</a>
                <a class='tronqué' href="<?= url('annonce/lome/' . slugifyBoutique($panier['noms'][$i]) . '-' . $id) ?>">
                    <?= htmlspecialchars($panier['noms'][$i]) ?>
                </a>
        
            </div>
            <a class='like-btn panier like' href='<?= url('annonce/lome/' . slugifyBoutique($panier['noms'][$i]) . '-' . $id) ?>'>Acheter Maintenant</a>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <h1><?= htmlspecialchars($message ?? 'Aucune annonce dans le panier') ?></h1>
    <p class='rp'>ou rupture de stock des annonces du panier</p>
        
    <a href="/">Ajouter une annonce</a>
    
<?php endif; ?>

</div>
</section>

<br/>
<br/>




<script>document.getElementById("copyright").textContent = "Copyright © " + new Date().getFullYear() + " Togomarket. Tous droits réservés.";</script>

</body>
</html>
