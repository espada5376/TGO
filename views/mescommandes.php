<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Commandes TogoMarket</title>
    <link rel="stylesheet" href="<?= ASSETS_URL ?>style/boutique.css?v=<?= filemtime(ASSETS_PATH.'style/boutique.css') ?>">
    <link rel="stylesheet" href="<?= ASSETS_URL ?>style/ui-states.css?v=<?= filemtime(ASSETS_PATH.'style/ui-states.css') ?>">
    <link rel="stylesheet" href="<?= ASSETS_URL ?>style/annonce.css?v=<?= filemtime(ASSETS_PATH.'style/annonce.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
    <script src="<?= ASSETS_URL ?>js/ui-states.js?v=<?= filemtime(ASSETS_PATH.'js/ui-states.js') ?>" defer></script>
    <script>window.__BASE_URL = "<?= BASE_URL ?>";</script>
    <script src="<?= ASSETS_URL ?>js/mescommandes.js?v=<?= filemtime(ASSETS_PATH.'js/mescommandes.js') ?>" defer></script>
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
        <a class='hstatus1' href="<?= url('') ?>"><span class='tf'>Togo</span>Market</a>
        </nav>
    </header>


<main>
    <h1>Commandes</h1>
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
document.addEventListener('DOMContentLoaded', () => {
  new Swiper("#cat", {
    slidesPerView: 3,
    spaceBetween: 12,
    loop: false,
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    breakpoints: {
      220: { slidesPerView: 1 },
      320: { slidesPerView: 1 },
      400: { slidesPerView: 2 },
      1024: { slidesPerView: 3 },
    },
  });
});
</script>



</body>
</html>