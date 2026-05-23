<?php http_response_code(404); 

require_once __DIR__ . '/../app/models/annonces.php';

        function formatMoney($amount) {
    return number_format($amount, 0, '', '.');
	}

    // Suggestions (ex: annonces récentes)
    $annonces = getTop20Annonces($conn);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Page introuvable</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="/../assets/style/index.css?v=<?= filemtime(__DIR__.'/../assets/style/index.css') ?>" />
<link rel="stylesheet" href="/../assets/style/annonce.css?v=<?= filemtime(__DIR__.'/../assets/style/annonce.css') ?>" />
   
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&amp;display=swap" rel="stylesheet">
<script src='/../assets/js/index.js?v=<?= filemtime(__DIR__.'/../assets/js/index.js') ?>' defer></script>  
<link rel="icon" type="image/svg+xml" href="assets/file-(1).svg">    
    
    
    
<style>

   body {
    background: #f5f7fa;
    font-family: 'Poppins', sans-serif;
    scroll-behavior: smooth;
    margin: 0;
}
.container {
    max-width: 1000px;
    margin: auto;
    text-align: center;
}

h1 {
    font-size: 100px;
    color: #ff4d4f;
}

.search-box {
    margin: 20px 0;
}

.search-box input {
    padding: 12px;
    width: 60%;
    border: 1px solid #ddd;
    border-radius: 6px;
}

.search-box button {
    padding: 12px 20px;
    background: #1677ff;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}

.grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 20px;
    margin-top: 30px;
}

.card {
    background: white;
    border-radius: 10px;
    overflow: hidden;
    text-align: left;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.card img {
    width: 100%;
    height: 150px;
    object-fit: cover;
}

.card .info {
    padding: 10px;
}

.price {
    font-weight: bold;
    color: #1677ff;
}
    
    
    
 


.search-container{
	margin-bottom: 36.36px;
}

    .vp{
        text-align: center;
        width: 100%;
        display: block !important;
        
    }
    
    
    
    
</style>
</head>

<body>

<div class="container">

    <h1>404</h1>
    <h2>Page introuvable</h2>
    <p>Essaie une recherche ou découvre ces annonces 👇</p>
</div>
    <br/>
    <br/>
    <br/>
    <!-- 🔍 Recherche -->
    <div class='search-container'>
    <div class='search'>
    <form id='formf' method = 'POST'>
     	<input type="text" id="searchInput" placeholder="Que veux-tu acheter ?" autocomplete="on" required>
        <button class='recherche' id='recherche' type='submit'>
    		<svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 24 24" fill="none">
			<path d="M15.7955 15.8111L21 21M18 10.5C18 14.6421 14.6421 18 10.5 18C6.35786 18 3 14.6421 3 10.5C3 6.35786 6.35786 3 10.5 3C14.6421 3 18 6.35786 18 10.5Z" 			stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
			</svg>
    	</button>
    </form>
        
        
        </div>
    </div>
    
    <br/>
    <br/>

    
    <div class="content">

        <?php foreach ($annonces as $annonce) : ?>

        	<div class="annonce photo" data-id="<?= $annonce['id_annonce'] ?>">

    <a class="ann" href="<?= url('annonce/lome/' . slugifyBoutique($annonce['titre_annonce']) . '-' . $annonce['id_annonce']) ?>">
        
            <img 
                src="/assets/product/<?= htmlspecialchars($annonce['photo_annonce']) ?>"
                alt="<?= htmlspecialchars($annonce['titre_annonce']) ?>"
                loading="lazy"
                decoding="async"
                class="annonces"
            />


        <div class="duré">
            <i class="fa-regular fa-clock"></i>
            <?= $annonce['duree_secondes'] ?? '' ?>
        </div>

    </a>

    <div class="informationannonce">

        <a 
            class="prix" 
            href="<?= url('annonce/lome/' . slugifyBoutique($annonce['titre_annonce']) . '-' . $annonce['id_annonce']) ?>"
        >
            <?= formatMoney($annonce['prix_unitaire_annonce']) ?> FCFA
        </a>

        <a 
            class="tronqué"
            href="<?= url('annonce/lome/' . slugifyBoutique($annonce['titre_annonce']) . '-' . $annonce['id_annonce']) ?>"
        >
            <?= htmlspecialchars($annonce['titre_annonce']) ?>
        </a>

        <div class="boutique">

            <a 
                href="<?= url('profil-boutique/lome/' . slugifyBoutique($annonce['nom_boutique']) . '-' . $annonce['id_boutique']) ?>" 
                class="logodiv"
            >
                <img 
                    class="logob"
                    src="/assets/logo_boutique/<?= htmlspecialchars($annonce['logo_boutique']) ?>"
                    alt="Logo <?= htmlspecialchars($annonce['nom_boutique']) ?>"
                />
            </a>

            <a href="<?= url('profil-boutique/lome/' . slugifyBoutique($annonce['nom_boutique']) . '-' . $annonce['id_boutique']) ?>">
                <?= htmlspecialchars($annonce['nom_boutique']) ?>
            </a>

        </div>

    </div>

    <button 
        type="button"
         name="panier"
        class=""
        data-id="<?= $annonce['id_annonce'] ?>"
        data-name="<?= htmlspecialchars($annonce['titre_annonce']) ?>"
        data-price="<?= $annonce['prix_unitaire_annonce'] ?>"
    >
        <i class="fa-solid fa-basket-shopping"></i>
        Ajouter au panier
    </button>

</div>

<?php endforeach; ?>

        
        
    </div>
    
<br/>
<br/>
<br/>
        
        <a	href='/' class='vp'>Voir plus</a>    
<br/>
<br/>
<br/> 
    
<script>
        document.querySelectorAll('.annonces').forEach(img => {

      const wrapper = document.createElement('div');
      wrapper.className = 'img-wrapper skeleton';

      img.decoding = 'async';
      img.loading = 'lazy';
      img.setAttribute('fetchpriority', 'low');

      const parent = img.parentNode;
      parent.replaceChild(wrapper, img);
      wrapper.appendChild(img);

      img.addEventListener('load', () => {
        wrapper.classList.remove('skeleton');
        img.classList.add('loaded');
      });

      if (img.complete) {
        wrapper.classList.remove('skeleton');
        img.classList.add('loaded');
      }
    });
</script>



</body>
</html>