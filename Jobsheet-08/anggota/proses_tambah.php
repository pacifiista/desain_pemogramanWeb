<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

$nama = trim($_POST['nama'] ?? '');
$noAnggota = trim($_POST['no_anggota'] ?? '');
$alamat = trim($_POST['alamat'] ?? '');
$noHp = trim($_POST['no_hp'] ?? '');

$errors = [];
if ($nama === '') {
    $errors[] = "Nama wajib diisi.";
} elseif (strlen($nama) < 3) {
    $errors[] = "Nama minimal harus 3 karakter.";
}

if ($noAnggota === '') {
    $errors[] = "No. Anggota wajib diisi.";
}
// Catatan: cek duplikasi manual (foreach $_SESSION['anggota'], jobsheet-07
// Tugas 37) DIHAPUS -- sekarang diserahkan ke batasan UNIQUE di database.
// Coba isi no_anggota yang sama dua kali untuk lihat sendiri error mentahnya.

if ($noHp !== '') {
    $cleanHp = preg_replace('/[^0-9]/', '', $noHp);
    if (!preg_match('/^[0-9+\s-]+$/', $noHp) || strlen($cleanHp) < 9 || strlen($cleanHp) > 15) {
        $errors[] = "No. HP tidak valid (harus berupa nomor telepon 9-15 digit).";
    }
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: tambah.php');
    exit;
}

$stmt = $pdo->prepare(
    "INSERT INTO anggota (nama, no_anggota, alamat, no_hp)
     VALUES (:nama, :no_anggota, :alamat, :no_hp)
     RETURNING id"
);
$stmt->execute([
    'nama' => $nama,
    'no_anggota' => $noAnggota,
    'alamat' => $alamat,
    'no_hp' => $noHp,
]);

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Anggota berhasil ditambahkan.'];
header('Location: list.php');
exit;