<?php
require_once __DIR__ . '/common.php';

$city = sanitize($_GET['city'] ?? '');
$service = sanitize($_GET['service'] ?? '');
$availability = sanitize($_GET['availability'] ?? '');

$professionals = getProfessionals();

$results = array_filter($professionals, function($p) use ($city, $service, $availability) {
    if (!$p['is_active']) return false;

    // City filter
    if ($city && stripos($p['profile']['location']['city'], $city) === false) {
        return false;
    }

    // Service filter
    if ($service && !in_array($service, $p['profile']['services'])) {
        return false;
    }

    // Availability filter
    if ($availability && empty($p['profile']['availability'][$availability])) {
        return false;
    }

    // Basic completion check (require name)
    if (empty($p['profile']['first_name']) || empty($p['profile']['last_name'])) {
        return false;
    }

    return true;
});

// Map to public view
$public_results = array_map(function($p) {
    return [
        'id' => $p['id'],
        'first_name' => $p['profile']['first_name'],
        'last_name' => $p['profile']['last_name'],
        'photo' => $p['profile']['photo'],
        'city' => $p['profile']['location']['city'],
        'province' => $p['profile']['location']['province'],
        'bio' => $p['profile']['bio'],
        'services' => $p['profile']['services'],
        'rates' => $p['profile']['rates'],
        'availability' => $p['profile']['availability'],
        'phone' => $p['profile']['phone'],
        'email' => $p['profile']['contact_email'],
        'monthly_discount' => $p['profile']['monthly_discount'] ?? false
    ];
}, array_values($results));

jsonResponse($public_results);
?>
