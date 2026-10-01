<?php
// Tugas Opsional 39: Menghapus / Mengosongkan Seluruh $_SESSION menggunakan session_destroy()
// Sesuai standar resmi dokumentasi PHP (php.net/manual/en/function.session-destroy.php)

session_start();

// 1. Kosongkan semua data dalam array superglobal $_SESSION
$_SESSION = [];

// 2. Jika sesi menggunakan cookie, hapus cookie sesi dari browser
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// 3. Hancurkan sesi di server
session_destroy();

// 4. Buka sesi baru yang bersih khusus untuk mengirimkan flash message konfirmasi
session_start();
$_SESSION['flash'] = [
    'type' => 'success',
    'pesan' => 'Semua data sesi berhasil di-reset dengan session_destroy().'
];

// 5. Alihkan pengguna kembali ke halaman Beranda
header('Location: index.php');
exit;
