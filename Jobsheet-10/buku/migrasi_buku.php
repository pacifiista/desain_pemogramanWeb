<?php
// 1. Panggil koneksi database (mundur 1 folder ke includes)
require __DIR__ . '/../includes/koneksi.php';

// 2. Baca file JSON yang ada di folder yang sama
$jsonString = file_get_contents('buku.json'); 
$data = json_decode($jsonString, true);

// 3. Siapkan query PostgreSQL
$sql = "INSERT INTO buku (judul, pengarang, tahun, isbn, stok, kategori) 
        VALUES (:judul, :pengarang, :tahun, :isbn, :stok, :kategori)";
$stmt = $pdo->prepare($sql);

$sukses = 0;
foreach ($data as $b) {
    $stmt->execute([
        ':judul' => $b['judul'],
        ':pengarang' => $b['pengarang'],
        ':tahun' => $b['tahun'],
        ':isbn' => $b['isbn'] ?? '000-00', // Sediakan default jika di json tidak ada
        ':stok' => $b['stok'] ?? 1,
        ':kategori' => $b['kategori'] ?? 'Lainnya'
    ]);
    $sukses++;
}
echo "Migrasi berhasil: $sukses data buku dipindahkan ke PostgreSQL.";
?>