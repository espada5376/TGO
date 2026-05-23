<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
   
    <link
  rel="stylesheet"
  href="/assets/style/profilboutique.css?v=<?= filemtime($_SERVER['DOCUMENT_ROOT'] . '/assets/style/profilboutique.css') ?>"
>
    
<link
  rel="stylesheet"
  href="/assets/style/annonce.css?v=<?= filemtime($_SERVER['DOCUMENT_ROOT'] . '/assets/style/annonce.css') ?>"
/>    
    
<link rel="icon" type="image/svg+xml" href="/assets/file (1).svg">
    
    <script
  src="/assets/js/profilboutique.js?v=<?= filemtime($_SERVER['DOCUMENT_ROOT'] . '/assets/js/profilboutique.js') ?>"
  defer>
</script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title><?= htmlspecialchars($boutique['nom_boutique']) ?> | TogoMarket</title>

      
    
      <!-- Open Graph -->
  <meta property="og:title" content="TogoMarket – Achetez et vendez au Togo">
  <meta property="og:description" content="<?= htmlspecialchars($boutique['nom_boutique'] ) ?>">
  <meta property="og:image" content="<?= $image ?>">
  <meta property="og:url" content="<?= $url ?>">
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
            <a class='hstatus' id="back"><i class="fa-solid fa-arrow-left"></i></a>
            <a class='hstatus1' href="<?= isset($_SESSION['id']) && isset($_SESSION['tel']) ? '/profil' : '/connexion' ?>">
                <?= isset($_SESSION['id']) && isset($_SESSION['tel']) 
                ? "<i class='fa-solid fa-user'></i> Profil" 
                : "Connexion" ?>
            </a>
            
        </nav>
    </header>
    <section>

        <div class="profil-box">
            <img loading="lazy" src="/assets/logo_boutique/<?=$boutique['logo_boutique']?>" loading="lazy"  alt="<?= $boutique['nom_boutique'] ?>"/>
        </div>

        <div>
            <h1><?= $boutique['nom_boutique'] ?></h1>
<p>
    <?= $interval === 0
        ? "Créé aujourd’hui"
        : "Créé il y a {$interval} jours"
    ?>
</p>

</p>
            <p>Catégorie: <?= $boutique['categorie_boutique'] ?></p>
        </div>

    </section>

    <hr>

    <div class="content">

<?php if (empty($annonces)): ?>
    <p>Aucune annonce publiée</p>
<?php endif; ?>

<?php foreach ($annonces as $annonce) : ?>
<div id='annonce' class="annonce photo">
    <a class='ann' href='<?=  url('annonce/lome/' . slugifyBoutique($annonce['titre_annonce'])	.	'-'	. $annonce['id_annonce']) ?>'>
        <img src="/assets/product/<?=$annonce['photo_annonce']?>" alt='<?= $annonce['titre_annonce'] ?>' loading="lazy" class='annonces'>
    </a>

    <div class='informationannonce'>
        <a class='prix' href='<?= url('annonce/lome/' . slugifyBoutique($annonce['titre_annonce'])	.	'-'	. $annonce['id_annonce']) ?>'>
            <?= formatMoney($annonce['prix_unitaire_annonce']) ?> FCFA
        </a>
        <a class='tronqué' href="<?= url('annonce/lome/' . slugifyBoutique($annonce['titre_annonce'])	.	'-'	. $annonce['id_annonce']) ?>">
            <?= $annonce['titre_annonce'] ?>
        </a>
        
    </div>

    <a class='like-btn panier' href='<?= url('annonce/lome/' . slugifyBoutique($annonce['titre_annonce']) .	'-'	. $annonce['id_annonce']) ?>'>
        Acheter Maintenant
    </a>
</div>
<?php endforeach; ?>


    </div>

<br/>
<br/>


</body>

</html>