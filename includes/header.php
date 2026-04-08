<?php
require_once __DIR__ . '/../config/constants.php';
require_once __DIR__ . '/functions.php';
startSession();
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME; ?></title>
    <link rel="stylesheet" href="../../assets/css/main.css">
    <link rel="stylesheet" href="../../assets/css/components.css">
    <?php if (isset($extra_css)): foreach ($extra_css as $css): ?>
        <link rel="stylesheet" href="../../assets/css/<?php echo $css; ?>.css">
    <?php endforeach; endif; ?>
</head>
<body>
    <header>
        <nav class="container">
            <div class="logo">
                <a href="../../pages/public/index.php"><?php echo APP_NAME; ?></a>
            </div>
            <ul class="nav-links">
                <li><a href="../../pages/public/index.php">Cerca Professionisti</a></li>
                <?php if (isLoggedIn()): ?>
                    <li><a href="../../pages/dashboard/index.php">Dashboard</a></li>
                    <li><a href="#" id="logout-btn">Logout</a></li>
                <?php else: ?>
                    <li><a href="../../pages/auth/login.php">Accedi</a></li>
                    <li><a href="../../pages/auth/register.php" class="btn btn-primary">Registrati</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main class="container">
