<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once './config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject = $_POST['subject'];
    $description = $_POST['description'];
    $priority_id = $_POST['priority_id'];

    // 1. Récupérer le délai (SLA) associé à la priorité choisie
    $stmtSla = $pdo->prepare("SELECT resolution_time_hours FROM slas WHERE id = ?");
    $stmtSla->execute([$priority_id]);
    $sla = $stmtSla->fetch();

    if ($sla) {
        // 2. CALCUL DU SLA : Heure actuelle + X heures
        $hours = $sla['resolution_time_hours'];
        $deadline = date('Y-m-d H:i:s', strtotime("+$hours hours"));

        // 3. Insertion du ticket avec sa deadline calculée
        $sql = "INSERT INTO tickets (subject, description, priority_id, deadline_at) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        
        if ($stmt->execute([$subject, $description, $priority_id, $deadline])) {
            echo "<h1>Ticket créé avec succès !</h1>";
            echo "Date limite de résolution : <strong>$deadline</strong><br>";
            echo "<a href='index.php'>Retour au tableau de bord</a>";
        }
    }
}