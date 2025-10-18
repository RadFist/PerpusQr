$("#toggleSidebar").on("click", function () {
    $("#sidebar").toggleClass("active");
});

//qr code scanner

let html5QrCode;
let currentMode = "buku"; // default mode

// === Ganti Mode ===
$("#mode-buku").click(function () {
    currentMode = "buku";
    $("#scan-mode-label").text("(Buku)");
    $("#mode-text").text("Buku");
    $(this).addClass("active");
    $("#mode-anggota").removeClass("active");
});

$("#mode-anggota").click(function () {
    currentMode = "anggota";
    $("#scan-mode-label").text("(Anggota)");
    $("#mode-text").text("Anggota");
    $(this).addClass("active");
    $("#mode-buku").removeClass("active");
});

// === Modal ditampilkan ===
$("#scannerModal").on("shown.bs.modal", function () {
    if (!html5QrCode) {
        html5QrCode = new Html5Qrcode("reader");
    }

    Html5Qrcode.getCameras()
        .then((devices) => {
            if (devices && devices.length) {
                const cameraId = devices[0].id;

                html5QrCode.start(
                    cameraId,
                    { fps: 10, qrbox: 250 },
                    (qrCodeMessage) => {
                        if (currentMode === "buku") {
                            $("#scan-result-buku").val(qrCodeMessage);
                        } else {
                            $("#scan-result-anggota").val(qrCodeMessage);
                        }
                    },
                    (errorMessage) => {}
                );
            }
        })
        .catch((err) => console.error("Tidak bisa mengakses kamera:", err));
});

// === Modal ditutup ===
$("#scannerModal").on("hidden.bs.modal", function () {
    if (html5QrCode) {
        html5QrCode
            .stop()
            .catch((err) => console.error("Gagal stop kamera:", err));
    }
});

// === Submit hasil scan ===
$("#submit-scan").click(function () {
    const hasilBuku = $("#scan-result-buku").val();
    const hasilAnggota = $("#scan-result-anggota").val();
    if (!hasilBuku && !hasilAnggota) {
        alert("Belum ada hasil scan!");
        return;
    }

    // Contoh: masukkan ke input form di luar modal
    if (!hasilBuku || !hasilAnggota) {
        alert("Scan belum lengkap!");
        return;
    }

    const data = [hasilAnggota, hasilBuku];

    const modal = bootstrap.Modal.getInstance(
        document.getElementById("scannerModal")
    );
    modal.hide();
    fecthData(data);
});

async function fecthData(data) {
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute("content");

    if (!csrfToken) {
        console.error("CSRF token tidak ditemukan!");
        return;
    }

    const loadingModal = new bootstrap.Modal(
        document.getElementById("loadingModal")
    );
    try {
        loadingModal.show();

        const response = await fetch("/API/borrow/scan", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
            body: JSON.stringify({
                anggota_id: data[0],
                buku_id: data[1],
            }),
        });

        const result = await response.json();

        appendBorrowing(result.data);
        console.log(result);

        // ✅ Tutup modal setelah respons berhasil
    } catch (error) {
        console.error("Error:", error);
        alert("Terjadi kesalahan saat mengirim data!");
    } finally {
        setTimeout(() => {
            loadingModal.hide();
        }, 2000);
    }
}

function appendBorrowing(data) {
    const csrfToken = $('meta[name="csrf-token"]').attr("content");
    const newRow = $(`
        <tr>
            <td class="text-center">#</td>
            <td>${data.nama}</td>
            <td>${data.judul}</td>
            <td>${formatDate(data.tanggal_pinjam)}</td>
            <td>${
                data.tanggal_kembali ? formatDate(data.tanggal_kembali) : "-"
            }</td>
            <td class="text-center">
                <span class="badge bg-warning text-dark">Dipinjam</span>
            </td>
            <td class="text-center">
                <a href="/borrow/${
                    data.id
                }/edit"  class="btn btn-sm btn-outline-success">
                     <i class="bi bi-pencil-square"></i>
                </a>
                <form action="/borrow/${
                    data.id
                }" method="POST" class="d-inline">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="${csrfToken}">
                    <button type="submit"  class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus?')">
                          <i class="bi bi-trash"></i>
                    </button>
                </form>
            </td>
        </tr>
    `);
    let pagination = $(".pagination");
    if (pagination.length > 0) {
        let liItems = pagination.find("li");
        let liCount = liItems.length;
        let secondLastLi = liItems.eq(liCount - 2);

        if (secondLastLi.hasClass("active")) {
            $("#tbody_borrowing").append(newRow);
            updateRowNumbers();
        }
    } else {
        $("#tbody_borrowing").append(newRow);
        updateRowNumbers();
    }
}

function updateRowNumbers() {
    $("#tbody_borrowing tr").each(function (index) {
        $(this)
            .find("td:first")
            .text(index + 1);
    });
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString("id-ID", {
        day: "2-digit",
        month: "short",
        year: "numeric",
    });
}
