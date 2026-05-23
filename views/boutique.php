<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Commandes recue TogoMarket</title>
    <link rel="stylesheet" href="<?= ASSETS_URL ?>style/boutique.css?v=<?= filemtime(ASSETS_PATH.'style/boutique.css') ?>">
    <link rel="stylesheet" href="<?= ASSETS_URL ?>style/annonce.css?v=<?= filemtime(ASSETS_PATH.'style/annonce.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= url('swiper-bundle.css') ?>">
    <script src="<?= url('swiper-bundle.js') ?>" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
    <script src="<?= ASSETS_URL ?>js/boutique.js?v=<?= filemtime(ASSETS_PATH.'js/boutique.js') ?>" defer></script>
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
        <a class='hstatus' href="<?= url('profil') ?>"><i class="fa-solid fa-arrow-left"></i></a>
    	<a	class='hstatus1' href="<?= url('voir-mes-annonces') ?>">Voir mes annonces</a>
        </nav>
    </header>

<!-- Lien boutique si existante -->
    <?php if ($boutique): ?>
	<div class='boutique'>
        <a class="boutique-lien" href='<?= url('profil-boutique/lome/' . slugifyBoutique($boutique['nom_boutique']) . '-' . $boutique['id_boutique']) ?>'><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.0" id="Layer_1" width="20px" height="20px" viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve">
<g>
	<path fill="#231F20" d="M17,28c2.209,0,4-1.791,4-4V0h-8v24C13,26.209,14.791,28,17,28z"></path>
	<path fill="#231F20" d="M53,24c0,2.209,1.791,4,4,4h4c1.312,0,2-0.687,2-2V4c0-2.211-1.789-4-4-4h-6V24z"></path>
	<path fill="#231F20" d="M27,28c2.209,0,4-1.791,4-4V0h-8v24C23,26.209,24.791,28,27,28z"></path>
	<path fill="#231F20" d="M7,28c2.209,0,4-1.791,4-4V0H5C2.789,0,1,1.789,1,4v22c0,1.313,0.812,2,2,2H7z"></path>
	<path fill="#231F20" d="M37,28c2.209,0,4-1.791,4-4V0h-8v24C33,26.209,34.791,28,37,28z"></path>
	<path fill="#231F20" d="M47,28c2.209,0,4-1.791,4-4V0h-8v24C43,26.209,44.791,28,47,28z"></path>
	<g>
		<path fill="#231F20" d="M12,64h12V50h-1c-0.553,0-1-0.447-1-1s0.447-1,1-1h1V38H12V64z"></path>
		<path fill="#231F20" d="M30,56h22V38H30V56z M47.293,40.293c0.391-0.391,1.023-0.391,1.414,0l1,1c0.391,0.391,0.391,1.023,0,1.414    C49.512,42.902,49.256,43,49,43s-0.512-0.098-0.707-0.293l-1-1C46.902,41.316,46.902,40.684,47.293,40.293z M42.293,40.293    c0.391-0.391,1.023-0.391,1.414,0l6,6c0.391,0.391,0.391,1.023,0,1.414C49.512,47.902,49.256,48,49,48s-0.512-0.098-0.707-0.293    l-6-6C41.902,41.316,41.902,40.684,42.293,40.293z"></path>
		<path fill="#231F20" d="M57,30c-2.088,0-3.926-1.068-5-2.687C50.926,28.932,49.088,30,47,30s-3.926-1.068-5-2.687    C40.926,28.932,39.088,30,37,30s-3.926-1.068-5-2.687C30.926,28.932,29.088,30,27,30s-3.926-1.068-5-2.687    C20.926,28.932,19.088,30,17,30s-3.926-1.068-5-2.687C10.926,28.932,9.088,30,7,30H4v30c0,2.211,1.789,4,4,4h2V37    c0-0.553,0.447-1,1-1h14c0.553,0,1,0.447,1,1v27h30c2.211,0,4-1.789,4-4V30H57z M54,57c0,0.553-0.447,1-1,1H29    c-0.553,0-1-0.447-1-1V37c0-0.553,0.447-1,1-1h24c0.553,0,1,0.447,1,1V57z"></path>
	</g>
</g>
</svg> <?= htmlspecialchars($boutique['nom_boutique']) ?>
        </a>
        <input id='id_boutique' hidden readonly value='<?= $boutique['id_boutique']?>'/>
        <input id='nom_boutique' hidden readonly value='<?= $boutique['nom_boutique'] ?>'/>
        <button class="boutique-lien secondary" id='shareBtn'>   
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="20px" width="20px" version="1.1" id="_x32_" viewBox="0 0 512 512" xml:space="preserve">
<style type="text/css">
	.st0{fill:white;}
</style>
<g>
	<path class="st0" d="M512,230.431L283.498,44.621v94.807C60.776,141.244-21.842,307.324,4.826,467.379   c48.696-99.493,149.915-138.677,278.672-143.14v92.003L512,230.431z"/>
</g>
</svg></button>
        <a class="boutique-lien secondary" href='/modepaiement'><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#ffff" height="20px" width="20px" version="1.1" id="Capa_1" viewBox="0 0 339.131 339.131" xml:space="preserve">
<g>
	<path d="M238.471,47.438c-2.438,0-4.845,0.127-7.232,0.328v-21.37C231.239,11.841,219.398,0,204.843,0H41.711   C27.156,0,15.315,11.841,15.315,26.396v286.338c0,14.555,11.841,26.396,26.396,26.396h163.132   c14.555,0,26.396-11.841,26.396-26.396v-94.926c2.401,0.204,4.812,0.319,7.232,0.319c47.059,0,85.345-38.285,85.345-85.344   C323.815,85.724,285.53,47.438,238.471,47.438z M101.311,25.249h38.179c4.694,0,8.5,3.806,8.5,8.5s-3.806,8.5-8.5,8.5h-38.179   c-4.694,0-8.5-3.806-8.5-8.5S96.616,25.249,101.311,25.249z M131.777,304.682c0,4.694-3.806,8.5-8.5,8.5   c-4.694,0-8.5-3.806-8.5-8.5v-8.501h17V304.682z M214.239,279.181H32.315V66.232c0-5.181,4.215-9.396,9.396-9.396h157.928   c-27.582,14.156-46.511,42.87-46.511,75.947c0,10.11,1.752,19.982,5.213,29.395l-13.984,55.138   c-0.866,3.417,0.13,7.037,2.622,9.529c1.899,1.899,4.452,2.929,7.072,2.929c0.818,0,1.644-0.101,2.458-0.307l57.731-14.64V279.181z    M238.471,198.127c-6.952,0-13.831-1.104-20.444-3.282c-1.806-0.595-3.743-0.662-5.585-0.195l-44.57,11.302l10.643-41.963   c0.529-2.087,0.371-4.289-0.452-6.278c-3.275-7.923-4.935-16.31-4.935-24.928c0-36.031,29.313-65.345,65.343-65.345   c36.031,0,65.345,29.313,65.345,65.345C303.815,168.814,274.502,198.127,238.471,198.127z"/>
	<path d="M240.057,123.186c-10.232-3.1-12.166-4.476-12.166-8.661c0-4.104,6.754-5.198,10.749-5.198   c3.844,0,8.417,1.22,11.123,2.966c0.571,0.369,1.266,0.496,1.929,0.353c0.665-0.143,1.247-0.544,1.615-1.115l5.287-8.185   c0.369-0.571,0.495-1.266,0.354-1.931c-0.145-0.665-0.545-1.247-1.116-1.616c-3.253-2.101-7.365-3.695-11.76-4.579V87.13   c0-1.416-1.147-2.564-2.564-2.564l-9.745-0.001c0,0,0,0,0,0c-0.68,0-1.332,0.271-1.813,0.751c-0.482,0.481-0.752,1.133-0.752,1.813   l-0.001,8.031c-11.12,2.235-18.18,9.657-18.18,19.365c0.002,16.012,13.678,20.153,22.728,22.895   c9.965,3.018,11.376,4.325,11.349,7.593c0,0.825-0.192,1.801-1.605,2.779c-1.841,1.274-4.982,2.007-8.62,2.01   c-0.018,0-0.038,0-0.058,0c-4.728-0.007-10.033-2.133-12.91-5.172c-0.972-1.029-2.595-1.074-3.625-0.1l-7.077,6.697   c-1.028,0.974-1.074,2.597-0.101,3.625c4.474,4.728,11.112,8.125,18.099,9.334v7.813c0,1.416,1.148,2.564,2.564,2.564h9.745   c1.416,0,2.564-1.148,2.564-2.564v-8.447c2.98-0.785,5.625-1.968,7.881-3.53c5.168-3.576,8.015-8.892,8.014-14.948   C262.094,129.859,248.833,125.843,240.057,123.186z"/>
</g>
</svg></a>
    </div>
    <?php endif; ?>
<main>
    <h1>Commandes Recues</h1>
    <p class='cda'></p>
    <br/>
<div id='cat' class='swiper'>
<nav class='swiper-wrapper'>
    <a class='swiper-slide' href="#/" data-route='#/'>en attente</a>
    <a class='swiper-slide' href="#/cours" data-route='#/cours'>en cours</a>
    <a class='swiper-slide' href="#/finish" data-route='#/finish'>Livré et payé</a>
</nav>
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
</div>

<div class="commandes">



<section id='cmd'></section>
<div class="loader"></div>
</div>
</main>

<br/>
<br/>



<script>
const catSwiper = new Swiper("#cat", {
  slidesPerView: 3,
  spaceBetween: 12,
  loop: false,
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  breakpoints: {
    220: {slidesPerView: 1},
    320: { slidesPerView: 1 },
    400: { slidesPerView: 2 },
    1024: { slidesPerView: 3 },
  },
});
</script>
</body>
</html>