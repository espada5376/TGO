<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>inscription TogoMarket</title>
<link
  rel="stylesheet"
  href="/assets/style/signUp.css?v=<?= filemtime($_SERVER['DOCUMENT_ROOT'] . '/assets/style/signUp.css') ?>"
>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script
  src="/assets/js/signUp.js?v=<?= filemtime($_SERVER['DOCUMENT_ROOT'] . '/assets/js/signUp.js') ?>"
  defer>
</script>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src='/assets/js/signUp.js?v=<?= filemtime(__DIR__ . '/assets/js/signUp.js') ?>' defer></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="icon" type="image/svg+xml" href="assets/file (1).svg">
    
    
    
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-8KND21DBNQ"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-8KND21DBNQ');
</script>

</head>
<body>
    <a class='titre' href='/'><h1><span class='tf'>Togo</span>Market</h1></a>
    <main class="formulaire">
        <div class='info'>
        <h2>Création de compte</h2>
        </div>
        <div class='bar'></div>
        <form action="#" method="post">
            <div>
                <label for="nom" class="label required">Nom d'utilisateur</label>
                <input class=''  type="text" id='nom' name="nom" autocomplete='name' required/>
            </div>
            
                <div><label class="label required" for="num">Numéro de téléphone(Whatsapp)</label>
                <div class="phone-input">
            
    <span class="country-code">+228</span>
    <input
        type="tel"
        id='num'
        name="tel"
        autocomplete='tel'
        maxlength="8"
        inputmode="numeric"
        class=''
        required
    >
            </div></div>
            <div>
                <label for="email">Email</label>
                <input type="email"  id='email' name="email" autocomplete='email'/>
            </div>
            <div>
                <label class="label required" for="mdp">Mot de passe</label>
                <input type="password" autocomplete="off"  id='mdp' name="mdp" required/>
            </div>
            <div>
                <label class="label required" for="confirmemdp">Comfirmer le Mot de passe</label>
                <input type="password" autocomplete="off"  id='confirmemdp' name="confirmemdp" required/>
            </div>
<label class="checkbox">
  <input id='cgv' type="checkbox" required/>
  <span class="checkmark"></span>
  <section class="label"><span>J’accepte</span><a href='/cgu' > les conditions général d'utilisation</a></section>
</label>
            <?php if (isset($_SESSION['error'])): ?>
    			<p class="message">
        			<?= htmlspecialchars($_SESSION['error']) ?>
    			</p>
    			<?php unset($_SESSION['error']); ?>
			<?php endif; ?>
            <button type="submit" name="inscription"><i class="fa-solid fa-arrow-right-to-bracket"></i>S'inscrire</button>
        </form>
        
        <div class="suggestion">
            <p>Vous avez déja un compte?</p><a href="/connexion">se connecter</a>
        
    </main>
    <br/>
</body>
</html>