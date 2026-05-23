<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Merci d'avoir commander sur TogoMarket</title>
    <link rel="stylesheet" href="/../assets/style/aprescommande.css?v=<?= filemtime(__DIR__.'/../assets/style/aprescommande.css') ?>" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="/../assets/js/aprèscommande.js?v=<?= filemtime(__DIR__.'/../assets/js/aprèscommande.js') ?>" defer></script>
        <link rel="icon" type="image/svg+xml" href="../public/file (1).svg">
        
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
            
            <a class='hstatus' href="<?= url('command/' . $id_annonce) ?>"><i class="fa-solid fa-arrow-left"></i></a>
           
            <a class='hstatus1' href="/"><span class='tf'>Togo</span>Market</a>
           
        </nav>
    </header>
<section>
        <h1>Commande enregistré avec succès</h1>
        <div class="main-container">
        <div class="check-container">
            <div class="check-background">
                <svg viewBox="0 0 65 51" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7 25L27.3077 44L58.5 7" stroke="white" stroke-width="13" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
            <div class="check-shadow"></div>   
        </div>
    </div>
    <h2>Merci pour votre commande</h2>
</section>
<br/>
<br/>


<script>document.getElementById("copyright").textContent = "Copyright © " + new Date().getFullYear() + " TogoMarket. Tous droits réservés.";</script>

</body>
</html>