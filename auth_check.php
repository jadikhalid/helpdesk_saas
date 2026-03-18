<?php
session_start();

// Rediriger vers login si non connecté
if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}

// Fonction pour restreindre l'accès à certains rôles
function restrictTo($roles)
{
  if (!in_array($_SESSION['user_role'], $roles)) {
    die("Accès refusé : Vous n'avez pas les permissions nécessaires.");
  }
}
