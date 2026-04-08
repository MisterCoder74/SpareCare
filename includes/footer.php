    </main>
    <footer class="container">
        <p>&copy; <?php echo date('Y'); ?> <?php echo APP_NAME; ?>. Tutti i diritti riservati.</p>
    </footer>
    <script src="../../assets/js/utils.js"></script>
    <script src="../../assets/js/auth.js"></script>
    <?php if (isset($extra_js)): foreach ($extra_js as $js): ?>
        <script src="../../assets/js/<?php echo $js; ?>.js"></script>
    <?php endforeach; endif; ?>
</body>
</html>
