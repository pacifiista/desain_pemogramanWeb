<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../includes/koneksi.php';
require_once __DIR__ . '/../includes/csrf.php'; // 1. Require CSRF

// 2. Verifikasi Token CSRF
csrf_verify();

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
    unset($_SESSION['failed_login']);

    // 3. Regenerasi ID Session (Session Fixation Protection)
    session_regenerate_id(true);

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['nama'] = $user['nama'];
    $_SESSION['role'] = $user['role'];

    // Cek apakah opsi Remember Me dicentang
    if (isset($_POST['remember'])) {
        setcookie('user_token', $user['username'], time() + (86400 * 30), "/", "", false, true);
    }

    header('Location: ../index.php');
    exit;
}

// JIKA LOGIN GAGAL (Username/Password salah):
$_SESSION['failed_login'] = ($_SESSION['failed_login'] ?? 0) + 1;

$_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Username atau password salah.'];
header('Location: login.php');
exit;