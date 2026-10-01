<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../includes/koneksi.php';

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

// 1. Cek batas percobaan gagal (Brute-force protection) SEBELUM query database
if (($_SESSION['failed_login'] ?? 0) >= 3) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Terlalu banyak percobaan gagal! Silakan tunggu beberapa saat.'];
    header('Location: login.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
$stmt->execute(['username' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    // JIKA LOGIN BERHASIL:
    // Reset kembali hitungan gagal login
    unset($_SESSION['failed_login']);

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['nama'] = $user['nama'];
    $_SESSION['role'] = $user['role'];

    // 2. PINDAHKAN KODE INI KE SINI: Cek apakah opsi Remember Me dicentang
    if (isset($_POST['remember'])) {
        // Mengatur cookie aman yang berlaku selama 30 hari
        setcookie('user_token', $user['username'], time() + (86400 * 30), "/", "", false, true);
    }

    header('Location: ../index.php');
    exit;
}

// JIKA LOGIN GAGAL (Username/Password salah):
// Tambah jumlah kesalahan login sebanyak 1
$_SESSION['failed_login'] = ($_SESSION['failed_login'] ?? 0) + 1;

$_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Username atau password salah.'];
header('Location: login.php');
exit;