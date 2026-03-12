<?php
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
            <div class="header-content">
                <h1>Helpdesk Support</h1>
                <span class="badge-dashboard">Dashboard</span>
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
                <!-- <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Sujet</th>
                            <th>Description</th>
                            <th>Priorité</th>
                            <th>Date de création</th>
                            <th>Deadline (SLA)</th>
                            <th>Status</th>
                            <th>Action</th>
                            <th>Suppression</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tickets as $ticket): ?>
                            <tr>
                                <td>#<?= $ticket['id'] ?></td>
                                <td><strong><?= htmlspecialchars($ticket['subject']) ?></strong></td>
                                <td><?= nl2br(htmlspecialchars($ticket['description'])) ?></td>
                                <td>
                                    <span style="background: #e9ecef; padding: 2px 8px; border-radius: 4px;">
                                        <?= htmlspecialchars($ticket['priority_label'] ?? 'Non définie') ?>
                                    </span>
                                </td>
                                <td><?= date('d/m/Y H:i', strtotime($ticket['created_at'])) ?></td>
                                <td style="color: <?= (strtotime($ticket['deadline_at']) < time()) ? 'red' : 'green' ?>;">
                                    <strong><?= date('d/m/Y H:i', strtotime($ticket['deadline_at'])) ?></strong>
                                </td>
                                <td>
                                    <?php
                                    $statusColors = [
                                        'open' => 'background: #ffc107; color: black;', // Jaune
                                        'pending' => 'background: #17a2b8; color: white;', // Bleu
                                        'resolved' => 'background: #28a745; color: white;' // Vert
                                    ];
                                    $style = $statusColors[$ticket['status']] ?? '';
                                    ?>
                                    <span style="
                                    display: inline-block; 
                                    width: 80px; 
                                    text-align: center; 
                                    padding: 3px 10px; 
                                    border-radius: 12px; 
                                    font-size: 0.8em; 
                                    <?= $style ?>" id="badge-<?= $ticket['id'] ?>">
                                        <?= strtoupper($ticket['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <form action="update_status.php" method="GET">
                                        <input type="hidden" name="id" value="<?= $ticket['id'] ?>">
                                        <select name="status" class="status-select" data-id="<?= $ticket['id'] ?>" style="width: 150px;">
                                            <option value="" disabled selected>Faîtes un choix</option>

                                            <?php
                                            $status = $ticket['status'];

                                            if ($status === 'open'): ?>
                                                <option value="pending">Prendre en charge</option>
                                                <option value="resolved">Clôturer</option>
                                            <?php elseif ($status === 'pending'): ?>
                                                <option value="open">Réouvrir</option>
                                                <option value="resolved">Clôturer</option>
                                            <?php elseif ($status === 'resolved'): ?>
                                                <option value="open">Réouvrir</option>
                                            <?php endif; ?>
                                        </select>
                                    </form>
                                </td>
                                <td>
                                    <a href="delete_ticket.php?id=<?= $ticket['id'] ?>"
                                        onclick="return confirm('Confirmer la suppression ?');"
                                        style="color: red; text-decoration: none;">🗑️ Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table> -->
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
                                $isOverdue = (strtotime($ticket['deadline_at']) < time());
                            ?>
                                <tr class="<?= $isOverdue ? 'overdue-row' : '' ?>">
                                    <td>#<?= $ticket['id'] ?></td>
                                    <td><?= htmlspecialchars($ticket['priority_label'] ?? '-') ?></td>
                                    <td><?= date('d/m H:i', strtotime($ticket['created_at'])) ?></td>
                                    <!-- <td><?= date('d/m H:i', strtotime($ticket['deadline_at'])) ?></td> -->
                                    <td><span class="status-badge"><?= strtoupper($ticket['status']) ?></span></td>
                                    <td>
                                        <button class="btn-detail" onclick="openModal(<?= $ticket['id'] ?>)">Voir</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div id="modal-container" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000;">
                    <div class="card" style="width: 500px; margin: 100px auto;">
                        <h2>Détails du Ticket</h2>
                        <div id="modal-content">Chargement...</div>
                        <button class="btn-close" onclick="document.getElementById('modal-container').style.display='none'">Fermer</button>
                    </div>
                </div>
            <?php else: ?>
                <p>Aucun ticket trouvé pour le moment. Utilisez le formulaire ci-dessus !</p>
            <?php endif; ?>
        </div>
    </div>

</html>