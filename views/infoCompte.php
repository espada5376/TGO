<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
    <script src="/../assets/js/infocompte.js?v=<?= filemtime(__DIR__.'/../assets/js/infocompte.js') ?>" defer></script>
    <title>Infos Compte TogoMarket</title>
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
        <a class='hstatus' id="back"><i class="fa-solid fa-arrow-left"></i></a>
        <a class='hstatus1' href="/"><span class='tf'>Togo</span>Market</a>
    </nav>
</header>

<main>
    <div class='infocompte'>
    <h2>Informations du compte<hr></h2>

    <p>Nom de l'utilisateur: <strong><?= htmlspecialchars($_SESSION['nom']) ?></strong></p>
    <p>Numéro de téléphone: <strong><?= htmlspecialchars($_SESSION['tel']) ?></strong></p>
    </div>

    <!-- Lien boutique si existante -->
    <?php if ($boutique): ?>
        <h2>Ma Boutique<hr></h2>
        <a class="boutique-lien" href='<?= url('profil-boutique/lome/' . slugifyBoutique($boutique['nom_boutique']) . '-' . $boutique['id_boutique']) ?>'><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.0" id="Layer_1" width="20px" height="20px" viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve">
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
</svg> <?= htmlspecialchars($boutique['nom_boutique']) ?>
        </a>
        <input id='id_boutique' hidden readonly value='<?= $boutique['id_boutique']?>'/>
		<input id='nom_boutique' hidden readonly value='<?= $boutique['nom_boutique']?>'/>
        <a class="boutique-lien" id='shareBtn'>   
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="20px" width="20px" version="1.1" id="_x32_" viewBox="0 0 512 512" xml:space="preserve">
<style type="text/css">
	.st0{fill:black;}
</style>
<g>
	<path class="st0" d="M512,230.431L283.498,44.621v94.807C60.776,141.244-21.842,307.324,4.826,467.379   c48.696-99.493,149.915-138.677,278.672-143.14v92.003L512,230.431z"/>
</g>
</svg>Partager ma boutique</a>
    <?php endif; ?>

</main>

<br/>
<br/>


</body>
</html>
