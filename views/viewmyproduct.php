<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="../../assets/style/viewmyproduct.css">
    <title>Annonces TogoMarket</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src='../../assets/js/viewmyproduct.js' defer ></script>
    <link rel="icon" type="image/svg+xml" href="assets/file (1).svg">
<link
  rel="stylesheet"
  href="/assets/style/annonce.css?v=<?= filemtime($_SERVER['DOCUMENT_ROOT'] . '/assets/style/annonce.css') ?>"
/>   
    
    <!-- Open Graph -->
  <meta property="og:title" content="TogoMarket – Achetez et vendez au Togo">
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
    <header>
        <nav>
        <a class='hstatus' href="/boutique"><i class="fa-solid fa-arrow-left"></i></a>
        <a class='hstatus1' href="/publier-une-annonce">Publier une annonce</a>
        </nav>
    </header>
    <h1>Mes Annonces </h1>

<div class="listeannonces">
    <?php if (!empty($annonces)) : ?>
        <?php foreach ($annonces as $annonce) : 
            $idannonce = $annonce['id_annonce'];
        ?>
            <div class="annonce">
                <img loading="lazy" src="/assets/product/<?=($annonce['photo_annonce']) ?>" alt="<?= htmlspecialchars($annonce['titre_annonce']) ?>" srcset="">
                <div class="informationannonce">
                    <p class='tronqué' ><?= htmlspecialchars($annonce['titre_annonce']) ?></p>
                    <p class='ca'><?= formatMoney(($annonce['prix_unitaire_annonce'])) ?> FCFA</p>
                </div>
                <div class="action">
                    <button value='<?= $idannonce ?>' name="mod" class="mod">Modifier</button>
                    <button value='<?= $idannonce ?>' name='sup' class="sup">Supprimer</button>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        
            <a class='addproduct' href="/addproduct">Ajouter une annonce</a>

    <?php endif; ?>
</div>

<br/>
<br/>


</body>

</html>