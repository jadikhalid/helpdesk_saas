<?php
session_start();
require_once './config/db.php';

// Redirection si déjà connecté
if (isset($_SESSION['user_id'])) {
  header('Location: index.php');
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->execute([$email]);
  $user = $stmt->fetch();

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_role'] = $user['role'];
    $_SESSION['user_name'] = $user['full_name'];
    header('Location: index.php');
    exit;
  } else {
    $error = "Identifiants incorrects.";
  }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion | JADI DIGITAL Helpdesk</title>
  <link rel="stylesheet" href="style.css">
</head>

<body class="login-page">
  <div class="login-container">
    <div class="login-card">
      <div class="login-header">
        <h2>JADI DIGITAL</h2>
        <p>Helpdesk SaaS Demo</p>
      </div>

      <?php if (isset($error)): ?>
        <div class="alert-error"><?= $error ?></div>
      <?php endif; ?>

      <form method="POST" class="login-form">
        <div class="form-group">
          <label for="email">Email Professionnel</label>
          <input type="email" id="email" name="email" required placeholder="nom@entreprise.com">
        </div>
        <div class="form-group">
          <label for="password">Mot de passe</label>
          <input type="password" id="password" name="password" required placeholder="••••••••">
        </div>
        <button type="submit" class="btn-login">Se connecter</button>
      </form>
    </div>

    <div class="demo-helper">
      <h3>Comptes de test (Mot de passe : password123)</h3>
      <div class="demo-grid">
        <div class="demo-item">
          <strong>Super Admin:</strong> <span>superadmin@jadi-digital.com</span>
        </div>
        <div class="demo-item">
          <strong>Admin:</strong> <span>admin@jadi-digital.com</span>
        </div>
        <div class="demo-item">
          <strong>Client:</strong> <span>user@jadi-digital.com</span>
        </div>
      </div>
    </div>
  </div>
</body>

</html>