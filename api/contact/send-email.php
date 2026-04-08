<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['error' => 'Method not allowed'], 405);
}

$input = json_decode(file_get_contents('php://input'), true);
$prof_id = sanitize($input['prof_id'] ?? '');
$name = sanitize($input['name'] ?? '');
$email = sanitize($input['email'] ?? '');
$message = sanitize($input['message'] ?? '');

if (empty($prof_id) || empty($name) || empty($email) || empty($message)) {
    jsonResponse(['error' => 'Tutti i campi sono obbligatori'], 400);
}

$db = new Database();
$professional = $db->findProfessionalById($prof_id);

if (!$professional) {
    jsonResponse(['error' => 'Professionista non trovato'], 404);
}

$to = $professional['profile']['contact_email'] ?? '';

if (empty($to)) {
    jsonResponse(['error' => 'Il professionista non ha fornito un indirizzo email di contatto'], 400);
}
$subject = "Nuovo messaggio da SpareCare: " . $name;
$headers = "From: " . $email . "\r\n" .
           "Reply-To: " . $email . "\r\n" .
           "X-Mailer: PHP/" . phpversion();

$email_body = "Hai ricevuto un nuovo messaggio tramite SpareCare.\n\n" .
              "Mittente: $name ($email)\n" .
              "Messaggio:\n$message";

// In a real environment, we would use mail() or a library like PHPMailer
// mail($to, $subject, $email_body, $headers);

// For simulation purposes:
// error_log("Simulated Email to $to: $subject\n$email_body");

jsonResponse(['success' => true, 'message' => 'Messaggio inviato con successo']);
?>
