<?php  

function formatMoney($amount) {
    return number_format($amount, 0, '', '.');
}

function generate(int $length = 4): string {
    return str_pad((string) random_int(0, 999999), $length, '0', STR_PAD_LEFT);
}

function sendWhatsAppMessage(string $phone, string $message): array {
    $baseUrl = 	" https://unretrenchable-shelby-topfull.ngrok-free.dev/api";
    $apiKey = "28698fb26d0141d08e640d2f706630f2";

    $phone = preg_replace('/[^0-9]/', '', $phone);
    if (strpos($phone, "228") === 0) {
        $phone = substr($phone, 3);
    }

    $chatId = "228" . $phone . "@c.us";

    
    function request($url, $data, $apiKey) {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "X-Api-Key: $apiKey"
            ],
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            return ["error" => $error];
        }

        curl_close($ch);

        return [
            "status" => $httpCode,
            "response" => json_decode($response, true)
        ];
    }


    request("$baseUrl/startTyping", [
        "chatId" => $chatId,
        "session" => "default"
    ], $apiKey);

    $typingTime = max(2000, min(strlen($message) * 50, 8000));
    usleep($typingTime * 1000); 
    
    request("$baseUrl/stopTyping", [
        "chatId" => $chatId,
        "session" => "default"
    ], $apiKey);

    $result = request("$baseUrl/sendText", [
        "chatId" => $chatId,
        "text" => $message,
        "session" => "default"
    ], $apiKey);

    usleep(rand(1000, 3000) * 1000);

    return $result;
}


function longPollNotifications(PDO $conn, array $tarifsRetrait)
{
    header('Content-Type: application/json');

    $notifications = getNewNotificationsUser($conn);

    if (empty($notifications)) {
        echo json_encode([
            "success" => true,
            "message" => "Aucune notification à envoyer"
        ]);
        return;
    }

    $errors = [];

    foreach ($notifications as $notif) {
		$commande = getCommandeInfo($conn, $notif['reference_id']);
        
        if ($notif['context_notification'] === 'commande_acheteur') {
            $tel = $commande['tel_client_commande'] ;
            $message = commandeAcheteurTemplate($commande, $tarifsRetrait);
        } else if($notif['context_notification'] === 'commande_vendeur' ) {
            $tel = boutiquetel($conn, (int)$notif['id_utilisateur']);
            $message = commandeVendeurTemplate($commande);
        } else if($notif['context_notification'] === 'commande_terminee_acheteur' ){
            $tel = $commande['tel_client_commande'];
            $message = commandeTerminerAcheteur($commande, $tarifsRetrait);
        } else{
            $tel = boutiquetel($conn, (int)$notif['id_utilisateur']);
            $message = commandeTerminerVendeur($commande);
        }

        if (!$tel) {
            $errors[] = [
                'id_notification' => $notif['id_notification'],
                'error' => 'Numéro introuvable'
            ];
            continue;
        }

    $result = sendWhatsAppMessage($tel, $message);

if ($result['status'] !== 201) {
    $errors[] = [
        'id_notification' => $notif['id_notification'] ?? null,
        'http_code' => $result['status'] ?? null,
        'error' => isset($result['response']) 
                     ? json_encode($result['response'], JSON_PRETTY_PRINT) 
                     : 'Erreur inconnue'
    ];
} else {
    markNotificationRead($conn, $notif['id_notification']);
}
               
}

    echo json_encode([
        "success" => empty($errors),
        "errors"  => $errors
    ]);
}




function commandeAcheteurTemplate($commande, array $tarifsRetrait){
    
$montant = (int)$commande['prix_unitaire_annonce'] * (int)$commande['quantite_commande'];

$frais = getFraisRetraitR($montant, $tarifsRetrait);
$fraisRetrait = $frais['frais'];

$fraisLivraison = 1000;

$montantTotal = $montant + $fraisRetrait + $fraisLivraison;

return "*Commande enregistrée*
   
*ID commande* : TG#{$commande['id_commande']}

*Article* : {$commande['titre_annonce']}
*Quantité* : {$commande['quantite_commande']}
*Montant* : " . formatMoney($montant) . " FCFA
*Frais (Retrait + Livraison inclus)* : " . formatMoney($fraisRetrait + $fraisLivraison) . " FCFA
*Montant total à payer* : " . formatMoney($montantTotal) . " FCFA

👉 Le livreur vous contactera.

_TogoMarket_";
}


function commandeVendeurTemplate($commande, array $tarifsRetrait){

$montant = (int)$commande['prix_unitaire_annonce'] * (int)$commande['quantite_commande'];
$frais = getFraisRetraitR($montant, $tarifsRetrait);
$montantTotal = $montant + $frais['frais'];

$nbra = generate();


return "*Nouvelle commande reçue*
   
*ID commande* : TG#{$commande['id_commande']}{$nbra}

*Article* : {$commande['titre_annonce']}
*Quantité* : {$commande['quantite_commande']}

*Client*
{$commande['nom_client_commande']}

*Montant total (avec frais)* : " . formatMoney($montantTotal) . " FCFA

👉 Le livreur vous contactera.

_TogoMarket_";
}

function commandeTerminerVendeur($commande, array $tarifsRetrait){
        
$montant = (int)$commande['prix_unitaire_annonce'] * (int)$commande['quantite_commande'];

$frais = getFraisRetraitR($montant, $tarifsRetrait);
$montantTotal = $montant + $frais['frais'];
$nbra = genarate();

$montantTotal = number_format($montantTotal, 0, ',', ' ');
    
return "*Commande livrée avec succès*
    
*La commande TG#{$commande['id_commande']}{$nbra} .  a été livrée et le paiement est confirmé*

*Client* : {$commande['nom_client_commande']}
*Article* : {$commande['titre_annonce']}
*Montant reçu* : {$montantTotal} FCFA
*Livraison* : effectuée

Merci pour votre collaboration
Continuez à fournir un service de qualité.

_TogoMarket_";
}

function commandeTerminerAcheteur($commande, array $tarifsRetrait){
    
$montant = (int)$commande['prix_unitaire_annonce'] * (int)$commande['quantite_commande'];

$frais = getFraisRetraitR($montant, $tarifsRetrait);
$fraisRetrait = $frais['frais'];

$fraisLivraison = 1000;
    
$montantTotal = $montant + $fraisRetrait + $fraisLivraison;

$montantTotal = number_format($montantTotal, 0, ',', ' ');
    
return "*Commande livrée avec succès*
    
*Votre commande TG#{$commande['id_commande']} a été livrée et le paiement est confirmé*

*Article* : {$commande['titre_annonce']}
*Montant payé* : {$montantTotal} FCFA (frais de retrait + livraison inclus)

Merci pour votre confiance.
Si vous avez un souci ou une remarque, notre support est disponible.

_TogoMarket_";
}

?>