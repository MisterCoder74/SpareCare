<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/auth-check.php';

$id = getLoggedInUserId();
$db = new Database();
$professional = $db->findProfessionalById($id);

if (!$professional) {
    jsonResponse(['error' => 'Professionista non trovato'], 404);
}

// Remove sensitive data
unset($professional['password_hash']);

jsonResponse($professional);
?>
