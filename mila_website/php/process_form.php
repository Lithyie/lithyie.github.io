<?php
require '../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

// Charger les variables d'environnement
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Valider et assainir les entrées
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['mail']));
    $message = htmlspecialchars(trim($_POST['message']));

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Format d'email invalide";
        exit;
    }

    // Envoyer l'email en utilisant PHPMailer
    sendEmail($name, $email, $message);
}

function sendEmail($name, $email, $message) {
    $mail = new PHPMailer(true);
    try {
        // Paramètres du serveur
        $mail->isSMTP();
        $mail->Host = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['SMTP_USERNAME'];
        $mail->Password = $_ENV['SMTP_PASSWORD'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Destinataires
        $mail->setFrom('from@example.com', 'Formulaire de Contact');
        $mail->addAddress('recipient@example.com', 'Nom du destinataire');

        // Contenu
        $mail->isHTML(true);
        $mail->Subject = 'Nouvelle soumission de formulaire de contact';
        $mail->Body    = "Nom: $name<br>Email: $email<br>Message: $message";

        $mail->send();
        echo 'Le message a été envoyé';
    } catch (Exception $e) {
        echo "Le message n'a pas pu être envoyé. Erreur Mailer : {$mail->ErrorInfo}";
    }
}
?>
