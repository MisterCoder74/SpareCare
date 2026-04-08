<?php
require_once __DIR__ . '/common.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['error' => 'Method not allowed'], 405);
}

requireAuth();

$id = getLoggedInUserId();
$input = json_decode(file_get_contents('php://input'), true);

$professional = findProfessionalById($id);

if (!$professional) {
    jsonResponse(['error' => 'Professionista non trovato'], 404);
}

// Update profile data
$professional['profile'] = array_merge($professional['profile'], $input['profile'] ?? []);

if (updateProfessional($professional)) {
    jsonResponse(['success' => true, 'message' => 'Profilo aggiornato']);
} else {
    jsonResponse(['error' => 'Errore durante l\'aggiornamento'], 500);
}
?>
