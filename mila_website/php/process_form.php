<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $to_email = "contact@luxantinnovation.com";
    $subject = "Nouveau message depuis le formulaire de contact";

    $name = filter_var(trim($_POST["name"]), FILTER_SANITIZE_STRING);
    $mail = filter_var(trim($_POST["mail"]), FILTER_SANITIZE_EMAIL);
    $message = filter_var(trim($_POST["message"]), FILTER_SANITIZE_STRING);

    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        echo "Adresse e-mail invalide.";
        exit;
    }

    if (preg_match("/[\r\n]/", $name) || preg_match("/[\r\n]/", $mail)) {
        echo "Tentative d'injection d'en-tête détectée.";
        exit;
    }

    $email_body = "Nom: $name\n";
    $email_body .= "E-mail: $mail\n\n";
    $email_body .= "Message:\n$message\n";

    $headers = "From: $mail\n";
    $headers .= "Reply-To: $mail\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\n";

    if (mail($to_email, $subject, $email_body, $headers)) {
        echo "Message envoyé avec succès!";
    } else {
        echo "Erreur lors de l'envoi du message.";
    }
}
?>