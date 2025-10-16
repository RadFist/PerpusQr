<div class="modal fade" id="scannerModal" tabindex="-1" aria-labelledby="scannerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="modal-title" id="scannerModalLabel">
                    <i class="bi bi-upc-scan"></i> Scan Kode
                    <span id="scan-mode-label">(Buku)</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <!-- Tombol mode -->
                <div class="d-flex justify-content-center mb-3">
                    <button class="btn btn-outline-primary me-2 active" id="mode-buku">
                        <i class="bi bi-book"></i> Buku
                    </button>
                    <button class="btn btn-outline-success" id="mode-anggota">
                        <i class="bi bi-person-badge"></i> Anggota
                    </button>
                </div>

                <!-- Area kamera -->
                <div id="reader" style="width:100%;"></div>

                <!-- Hasil scan -->
                <div class="mt-3">
                    <label class="fw-semibold">Hasil Scan (<span id="mode-text-buku">Buku</span>):</label>
                    <input type="text" id="scan-result-buku" class="form-control" readonly>
                </div>
                <div class="mt-3">
                    <label class="fw-semibold">Hasil Scan (<span id="mode-text-anggota">Anggota</span>):</label>
                    <input type="text" id="scan-result-anggota" class="form-control" readonly>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-success" id="submit-scan">
                    <i class="bi bi-check-circle"></i> Gunakan Hasil
                </button>
                <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>


<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>