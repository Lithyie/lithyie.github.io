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
    $email = filter_var(trim($_POST['mail']), FILTER_VALIDATE_EMAIL);
    $consent = isset($_POST['consent']) && $_POST['consent'] === 'on';

    if (!$email) {
        $response['status'] = 'error';
        $response['message'] = 'Adresse email invalide.';
        echo json_encode($response);
        exit;
    }

    if (!isValidDomain($email)) {
        $response['status'] = 'error';
        $response['message'] = 'Le domaine de l\'adresse email est invalide ou n\'existe pas.';
        echo json_encode($response);
        exit;
    }

    if (!$consent) {
        $response['status'] = 'error';
        $response['message'] = 'Vous devez accepter la politique de confidentialité.';
        echo json_encode($response);
        exit;
    }

    try {
        // Connexion à la base de données
        $pdo = new PDO('mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Vérifiez si l'email est déjà inscrit
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM subscribers WHERE email = :email');
        $stmt->execute(['email' => $email]);
        if ($stmt->fetchColumn() > 0) {
            $response['status'] = 'error';
            $response['message'] = 'Cette adresse email est déjà inscrite.';
            echo json_encode($response);
            exit;
        }

        // Insérer l'email dans la base de données
        $stmt = $pdo->prepare('INSERT INTO subscribers (email) VALUES (:email)');
        $stmt->execute(['email' => $email]);

        // Envoyer un email de confirmation
        $mail = new PHPMailer(true);
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();
        $mail->Host = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['SMTP_USERNAME'];
        $mail->Password = $_ENV['SMTP_PASSWORD'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom($_ENV['SMTP_USERNAME'], 'Newsletter');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Confirmation d\'inscription à notre newsletter';
        $mail->Body = '
        <html>
        <head>
            <style>
                /* Styles pour les clients de messagerie qui supportent les styles internes */
                .email-body {
                    font-family: Arial, sans-serif;
                    color: #333;
                    background-color: #f5f5f5;
                    padding: 20px;
                    border-radius: 10px;
                    max-width: 600px;
                    margin: 0 auto;
                    text-align: center;
                }
                .email-header {
                    background-color: #d6bb73;
                    color: white;
                    padding: 10px;
                    border-radius: 10px 10px 0 0;
                    font-size: 1.5em;
                    margin-bottom: 10px;
                }
                .email-content {
                    background-color: white;
                    padding: 20px;
                    border-radius: 0 0 10px 10px;
                    border: 3px solid #d6bb73;
                }
                .email-button {
                    background-color: #d6bb74;
                    border: none;
                    border-radius: 5px;
                    color: white;
                    padding: 10px 20px;
                    font-size: 1em;
                    text-decoration: none;
                    display: inline-block;
                    margin-top: 20px;
                }
            </style>
        </head>
        <body>
            <div class="email-body">
                <div class="email-header">Confirmation d\'Inscription</div>
                <div class="email-content">
                    Bonjour,<br><br>
                    Merci pour votre inscription à notre newsletter.<br><br>
                    Vous pouvez vous désinscrire via ce bouton <br> <a href="URL/unsubscribe.php?email=' . urlencode($email) . '" class="email-button">Se désinscrire</a>
                </div>
            </div>
        </body>
        </html>';
        $mail->send();

        $response['status'] = 'success';
        $response['message'] = 'Inscription réussie. Un email de confirmation a été envoyé.';
    } catch (PDOException $e) {
        $response['status'] = 'error';
        $response['message'] = 'Erreur lors de l\'inscription : ' . $e->getMessage();
    } catch (Exception $e) {
        $response['status'] = 'error';
        $response['message'] = 'Erreur lors de l\'envoi de l\'email : ' . $e->getMessage();
    }

    echo json_encode($response);
}

// Fonction pour vérifier si le domaine de l'email est valide
function isValidDomain($email) {
    $domain = substr(strrchr($email, "@"), 1); // Extraire le domaine de l'email
    return checkdnsrr($domain, 'MX'); // Vérifier l'existence des enregistrements MX
}
?>
