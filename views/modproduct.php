<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Modifier annonce TogoMarket</title>
    <link rel="stylesheet" href="<?= ASSETS_URL ?>style/addproduct.css?v=<?= filemtime(ASSETS_PATH.'style/addproduct.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="icon" type="image/svg+xml" href="<?= ASSETS_URL ?>file-(1).svg">
    
    
      <!-- Open Graph -->
  <meta property="og:title" content="TogoMarket – Achetez et vendez au Togo">
  <meta property="og:description" content="Plateforme togolaise de vente et d'achat en ligne.">
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
            <a class='hstatus' href="/viewProduct"><i class="fa-solid fa-arrow-left"></i></a>
            <a class='hstatus1' href="/"><span class='tf'>Togo</span>Market</a>
            
        </nav>
    </header>
    
    <div class="formulaire">
        <h1>Modifier un annonce</h1>
    	<?php if (!empty($_SESSION['success'])): ?>
    <p style='color : <?= $_SESSION['success'] === 'Annonce modifiée avec succès' ? 'green' : 'red' ?>'>
        <?= htmlspecialchars($_SESSION['success']) ?>
    </p>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>
        
<div class='b'>
    
</div>

        <form id='form' action="#" method="post" enctype="multipart/form-data">
            
            <div>
                <label for="nom_produit">Titre de l'annonce</label>
                <input class='' value="<?= $annonce['titre_annonce'] ?>" type="text" name="titre" id='nom_produit' />
                <span style='display: none; color: red' class='msg_np'></span>
            </div>
            <div>
                <label for="qte">Quantité disponible</label>
                <section>
                <input id='qte' value='<?= $annonce['quantite_disponible_annonce'] ?>' class='qte' step="1" min="0" name="quantite"  />
            </div>
            
            <div>
                <label for="prix_du_produit">prix unitaire</label>
                <input class='' value="<?= $annonce['prix_unitaire_annonce'] ?>" min="0" step="1" name="prix" id='prix_du_produit'  />
            </div>

            <div>
                <label for="description">Description de l'annonce</label>
                <textarea name="description" id='description'><?= $annonce['description_annonce'] ?></textarea>
            </div>
                

            <button type="submit">Modifier</button>
            
        </form>

    </div>
    
</body>

</html>