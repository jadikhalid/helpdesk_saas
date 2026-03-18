<?php
require_once 'auth_check.php';
require_once './config/db.php';

// On récupère les SLAs pour prouver que la jointure future fonctionnera
$query = $pdo->query("SELECT * FROM slas");
$priorities = $query->fetchAll();

// 2. NOUVEAU : Récupérer tous les tickets triés par deadline
// On fait une jointure pour avoir le libellé de la priorité (ex: "Critique")
$queryTickets = $pdo->query("
    SELECT t.*, s.label as priority_label 
    FROM tickets t 
    LEFT JOIN slas s ON t.priority_id = s.id 
    ORDER BY t.created_at DESC
");
$tickets = $queryTickets->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Helpdesk SaaS - Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="./app.js" defer></script>
</head>

<body>
    <div class="container">
        <header class="header-dashboard">
            <div class="header-content" style="width: 100%; display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; align-items: center; gap: 15px;">
                    <h1>Helpdesk Support</h1>
                    <span class="badge-dashboard">Dashboard</span>
                    <span style="font-size: 0.8rem; color: #64748b;">Connecté en tant que : <strong><?= htmlspecialchars($_SESSION['user_name']) ?></strong></span>
                </div>

                <a href="logout.php" class="btn-logout" style="text-decoration: none;">Se déconnecter</a>
            </div>
        </header>
        <div class="card">
            <h1>Configuration des SLAs</h1>
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Niveau de Priorité</th>
                            <th>Délai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($priorities as $priority): ?>
                            <tr>
                                <td><?= $priority['id'] ?></td>
                                <td style="font-weight: 500;"><?= htmlspecialchars($priority['label']) ?></td>
                                <td><?= $priority['resolution_time_hours'] ?> heures</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card">
            <h1>Ouvrir un nouveau ticket</h1>
            <form action="create_ticket.php" method="POST" class="ticket-form">
                <div class="form-group">
                    <label>Sujet</label>
                    <input type="text" name="subject" placeholder="Ex: Problème de connexion" required>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" rows="6" placeholder="Décrivez votre problème ici..." required></textarea>
                </div>

                <div class="form-group">
                    <label>Priorité</label>
                    <select name="priority_id">
                        <?php foreach ($priorities as $priority): ?>
                            <option value="<?= $priority['id'] ?>"><?= htmlspecialchars($priority['label']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn-submit"><span style="font-size: 1.1rem;">+</span> Créer le ticket</button>
            </form>
        </div>
        <div class="card" style="margin-top: 20px; font-size: 0.9rem;">
            <h2>Tickets en cours dans la base</h2>
            <?php if (count($tickets) > 0): ?>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Priorité</th>
                                <th>Création</th>
                                <!-- <th>Deadline</th> -->
                                <th>Status</th>
                                <th>Détails</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tickets as $ticket):
                            ?>
                                <tr>
                                    <td>#<?= $ticket['id'] ?></td>
                                    <td><?= htmlspecialchars($ticket['priority_label'] ?? '-') ?></td>
                                    <td><?= date('d/m H:i', strtotime($ticket['created_at'])) ?></td>
                                    <td><span class="status-badge status-<?= $ticket['status'] ?>"><?= strtoupper($ticket['status']) ?></span></td>
                                    <td>
                                        <button class="btn-detail" onclick="openModal(<?= $ticket['id'] ?>)">Voir</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p>Aucun ticket trouvé pour le moment. Utilisez le formulaire ci-dessus !</p>
            <?php endif; ?>
        </div>
        <div id="modal-container" class="modal-overlay">
            <div class="card modal-fullscreen">
                <button class="btn-close" onclick="closeModal()">&times; Fermer</button>
                <h2>Détails du Ticket</h2>
                <div id="modal-content">Chargement...</div>
            </div>
        </div>
    </div>

</html>