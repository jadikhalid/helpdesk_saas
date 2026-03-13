<?php
require_once './config/db.php';

$id = (int)$_GET['id'];
$query = $pdo->prepare("
    SELECT t.*, s.label as priority_label 
    FROM tickets t 
    LEFT JOIN slas s ON t.priority_id = s.id 
    WHERE t.id = :id
");
$query->execute(['id' => $id]);
$ticket = $query->fetch();

if (!$ticket) {
  echo "Ticket non trouvé.";
  exit;
}

// Définition des transitions possibles
$transitions = [
  'open'     => ['pending' => 'Prendre en charge', 'resolved' => 'Marquer comme résolu', 'closed' => 'Clôturer'],
  'pending'  => ['open' => 'Réouvrir', 'resolved' => 'Marquer comme résolu', 'closed' => 'Clôturer'],
  'resolved' => ['open' => 'Réouvrir', 'pending' => 'Mettre en attente', 'closed' => 'Clôturer'],
  'closed'   => ['open' => 'Réouvrir']
];

// Récupération du statut actuel du ticket
$currentStatus = $ticket['status'];

// Récupération des options disponibles pour cet état spécifique
$options = $transitions[$currentStatus] ?? [];
?>

<div class="modal-info">
  <p><strong>ID:</strong> #<?= $ticket['id'] ?></p>
  <p><strong>Statut:</strong> <?= htmlspecialchars($ticket['status']) ?></p>
  <p><strong>Sujet:</strong> <?= htmlspecialchars($ticket['subject']) ?></p>
  <p><strong>Description:</strong><br><?= nl2br(htmlspecialchars($ticket['description'])) ?></p>
  <p><strong>Priorité:</strong> <?= htmlspecialchars($ticket['priority_label']) ?></p>
  <p><strong>Date de création:</strong> <?= date('d/m/Y H:i', strtotime($ticket['created_at'])) ?></p>
  <p><strong>Deadline:</strong> <?= date('d/m/Y H:i', strtotime($ticket['deadline_at'])) ?></p>
  <hr class="hr-left">
  <label><strong>Changer le statut :</strong></label>
  <select id="modal-status-select">
    <option value="" disabled selected>-- Choisir une action --</option>

    <?php foreach ($options as $value => $label): ?>
      <option value="<?= $value ?>"><?= $label ?></option>
    <?php endforeach; ?>
  </select>
  <textarea id="modal-comment" rows="10" placeholder="Entrez un commentaire (minimum 50 caractères)..."></textarea>
  <hr class="hr-left">

  <div class="modal-footer">
    <button id="btn-validate-status" class="btn-submit-action" onclick="validateStatusChange(<?= $ticket['id'] ?>)">
      Confirmer le changement
    </button>
  </div>
</div>