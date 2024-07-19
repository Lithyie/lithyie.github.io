<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var(trim($_POST["mail"]), FILTER_SANITIZE_EMAIL);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Adresse e-mail invalide.";
        exit;
    }

    $file = 'newsletter_subscribers.txt';

    if (file_put_contents($file, $email . PHP_EOL, FILE_APPEND | LOCK_EX)) {
        echo "Vous êtes inscrit(e) à la newsletter avec succès!";
    } else {
        echo "Erreur lors de l'inscription. Veuillez réessayer plus tard.";
    }
}
?>