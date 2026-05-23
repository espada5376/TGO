<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
    <script src="/../assets/js/createboutique.js?v=<?= filemtime(__DIR__.'/../assets/js/createboutique.js') ?>" defer></script>
    <title>Création de boutique TogoMarket</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" type="image/svg+xml" href="assets/file (1).svg">
    <link rel="stylesheet" href="/../assets/style/infocompte.css?v=<?= filemtime(__DIR__.'/../assets/style/infocompte.css') ?>" />
    
    
    
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
        <a class='hstatus' id='back' ><i class="fa-solid fa-arrow-left"></i></a>
        <a class='hstatus1' href="/"><span class='tf'>Togo</span>Market</a>
    </nav>
</header>
    
<main>
    <!-- FORMULAIRE DE CREATION DE BOUTIQUE -->
    <form method="POST"
          enctype="multipart/form-data"
          id="formPosition"
          style="display: <?= !empty($boutique) ? 'none' : 'block' ?>;">
        
        <h2>Création de Boutique<hr></h2>
    <?php
        if (!empty($_SESSION['flash'])) {
            echo '<div class="alert ' . $_SESSION['flash']['type'] . '">';
            echo $_SESSION['flash']['message'];
            echo '</div>';

    		unset($_SESSION['flash']); 
		}
	?>
        <div class='inputs'>
        <div>
        <label>Nom de la boutique</label>
            <input name='nom' id='nom' type='text' required />
        </div>
        
        <div>

        <label>Catégorie principale</label>
            <select id='categorie' name='categorie'>
                <?php foreach ($categories as $categorie): ?>
        			<option value="<?= htmlspecialchars($categorie['id_categorie']) ?>">
            		<?= htmlspecialchars($categorie['nom_categorie']) ?>
        			</option>
    			<?php endforeach; ?>
            </select>
    
            </div>
        

		<div>
            <label>Quartier de la boutique</label>
                
                <input name='adresse' id='adresse' type='text' required />
            </div>
    
            <div>
            <label>Numéro de Téléphone</label>
    <div class="phone-input">
                <span class="country-code">+228</span>
                <input name='btel' id='btel' type='text' maxlength="8" required />
            </div>
            </div>
        
        <button type="button" id="getLocationBtn">
            Partager ma position
            <div class="loader"></div>
            <div class="true"></div>
        </button>
        <input hidden name='longitude' id='longitude' />
        <input hidden name='latitude' id='latitude' />
        
            <div>
            <p class='logo'>Logo de la boutique</p>
            <label for="fileInput" class="image">
                <div id="divtext"><i class="fa-solid fa-camera"></i></div>
                <img src="" alt="img" srcset="" id="preview" style="display: none;"></label>
            <input type="file" name="logo_boutique" required accept="image/*" id="fileInput" style="visibility: hidden;" />
        	</div>
        
        <label class="checkbox">
  <input id='cgv' type="checkbox" required />
  <span class="checkmark"></span>
  <section class="label"><span>J’accepte</span><a href='/cgu' > les conditions général d'utilisation</a></section>
</label>

        

        <button type='submit' id='enregistrerPosition'>Créer ma boutique</button>
    </div>
    </form>
</main>


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
<br/>


</body>
</html>
