// Latihan 8.4 #2: Fungsi generik pengganti muatDaftarBuku()/muatDaftarAnggota()
// yang tadinya ditulis terpisah meski strukturnya identik (lihat bab 5 §5.4).
// Sekarang cukup satu fungsi yang menerima:
//   - urlJson       : path fetch ke file JSON (mis. "../data/buku.json")
//   - kolom         : array nama kunci objek, sesuai urutan kolom tabel
//                     (mis. ["judul", "pengarang", "tahun", "stok"])
//   - colspanError  : jumlah kolom (termasuk kolom Aksi) untuk baris error
async function muatDaftarData(opsi) {
    const { urlJson, kolom, colspanError } = opsi;

    const tbody = document.querySelector(".table-responsive table tbody");
    const loading = document.getElementById("loading-indicator");

    if (!tbody) return;

    loading.style.display = "block";
    tbody.innerHTML = "";

    try {
        await new Promise((resolve) => setTimeout(resolve, 3000));

        const res = await fetch(urlJson);

        if (!res.ok) {
            throw new Error("Gagal mengambil data (status " + res.status + ")");
        }

        const daftar = await res.json();

        daftar.forEach(function (item) {
            const tr = document.createElement("tr");

            // Bangun satu <td> untuk setiap kunci di parameter "kolom",
            // urutannya menentukan urutan kolom yang tampil di tabel.
            let isiBaris = "";
            kolom.forEach(function (kunci) {
                isiBaris += "<td>" + item[kunci] + "</td>";
            });
            isiBaris +=
                "<td>" +
                "<button type=\"button\">Edit</button> " +
                "<button type=\"button\" class=\"btn-hapus\">Hapus</button>" +
                "</td>";

            tr.innerHTML = isiBaris;
            tbody.appendChild(tr);
        });
    } catch (err) {
        tbody.innerHTML =
            "<tr><td colspan=\"" + colspanError + "\">Gagal memuat data: " + err.message + "</td></tr>";
    } finally {
        loading.style.display = "none";
    }
}