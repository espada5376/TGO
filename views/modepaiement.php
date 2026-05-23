<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Mode de paiement TogoMarket</title>

<link rel="stylesheet" href="/assets/style/modepaiement.css?v=<?= filemtime($_SERVER['DOCUMENT_ROOT'] . '/assets/style/modepaiement.css') ?>">
<script src="/assets/js/modepaiement.js?v=<?= filemtime($_SERVER['DOCUMENT_ROOT'] . '/assets/js/modepaiement.js') ?>" defer></script>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<link rel="icon" type="image/svg+xml" href="/assets/file (1).svg">

</head>
<body>
    <header>
        <nav>
        <a class='hstatus' href="/boutique"><i class="fa-solid fa-arrow-left"></i></a>
        <a class='hstatus1' href="/"><span class='tf'>Togo</span>Market</a>
        </nav>
    </header>


<main>
    <h1>Mode de Paiement</h1>
	<p class='ux'>Disponible pour votre boutique(appliquer a toute les annonces de la boutique)</p>
<form method="POST" action="#">

<?php foreach ($paymentMethods as $method): ?>
    <label>
        <input type="checkbox" checked name="payment_methods[]" value="<?php echo htmlspecialchars($method['id_mode_paiement']); ?>" <?= in_array($method['id_mode_paiement'], $boutique_mode_paiement) ? 'checked' : '' ?>>
        <?php echo htmlspecialchars($method['label_mode_paiement']); ?>
    </label>
<?php endforeach; ?>
	<br/>
    <button type="submit">Enregistrer</button>
	<br/>

    	<?php if (!empty($_SESSION['success'])): ?>
    <p style='color : <?= $_SESSION['success'] === 'Mode de paiement ajoutées avec succès !' ? 'green' : 'red' ?>'>
        <?= htmlspecialchars($_SESSION['success']) ?>
    </p>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

</form>
<br/>


</main>




</body>
</html>