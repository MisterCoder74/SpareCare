<?php
// Global Constants
define('APP_NAME', 'SpareCare');
define('BASE_PATH', dirname(__DIR__));
define('DATA_PATH', BASE_PATH . '/data');
define('UPLOADS_PATH', BASE_PATH . '/assets/images/uploads');
define('UPLOAD_URL', '/assets/images/uploads');

// Default Services
define('DEFAULT_SERVICES', [
    'assistenza_anziani' => 'Assistenza Anziani',
    'assistenza_disabili' => 'Assistenza Disabili',
    'baby_sitting' => 'Baby Sitting',
    'colf' => 'Collaboratore Domestico',
    'badante' => 'Badante',
    'fisioterapia' => 'Fisioterapia a domicilio',
    'infermieristica' => 'Assistenza Infermieristica'
]);

// Availability Options
define('AVAILABILITY_OPTIONS', [
    'morning' => 'Mattina',
    'afternoon' => 'Pomeriggio',
    'evening' => 'Sera',
    'night' => 'Notte',
    'weekend' => 'Weekend',
    'holidays' => 'Festivi'
]);
?>
