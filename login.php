<?php
session_start();
require_once './config/db.php';

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
  <title>T.CHECK | Par JADI DIGITAL</title>
  <link rel="icon" type="image/svg+xml" href="./src/img/favicon.svg">
  <link rel="stylesheet" href="style.css">
</head>

<body class="login-page" style="padding:0; background:none;">
  <div class="split-screen">
    <section class="left-side">
      <div class="blob blob-1"></div>
      <div class="blob blob-2"></div>

      <div class="business-logic" style="display: flex; flex-direction: column; height: 100%; justify-content: flex-end; gap: 40px;">

        <div class="brand-header">
          <div class="logo-wrapper" style="display: flex; align-items: center; gap: 12px; margin-bottom: 10px;">
            <div class="abstract-logo" style="width: 40px; height: 40px; background: #6366f1; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
              <div style="width: 15px; height: 20px; border-left: 4px solid white; border-bottom: 4px solid white; border-radius: 0 0 0 5px; transform: rotate(-10deg);"></div>
            </div>
            <span style="font-size: 1.5rem; font-weight: 900; letter-spacing: 1px; color: #fff;">T.CHECK</span>
          </div>
          <span style="background: rgba(99, 102, 241, 0.2); color: #818cf8; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; border: 1px solid rgba(99, 102, 241, 0.3);">
            Ticketing & Helpdesk System
          </span>
        </div>

        <div class="hero-text">
          <h1 style="font-size: 3.2rem; line-height: 1.1; font-weight: 800; margin-top: 20%; letter-spacing: -1.5px;">
            Gérez chaque incident <br>
            <span style="color: #6366f1;">avec précision.</span>
          </h1>
          <p style="color: #94a3b8; font-size: 1.1rem; margin-top: 20px; max-width: 70%; line-height: 1.6; font-weight: 400;">
            Optimisez vos flux de support et centralisez vos demandes avec la puissance technologique de <strong>T.CHECK</strong>.
          </p>
          <div style="width: 60px; height: 4px; background: #6366f1; border-radius: 2px;"></div>
        </div>


        <div style="margin-top: auto;">
          <p style="font-size: 0.75rem; color: rgba(255,255,255,0.3); letter-spacing: 1px;">
            © 2026 JADI DIGITAL · CASABLANCA - FRANCE - USA
          </p>
        </div>

      </div>
    </section>
    <section class="right-side">
      <div class="login-container" style="max-width: 400px; width: 100%;">
        <div class="login-card">
          <div class="login-header">
            <h2 style="font-weight: 900; color: #0f172a; font-size: 1.8rem;">Connexion</h2>
            <p>Ravi de vous revoir !</p>
          </div>

          <?php if (isset($error)): ?>
            <div class="alert-error"><?= $error ?></div>
          <?php endif; ?>

          <form method="POST" class="login-form">
            <div class="form-group">
              <label>Email</label>
              <input type="email" name="email" required placeholder="nom@entreprise.com">
            </div>
            <div class="form-group">
              <label>Mot de passe</label>
              <input type="password" name="password" required placeholder="••••••••">
            </div>
            <button type="submit" class="btn-login" style="background: #0f172a; height: 50px;">S'identifier</button>
          </form>

          <div style="margin-top: 25px; text-align: center; border-top: 1px solid #edf2f7; padding-top: 20px;">
            <p style="color: #64748b; font-size: 0.9rem;">
              Nouveau sur la plateforme ?<br><br>
              <a href="subscription.php" style="color: #3c3d63; font-weight: 700; text-decoration: none; margin-left: 5px;">
                Créer un compte
              </a>
            </p>
          </div>
        </div>
      </div>
    </section>
  </div>
</body>

</html>