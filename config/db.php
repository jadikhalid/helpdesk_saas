<?php
// config/db.php

use Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php'; // Si vous utilisez Composer pour gérer les dépendances

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$host = 'localhost';
$db   = 'helpdesk_saas';
$user = 'root';
$pass = $_ENV['DB_PASSWORD']; // Celui que vous avez défini tout à l'heure
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Pour voir les erreurs SQL
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Pour récupérer les données sous forme de tableaux propres
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Utilise les vraies requêtes préparées (Haute Performance)
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
     // echo "Connexion réussie !"; // Décommentez pour tester au début
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}