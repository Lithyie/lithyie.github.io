<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer et valider l'adresse e-mail
    $email = filter_var(trim($_POST["mail"]), FILTER_SANITIZE_EMAIL);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Adresse e-mail invalide.";
        exit;
    }

    // Chemin vers le fichier de stockage des e-mails
    $file = 'newsletter_subscribers.txt';

    // Enregistrer l'adresse e-mail dans le fichier
    if (file_put_contents($file, $email . PHP_EOL, FILE_APPEND | LOCK_EX)) {
        echo "Vous êtes inscrit(e) à la newsletter avec succès!";
    } else {
        echo "Erreur lors de l'inscription. Veuillez réessayer plus tard.";
    }
}
?>