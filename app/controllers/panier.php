<?php



function afficherPanierController($conn) {

    $userId = (int)$_SESSION['id'];

    $likes = getLikesByUser($conn, $userId);

    if (empty($likes)) {
        return [
            'success' => false,
            'message' => "Vous n'avez pas de produit dans le panier"
        ];
    }

    $panier = [
        'noms' => [],
        'photos' => [],
        'prix' => [],
        'ids' => [],
        'total' => 0
    ];

    foreach ($likes as $like) {
        $produit = getProduitById($conn, $like['id_annonce']);

        if ($produit) {
            $panier['noms'][]   = $produit['titre_annonce'];
            $panier['photos'][] = $produit['photo_annonce'];
            $panier['prix'][]   = $produit['prix_unitaire_annonce'];
            $panier['ids'][]    = $produit['id_annonce'];
            $panier['total']   += (int)$produit['prix_unitaire_annonce'];
        }
    }

    return [
        'success' => true,
        'panier' => $panier
    ];
}

function verifierQuantitesController($quantites) {
    foreach ($quantites as $qte) {
        if (trim($qte) === '') {
            return false;
        }
    }
    return true;
}
?>