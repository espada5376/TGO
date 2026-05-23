<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Connexion TogoMarket</title>
    <link rel="stylesheet" href="<?= ASSETS_URL ?>style/signIn.css?v=<?= filemtime(ASSETS_PATH.'style/signIn.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
    <script src="<?= ASSETS_URL ?>js/signIn.js?v=<?= filemtime(ASSETS_PATH.'js/signIn.js') ?>" defer></script>
    <link rel="icon" type="image/svg+xml" href="<?= ASSETS_URL ?>file-(1).svg">
    
    
    
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-8KND21DBNQ"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-8KND21DBNQ');
</script>

</head>
<body>
    <a class='titre' href='<?= url() ?>'><h1><span class='tf'>Togo</span>Market</h1></a>
    <main class="formulaire">
        <div class='info'>
        <h2>Connexion</h2>
        <p>Identifiez-vous pour<strong> accéder à votre compte.</strong></p>
        </div>

        <div class='bar'></div>
        <form action="#" method="post">
            <div>
                <label for="num">Numéro de téléphone</label>
                <input class='' type="tel" id='num' name="tel" autocomplete='tel' required/>
            </div>
            <div>
                <label for="mdp">Mot de passe</label>
                <input class='' autocomplete="off" type="password" id='mdp' name="mdp" autocomplete='current-password' required/>  
            </div>
            
            <?php if (isset($_SESSION['error'])): ?>
    			<p class="message">
        			<?= htmlspecialchars($_SESSION['error']) ?>
    			</p>
    			<?php unset($_SESSION['error']); ?>
			<?php endif; ?>
                    
            <button type="submit" name="connecter"><i class="fa-solid fa-arrow-right-to-bracket"></i>se connecter</button>
            <div class="suggestion">
                <p>Vous n'avez pas de compte?</p><a href="<?= url('inscription') ?>">créez un compte</a>
            </div>
        </form>
        
        
    </main>
</body>
</html>