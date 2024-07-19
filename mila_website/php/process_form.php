<?php

require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

header('Content-Type: application/json');
header('Content-Type: text/html; charset=utf-8');

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$response = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recaptchaToken = $_POST['recaptcha_token'];
    $recaptchaSecret = $_ENV['RECAPTCHA_SECRET_KEY'];
    $recaptchaUrl = 'https://www.google.com/recaptcha/api/siteverify';

    $recaptchaResponse = file_get_contents($recaptchaUrl . '?secret=' . $recaptchaSecret . '&response=' . $recaptchaToken);
    $recaptchaData = json_decode($recaptchaResponse);

    if (!$recaptchaData->success || $recaptchaData->score < 0.5) {
        $response['status'] = 'error';
        $response['message'] = 'La vérification reCAPTCHA a échoué. Essayez à nouveau.';
        echo json_encode($response);
        exit;
    }

    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['mail']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validation du champ message
    $maxLength = 2000; // Définissez la longueur maximale autorisée pour le message
    if (strlen($message) > $maxLength) {
        $response['status'] = 'error';
        $response['message'] = 'Le message est trop long.';
        echo json_encode($response);
        exit;
    }

    // Nettoyage du message pour les caractères non autorisés
    // Vous pouvez utiliser des expressions régulières pour filtrer les caractères spécifiques
    $message = preg_replace('/[^\w\s\.,!?]/', '', $message);

    if (empty($message)) {
        $response['status'] = 'error';
        $response['message'] = 'Le message est vide ou contient des caractères non autorisés.';
        echo json_encode($response);
        exit;
    }

    $success = sendEmail($name, $email, $message);

    if ($success) {
        $response['status'] = 'success';
        $response['message'] = 'Le message a été envoyé';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Le message n\'a pas pu être envoyé. Veuillez réessayer plus tard.';
    }

    echo json_encode($response);
    exit;
}

function sendEmail($name, $email, $message) {
    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8'; 
    try {
        $mail->isSMTP();
        $mail->Host = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['SMTP_USERNAME'];
        $mail->Password = $_ENV['SMTP_PASSWORD'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom($_ENV['SMTP_USERNAME'], 'Formulaire de Contact');
        $mail->addAddress($_ENV['RECIPIENT_EMAIL'], 'Nom du destinataire');

        $mail->isHTML(true);
        $mail->Subject = 'Nouvelle soumission de formulaire de contact';
        $mail->Body    = "Nom: $name<br>Email: $email<br>Message: $message";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Erreur lors de l'envoi de l'email : " . $mail->ErrorInfo);
        return false;
    }
}
?>
