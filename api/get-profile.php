<?php
require_once __DIR__ . '/common.php';

requireAuth();

$id = getLoggedInUserId();
$professional = findProfessionalById($id);

if (!$professional) {
    jsonResponse(['error' => 'Professionista non trovato'], 404);
}

// Remove sensitive data
unset($professional['password_hash']);

jsonResponse($professional);
?>
