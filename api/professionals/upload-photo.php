<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/auth-check.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['photo'])) {
    jsonResponse(['error' => 'Invalid request'], 400);
}

$id = getLoggedInUserId();
$file = $_FILES['photo'];

$allowed_types = ['image/jpeg', 'image/png', 'image/webp'];
if (!in_array($file['type'], $allowed_types)) {
    jsonResponse(['error' => 'Formato non supportato (solo JPG, PNG, WEBP)'], 400);
}

if ($file['size'] > 2 * 1024 * 1024) {
    jsonResponse(['error' => 'File troppo grande (max 2MB)'], 400);
}

$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
$filename = 'photo-' . $id . '-' . time() . '.' . $ext;
$target_path = UPLOADS_PATH . '/' . $filename;

if (move_uploaded_file($file['tmp_name'], $target_path)) {
    $db = new Database();
    $professional = $db->findProfessionalById($id);
    
    // Delete old photo if exists
    if (!empty($professional['profile']['photo'])) {
        $old_photo = BASE_PATH . '/' . $professional['profile']['photo'];
        if (file_exists($old_photo)) {
            unlink($old_photo);
        }
    }
    
    $professional['profile']['photo'] = 'assets/images/uploads/' . $filename;
    $db->updateProfessional($professional);
    
    jsonResponse(['success' => true, 'photo_url' => '/' . $professional['profile']['photo']]);
} else {
    jsonResponse(['error' => 'Errore durante l\'upload'], 500);
}
?>
