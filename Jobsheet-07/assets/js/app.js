// ===== Hamburger menu (JS-driven, menggantikan checkbox hack) =====
function initNavToggle() {
    const toggleBtn = document.getElementById("nav-toggle-btn");
    const nav = document.querySelector("header nav");
    if (!toggleBtn || !nav) return;

    toggleBtn.addEventListener("click", function () {
        nav.classList.toggle("nav-open");
    });
}

// ===== Konfirmasi hapus (front-end only, belum ke server) =====
function initHapusConfirm() {
    document.addEventListener("click", function (e) {
        console.log("Elemen yang diklik (e.target): ", e.target);
        const btn = e.target.closest(".btn-hapus");
        if (!btn) return;

        const row = btn.closest("tr");
        const nama = row ? row.querySelector("td")?.textContent : "data ini";
        const yakin = confirm("Yakin ingin menghapus \"" + nama + "\"?");

    });
}

// ===== Filter/pencarian tabel real-time =====
function initTableFilter() {
    const input = document.getElementById("search-input");
    const table = document.querySelector(".table-responsive table");
    if (!input || !table) return;

    input.addEventListener("keyup", function () {
        const keyword = input.value.toLowerCase();
        const rows = table.querySelectorAll("tbody tr");
        rows.forEach(function (row) {
            const teks = row.textContent.toLowerCase();
            row.style.display = teks.includes(keyword) ? "" : "none";
        });
    });
}

// ===== Validasi form (client-side) =====
function tampilkanError(input, pesan) {
    hapusError(input);
    const span = document.createElement("span");
    span.className = "error error-message";
    span.textContent = pesan;
    input.insertAdjacentElement("afterend", span);
}

function hapusError(input) {
    const next = input.nextElementSibling;
    if (next && (next.classList.contains("error") || next.classList.contains("error-message"))) {
        next.remove();
    }
}

function initValidasiForm() {
    const form = document.getElementById("form-tambah");
    if (!form) return;

    form.addEventListener("submit", function (e) {
        let valid = true;

        // Validasi Judul (Buku)
        const judul = form.querySelector("[name='judul']");
        if (judul && judul.value.trim() === "") {
            tampilkanError(judul, "Judul wajib diisi.");
            valid = false;
        } else if (judul) {
            hapusError(judul);
        }

        // Validasi Pengarang (Buku)
        const pengarang = form.querySelector("[name='pengarang']");
        if (pengarang && pengarang.value.trim() === "") {
            tampilkanError(pengarang, "Pengarang wajib diisi.");
            valid = false;
        } else if (pengarang) {
            hapusError(pengarang);
        }

        // Validasi Tahun (Buku)
        const tahun = form.querySelector("[name='tahun']");
        if (tahun) {
            const nilai = parseInt(tahun.value, 10);
            if (tahun.value.trim() === "" || isNaN(nilai) || nilai < 1900 || nilai > 2026) {
                tampilkanError(tahun, "Tahun harus di antara 1900-2026.");
                valid = false;
            } else {
                hapusError(tahun);
            }
        }

        // Validasi Stok (Buku)
        const stok = form.querySelector("[name='stok']");
        if (stok) {
            const nilai = parseInt(stok.value, 10);
            if (stok.value.trim() === "" || isNaN(nilai) || nilai < 0) {
                tampilkanError(stok, "Stok tidak boleh negatif.");
                valid = false;
            } else {
                hapusError(stok);
            }
        }

        // Validasi ISBN (Buku - Tugas 36)
        const isbn = form.querySelector("[name='isbn']");
        if (isbn && isbn.value.trim() !== "") {
            if (!/^[0-9-]+$/.test(isbn.value.trim())) {
                tampilkanError(isbn, "ISBN hanya boleh berisi angka dan tanda hubung (-).");
                valid = false;
            } else {
                hapusError(isbn);
            }
        } else if (isbn) {
            hapusError(isbn);
        }

        // Validasi Nama (Anggota - Tugas 37)
        const nama = form.querySelector("[name='nama']");
        if (nama && nama.value.trim() === "") {
            tampilkanError(nama, "Nama wajib diisi.");
            valid = false;
        } else if (nama && nama.value.trim().length < 3) {
            tampilkanError(nama, "Nama minimal harus 3 karakter.");
            valid = false;
        } else if (nama) {
            hapusError(nama);
        }

        // Validasi No. Anggota (Anggota - Tugas 37)
        const noAnggota = form.querySelector("[name='no_anggota']");
        if (noAnggota && noAnggota.value.trim() === "") {
            tampilkanError(noAnggota, "No. Anggota wajib diisi.");
            valid = false;
        } else if (noAnggota) {
            hapusError(noAnggota);
        }

        // Validasi No. HP (Anggota - Tugas 37)
        const noHp = form.querySelector("[name='no_hp']");
        if (noHp && noHp.value.trim() !== "") {
            const cleaned = noHp.value.replace(/[^0-9]/g, "");
            if (!/^[0-9+\s-]+$/.test(noHp.value.trim()) || cleaned.length < 9 || cleaned.length > 15) {
                tampilkanError(noHp, "No. HP tidak valid (harus berupa nomor telepon 9-15 digit).");
                valid = false;
            } else {
                hapusError(noHp);
            }
        } else if (noHp) {
            hapusError(noHp);
        }

        if (!valid) {
            e.preventDefault();
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    initNavToggle();
    initHapusConfirm();
    initTableFilter();
    initValidasiForm();
});