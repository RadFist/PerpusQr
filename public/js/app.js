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
    // if (!hasilBuku && !hasilAnggota) {
    //     alert("Belum ada hasil scan!");
    //     return;
    // }

    // // Contoh: masukkan ke input form di luar modal
    // if (!hasilBuku || !hasilAnggota) {
    //     alert("Scan belum lengkap!");
    //     return;
    // }

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
                "X-CSRF-TOKEN": csrfToken,
            },
            body: JSON.stringify({
                anggota_id: data[0],
                buku_id: data[1],
            }),
        });

        const result = await response.json();
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
