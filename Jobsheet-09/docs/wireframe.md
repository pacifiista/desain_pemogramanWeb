# 6.3 latihan jobsheet 4

## 1. Pembayangan visual Wireframe ke tampilan Nyata
    - **Header/Navbar** (SIMPUS - Mini) : Berada di posisi paling atas dengan latar belakang warna biru tema #1d5b8a, teks putih, dan tata letak sejajar horizontal menggunakan Flexbox (justify-content: space-between).
    - **Kartu Form** ( [Login Petugas], [Peminjaman Baru] ): Dibungkus dalam kotak elemen <section> berbentuk kartu putih (card) berujung tumpul (border-radius) dengan bayangan halus (box-shadow) di atas latar belakang abu-abu terang.
    - **Form Field** (Username, Password, Pilih Anggota): Label ditampilkan dengan teks tebal (bold) di atas kotak input (<label>), sedangkan elemen <input> memiliki border rapi dengan efek focus saat diklik.
    - **Tombol** ( [ Masuk ], [ Simpan ] ) : Berwarna dasar biru #1d5b8a dengan teks putih, padding yang nyaman diklik, dan berubah warna sedikit lebih gelap (hover) saat kursor diarahkan ke atasnya.

## 2. Penelusuran Langkah demi Langkah User Flow Peminjaman
    - Kotak [Petugas Login] : halaman login dengan aksi Petugas memasukkan username & password, lalu menekan tombol [ Masuk ]
    - Kotak [ Dashboard ] : Halaman uatama Petugas dengan aksi Petugas mengklik tombol + Peminjaman Baru pada bagian aksi cepat
    - Kotak [Pilih Anggota] & [Pilih Buku (stok > 0)]:
    halaman Form Peminjaman buku dengan aksi Petugas memilih nama anggota peminjam dari daftar, lalu memilih judul buku. Jika buku dengan stok 0 maka tidak dapat dipilih.
    - Kotak [ Simpan ] : Petugas menekan tombol [ Simpan ]. Di balik layar (backend logic), sistem mencatat transaksi baru dan secara otomatis.
    - Kotak [ Kembali ke Dashboard ] : Halaman dashboard Petugas dengan aksi Sistem menampilkan pesan sukses dan memperbarui tabel Transaksi Terbaru serta statistik buku yang sedang dipinjam.

## 3. Analisis Perbandingan: index.html (Jalan) vs Wireframe Dashboard Petugas
    - Navbar/Header : Logo/Judul SIMPUS-Mini, struktur <header>, menu Beranda, Buku, dan Anggota. Penambahan menu baru Peminjaman serta indikator status login di sebelah kanan: (Nama Petugas) Logout.
    - Kartu Statisstik : Menggunakan CSS Grid yang sama untuk menampilkan Total Buku dan Total Anggota. Penambahan kartu statistik baru: [Sedang Dipinjam] untuk memantau sirkulasi buku aktif.
    - Konten Utama : Penggunaan pembungkus <main> dan gaya kartu <section> bernuansa putih. Penambahan section Aksi Cepat (Tombol + Peminjaman Baru & + Pengembalian) serta tabel Transaksi Terbaru.

# 6.4 Latihan Opsional Jobsheet 4

##	1. Gambar wireframe halaman Registrasi Anggota Baru
    
```text
+---------------------------------------+
|             SIMPUS MINI               |
|---------------------------------------|
|                                       |
|     [ Registrasi Anggota Baru]        |
|                                       |
|   Nama Lengkap : [______________]     |
|   Nim          : [______________]     |
|   Email        : [______________]     |
|   No Telp      : [______________]     |
|                                       |
|           [ DaftarSekarang ]          |
|                                       |
|    Belum punya akun? Daftar disini    |
|                                       |
+---------------------------------------+
```

## 2. User Flow: Mencari Anggota Menunggak Jatuh Tempo
    [Petugas Login] > [Dasboard Petugas] > [Pilih Menu "Riwayat / Transaksi"]
        > [Filter / Mencari Status: "Terlambat / Menunggak" ]
        > [Sistem Menampilkan Daftar Anggota & Detail Denda]
        > [Pilih Aksi "Kirim Pengingat" / "Lihat Detail Anggota"]
        > [Selesai / Kembali ke Dashboard]

## 3. Analisis Edge Case Tambahan
    - Skenario khusus : Petugas mencoba meminjamkan buku yang sama ke anggota yang sama dua kali berturut-turut, padahal status peminjaman buku tersebut sebelumnya belum dikembalikan.
    - Potensi Masalah : Terjadi duplikasi data transaksi aktif (duplicate active loan) serta pengurangan stok buku yang tidak valid.
    - Solusi : Sebelum transaksi disimpan, sistem melakukan pengecekan validasi apakah kombinasi (ID Anggota + ID Buku) masih tercatat aktif di tabel peminjaman. Jika transaksi masih aktif, sistem akan menolak penyimpanan data baru dan memunculkan notifikasi peringatan:
    ` "Anggota ini sedang meminjam buku tersebut dan belum mengembalikannya." `

## 4 

