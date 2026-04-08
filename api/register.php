<?php
require_once __DIR__ . '/common.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['error' => 'Method not allowed'], 405);
}

$input = json_decode(file_get_contents('php://input'), true);
$email = sanitize($input['email'] ?? '');
$password = $input['password'] ?? '';
$confirm_password = $input['confirm_password'] ?? '';

if (empty($email) || empty($password)) {
    jsonResponse(['error' => 'Email e password obbligatori'], 400);
}

if ($password !== $confirm_password) {
    jsonResponse(['error' => 'Le password non coincidono'], 400);
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    jsonResponse(['error' => 'Email non valida'], 400);
}

if (findProfessionalByEmail($email)) {
    jsonResponse(['error' => 'Email già registrata'], 400);
}

$password_hash = password_hash($password, PASSWORD_BCRYPT);

$professional = [
    'email' => $email,
    'password_hash' => $password_hash,
    'profile' => [
        'first_name' => '',
        'last_name' => '',
        'photo' => '',
        'location' => [
            'city' => '',
            'province' => '',
            'zip_code' => ''
        ],
        'phone' => '',
        'contact_email' => $email,
        'bio' => '',
        'rates' => [
            'hourly' => 0,
            'daily' => 0,
            'currency' => 'EUR'
        ],
        'services' => [],
        'custom_services' => [],
        'availability' => [
            'morning' => false,
            'afternoon' => false,
            'evening' => false,
            'night' => false,
            'weekend' => false,
            'holidays' => false
        ]
    ]
];

$id = addProfessional($professional);

$_SESSION['user_id'] = $id;

jsonResponse(['success' => true, 'message' => 'Registrazione completata']);
?>
