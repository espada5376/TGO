<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<link rel="icon" type="image/svg+xml" href="<?= ASSETS_URL ?>file-(1).svg">
    <title><?= $annonce['titre_annonce'] ?> | TogoMarket</title>


	<link rel="apple-touch-icon" sizes="180x180" href="<?= ASSETS_URL ?>icons/file(1).png">

    <meta name="apple-mobile-web-app-capable" content="yes">
    <!-- Android / Chrome -->
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="TogoMarket">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">



    	
    <!-- Open Graph -->
    <meta property="og:title" content="<?= htmlspecialchars($annonce['titre_annonce']) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($annonce['description_annonce']) ?>">
    <meta property="og:image" content="<?= $image ?>">
	<meta property="og:site_name" content="TogoMarket">
	<meta property="og:locale" content="fr_FR">
    <meta property="og:url" content="<?= $url ?>">
    <meta property="og:type" content="product">
   
    
    
    <link rel="stylesheet" href="<?= ASSETS_URL ?>style/command.css?v=<?= filemtime(ASSETS_PATH.'style/command.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= url('swiper-bundle.css') ?>">
    <script src="<?= url('swiper-bundle.js') ?>" defer></script>
    <script src="<?= ASSETS_URL ?>js/command.js?v=<?= filemtime(ASSETS_PATH.'js/command.js') ?>" defer></script>


<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-8KND21DBNQ');
</script>

<script>
gtag('event', 'view_item', {
  currency: 'XOF',
  value: <?= $annonce['prix_unitaire_annonce'] ?>,
  items: [{
    item_id: "<?= $annonce['id_annonce'] ?>",
    item_name: "<?= addslashes($annonce['titre_annonce']) ?>",
    item_category: "<?= $annonce['id_categorie'] ?>",
    price: <?= $annonce['prix_unitaire_annonce'] ?>
  }]
});
</script>
</head>
<body>
        <header>
        <nav>
            <a class='hstatus' id="back"><img src='/assets/left-arrow-svgrepo-com (1).svg' width='20px'/></a>
            <a class='hstatus1' href="/<?= isset($_SESSION['id']) ? 'profil' : 'connexion' ?>">
    <?=  isset($_SESSION['id'])
        ? '<svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 16 16" fill="none">
<path d="M8 7C9.65685 7 11 5.65685 11 4C11 2.34315 9.65685 1 8 1C6.34315 1 5 2.34315 5 4C5 5.65685 6.34315 7 8 7Z" fill="#000000"/>
<path d="M14 12C14 10.3431 12.6569 9 11 9H5C3.34315 9 2 10.3431 2 12V15H14V12Z" fill="#000000"/>
</svg> Profil' 
        : "Connexion" ?>
</a>
        </nav>
    </header>

    <input id='id_annonce' hidden value='<?= $annonce['id_annonce'] ?>'/>

    <div class='command'>
        <div class='swiper'>
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img src="/assets/product/<?= $annonce['photo_annonce'] ?>" alt="<? $annonce['titre_annonce'] ?>" class='annonceimg' srcset="">
                </div>
                <div class="swiper-slide">
                    <img src="/assets/product/<?= $annonce['photo_annonce1'] ?>" alt="<? $annonce['titre_annonce'] ?>" class='annonceimg' srcset="">
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
        <div class='informationannonce'>
            <p class='nom'><?= $annonce['titre_annonce'] ?></p>
  
            <p	class='prix'><?= formatMoney($annonce['prix_unitaire_annonce']) ?> FCFA</strong></p>

    		<button type='button' class='commander' id="btn">Acheter Maintenant</button>

    <div class='meta'>
        <p>✔ Livraison rapide à Lomé</p>
        <p>✔ Payement à la livraison</p>
        <p>✔ Support Clients</p>
    </div>
    
    <div class="description">
  <h3>Description</h3>

  <div class="description-content">
    <p>
      <?= !empty($annonce['description_annonce']) ? $annonce['description_annonce'] : 'Aucune description' ?>
    </p>
  </div>
</div>
    
    
    <div class='social'>
        <p>Ajout au panier: <strong class='ca'><?= isset($likes['total']) ? $likes['total'] : 0 ?></strong></p>

        <p>Reste <strong class='ca'><?= $annonce['quantite_disponible_annonce']?></strong> articles en stock</p>
    </div>
	
    <div class='social'>
    	<a class="boutique-lien" href="<?= url('profil-boutique/lome/' . slugifyBoutique($boutiquename) . '-' . $annonce['id_boutique']) ?>"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.0" id="Layer_1" width="20px" height="20px" viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve">
<g>
	<path fill="#231F20" d="M17,28c2.209,0,4-1.791,4-4V0h-8v24C13,26.209,14.791,28,17,28z"/>
	<path fill="#231F20" d="M53,24c0,2.209,1.791,4,4,4h4c1.312,0,2-0.687,2-2V4c0-2.211-1.789-4-4-4h-6V24z"/>
	<path fill="#231F20" d="M27,28c2.209,0,4-1.791,4-4V0h-8v24C23,26.209,24.791,28,27,28z"/>
	<path fill="#231F20" d="M7,28c2.209,0,4-1.791,4-4V0H5C2.789,0,1,1.789,1,4v22c0,1.313,0.812,2,2,2H7z"/>
	<path fill="#231F20" d="M37,28c2.209,0,4-1.791,4-4V0h-8v24C33,26.209,34.791,28,37,28z"/>
	<path fill="#231F20" d="M47,28c2.209,0,4-1.791,4-4V0h-8v24C43,26.209,44.791,28,47,28z"/>
	<g>
		<path fill="#231F20" d="M12,64h12V50h-1c-0.553,0-1-0.447-1-1s0.447-1,1-1h1V38H12V64z"/>
		<path fill="#231F20" d="M30,56h22V38H30V56z M47.293,40.293c0.391-0.391,1.023-0.391,1.414,0l1,1c0.391,0.391,0.391,1.023,0,1.414    C49.512,42.902,49.256,43,49,43s-0.512-0.098-0.707-0.293l-1-1C46.902,41.316,46.902,40.684,47.293,40.293z M42.293,40.293    c0.391-0.391,1.023-0.391,1.414,0l6,6c0.391,0.391,0.391,1.023,0,1.414C49.512,47.902,49.256,48,49,48s-0.512-0.098-0.707-0.293    l-6-6C41.902,41.316,41.902,40.684,42.293,40.293z"/>
		<path fill="#231F20" d="M57,30c-2.088,0-3.926-1.068-5-2.687C50.926,28.932,49.088,30,47,30s-3.926-1.068-5-2.687    C40.926,28.932,39.088,30,37,30s-3.926-1.068-5-2.687C30.926,28.932,29.088,30,27,30s-3.926-1.068-5-2.687    C20.926,28.932,19.088,30,17,30s-3.926-1.068-5-2.687C10.926,28.932,9.088,30,7,30H4v30c0,2.211,1.789,4,4,4h2V37    c0-0.553,0.447-1,1-1h14c0.553,0,1,0.447,1,1v27h30c2.211,0,4-1.789,4-4V30H57z M54,57c0,0.553-0.447,1-1,1H29    c-0.553,0-1-0.447-1-1V37c0-0.553,0.447-1,1-1h24c0.553,0,1,0.447,1,1V57z"/>
	</g>
</g>
</svg>Voir la boutique</a>
            <button class="boutique-lien" id='shareBtn'>   
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="20px" width="20px" version="1.1" id="_x32_" viewBox="0 0 512 512" xml:space="preserve">
<style type="text/css">
	.st0{fill:#000000;}
</style>
<g>
	<path class="st0" d="M512,230.431L283.498,44.621v94.807C60.776,141.244-21.842,307.324,4.826,467.379   c48.696-99.493,149.915-138.677,278.672-143.14v92.003L512,230.431z"/>
</g>
</svg> Partager l'annonce</button> 
    </div>
    		
                  
        </div>
        
    </div>
	
	<div class='c'>
    <form id="formcommand" style="display: none;">
		<h2	id='h2'>Renseigner le formulaire<hr></h2>
        <div class='inputs'>
           <div> <label for='nom'	class="label required">Nom du client</label><input name='nom' class='' id='nom' value='<?=  isset($_SESSION['id']) ? htmlspecialchars($_SESSION['nom']) : '' ?>' required/></div>

            <button id="getLocationBtn">Partager ma position pour la livraison<div class='loader'></div>
            <div class='true'>✔️</div></button>
            <input hidden class='localisation' name='localisationAcheteur' />
            <input hidden class='longitude' name='longitude' />
            <input hidden class='latitude' name='latitude' />
            <div><label for='nomp'>Nom du produit</label><input name='nomp' class='' id='nomp' value="<?= $annonce['titre_annonce'] ?>" readonly required/></div>
			<div class='divqte'>
            <div><label for='qte' class="label required">Quantité</label><input class='' id='qte' name='qte'  min="1" max="<?= $annonce['quantite_disponible_annonce'] ?>" value="1" required/></div><button class='plusmoins' id='plus' type='button'>+</button>
                <button id='moins' class='plusmoins' type='button'>-</button></section>
        	</div>

            <div><label for='prix'>Prix unitaire</label><input class='' id='prix' name='prixu' type="text" value="<?= $annonce['prix_unitaire_annonce'] ?>" readonly required/></div>

            <div><label for='total'>Total + Frais Mobile Money + livraison</label><input type='text' class='' id='total' name='total' required readonly/></div>
		<div>
            <label for='Modepaiement'	class="label required">Choix du mode de paiement</label>
                <select name='ModePaiement' class='Modepaiement' id='Modepaiement' required>
                    <?php if (!empty($mode_paiement)): ?>
    <?php foreach ($mode_paiement as $mode): ?>
        <option value="<?= htmlspecialchars($mode['label_mode_paiement']) ?>">
            <?= htmlspecialchars($mode['label_mode_paiement']) ?>
        </option>
    <?php endforeach; ?>
<?php else: ?>
    <option value="Mix By Yas" selected>Mix By Yas</option>
<?php endif; ?>

                </select>  
        </div>
        
        <div>
        <label id='paiementdiv'	class="label required" for='paiement'>Numéro de téléphone(Whatsapp)</label>
        <div class="phone-input">
            
    <span class="country-code">+228</span>
    <input
           value='<?= isset($_SESSION['id']) ? htmlspecialchars($_SESSION['tel']) : '' ?>'
        type="tel"
        id='paiement'
        name='numPaiement'
        maxlength="8"
        inputmode="numeric"
        required
        <?= isset($_SESSION['id']) ? 'readonly' : '' ?>
    >
</div>
        </div>
            
            
            
		<div>
            <label for='instructions'>Note ou instruction<span class="hint">ex:devant ma porte à 12h...</span></label><textarea id='instructions'></textarea>
            <input hidden class='idannonce' name='idannonce' value='<?= isset($id_annonce) ? $id_annonce : null ?>'/>
        </div>
        
        </div>
            <label class="checkbox" for='cgv'>
  <input id='cgv' type="checkbox" required/>
  <span class="checkmark"></span>
  <section class="label"><span>J'accepte</span><a href='/cgu' > les conditions général d'utilisation</a></section>
</label>
        <button type='submit' id='envoicommande' class='Ccommander'>Comfirmer la commande</button>
    </form>
</div>


<!-- Modal OTP -->
<div id="otpModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h3>Vérification OTP</h3>
    <p>Veuillez entrer le code reçu sur WhatsApp :</p>
    <input type="text" id="otpInput" maxlength="6" autocomplete="off" placeholder="123456">
    <button id="submitOTP">Valider</button>
    <p id="otpError" style="color:red; display:none;">OTP incorrect</p>
  </div>
</div>



<br/>
   

    
</body>
</html>
