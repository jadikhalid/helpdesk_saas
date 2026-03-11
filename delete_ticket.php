<?php
require_once './config/db.php';

// Vérification du mot de passe (À remplacer par un hash sécurisé en production)
$admin_password = "votre_mot_de_passe_secret";

if (isset($_GET['id'])) {
  $id = (int)$_GET['id'];

  // Formulaire de saisie du mot de passe
  echo '<form method="POST">
            <p>Entrez le mot de passe administrateur pour supprimer le ticket #' . $id . '</p>
            <input type="password" name="password" required>
            <button type="submit">Confirmer la suppression</button>
          </form>';

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['password'] === $admin_password) {
      $stmt = $pdo->prepare("DELETE FROM tickets WHERE id = ?");
      $stmt->execute([$id]);
      header('Location: index.php?msg=deleted');
      exit;
    } else {
      echo "<p style='color:red;'>Mot de passe incorrect.</p>";
    }
  }
}
