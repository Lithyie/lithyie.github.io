<?php
require '../vendor/autoload.php';

use Dotenv\Dotenv;
use PDO;
use PDOException;

// Charger les variables d'environnement
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Connexion à la base de données
try {
    $pdo = new PDO('mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Erreur de connexion à la base de données.';
    exit;
}

// Récupérer l'email de la requête
if (isset($_GET['email']) && filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)) {
    $email = trim($_GET['email']);

    // Supprimer l'email de la base de données
    try {
        $stmt = $pdo->prepare('DELETE FROM subscribers WHERE email = :email');
        $stmt->execute(['email' => $email]);

        // Redirection vers la page de confirmation avec un statut de succès
        header('Location: unsubscribe_confirmation.php?status=success');
    } catch (PDOException $e) {
        // Redirection vers la page de confirmation avec un statut d'erreur
        header('Location: unsubscribe_confirmation.php?status=error');
    }
} else {
    // Redirection vers la page de confirmation avec un statut d'erreur
    header('Location: unsubscribe_confirmation.php?status=error');
}
exit;
