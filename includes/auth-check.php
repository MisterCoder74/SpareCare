<?php
require_once __DIR__ . '/functions.php';

if (!isLoggedIn()) {
    if (strpos($_SERVER['REQUEST_URI'], '/api/') !== false) {
        jsonResponse(['error' => 'Unauthorized'], 401);
    } else {
        redirect('../auth/login.php');
    }
}
?>
