<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/csrf.php';
require __DIR__ . '/../includes/koneksi.php';

csrf_verify();

$id = $_POST['id'] ?? null;
$nama = trim($_POST['nama'] ?? '');
$email = trim($_POST['email'] ?? '');
$telepon = trim($_POST['telepon'] ?? '');
$alamat = trim($_POST['alamat'] ?? '');

if (!$id) {
    header('Location: list.php');
    exit;
}

if ($nama === '' || $email === '' || $telepon === '' || $alamat === '') {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Semua data wajib diisi.'];
    header('Location: edit.php?id=' . urlencode($id));
    exit;
}

$stmt = $pdo->prepare(
    "UPDATE anggota SET nama = :nama, email = :email, telepon = :telepon, alamat = :alamat WHERE id = :id"
);

$stmt->execute([
    'nama' => $nama,
    'email' => $email,
    'telepon' => $telepon,
    'alamat' => $alamat,
    'id' => $id,
]);

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data anggota berhasil diperbarui.'];
header('Location: list.php');
exit;
?>