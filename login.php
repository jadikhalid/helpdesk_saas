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
  <title>Connexion | JADI DIGITAL Helpdesk</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .split-screen {
      display: flex;
      flex-direction: row;
      min-height: 100vh;
      width: 100%;
      overflow: hidden;
    }

    /* --- SECTION INFO AVEC DÉCORATIONS --- */
    .left-side {
      flex: 1;
      background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
      color: white;
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 60px;
      position: relative;
      /* Nécessaire pour positionner les formes */
      overflow: hidden;
    }

    /* Tâches de lumière blanches/bleutées */
    .blob {
      position: absolute;
      width: 300px;
      height: 300px;
      background: rgba(255, 255, 255, 0.05);
      filter: blur(80px);
      border-radius: 50%;
      z-index: 1;
    }

    .blob-1 {
      top: -100px;
      left: -100px;
      background: rgba(99, 102, 241, 0.15);
    }

    .blob-2 {
      bottom: -50px;
      right: -50px;
      width: 400px;
      height: 400px;
    }

    /* Formes géométriques stylisées */
    .shape {
      position: absolute;
      border: 1px solid rgba(255, 255, 255, 0.1);
      z-index: 1;
    }

    .circle-shape {
      width: 200px;
      height: 200px;
      border-radius: 50%;
      top: 10%;
      right: -50px;
    }

    .square-shape {
      width: 150px;
      height: 150px;
      bottom: 15%;
      left: -30px;
      transform: rotate(45deg);
    }

    .business-logic {
      position: relative;
      z-index: 10;
      /* Passe au dessus des formes */
    }

    .logic-item {
      background: rgba(255, 255, 255, 0.03);
      padding: 20px;
      border-radius: 12px;
      border: 1px solid rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(5px);
      margin-bottom: 20px;
    }

    /* --- SECTION FORMULAIRE --- */
    .right-side {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: #ffffff;
      padding: 40px;
      z-index: 20;
    }

    .login-card {
      border: none;
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
    }

    @media (max-width: 768px) {
      .split-screen {
        flex-direction: column-reverse;
      }

      .left-side {
        padding: 40px 20px;
      }

      .blob {
        display: none;
      }

      /* On simplifie sur mobile pour la performance */
    }
  </style>
</head>

<body class="login-page" style="padding:0; background:none;">
  <div class="split-screen">


    <section class="left-side">
      <div class="blob blob-1"></div>
      <div class="blob blob-2"></div>
      <div class="shape circle-shape"></div>
      <div class="shape square-shape"></div>

      <div class="business-logic">

        <div class="logo-wrapper" style="margin-bottom: 40px; display: flex; align-items: center; gap: 15px;">
          <div class="abstract-logo" style="
        position: relative;
        width: 50px;
        height: 50px;
        background: #6366f1;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 20px rgba(99, 102, 241, 0.4);
      ">
            <div style="
          width: 20px;
          height: 25px;
          border-left: 5px solid white;
          border-bottom: 5px solid white;
          border-radius: 0 0 0 8px;
          transform: rotate(-10deg) translateX(2px);
        "></div>
            <div style="
          position: absolute;
          top: 10px;
          right: 10px;
          width: 8px;
          height: 8px;
          background: #fff;
          border-radius: 50%;
        "></div>
          </div>
          <div>
            <span style="display: block; font-size: 1.4rem; font-weight: 900; letter-spacing: 1px; color: #fff; line-height: 1;">T.CHECK</span>
          </div>
        </div>

        <h2 style="color: #6366f1; font-weight: 700; font-size: 0.9rem; text-transform: uppercase;">Plateforme Helpdesk</h2>
        <h1 style="font-size: 2.8rem; margin: 10px 0 40px 0; line-height: 1.1; letter-spacing: -1px;">
          L'intelligence au service du <span style="color: #94a3b8;">Support.</span>
        </h1>

        <div class="logic-grid">
          <div class="logic-item">
            <h3 style="color: #fff;">⚡ Moteur de support universel</h3>
            <p style="color: #94a3b8; font-size: 0.9rem; margin: 0;">Un système qui s'ajuste à vos propres processus métier et à vos engagements de service (SLA) en quelques clics.</p>
          </div>

          <div class="logic-item">
            <h3 style="color: #fff;">🔒 Sécurité Native</h3>
            <p style="color: #94a3b8; font-size: 0.9rem; margin: 0;">Gestion des accès basée sur les rôles (RBAC) pour une isolation stricte des données.</p>
          </div>
        </div>

        <p style="margin-top: 30px; font-size: 0.8rem; color: rgba(255,255,255,0.3);">
          © 2026 JADI DIGITAL. Tous droits réservés.
        </p>
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