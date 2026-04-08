<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['error' => 'Method not allowed'], 405);
}

$input = json_decode(file_get_contents('php://input'), true);
$email = sanitize($input['email'] ?? '');
$password = $input['password'] ?? '';

if (empty($email) || empty($password)) {
    jsonResponse(['error' => 'Email e password obbligatori'], 400);
}

$db = new Database();
$professional = $db->findProfessionalByEmail($email);

if (!$professional || !password_verify($password, $professional['password_hash'])) {
    jsonResponse(['error' => 'Credenziali non valide'], 401);
}

startSession();
$_SESSION['user_id'] = $professional['id'];

jsonResponse(['success' => true, 'message' => 'Login effettuato']);
?>
