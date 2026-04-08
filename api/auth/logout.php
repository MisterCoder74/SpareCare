<?php
require_once __DIR__ . '/../../includes/functions.php';

startSession();
session_unset();
session_destroy();

jsonResponse(['success' => true]);
?>
