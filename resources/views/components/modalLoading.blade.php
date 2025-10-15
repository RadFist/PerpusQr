<!-- Modal Loading -->
<div class="modal fade" id="loadingModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 bg-transparent shadow-none">
            <div class="d-flex flex-column align-items-center justify-content-center p-4">
                <div class="spinner-border text-primary" role="status" style="width: 4rem; height: 4rem;">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-3 text-white fw-semibold">Mohon tunggu...</p>
            </div>
        </div>
    </div>
</div>

<!-- Optional styling (gelap transparan) -->
<style>
    #loadingModal .modal-content {
        background: rgba(0, 0, 0, 0.65);
        color: white;
        border-radius: 1rem;
        text-align: center;
    }
</style>