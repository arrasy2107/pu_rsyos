{{-- 3. INSTALASI BEDAH SENTRAL (IBS) - DRAF LAPORAN (Input/Edit) --}}


<div class="card shadow-sm mb-4 animate-fade-in-up border-left-{{ $ibsDraf ? 'success' : 'primary' }}">
    <a href="#collapseIBS" class="d-block card-header collapse-header py-3 collapsed" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseIBS">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-dark"><i class="fas fa-syringe me-2 text-primary"></i> Instalasi Bedah Sentral (IBS)</h6>
            @if($ibsDraf)
            <span class="badge bg-primary px-3 py-2 me-2"><i class="fas fa-info-circle me-1"></i> Lihat Laporan</span>
            @endif
        </div>
    </a>
    <div class="collapse" id="collapseIBS" data-bs-parent="#drafAccordion">
        <div class="card-body bg-light">
            <div class="bg-white p-4 border rounded shadow-sm mb-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="fw-bold m-0 text-danger"><i class="fas fa-users me-2"></i> Total Pasien IBS: {{ $ibsDrafDetailCount }} orang</h6>
                    @if($ibsDraf)
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahibs"><i class="fas fa-plus me-1"></i> Tambah Pasien IBS</button>
                    @endif
                </div>

                <div class="tableketeranganibs">
                    @livewire('pengawas.ibs-detail')
                </div>
            </div>

            <form method="post" action="{{ route('editDraftlaporanIBS') }}" id="editdraftibs" role="form">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <input type="hidden" name="hitungketeranganibs" id="hitungketeranganibs" value="{{ $ibsDrafDetailCount }}">
                <input type="hidden" name="idibs" value="{{ $ibsDraf?->id }}">

                <div class="bg-white p-4 border rounded shadow-sm">
                    <div class="form-group shadow-textarea mb-0">
                        <label class="fw-bold text-dark"><i class="fas fa-clipboard-list me-2 text-info"></i> Catatan IBS untuk Dinas Berikutnya</label>
                        <textarea class="form-control z-depth-1" name="ibs_catatan" id="ibs_catatan" rows="3" readonly>{{ $ibsDraf?->catatan }}</textarea>
                    </div>
                </div>
            </form>

            @if($ibsDraf)
            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('deleteDraftlaporanIBS', $ibsDraf->id) }}" id="batalibs" class="btn btn-outline-danger me-2">
                    <i class="fas fa-trash-alt me-1"></i> Batalkan Laporan
                </a>
                <button id="editibslaporan" type="button" class="btn btn-primary btn-edit-ibs me-2">
                    <i class="fas fa-edit me-1"></i> Ubah Laporan
                </button>
                <span id="ibs-edit-actions"></span>
                <template id="ibs-edit-actions-template">
                    <button id="batalperubahanibs" type="button" class="btn btn-secondary btn-batal-ibs me-2">Batal Ubah</button>
                    <button id="simpanibs" class="btn btn-success btn-simpan-ibs shadow-sm" type="button"><i class="fas fa-save me-1"></i> Simpan Perubahan</button>
                </template>
            </div>
            @endif
        </div>
    </div>
</div>
