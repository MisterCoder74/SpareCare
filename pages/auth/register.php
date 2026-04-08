<?php
require_once __DIR__ . '/../../includes/header.php';
if (isLoggedIn()) redirect('../dashboard/index.php');
?>

<div class="card" style="max-width: 500px; margin: 2rem auto;">
    <h2>Registrazione Professionista</h2>
    <form id="register-form">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="confirm_password">Conferma Password</label>
            <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Registrati</button>
    </form>
    <p style="margin-top: 1rem;">Hai già un account? <a href="login.php">Accedi qui</a></p>
</div>

<?php 
$extra_js = ['auth'];
require_once __DIR__ . '/../../includes/footer.php'; 
?>
