<?php
$page_title = "Debug Session";
include __DIR__ . '/includes/header.php';
?>
        <section>
            <h2>Debug Isi $_SESSION (Tugas Opsional 38)</h2>
            <p style="margin-bottom: 1rem; color: #555;">
                Halaman ini digunakan untuk mengintip isi mentah dari variabel superglobal <code>$_SESSION</code> 
                yang saat ini tersimpan di server untuk sesi browsermu.
            </p>

            <pre class="debug-box"><?php print_r($_SESSION); ?></pre>

            <div style="margin-top: 1.5rem; display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap;">
                <a href="<?php echo $base; ?>index.php" style="display: inline-block; padding: 0.55rem 1rem; background-color: #8b4b62; color: #fff; border-radius: 4px; font-weight: 500;">&larr; Kembali ke Beranda</a>
                <form method="post" action="<?php echo $base; ?>reset_session.php" onsubmit="return confirm('Yakin ingin mereset seluruh data sesi?');" style="margin: 0;">
                    <button type="submit" class="btn-danger">Reset Data Sesi</button>
                </form>
            </div>
        </section>
<?php include __DIR__ . '/includes/footer.php'; ?>
