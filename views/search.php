<!DOCTYPE html>
<html lang="en">

<head>   
    
<link rel="apple-touch-icon" sizes="180x180" href="/assets/icons/file(1).png">    
<link rel="icon" type="image/svg+xml" href="/assets/file (1).svg">
<meta name="apple-mobile-web-app-capable" content="yes">
<!-- Android / Chrome -->
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-title" content="TogoMarket">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

<title>TogoMarket – Achetez et vendez facilement en ligne au Togo</title>
<meta name="title" content="TogoMarket – Achetez et vendez facilement en ligne au Togo" />
<meta name="description" content="Marketplace togolaise de vente et d’achat en ligne">
       
<meta property="og:title" content="TogoMarket – Achetez et vendez facilement en ligne au Togo" />
<meta property="og:description" content="Marketplace togolaise de vente et d’achat en ligne" />
<meta property="og:image" content="https://tg.infinityfreeapp.com/assets/file-(1).svg" />
<meta property="og:url" content="https://tg.infinityfreeapp.com/" />
<meta property="og:type" content="website" />
    
<meta property="twitter:card" content="summary_large_image" />
<meta property="twitter:url" content="https://tg.infinityfreeapp.com/" />
<meta property="twitter:title" content="TogoMarket – Achetez et vendez facilement en ligne au Togo" />
<meta property="twitter:description" content="Marketplace togolaise de vente et d’achat en ligne" />
<meta property="twitter:image" content="https://tg.infinityfreeapp.com/assets/file-(1).svg" />

<link rel="stylesheet" href="/../assets/style/index.css?v=<?= filemtime(__DIR__.'/../assets/style/index.css') ?>" />
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<link
  rel="stylesheet"
  href="/assets/style/annonce.css?v=<?= filemtime($_SERVER['DOCUMENT_ROOT'] . '/assets/style/annonce.css') ?>"
/>  
<link rel="stylesheet" href="/swiper-bundle.css"/>
<script src="/swiper-bundle.js" defer></script>
<script src='/../assets/js/search.js?v=<?= filemtime(__DIR__.'/../assets/js/search.js') ?>' defer></script>  
    
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
    		<div class = 'containerf'>
                <a href="/"><span class='tf'>Togo</span>Market</a> 
                <div class="search-container">

                    <div class='search'>
                        <button type='button' class='cats' >catégories<img src='/assets/down-arrow-5-svgrepo-com.svg' width='20px'/></button>
    					<form id='formr' method = 'POST'>
                            <input type="text" id="searchInput" placeholder="Que veux-tu acheter ?" autocomplete="on" required>
                            <button class='recherche' id='recherche' type='submit'><svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 24 24" fill="none">
<path d="M15.7955 15.8111L21 21M18 10.5C18 14.6421 14.6421 18 10.5 18C6.35786 18 3 14.6421 3 10.5C3 6.35786 6.35786 3 10.5 3C14.6421 3 18 6.35786 18 10.5Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg></button>
    					</form>	
                    </div>
                    <div id="searchResults" class="results"></div>
                    </div>
                <div class="panier-produit">
                    <a class='hpanier' href='/panier'>
                        <img src='/assets/basket-svgrepo-com.svg' width='20px'/>
                        <span class="like-count pani"></span>
                    </a>
                </div>
                <a class='hstatus' href="<?= isset($_SESSION['id']) && isset($_SESSION['tel']) ? '/profil' : '/connexion' ?>">
                    <?= isset($_SESSION['id']) && isset($_SESSION['tel']) 
                    ? "<img src='/assets/user-profile-svgrepo-com.svg' width='20px'/> Profil" 
                    : "Connexion" ?>
                </a>
			</div>
                <div class='searchf'>
                        <button type='button' class='cats' >catégories<img src='/assets/down-arrow-5-svgrepo-com.svg' width='20px'/></button>
                    	<form id='formrf' method = 'POST'>
                            <input type="text" id="searchInputf" placeholder="Que veux-tu acheter ?" autocomplete="on" required>
                            <button class='recherche' id='recherchef' type='submit'><svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 24 24" fill="none">
<path d="M15.7955 15.8111L21 21M18 10.5C18 14.6421 14.6421 18 10.5 18C6.35786 18 3 14.6421 3 10.5C3 6.35786 6.35786 3 10.5 3C14.6421 3 18 6.35786 18 10.5Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg></button>
                        </form>
                    </div>
                    <div id="searchResults" class="resultsf"></div>
                </div>
			
        </nav>
        
    </header>



<!-- TRIER LES PRODUITS PAR CATEGORIE-->

    <br/>



    <br/>

    <h2 id='nbannonce'></h2>

    <br />

<section class='' id='section1'>
    <div class='content'></div>
    <div class="loader"></div>
    <br/>
    <br/>
    <br/>
    <div class="sentinel"></div>
    
</section>



</body>

</html>