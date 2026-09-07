{{-- 4. INSTALASI RAWAT JALAN (IRJ) - DRAF LAPORAN (Input/Edit) --}}
@if ((strtotime($nowTime) > strtotime($start) && strtotime($nowTime) < strtotime($end) && $t->is_sunday() != true) ||
    (strtotime($nowTime) > strtotime($start) && strtotime($nowTime) < strtotime($end) && $t->is_holiday() == true && \App\Models\Irjbuka::where('tanggal',$hariini)->first()))


        <div class="card shadow-sm mb-4 animate-fade-in-up border-left-{{ $irjDraf ? 'success' : 'primary' }}">
            <a href="#collapseIRJ" class="d-block card-header collapse-header py-3 collapsed" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseIRJ">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold text-dark"><i class="fas fa-stethoscope me-2 text-primary"></i> Instalasi Rawat Jalan (IRJ)</h6>
                    @if($irjDraf)
                    <span class="badge bg-primary px-3 py-2 me-2"><i class="fas fa-info-circle me-1"></i> Lihat Laporan</span>
                    @endif
                </div>
            </a>

            <div class="collapse" id="collapseIRJ" data-bs-parent="#drafAccordion">
                <div class="card-body bg-light">
                    <div class="bg-white p-4 border rounded shadow-sm mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h6 class="fw-bold m-0 text-danger"><i class="fas fa-users me-2"></i> Total Pasien IRJ: {{ $irjDrafDetailTotal }} orang</h6>
                            @if($irjDraf)
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah"><i class="fas fa-plus me-1"></i> Input Pasien Dokter</button>
                            @endif
                        </div>

                        <div class="tableketerangan">
                            @livewire('pengawas.irj-detail')
                        </div>
                    </div>

                    <form method="post" action="{{ route('editDraftlaporanIRJ') }}" id="editdraftirj" role="form">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <input type="hidden" name="hitungketerangan" id="hitungketerangan" value="{{ $irjDrafDetailCount }}">
                        <input type="hidden" name="id" value="{{ $irjDraf?->id }}">

                        <div class="bg-white p-4 border rounded shadow-sm">
                            <div class="form-group shadow-textarea">
                                <label class="fw-bold text-dark"><i class="fas fa-exclamation-circle me-2 text-warning"></i> Masalah (Jika ada)</label>
                                <textarea class="form-control z-depth-1" name="irj_masalah" id="irj_masalah" rows="3" readonly>{{ $irjDraf?->masalah }}</textarea>
                            </div>
                            <div class="form-group shadow-textarea mb-0">
                                <label class="fw-bold text-dark"><i class="fas fa-check-circle me-2 text-success"></i> Langkah atasi masalah</label>
                                <textarea class="form-control" name="irj_langkah" id="irj_langkah" rows="3" readonly>{{ $irjDraf?->langkah_atasi_masalah }}</textarea>
                            </div>
                        </div>
                    </form>

                    @if($irjDraf)
                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('deleteDraftlaporanIRJ', $irjDraf->id) }}" id="batalirj" class="btn btn-outline-danger me-2">
                            <i class="fas fa-trash-alt me-1"></i> Batalkan Laporan
                        </a>
                        <button id="editirj" type="button" class="btn btn-primary btn-edit-irj me-2">
                            <i class="fas fa-edit me-1"></i> Ubah Laporan
                        </button>
                        <span id="irj-edit-actions"></span>
                        <template id="irj-edit-actions-template">
                            <button id="batalperubahanirj" type="button" class="btn btn-secondary me-2">Batal Ubah</button>
                            <button id="simpanirj" class="btn btn-success shadow-sm" type="button"><i class="fas fa-save me-1"></i> Simpan Perubahan</button>
                        </template>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        @endif
