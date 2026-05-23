<?php

function calculateTrustScore(PDO $conn, array $annonce): int
{
    $scoreQualite = 0;


    $scoreWatermark = hasWatermark($annonce['photo_annonce'] ?? '') ? 0 : 15;
    $scoreQualite += 1 - exp(-0.2 * $scoreWatermark) * 15; 
    
    $scoreTitre = scoreTitre($annonce['titre_annonce']);
    $scoreQualite += $scoreTitre;
    
    $scoreDescription =	scoreDescription($annonce['description_annonce']);
    $scoreQualite += $scoreDescription;

    $scorePhone = (containsPhoneNumber($annonce['description_annonce'] ?? '') ||
                   containsPhoneNumber($annonce['titre_annonce'] ?? '')) ? 0 : 10;
    $scoreQualite += 1 - exp(-0.3 * $scorePhone) * 10;

    $timestampPublication = is_numeric($annonce['date_creation_annonce']) ?
                            (int)$annonce['date_creation_annonce'] :
                            strtotime($annonce['date_creation_annonce']);

    $scoreAnnonce = scoreAnnonce($scoreQualite, $timestampPublication);

    $scoreFinal = (0.85 * $scoreQualite) + (0.15 * $scoreAnnonce);
    
    return (int) round(max(0, min(100, $scoreFinal)));
}

function scoreAnnonce(float $scoreInitial, int $timestampPublication, float $lambda = 0.03): float
{
    $jours = joursDepuis($timestampPublication);
    return $scoreInitial * exp(-$lambda * $jours);
}

function joursDepuis(int $timestamp): int
{
    return floor((time() - $timestamp) / 86400);
}

function hasWatermark(string $filename): bool
{
    $keywords = ['shutterstock', 'getty', 'alamy', 'istock', 'depositphotos'];
    $filename = strtolower($filename);

    foreach ($keywords as $word) {
        if (str_contains($filename, $word)) return true;
    }
    return false;
}

function containsPhoneNumber(string $text): bool
{
    return preg_match('/(\+228|00228)?\s?[279][0-9]{7}/', $text) === 1;
}

function scoreTitre(string $titre): int
{
    $score = 0;

    $titre = trim($titre);
    $len = strlen($titre);

    if ($len >= 20) $score += 5;
    if ($len >= 40) $score += 5;

    if (!preg_match('/^[A-Z\s0-9]+$/', $titre)) {
        $score += 5; // pas tout en majuscule
    }

    return min($score, 15);
}


function scoreDescription(string $description): int
{
    $score = 0;

    $len = strlen(trim($description));

    if ($len > 50) $score += 5;
    if ($len > 150) $score += 5;
    if ($len > 300) $score += 5;

    if (substr_count($description, '.') >= 2) {
        $score += 5;
    }

    return min($score, 20);
}


function trustscoreController(PDO $conn): void
{
    $annonces = getAnnoncesForTrustscore($conn);

    foreach ($annonces as $annonce) {
        $score = calculateTrustScore($conn, $annonce);

        updateAnnonceTrustscore(
            $conn,
            $annonce['id_annonce'],
            $score
        );

        markAnnonceAsChecked(
            $conn,
            $annonce['id_annonce']
        );
    }
}

?>