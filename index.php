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
    <style>
        body {
            font-family: sans-serif;
            background: #f4f4f4;
            padding: 20px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>

<body>
    <div class="card">
        <h1>Configuration des SLAs</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Niveau de Priorité</th>
                    <th>Délai de résolution (Heures)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($priorities as $priority): ?>
                    <tr>
                        <td><?= $priority['id'] ?></td>
                        <td><strong><?= htmlspecialchars($priority['label']) ?></strong></td>
                        <td><?= $priority['resolution_time_hours'] ?> h</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="card" style="margin-top: 20px;">
        <h2>Ouvrir un nouveau ticket</h2>
        <form action="create_ticket.php" method="POST">
            <label>Sujet :</label><br>
            <input type="text" name="subject" required style="width:100%; margin-bottom:10px;"><br>

            <label>Description du problème :</label><br>
            <textarea name="description" required style="width:100%; height:100px; margin-bottom:10px;"></textarea><br>

            <label>Priorité :</label><br>
            <select name="priority_id" style="width:100%; margin-bottom:20px;">
                <?php foreach ($priorities as $priority): ?>
                    <option value="<?= $priority['id'] ?>"><?= $priority['label'] ?> (délai : <?= $priority['resolution_time_hours'] ?>h)</option>
                <?php endforeach; ?>
            </select><br>

            <button type="submit" style="background: #28a745; color: white; border: none; padding: 10px 20px; cursor: pointer;">Envoyer le ticket</button>
        </form>
    </div>
    <div class="card" style="margin-top: 20px;">
        <h2>Tickets en cours dans la base</h2>
        <?php if (count($tickets) > 0): ?>
            <table>
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
            </table>
        <?php else: ?>
            <p>Aucun ticket trouvé pour le moment. Utilisez le formulaire ci-dessus !</p>
        <?php endif; ?>
    </div>
    <script>
        document.querySelectorAll('.status-select').forEach(select => {
            select.addEventListener('change', function() {
                const ticketId = this.getAttribute('data-id');
                const newStatus = this.value;
                const badge = document.getElementById('badge-' + ticketId);
                const selectElement = this;

                fetch(`update_status.php?id=${ticketId}&status=${newStatus}`)
                    .then(response => response.text())
                    .then(data => {
                        if (data === "success") {
                            // 1. Mettre à jour le badge
                            badge.innerText = newStatus.toUpperCase();
                            const colors = {
                                'open': 'background: #ffc107; color: black;',
                                'pending': 'background: #17a2b8; color: white;',
                                'resolved': 'background: #28a745; color: white;'
                            };
                            badge.style.cssText = "display: inline-block; width: 80px; text-align: center; padding: 3px 10px; border-radius: 12px; font-size: 0.8em; " + colors[newStatus];

                            // 2. Mettre à jour les options du SELECT dynamiquement
                            let optionsHtml = `<option value="" disabled selected>Faîtes un choix</option>`;

                            if (newStatus === 'open') {
                                optionsHtml += `<option value="pending">Prendre en charge</option>
                                        <option value="resolved">Clôturer</option>`;
                            } else if (newStatus === 'pending') {
                                optionsHtml += `<option value="open">Réouvrir</option>
                                        <option value="resolved">Clôturer</option>`;
                            } else if (newStatus === 'resolved') {
                                optionsHtml += `<option value="open">Réouvrir</option>`;
                            }

                            selectElement.innerHTML = optionsHtml;
                        }
                    });
            });
        });
    </script>
</body>

</html>