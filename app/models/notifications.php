<?php

function getNewNotificationsUser($conn): array
{
    $stmt = $conn->prepare("
	SELECT * FROM notifications WHERE status_notification = 0
        ORDER BY id_notification ASC;
    ");

    $stmt->execute([]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function usertel(PDO $conn, int $id_user): ?string
{
    $stmt = $conn->prepare("SELECT tel_utilisateur FROM utilisateurs WHERE id_utilisateur = ? LIMIT 1");
    $stmt->execute([$id_user]);

    $tel = $stmt->fetchColumn();
    return $tel !== false ? $tel : null;
}


function boutiquetel(PDO $conn, int $id_user): ?string
{
    $stmt = $conn->prepare("
        SELECT b.tel_boutique
        FROM boutiques b
        INNER JOIN utilisateurs u
            ON b.id_utilisateur = u.id_utilisateur
        WHERE u.id_utilisateur = ?
        LIMIT 1
    ");
    
    $stmt->execute([$id_user]);
    $tel = $stmt->fetchColumn();
    
    return $tel !== false ? $tel : null;
}


function markNotificationRead(PDO $conn, int $notificationId): bool
{
    $stmt = $conn->prepare("SELECT 1 FROM notifications WHERE id_notification = ? LIMIT 1
	");

	$stmt->execute([$notificationId]);

	if (!$stmt->fetch()) {
    	return false; 
	}

    $update = $conn->prepare("UPDATE notifications SET status_notification = 1 WHERE id_notification = ?");
    return $update->execute([$notificationId]);
}





function setNotification(
    PDO $conn,
    int $id_utilisateur,
    string $role_notification,
    string $context_notification,
    int $reference_id,
    int $status_notification = 0
): bool {

    $stmt = $conn->prepare("
        INSERT INTO notifications 
        (id_utilisateur, role_notification, context_notification, reference_id, status_notification)
        VALUES (?, ?, ?, ?, ?)
    	");

    return $stmt->execute([
        $id_utilisateur,
        $role_notification,
        $context_notification,
        $reference_id,
        $status_notification
    ]);
}


?>