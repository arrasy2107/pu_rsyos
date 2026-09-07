<!-- Modal Pasien Istimewa -->
<div class="modal fade" id="istimewa" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><i class="fas fa-star text-warning me-2"></i>Catatan Pasien Istimewa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                @livewire('dashboard.catatan-pasien-istimewa-modal')
            </div>
        </div>
    </div>
</div>

<!-- Modal Pasien Baru -->
<div class="modal fade" id="baru" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><i class="fas fa-user-plus text-success me-2"></i>Catatan Pasien Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                @livewire('dashboard.catatan-pasien-baru-modal')
            </div>
        </div>
    </div>
</div>

<!-- Modal Permasalahan -->
<div class="modal fade" id="permasalahan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><i class="fas fa-exclamation-triangle text-danger me-2"></i>Permasalahan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                @livewire('dashboard.permasalahan-modal')
            </div>
        </div>
    </div>
</div>