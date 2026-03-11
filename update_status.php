<?php
require_once './config/db.php';

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = (int)$_GET['id'];
    $status = $_GET['status'];

    // Liste des statuts autorisés pour la sécurité
    $allowed_status = ['open', 'pending', 'resolved'];

    if (in_array($status, $allowed_status)) {
        $stmt = $pdo->prepare("UPDATE tickets SET status = ? WHERE id = ?");
        $stmt->execute([$status, $id]);
        // On renvoie une réponse simple (ex: "success") au lieu de rediriger
        echo "success";
    }
}
