<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $to_email = "florent.levasseur@luxantinnovation.com"; // Adresse e-mail de destination
    $subject = "Nouveau message depuis le formulaire de contact"; // Sujet du e-mail

    // Récupérer les données du formulaire
    $name = $_POST["name"];
    $mail = $_POST["mail"];
    $message = $_POST["message"];

    // Corps du message e-mail
    $email_body = "Nom: $name\n";
    $email_body .= "E-mail: $mail\n\n";
    $email_body .= "Message:\n$message\n";

    // En-têtes pour spécifier l'expéditeur et le format e-mail
    $headers = "From: $mail\n";
    $headers .= "Reply-To: $mail\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\n";

    // Envoyer l'e-mail
    if (mail($to_email, $subject, $email_body, $headers)) {
        echo "Message envoyé avec succès!";
    } else {
        echo "Erreur lors de l'envoi du message.";
    }
}
?>