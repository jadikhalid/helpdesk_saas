<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>S'abonner | JADI DIGITAL Helpdesk</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .split-screen {
      display: flex;
      flex-direction: row;
      min-height: 100vh;
      width: 100%;
      overflow: hidden;
    }

    /* --- SECTION INFOS (Gauche) --- */
    .left-side {
      flex: 1;
      background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
      color: white;
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 60px;
      position: relative;
      overflow: hidden;
    }

    /* Décorations d'arrière-plan */
    .blob {
      position: absolute;
      width: 300px;
      height: 300px;
      background: rgba(99, 102, 241, 0.1);
      filter: blur(80px);
      border-radius: 50%;
      z-index: 1;
    }

    .blob-1 {
      top: -50px;
      left: -50px;
    }

    .blob-2 {
      bottom: 10%;
      right: -50px;
      background: rgba(255, 255, 255, 0.05);
    }

    .content-wrapper {
      position: relative;
      z-index: 10;
    }

    /* Style du Logo */
    .logo-wrapper {
      margin-bottom: 40px;
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .abstract-logo {
      position: relative;
      width: 52px;
      height: 52px;
      background: #6366f1;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 10px 20px rgba(99, 102, 241, 0.3);
    }

    .logo-symbol {
      width: 18px;
      height: 22px;
      border-left: 5px solid white;
      border-bottom: 5px solid white;
      border-radius: 0 0 0 6px;
      transform: rotate(-10deg) translateX(2px);
    }

    .logo-dot {
      position: absolute;
      top: 8px;
      right: 8px;
      width: 6px;
      height: 6px;
      background: #fff;
      border-radius: 50%;
    }

    .price-card {
      background: rgba(255, 255, 255, 0.05);
      padding: 30px;
      border-radius: 16px;
      border: 1px solid rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      margin-top: 30px;
    }

    .price-tag {
      font-size: 3rem;
      font-weight: 800;
      color: #fff;
    }

    .price-tag span {
      font-size: 1rem;
      color: #94a3b8;
    }

    /* --- SECTION FORMULAIRE (Droite) --- */
    .right-side {
      flex: 1.2;
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: #ffffff;
      padding: 40px;
    }

    .sub-container {
      max-width: 500px;
      width: 100%;
    }

    .step-indicator {
      display: flex;
      gap: 10px;
      margin-bottom: 30px;
    }

    .step {
      height: 4px;
      flex: 1;
      background: #edf2f7;
      border-radius: 2px;
    }

    .step.active {
      background: #6366f1;
    }

    .form-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 15px;
    }

    @media (max-width: 900px) {
      .split-screen {
        flex-direction: column;
      }

      .left-side,
      .right-side {
        padding: 40px 20px;
      }
    }
  </style>

</head>
</head>

<body style="margin:0; padding:0; background:none;">
  <div class="split-screen">

    <section class="left-side">
      <div class="blob blob-1"></div>
      <div class="blob blob-2"></div>

      <div class="content-wrapper">
        <div class="logo-wrapper">
          <div class="abstract-logo">
            <div class="logo-symbol"></div>
            <div class="logo-dot"></div>
          </div>
          <div>
            <span style="display: block; font-size: 1.4rem; font-weight: 900; letter-spacing: 1px; color: #fff; line-height: 1;">T.CHECK</span>

          </div>
        </div>

        <a href="login.php" style="color: #6366f1; text-decoration: none; font-weight: 600; font-size: 0.85rem;">← Retour à la connexion</a>

        <h2 style="margin-top: 25px; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; font-size: 0.8rem;">Offre Lancement</h2>
        <h1 style="font-size: 2.5rem; line-height: 1.1; margin: 10px 0; letter-spacing: -1px;">Le Helpdesk qui <br><span style="color: #6366f1;">travaille pour vous.</span></h1>

        <p style="color: #94a3b8; line-height: 1.6; max-width: 400px;">Rejoignez les entreprises qui ont choisi la flexibilité pour leur support client.</p>

        <div class="price-card">
          <div class="price-tag">49€<span> /mois /HT</span></div>
          <ul style="list-style: none; padding: 0; margin: 20px 0; color: #cbd5e1; font-size: 0.9rem;">
            <li style="margin-bottom: 10px;">✓ Tickets illimités</li>
            <li style="margin-bottom: 10px;">✓ Moteur de support universel</li>
            <li style="margin-bottom: 10px;">✓ Étanchéité totale des données</li>
            <li style="margin-bottom: 10px;">✓ Support technique 24/7</li>
          </ul>
        </div>
      </div>
    </section>

    <section class="right-side">
      <div class="sub-container">
        <div class="step-indicator">
          <div class="step active"></div>
          <div class="step"></div>
          <div class="step"></div>
        </div>

        <h2 style="font-weight: 900; color: #0f172a; font-size: 1.8rem; margin-bottom: 10px;">Créer votre instance</h2>
        <p style="color: #64748b; margin-bottom: 30px;">Commencez votre essai gratuit de 14 jours dès maintenant.</p>

        <form action="#" method="POST" class="login-form">
          <div class="form-grid">
            <div class="form-group">
              <label>Prénom</label>
              <input type="text" name="firstname" required placeholder="Jean">
            </div>
            <div class="form-group">
              <label>Nom</label>
              <input type="text" name="lastname" required placeholder="Dupont">
            </div>
          </div>

          <div class="form-group">
            <label>Nom de l'entreprise</label>
            <input type="text" name="company" required placeholder="Ex: JADI DIGITAL SARL">
          </div>

          <div class="form-group">
            <label>Email Professionnel</label>
            <input type="email" name="email" required placeholder="jean@entreprise.com">
          </div>

          <div class="form-group">
            <label>Mot de passe</label>
            <input type="password" name="password" required placeholder="Minimum 8 caractères">
          </div>

          <div style="margin: 20px 0;">
            <label style="display: flex; align-items: flex-start; gap: 10px; font-size: 0.85rem; color: #64748b; cursor: pointer;">
              <input type="checkbox" required style="width: auto; margin-top: 3px;">
              <span>J'accepte les <a href="#" style="color: #6366f1;">Conditions Générales</a> et la <a href="#" style="color: #6366f1;">Politique de Confidentialité</a>.</span>
            </label>
          </div>

          <button type="submit" class="btn-login" style="background: #6366f1; height: 55px; font-size: 1rem; box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.3);">
            Démarrer mon essai gratuit
          </button>
        </form>

        <p style="text-align: center; margin-top: 25px; font-size: 0.9rem; color: #64748b;">
          Déjà un compte ? <a href="login.php" style="color: #0f172a; font-weight: 700; text-decoration: none;">Se connecter</a>
        </p>
      </div>
    </section>

  </div>
</body>

</html>