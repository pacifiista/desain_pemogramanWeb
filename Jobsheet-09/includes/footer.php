</main>

    <footer>
        <p>&copy; 2026 SIMPUS-Mini &mdash; Jobsheet 7</p>
    </footer>

    <!-- Script Utama -->
    <script src="<?php echo $base; ?>assets/js/app.js"></script>

    <!-- Script Tambahan Per Halaman (misal: buku.js) -->
    <?php if (!empty($extra_scripts) && is_array($extra_scripts)): ?>
        <?php foreach ($extra_scripts as $src): ?>
            <script src="<?php echo $src; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>