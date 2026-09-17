console.log("File app.js berhasil dimuat");

// === Helper: Fungsi Counter Jumlah Baris Tabel ===
function updateTableCounter() {
    const counterElement = document.getElementById("table-counter");
    const totalRows = document.querySelectorAll("tbody tr");

    if (!counterElement || totalRows.length === 0) return;

    let visibleCount = 0;
    totalRows.forEach(function (row) {
        if (row.style.display !== "none") {
            visibleCount++;
        }
    });

    counterElement.textContent = `Menampilkan ${visibleCount} dari ${totalRows.length} buku`;
}

// === 1. Hamburger Menu ===
function initNavToggle() {
    const navToggleBtn = document.getElementById("nav-toggle-btn");
    const navMenu = document.querySelector("header nav");

    if (navToggleBtn && navMenu) {
        navToggleBtn.addEventListener("click", function () {
            navMenu.classList.toggle("active");
        });
    }
}

// === 2. Konfirmasi Hapus + Update Counter ===
function initHapusKonfirmasi() {
    document.querySelectorAll(".btn-hapus").forEach(function (btn) {
        btn.addEventListener("click", function () {
            const row = btn.closest("tr");
            const nama = row ? row.querySelector("td").textContent : "data ini";
            const yakin = confirm("Apakah Anda yakin ingin menghapus " + nama + " ?");
            if (yakin && row) {
                row.remove();
                updateTableCounter(); // Update angka counter setelah baris dihapus
            }
        });
    });
}

// === 3. Filter Tabel Real-Time (Khusus Kolom Judul) + Counter ===
function initFilterTabel() {
    const searchInput = document.getElementById("search-input");
    const tableRows = document.querySelectorAll("tbody tr");

    if (searchInput && tableRows.length > 0) {
        // Tampilkan counter saat halaman pertama kali dibuka
        updateTableCounter();

        searchInput.addEventListener("input", function () {
            const query = searchInput.value.toLowerCase().trim();

            tableRows.forEach(function (row) {
                // Ambil elemen td pertama (kolom Judul)
                const titleCell = row.querySelector("td");

                if (titleCell) {
                    const titleText = titleCell.textContent.toLowerCase();

                    if (titleText.includes(query)) {
                        row.style.display = ""; // Tampilkan baris
                    } else {
                        row.style.display = "none"; // Sembunyikan baris
                    }
                }
            });

            // Update counter setiap kali mengetik pencarian
            updateTableCounter();
        });
    }
}

// === 4. Validasi Form ===
function tampilanError(input, pesan) {
    hapusEror(input);
    const span = document.createElement("span");
    span.className = "error-message";
    span.textContent = pesan;
    input.insertAdjacentElement("afterend", span);
}

function hapusEror(input) {
    const error = input.nextElementSibling;
    if (error && error.classList.contains("error-message")) {
        error.remove();
    }
}

function initFormValidasi() {
    const formTambah = document.getElementById("form-tambah");

    if (formTambah) {
        formTambah.addEventListener("submit", function (e) {
            let hasError = false;

            // 1. Daftar field yang wajib diisi (Array Config)
            const requiredFields = [
                { id: "judul", pesan: "Judul buku wajib diisi" },
                { id: "pengarang", pesan: "Nama pengarang wajib diisi" },
                { id: "tahun", pesan: "Tahun terbit wajib diisi" },
                { id: "stok", pesan: "Jumlah stok wajib diisi" },
                { id: "kategori", pesan: "Pilih salah satu kategori" }
            ];

            // 2. Loop perulangan forEach untuk validasi field wajib
            requiredFields.forEach(function (field) {
                const inputElement = document.getElementById(field.id);
                if (inputElement) {
                    if (!inputElement.value.trim()) {
                        tampilanError(inputElement, field.pesan);
                        hasError = true;
                    } else {
                        hapusEror(inputElement);
                    }
                }
            });

            // 3. Validasi Khusus: Format ISBN (Pengecekan terpisah karena opsional/spesifik)
            const isbn = document.getElementById("isbn");
            if (isbn) {
                const isbnVal = isbn.value.trim();
                const isbnRegex = /^[0-9-]+$/;

                if (isbnVal !== "" && !isbnRegex.test(isbnVal)) {
                    tampilanError(isbn, "ISBN hanya boleh berisi angka dan tanda hubung (-)");
                    hasError = true;
                } else {
                    hapusEror(isbn);
                }
            }

            // Hentikan submit form jika ada error
            if (hasError) {
                e.preventDefault();
            }
        });
    }
}
// function initFormValidasi() {
//     const formTambah = document.getElementById("form-tambah");

//     if (formTambah) {
//         formTambah.addEventListener("submit", function (e) {
//             let hasError = false;

//             const judul = document.getElementById("judul");
//             const pengarang = document.getElementById("pengarang");
//             const tahun = document.getElementById("tahun");
//             const isbn = document.getElementById("isbn");
//             const stok = document.getElementById("stok");
//             const kategori = document.getElementById("kategori");

//             // 1. Validasi Judul
//             if (!judul.value.trim()) {
//                 tampilanError(judul, "Judul buku wajib diisi");
//                 hasError = true;
//             } else {
//                 hapusEror(judul);
//             }

//             // 2. Validasi Pengarang
//             if (!pengarang.value.trim()) {
//                 tampilanError(pengarang, "Nama pengarang wajib diisi");
//                 hasError = true;
//             } else {
//                 hapusEror(pengarang);
//             }

//             // 3. Validasi Tahun
//             if (!tahun.value.trim()) {
//                 tampilanError(tahun, "Tahun terbit wajib diisi");
//                 hasError = true;
//             } else {
//                 hapusEror(tahun);
//             }

//             // 4. Validasi ISBN
//             if (isbn) {
//                 const isbnVal = isbn.value.trim();
//                 const isbnRegex = /^[0-9-]+$/;

//                 if (isbnVal !== "" && !isbnRegex.test(isbnVal)) {
//                     tampilanError(isbn, "ISBN hanya boleh berisi angka dan tanda hubung (-)");
//                     hasError = true;
//                 } else {
//                     hapusEror(isbn);
//                 }
//             }

//             // 5. Validasi Stok
//             if (!stok.value.trim()) {
//                 tampilanError(stok, "Jumlah stok wajib diisi");
//                 hasError = true;
//             } else {
//                 hapusEror(stok);
//             }

//             // 6. Validasi Kategori
//             if (!kategori.value) {
//                 tampilanError(kategori, "Pilih salah satu kategori");
//                 hasError = true;
//             } else {
//                 hapusEror(kategori);
//             }

//             // Hentikan submit jika ada error
//             if (hasError) {
//                 e.preventDefault();
//             }
//         });
//     }
// }

// === Entry Point ===
document.addEventListener("DOMContentLoaded", function () {
    initNavToggle();
    initHapusKonfirmasi();
    initFilterTabel();
    initFormValidasi();
});