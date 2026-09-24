<?php
$page_title = "Beranda";
include __DIR__ . '/includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$totalBuku = count($_SESSION['buku'] ?? []);
$totalAnggota = count($_SESSION['anggota'] ?? []);
?>
        <section>
            <h2>Selamat Datang di Sistem Perpustakaan Mini</h2>
            <p>Aplikasi sederhana untuk mengelola data buku dan anggota perpustakaan.</p>

            <?php if ($flash): ?>
                <p class="flash flash-<?php echo $flash['type']; ?>" style="margin-top: 1rem;"><?php echo $flash['pesan']; ?></p>
            <?php endif; ?>
        </section>

        <section>
            <h2>Ringkasan</h2>
            <article>
                <h3>Total Buku</h3>
                <p><?php echo $totalBuku; ?></p>
            </article>
            <article>
                <h3>Total Anggota</h3>
                <p><?php echo $totalAnggota; ?></p>
            </article>
            <article>
                <h3>Sedang Dipinjam</h3>
                <p>0</p>
            </article>
        </section>

        <section>
            <h2>Alat Sesi (Tugas Tambahan)</h2>
            <p style="margin-bottom: 1rem; color: #555;">
                Gunakan tombol di bawah untuk menguji penghapusan sesi menggunakan <code>session_destroy()</code> atau memeriksa data mentah sesi server.
            </p>
            <div style="display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap;">
                <form method="post" action="<?php echo $base; ?>reset_session.php" onsubmit="return confirm('Apakah kamu yakin ingin mengosongkan seluruh data sesi (session_destroy)?');" style="margin: 0;">
                    <button type="submit" class="btn-danger">Reset Data Sesi (Tugas 39)</button>
                </form>
                <a href="<?php echo $base; ?>debug_session.php" style="display: inline-block; padding: 0.6rem 1.2rem; background-color: #55677a; color: #fff; border-radius: 4px; font-weight: 600;">Lihat Debug Session (Tugas 38)</a>
            </div>
        </section>
<?php include __DIR__ . '/includes/footer.php'; ?>