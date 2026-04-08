<?php
require_once __DIR__ . '/../../includes/header.php';
if (isLoggedIn()) redirect('/pages/dashboard/index.php');
?>

<div class="card" style="max-width: 500px; margin: 2rem auto;">
    <h2>Accedi a SpareCare</h2>
    <form id="login-form">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Accedi</button>
    </form>
    <p style="margin-top: 1rem;">Non hai un account? <a href="register.php">Registrati qui</a></p>
</div>

<?php 
$extra_js = ['auth'];
require_once __DIR__ . '/../../includes/footer.php'; 
?>
