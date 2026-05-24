<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Ajouter une annonce sur TogoMarket</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="<?= ASSETS_URL ?>style/addproduct.css?v=<?= filemtime(ASSETS_PATH.'style/addproduct.css') ?>">
    <link rel="stylesheet" href="<?= ASSETS_URL ?>style/annonce.css?v=<?= filemtime(ASSETS_PATH.'style/annonce.css') ?>">
    <script src="<?= ASSETS_URL ?>js/addproduct.js?v=<?= filemtime(ASSETS_PATH.'js/addproduct.js') ?>" defer></script>
    <link rel="icon" type="image/svg+xml" href="<?= ASSETS_URL ?>file-(1).svg">    
    
      <!-- Open Graph -->
  <meta property="og:title" content="Togomarket – Achetez et vendez au Togo">
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
            <a class='hstatus' id="back"><i class="fa-solid fa-arrow-left"></i></a>
            <a class='hstatus1' href="/"><span class='tf'>Togo</span>Market</a>
            
        </nav>
    </header>
    
    <div class="formulaire">
        <h1>Publier une annonce</h1>
    
    	<?php if (!empty($_SESSION['success'])): ?>
           <p style="color: <?= $_SESSION['success'] === 'Annonce publiée' ? 'green' : 'red' ?>; font-weight: bold;">
                <?= htmlspecialchars($_SESSION['success']) ?>
            </p>
            <?php unset($_SESSION['success']); ?>
		<?php endif; ?>

<div class="b">
    <a href="/createboutique"
       class="<?= !empty($_SESSION['need_boutique']) ? 'show-link' : 'hide-link'; ?>">
        Créer une boutique
    </a>
</div>

<div class='contenu'>

        <form id='form' action="#" method="post" enctype="multipart/form-data">
            <div>
                <label for="nom_produit" class="label required">Titre de l'annonce</label>
                <input class='' type="text" name="nom_produit" id='nom_produit' required />
                <span style='display: none; color: red' class='msg_np'></span>
            </div>
            <div>
                <label class="label required" for="qte">Quantité disponible</label>
                <section>
                <input id='qte' class='qte' value='1' step="1" min="0" name="quantite" required />
                <button id='plus' type='button'>+</button>
                <button id='moins' type='button'>-</button></section>
            </div>
            
            <div>
                <label class="label required" for="prix_du_produit">prix unitaire</label>
                <input class='' min="0" step="1" name="prix_du_produit" id='prix_du_produit' required />
            </div>
            <div>
                <label class="label required" for="categorie">Sous-Catégories de l'annonces</label>
               
                <select name='categorie' id='categorie' required>
                    
					<option value="">Choisir une sous-catégorie</option>

                    <?php if(empty($sousCategories)): ?>

                    <option value="">Aucune sous-catégorie disponible</option>

                    <?php else: ?>

                        <?php foreach ($sousCategories as $scategorie): ?>
                            <option value="<?= htmlspecialchars($scategorie['id_sous_categorie']) ?>">
                                <?= htmlspecialchars($scategorie['nom_sous_categorie']) ?>
                            </option>
                        <?php endforeach; ?>

                    <?php endif; ?>
                    
                </select>
                
            </div>
            <div>
         
                <label  for="description">Description de l'annonce</label>
                <textarea name="description" id='description'></textarea>
            </div>
                    
                    <div>
                    
                <label class="label required">photo de l'annonce</label>
                <div class='photo'>
                <main>
                <label for="fileInput" class="image">
                    <div id="divtext"><i class="fa-solid fa-camera"></i></div>
                    <img src="" alt="img" srcset="" id="preview" style="display: none;">
                </label>
                <input type="file" name="image_de_annonce" required accept="image/*" id="fileInput" style="visibility: hidden;" />
                </main>
                
                <main>
                <label for="fileInput1" class="image">
                <div id="divtext1"><i class="fa-solid fa-camera"></i></div>
                    <img src="" alt="img" srcset="" id="preview1" style="display: none;">
                </label>
                <input type="file" name="image_de_annonce1" accept="image/*" id="fileInput1" style="visibility: hidden;" />
                </main>
                </div>
            </div>
            
                        <label class="checkbox">
  <input type="checkbox" required/>
  <span class="checkmark"></span>
  <main class="label"><span>J'accepte</span><a href='/cgu' > les conditions général d'utilisation</a></main>
</label>

            
            
            <button type="submit">Publier</button>
            
        </form>


<div class="annonce" data-id="ID_ANNONCE">

  <div class="ann" href="URL_ANNONCE">
    <div class="img-wrapper">
      <img 
        class="annonces"
        src="BASE_URL/assets/product/PHOTO_ANNONCE"
        alt="IMAGE_ANNONCE"
        loading="lazy"
        decoding="async"
        fetchpriority="low"
      >
      <div class="duré">
      <i class="fa-regular fa-clock"></i>
      DUREE
    </div>
    </div>


  </div>

  <div class="informationannonce">
    
    <p class="prix" href="URL_ANNONCE">
      [PRIX FCFA]
    </p>

    <p class="tronqué" href="URL_ANNONCE">
      [TITRE_ANNONCE]
    </p>

    <div class="boutique">
      
      <diV class='logodiv'>
        <img 
          class="logob"
          src="/assets/logo_boutique/<?= !$boutiqueenseigne ? '' : $boutiqueenseigne['logo_boutique'] ?>"
        />
      </div>
      <p href="URL_BOUTIQUE">
        <?= !$boutiqueenseigne ? '' : $boutiqueenseigne['nom_boutique'] ?>
      </p>

    </div>
  </div>

  <button 
    class="like-btn panier"
    name="panier"
    data-id="ID_ANNONCE"
    data-name="TITRE_ANNONCE"
    data-category="ID_CATEGORIE"
    data-price="PRIX"
  >

    Ajouter au panier 
    <span class="panier-count"></span>
  </button>

</div>

</div>



</div>




    
<br/>
<br/>

</body>

</html>