<?php
// Common functions and setup for all API files

session_start();

// Paths
$dataFile = __DIR__ . '/../data/professionals.json';
$uploadDir = __DIR__ . '/../uploads/';
$baseUrl = 'uploads/';

// Constants
define('DEFAULT_SERVICES', [
    'assistenza_anziani' => 'Assistenza Anziani',
    'assistenza_disabili' => 'Assistenza Disabili',
    'baby_sitting' => 'Baby Sitting',
    'colf' => 'Collaboratore Domestico',
    'badante' => 'Badante',
    'fisioterapia' => 'Fisioterapia a domicilio',
    'infermieristica' => 'Assistenza Infermieristica'
]);

define('AVAILABILITY_OPTIONS', [
    'morning' => 'Mattina',
    'afternoon' => 'Pomeriggio',
    'evening' => 'Sera',
    'night' => 'Notte',
    'weekend' => 'Weekend',
    'holidays' => 'Festivi'
]);

// Utility Functions
function sanitize($data) {
    if (is_array($data)) {
        return array_map('sanitize', $data);
    }
    return htmlspecialchars(stripslashes(trim($data)));
}

function jsonResponse($data, $status = 200) {
    http_response_code($status);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function getLoggedInUserId() {
    return $_SESSION['user_id'] ?? null;
}

function getProfessionals() {
    global $dataFile;
    if (!file_exists($dataFile)) {
        return [];
    }
    $data = json_decode(file_get_contents($dataFile), true);
    return $data['professionals'] ?? [];
}

function saveProfessionals($professionals) {
    global $dataFile;
    file_put_contents($dataFile, json_encode(['professionals' => $professionals], JSON_PRETTY_PRINT));
}

function findProfessionalByEmail($email) {
    $professionals = getProfessionals();
    foreach ($professionals as $p) {
        if ($p['email'] === $email) {
            return $p;
        }
    }
    return null;
}

function findProfessionalById($id) {
    $professionals = getProfessionals();
    foreach ($professionals as $p) {
        if ($p['id'] === $id) {
            return $p;
        }
    }
    return null;
}

function updateProfessional($updatedProfessional) {
    $professionals = getProfessionals();
    foreach ($professionals as &$p) {
        if ($p['id'] === $updatedProfessional['id']) {
            $p = array_merge($p, $updatedProfessional);
            $p['updated_at'] = date('c');
            saveProfessionals($professionals);
            return true;
        }
    }
    return false;
}

function addProfessional($professional) {
    $professionals = getProfessionals();
    $professional['id'] = bin2hex(random_bytes(16));
    $professional['created_at'] = date('c');
    $professional['updated_at'] = date('c');
    $professional['is_active'] = true;
    $professionals[] = $professional;
    saveProfessionals($professionals);
    return $professional['id'];
}

function requireAuth() {
    if (!isLoggedIn()) {
        jsonResponse(['error' => 'Unauthorized'], 401);
    }
}
?>
