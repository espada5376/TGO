<?php

function generateOTP(int $length = 6): string {
    return str_pad((string) random_int(0, 999999), $length, '0', STR_PAD_LEFT);
}

function createOTP(PDO $conn, string $Tel_or_Mail): string {
    $otp = generateOTP();
    $hash = password_hash($otp, PASSWORD_DEFAULT);
    $expiresAt = gmdate('Y-m-d H:i:s', time() + 5 * 60);

    $stmt = $conn->prepare("DELETE FROM otp_codes WHERE Tel_or_Mail = ?");
    $stmt->execute([$Tel_or_Mail]);
    
    $stmt = $conn->prepare("
        INSERT INTO otp_codes (Tel_or_Mail, otp_hash, expires_at)
        VALUES (?, ?, ?)
    ");
    $stmt->execute([$Tel_or_Mail, $hash, $expiresAt]);

    return $otp;
}

function getOTP($conn, string $Tel_or_Mail) {
    $stmt = $conn->prepare("
        SELECT TIMESTAMPDIFF(MINUTE, created_at, NOW()) AS minutes_passé, otp_hash FROM otp_codes
        WHERE Tel_or_Mail = ? AND expires_at >= NOW()
        LIMIT 1
    ");
    $stmt->execute([$Tel_or_Mail]);
    return $stmt->fetch(PDO::FETCH_ASSOC);

}

function DeleteOTP(PDO $conn, string $Tel_or_Mail): bool {
    $stmt = $conn->prepare("DELETE FROM otp_codes WHERE Tel_or_Mail = ?");
    return $stmt->execute([$Tel_or_Mail]);
}

function updateDelevery(PDO $conn, int $idcommande){
    $stmt = $conn->prepare("UPDATE commandes SET status_commande = 'nouvelle commande' WHERE id_commande = ?");
    return $stmt->execute([$idcommande]);
}

?>