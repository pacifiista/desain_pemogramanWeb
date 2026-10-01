<?php
require __DIR__ . '/../includes/auth.php';
$page_title = "Edit Anggota";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: list.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM anggota WHERE id = :id");
$stmt->execute(['id' => $id]);
$anggota = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$anggota) {
    header('Location: list.php');
    exit;
}
?>
<section>
    <h2>Edit Anggota</h2>
    <?php if ($flash): ?>
        <p style="color: red;"><?php echo $flash['pesan']; ?></p>
    <?php endif; ?>
    
    <form id="form-tambah" method="post" action="proses_edit.php">
        <input type="hidden" name="id" value="<?php echo $anggota['id']; ?>">
        <p>
            <label for="nama">Nama</label><br>
            <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($anggota['nama']); ?>" required>
        </p>
        <p>
            <label for="email">Email</label><br>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($anggota['email']); ?>" required>
        </p>
        <p>
            <label for="telepon">Telepon</label><br>
            <input type="text" id="telepon" name="telepon" value="<?php echo htmlspecialchars($anggota['telepon']); ?>" required>
        </p>
        <p>
            <label for="alamat">Alamat</label><br>
            <textarea id="alamat" name="alamat" rows="3" required><?php echo htmlspecialchars($anggota['alamat']); ?></textarea>
        </p>
        <p>
            <button type="submit">Simpan Perubahan</button>
        </p>
    </form>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>