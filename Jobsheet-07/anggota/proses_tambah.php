<?php
session_start();

$nama = trim($_POST['nama'] ?? '');
$noAnggota = trim($_POST['no_anggota'] ?? '');
$alamat = trim($_POST['alamat'] ?? '');
$noHp = trim($_POST['no_hp'] ?? '');

$errors = [];
// Validasi Nama
if ($nama === '') {
    $errors[] = "Nama wajib diisi.";
} elseif (strlen($nama) < 3) {
    $errors[] = "Nama minimal harus 3 karakter.";
}

// Validasi No. Anggota
if ($noAnggota === '') {
    $errors[] = "No. Anggota wajib diisi.";
} else {
    // Tugas 37: Cek duplikasi No. Anggota di $_SESSION
    if (!empty($_SESSION['anggota'])) {
        foreach ($_SESSION['anggota'] as $item) {
            if ($item['no_anggota'] === $noAnggota) {
                $errors[] = "No. Anggota '$noAnggota' sudah terdaftar.";
                break;
            }
        }
    }
}

// Tugas 37: Validasi No. HP jika diisi
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

if (!isset($_SESSION['anggota'])) {
    $_SESSION['anggota'] = [];
}

$_SESSION['anggota'][] = [
    'nama' => $nama,
    'no_anggota' => $noAnggota,
    'alamat' => $alamat,
    'no_hp' => $noHp,
];

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Anggota berhasil ditambahkan.'];
header('Location: list.php');
exit;