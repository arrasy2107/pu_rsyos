@push('modals')
{{-- ========================================== --}}
{{-- MODALS SECTION --}}
{{-- ========================================== --}}

@section ('custom_style')
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* Select2 overrides */
    .select2-container .select2-selection--single {
        height: 42px !important;
        border: 1.5px solid var(--color-neutral-300) !important;
        border-radius: var(--radius-md) !important;
        font-family: var(--font-family) !important;
        font-size: var(--font-size-sm) !important;
    }

    .select2-selection__rendered {
        line-height: 40px !important;
        padding-left: 2.5rem !important;
        color: var(--color-neutral-900) !important;
    }

    .select2-selection__arrow {
        height: 40px !important;
    }

    .select2-container--default .select2-selection--single:focus,
    .select2-container--open .select2-selection--single {
        border-color: var(--color-accent) !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15) !important;
        outline: none !important;
    }

    .select2-dropdown {
        border: 1.5px solid var(--color-neutral-300) !important;
        border-radius: var(--radius-md) !important;
        box-shadow: var(--shadow-md) !important;
        font-family: var(--font-family) !important;
        font-size: var(--font-size-sm) !important;
    }

    .select2-results__options {
        max-height: 260px !important;
        overflow-y: auto !important;
    }
</style>
@stop

<!-- Modal Tambah IBS -->
<div id="tambahibs" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header pu-card-gradient-header text-white">
                <h5 class="modal-title fw-bold"><i class="fas fa-user-plus me-2"></i> Input Pasien IBS</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('tambahibsdetail') }}" id="tambahketeranganibs" role="form" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="fw-bold">Nama Pasien</label>
                                <input type="text" class="form-control" name="nama" required />
                            </div>
                            <div class="form-group">
                                <label class="fw-bold">No. Rekam Medis (RM)</label>
                                <input type="text" class="form-control" name="rm" required />
                            </div>
                            <div class="form-group">
                                <label class="fw-bold">Ruangan Asal</label>
                                <select class="form-control select2" name="id_ruangan" id="id_ruangan" style="width: 100%" required>
                                    <option value="" selected disabled hidden>Pilih Ruangan</option>
                                    @foreach(\App\Models\Ruangan::where('status',1)->get() as $mb)
                                    <option value="{{ $mb->id }}">{{ $mb->nama_ruangan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="fw-bold">Pendamping / Petugas</label>
                                <input type="text" class="form-control" name="pendamping" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="fw-bold">Dokter Operasi</label>
                                <select multiple="multiple" class="form-control select2" name="id_dokter_operasi" id="id_dokter_operasi" style="width: 100%" data-placeholder="Pilih Dokter Operasi" required>
                                    @foreach(\App\Models\Dokterirj::where('status',1)->where('id_sdmk_jenis','<>',3)->where('id_sdmk_jenis','<>',21)->get() as $mb)
                                            <option value="{{ $mb->id }}">{{ $mb->nama }}</option>
                                            @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="fw-bold">Dokter Anestesi</label>
                                <select class="form-control select2" name="id_dokter_anestesi" id="id_dokter_anestesi" style="width: 100%" required>
                                    <option value="" selected disabled hidden>Pilih Dokter Anestesi</option>
                                    @foreach(\App\Models\Dokterirj::where('status',1)->where('id_sdmk_jenis',8)->get() as $mb)
                                    <option value="{{ $mb->id }}">{{ $mb->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="fw-bold text-success">Jam Mulai</label>
                                        <input type="time" class="form-control" name="jam_mulai" required />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="fw-bold text-danger">Jam Selesai</label>
                                        <input type="time" class="form-control" name="jam_selesai" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group shadow-textarea mt-3">
                        <label class="fw-bold">Diagnosa Pre-Operatif</label>
                        <textarea class="form-control" name="diagnosapre" rows="2" placeholder="Tulis diagnosa sebelum operasi..." required></textarea>
                    </div>
                    <div class="form-group shadow-textarea">
                        <label class="fw-bold">Diagnosa Post-Operatif</label>
                        <textarea class="form-control" name="diagnosapost" rows="2" placeholder="Tulis diagnosa setelah operasi..." required></textarea>
                    </div>
                    <div class="text-end mt-4">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-tambahibs"><i class="fas fa-save me-1"></i> Simpan Data IBS</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit IBS -->
<div id="editibs" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header pu-card-gradient-header text-white">
                <h5 class="modal-title fw-bold"><i class="fas fa-user-edit me-2"></i> Ubah Data Pasien IBS</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('editibsdetail') }}" id="editketeranganibs" role="form" autocomplete="off">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <input type="hidden" class="txtidibs" name="idibs">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="fw-bold">Nama Pasien</label>
                                <input type="text" class="form-control txt-nama" name="nama2" required />
                            </div>
                            <div class="form-group">
                                <label class="fw-bold">No. Rekam Medis (RM)</label>
                                <input type="text" class="form-control txt-rm" name="rm2" required />
                            </div>
                            <div class="form-group">
                                <label class="fw-bold">Ruangan Asal</label>
                                <select class="form-control select2 txt-ruangan" name="id_ruangan2" id="id_ruangan2" style="width: 100%" required>
                                    <option value="" selected disabled hidden>Pilih Ruangan</option>
                                    @foreach(\App\Models\Ruangan::where('status',1)->get() as $mb)
                                    <option value="{{ $mb->id }}">{{ $mb->nama_ruangan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="fw-bold">Pendamping / Petugas</label>
                                <input type="text" class="form-control txt-pendamping" id="pendamping2" name="pendamping2" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="fw-bold">Dokter Operasi</label>
                                <select multiple="multiple" class="form-control select2 txt-operasi" name="id_dokter_operasi2" id="id_dokter_operasi2" style="width: 100%" data-placeholder="Pilih Dokter (Bisa > 1)" required>
                                    @foreach(\App\Models\Dokterirj::where('status',1)->where('id_sdmk_jenis','<>',3)->where('id_sdmk_jenis','<>',21)->get() as $mb)
                                            <option value="{{ $mb->id }}">{{ $mb->nama }}</option>
                                            @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="fw-bold">Dokter Anestesi</label>
                                <select class="form-control select2 txt-anestesi" name="id_dokter_anestesi2" id="id_dokter_anestesi2" style="width: 100%" required>
                                    <option value="" selected disabled hidden>Pilih Dokter Anestesi</option>
                                    @foreach(\App\Models\Dokterirj::where('status',1)->where('id_sdmk_jenis',8)->get() as $mb)
                                    <option value="{{ $mb->id }}">{{ $mb->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="fw-bold text-success">Jam Mulai</label>
                                        <input type="time" class="form-control txt-mulai" name="jam_mulai2" required />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="fw-bold text-danger">Jam Selesai</label>
                                        <input type="time" class="form-control txt-selesai" name="jam_selesai2" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group shadow-textarea mt-3">
                        <label class="fw-bold">Diagnosa Pre-Operatif</label>
                        <textarea class="form-control txt-diagnosapre" name="diagnosapre2" rows="2" placeholder="Tulis diagnosa sebelum operasi..." required></textarea>
                    </div>
                    <div class="form-group shadow-textarea">
                        <label class="fw-bold">Diagnosa Post-Operatif</label>
                        <textarea class="form-control txt-diagnosapost" name="diagnosapost2" rows="2" placeholder="Tulis diagnosa setelah operasi..." required></textarea>
                    </div>
                    <div class="text-end mt-4">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-info btn-simpanibs"><i class="fas fa-save me-1"></i> Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah IRJ -->
<div id="tambah" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><i class="fas fa-plus-circle me-2 text-primary"></i> Input Data Pasien IRJ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('tambahirjdetail') }}" id="tambahketerangan" role="form" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="fw-bold">Dokter Poliklinik</label>
                        <select class="form-control select2" name="id_dokter_irj" id="id_dokter_irj" style="width: 100%" required>
                            <option value="" selected disabled hidden>Pilih Dokter...</option>
                            @foreach(\App\Models\Dokterirj::where('status',1)->get() as $mb)
                            @if(!\App\Models\Laporanirjdetail::where('id_pengawas',\Auth::user()->id)->where('status',0)->where('id_dokter_irj',$mb->id)->first())
                            <option value="{{ $mb->id }}">{{ $mb->nama }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="fw-bold text-info">Jumlah Pasien Lama (RM Lama)</label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user-clock"></i></span></div>
                            <input type="number" class="form-control" name="pasien_lama" min="0" required />
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <label class="fw-bold text-success">Jumlah Pasien Baru (RM Baru)</label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user-plus"></i></span></div>
                            <input type="number" class="form-control" name="pasien_baru" min="0" required />
                        </div>
                    </div>
                    <div class="text-end mt-4 pt-3 border-top">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-tambah"><i class="fas fa-save me-1"></i> Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit IRJ -->
<div id="edit" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><i class="fas fa-edit me-2 text-info"></i> Ubah Data Pasien IRJ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('editirjdetail') }}" id="editketerangan" role="form" autocomplete="off">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <input type="hidden" class="txtid" name="id">
                    <div class="form-group">
                        <label class="fw-bold">Dokter Poliklinik</label>
                        <select class="form-control txtiddokter select2" name="id_dokter_irj" id="id_dokter_irj2" style="width: 100%" required>
                            <option value="" selected disabled hidden>Pilih Dokter...</option>
                            @foreach(\App\Models\Dokterirj::where('status',1)->get() as $mb)
                            <option value="{{ $mb->id }}">{{ $mb->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="fw-bold text-info">Jumlah Pasien Lama (RM Lama)</label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user-clock"></i></span></div>
                            <input type="number" class="form-control txtlama" name="pasien_lama" min="0" required />
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <label class="fw-bold text-success">Jumlah Pasien Baru (RM Baru)</label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user-plus"></i></span></div>
                            <input type="number" class="form-control txtbaru" name="pasien_baru" min="0" required />
                        </div>
                    </div>
                    <div class="text-end mt-4 pt-3 border-top">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-info btn-simpan"><i class="fas fa-save me-1"></i> Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Catatan Pasien Istimewa -->
<div id="tambahistimewa" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><i class="fas fa-plus-circle me-2 text-primary"></i> Input Catatan Pasien Istimewa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="tambahcatatanpasien" id="formTambahIstimewa" role="form" autocomplete="off">
                    {{ csrf_field() }}
                    <input type="hidden" name="jenis_pasien" value="1">
                    <input type="hidden" name="ruangan" value="">

                    <div class="form-group">
                        <label class="fw-bold">Kamar</label>
                        <input type="text" class="form-control" name="kamar" placeholder="Contoh: 01A" required />
                    </div>
                    <div class="form-group">
                        <label class="fw-bold">Nama Pasien</label>
                        <input type="text" class="form-control" name="nama" placeholder="Nama lengkap pasien" required />
                    </div>
                    <div class="form-group">
                        <label class="fw-bold">No. Rekam Medis (RM)</label>
                        <input type="text" class="form-control" name="rm" placeholder="Nomor RM" required />
                    </div>
                    <div class="form-group">
                        <label class="fw-bold">Diagnosa</label>
                        <textarea class="form-control" name="diagnosa" rows="2" placeholder="Tuliskan diagnosa" required></textarea>
                    </div>
                    <div class="form-group">
                        <label class="fw-bold">Dokter DPJP</label>
                        <select class="form-control select2" name="dpjp" style="width: 100%" required>
                            <option value="" selected disabled hidden>Pilih Dokter DPJP...</option>
                            @foreach(\App\Models\Dokterirj::where('status',1)->get() as $dok)
                            <option value="{{ $dok->id }}">{{ $dok->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-0">
                        <label class="fw-bold">Kondisi Pasien</label>
                        <textarea class="form-control" name="kondisi" rows="2" placeholder="Tuliskan kondisi pasien" required></textarea>
                    </div>
                    <div class="text-end mt-4 pt-3 border-top">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan Catatan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Catatan Pasien Istimewa -->
<div id="editistimewa" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><i class="fas fa-edit me-2 text-info"></i> Edit Catatan Pasien Istimewa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="editcatatanpasien" id="formEditIstimewa" role="form" autocomplete="off">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <input type="hidden" class="txtidistimewa" name="id">
                    <input type="hidden" name="jenis_pasien" value="1">
                    <input type="hidden" name="ruangan" value="">

                    <div class="form-group">
                        <label class="fw-bold">Kamar</label>
                        <input type="text" class="form-control txt-kamar" name="kamar" placeholder="Contoh: 01A" required />
                    </div>
                    <div class="form-group">
                        <label class="fw-bold">Nama Pasien</label>
                        <input type="text" class="form-control txt-nama" name="nama" placeholder="Nama lengkap pasien" required />
                    </div>
                    <div class="form-group">
                        <label class="fw-bold">No. Rekam Medis (RM)</label>
                        <input type="text" class="form-control txt-rm" name="rm" placeholder="Nomor RM" required />
                    </div>
                    <div class="form-group">
                        <label class="fw-bold">Diagnosa</label>
                        <textarea class="form-control txt-diagnosa" name="diagnosa" rows="2" placeholder="Tuliskan diagnosa" required></textarea>
                    </div>
                    <div class="form-group">
                        <label class="fw-bold">Dokter DPJP</label>
                        <select class="form-control select2 txt-dpjp" name="dpjp" style="width: 100%" required>
                            <option value="" selected disabled hidden>Pilih Dokter DPJP...</option>
                            @foreach(\App\Models\Dokterirj::where('status',1)->get() as $dok)
                            <option value="{{ $dok->id }}">{{ $dok->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-0">
                        <label class="fw-bold">Kondisi Pasien</label>
                        <textarea class="form-control txt-kondisi" name="kondisi" rows="2" placeholder="Tuliskan kondisi pasien" required></textarea>
                    </div>
                    <div class="text-end mt-4 pt-3 border-top">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-info"><i class="fas fa-save me-1"></i> Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Catatan Pasien Baru -->
<div id="tambahbaru" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><i class="fas fa-plus-circle me-2 text-primary"></i> Input Catatan Pasien Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="tambahcatatanpasien" id="formTambahBaru" role="form" autocomplete="off">
                    {{ csrf_field() }}
                    <input type="hidden" name="jenis_pasien" value="2">
                    <input type="hidden" name="ruangan" value="">

                    <div class="form-group">
                        <label class="fw-bold">Kamar</label>
                        <input type="text" class="form-control" name="kamar" placeholder="Contoh: 01A" required />
                    </div>
                    <div class="form-group">
                        <label class="fw-bold">Nama Pasien</label>
                        <input type="text" class="form-control" name="nama" placeholder="Nama lengkap pasien" required />
                    </div>
                    <div class="form-group">
                        <label class="fw-bold">No. Rekam Medis (RM)</label>
                        <input type="text" class="form-control" name="rm" placeholder="Nomor RM" required />
                    </div>
                    <div class="form-group">
                        <label class="fw-bold">Diagnosa</label>
                        <textarea class="form-control" name="diagnosa" rows="2" placeholder="Tuliskan diagnosa" required></textarea>
                    </div>
                    <div class="form-group">
                        <label class="fw-bold">Dokter DPJP</label>
                        <select class="form-control select2" name="dpjp" style="width: 100%" required>
                            <option value="" selected disabled hidden>Pilih Dokter DPJP...</option>
                            @foreach(\App\Models\Dokterirj::where('status',1)->get() as $dok)
                            <option value="{{ $dok->id }}">{{ $dok->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-0">
                        <label class="fw-bold">Kondisi Pasien</label>
                        <textarea class="form-control" name="kondisi" rows="2" placeholder="Tuliskan kondisi pasien" required></textarea>
                    </div>
                    <div class="text-end mt-4 pt-3 border-top">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan Catatan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Catatan Pasien Baru -->
<div id="editbaru" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><i class="fas fa-edit me-2 text-info"></i> Edit Catatan Pasien Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="editcatatanpasien" id="formEditBaru" role="form" autocomplete="off">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <input type="hidden" class="txtidbaru" name="id">
                    <input type="hidden" name="jenis_pasien" value="2">
                    <input type="hidden" name="ruangan" value="">

                    <div class="form-group">
                        <label class="fw-bold">Kamar</label>
                        <input type="text" class="form-control txt-kamar" name="kamar" placeholder="Contoh: 01A" required />
                    </div>
                    <div class="form-group">
                        <label class="fw-bold">Nama Pasien</label>
                        <input type="text" class="form-control txt-nama" name="nama" placeholder="Nama lengkap pasien" required />
                    </div>
                    <div class="form-group">
                        <label class="fw-bold">No. Rekam Medis (RM)</label>
                        <input type="text" class="form-control txt-rm" name="rm" placeholder="Nomor RM" required />
                    </div>
                    <div class="form-group">
                        <label class="fw-bold">Diagnosa</label>
                        <textarea class="form-control txt-diagnosa" name="diagnosa" rows="2" placeholder="Tuliskan diagnosa" required></textarea>
                    </div>
                    <div class="form-group">
                        <label class="fw-bold">Dokter DPJP</label>
                        <select class="form-control select2 txt-dpjp" name="dpjp" style="width: 100%" required>
                            <option value="" selected disabled hidden>Pilih Dokter DPJP...</option>
                            @foreach(\App\Models\Dokterirj::where('status',1)->get() as $dok)
                            <option value="{{ $dok->id }}">{{ $dok->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-0">
                        <label class="fw-bold">Kondisi Pasien</label>
                        <textarea class="form-control txt-kondisi" name="kondisi" rows="2" placeholder="Tuliskan kondisi pasien" required></textarea>
                    </div>
                    <div class="text-end mt-4 pt-3 border-top">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-info"><i class="fas fa-save me-1"></i> Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endpush


@push('scripts')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        // Ensure Select2 works in modals
        $('.select2').each(function() {
            var $this = $(this);
            var parent = $this.closest('.modal').length ? $this.closest('.modal') : $('body');
            $this.select2({
                dropdownParent: parent
            });
        });

        $("#dataTable, #dataTable2").each(function() {
            var $table = $(this);
            var hasDataRows = $table.find('tbody tr').filter(function() {
                return $(this).find('td[colspan]').length === 0;
            }).length > 0;

            if (!hasDataRows) return;

            $table.DataTable({
                "pageLength": 5,
                "ordering": false,
                "lengthMenu": [
                    [5, 10, -1],
                    [5, 10, "Semua"]
                ],
                "language": {
                    url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/id.json'
                }
            });
        });

    });

    // ==========================================
    // JS IGD: Hover Image Logic
    // ==========================================
    const ASSET_BASE = "{{asset('sb-admin/icon/')}}";

    function setImg(id, src) {
        document.getElementById(id).setAttribute('src', ASSET_BASE + src);
    }

    // Focus actions
    function igd1a() {
        setImg("gbr_igd_pasien", "/warna/general/pasien.png");
    }

    function igd2a() {
        setImg("gbr_igd_pasien_rawat", "/warna/igd/pasien-dirawat.png");
    }

    function igd3a() {
        setImg("gbr_igd_pasien_emergency", "/warna/igd/pasien-emergency.png");
    }

    function igd4a() {
        setImg("gbr_igd_pasien_tidak_rawat", "/warna/igd/pasien-tidak-bisa-dirawat.png");
    }

    function igd5a() {
        setImg("gbr_igd_pasien_doa", "/warna/igd/pasien-doa.png");
    }

    function igd6a() {
        setImg("gbr_igd_pasien_sisrute", "/warna/igd/sisrute.png");
    }

    function igd7a() {
        setImg("gbr_igd_pasien_sisrute_diterima", "/warna/igd/sisrute-terima.png");
    }

    // Blur actions
    function igd1b() {
        setImg("gbr_igd_pasien", "/general/pasien.png");
    }

    function igd2b() {
        setImg("gbr_igd_pasien_rawat", "/igd/pasien-dirawat.png");
    }

    function igd3b() {
        setImg("gbr_igd_pasien_emergency", "/igd/pasien-emergency.png");
    }

    function igd4b() {
        setImg("gbr_igd_pasien_tidak_rawat", "/igd/pasien-tidak-bisa-dirawat.png");
    }

    function igd5b() {
        setImg("gbr_igd_pasien_doa", "/igd/pasien-doa.png");
    }

    function igd6b() {
        setImg("gbr_igd_pasien_sisrute", "/igd/sisrute.png");
    }

    function igd7b() {
        setImg("gbr_igd_pasien_sisrute_diterima", "/igd/sisrute-terima.png");
    }


    // ==========================================
    // JS RAWAT INAP: AJAX room form loading
    // ==========================================
    $(document).on('change', '#inap_ruangan', function() {
        const val = $(this).val();
        if (!val) {
            $(".tablelaporan").html('<div class="text-center py-4 text-muted border border-dashed rounded bg-white"><i class="fas fa-hand-pointer fa-2x mb-3 text-gray-300"></i><p class="mb-0">Pilih ruangan dari dropdown di atas untuk mengisi laporan form.</p></div>');
            return;
        }

        $(".tablelaporan").html('<div class="text-center py-5"><i class="fas fa-circle-notch fa-spin fa-3x text-primary mb-3"></i><p>Memuat form ruangan...</p></div>');
        $.ajax({
            type: "get",
            url: '/refresh-laporan-ruangan/' + val,
            data: {
                ruangan: val
            },
            success: function(data) {
                $(".tablelaporan").html(data);
            },
            error: function(xhr) {
                $(".tablelaporan").html('<div class="alert alert-danger">Gagal memuat form ruangan. Silakan pilih ruangan lain.</div>');
            }
        });
    });

    // Helper functions for rawat inap icons
    function ranapIcon(id, file, state) {
        let prefix = state === 'a' ? '/warna/ranap/' : '/ranap/';
        // Special exceptions based on original code
        if (id === "gbr_inap_pasien_lama") prefix = state === 'a' ? '/warna/general/' : '/general/';
        if (id === "gbr_inap_pasien_pulang") prefix = state === 'a' ? '/warna/igd/' : '/igd/';

        document.getElementById(id).setAttribute('src', ASSET_BASE + prefix + file);
    }

    function ranap2a() {
        ranapIcon("gbr_inap_pasien_baru", "pasien-baru.png", 'a');
    }

    function ranap2b() {
        ranapIcon("gbr_inap_pasien_baru", "pasien-baru.png", 'b');
    }

    function ranap3a() {
        ranapIcon("gbr_inap_pasien_pindah", "pasien-pindah.png", 'a');
    }

    function ranap3b() {
        ranapIcon("gbr_inap_pasien_pindah", "pasien-pindah.png", 'b');
    }

    function ranap4a() {
        ranapIcon("gbr_inap_pasien_pindahan", "pasien-pindahan.png", 'a');
    }

    function ranap4b() {
        ranapIcon("gbr_inap_pasien_pindahan", "pasien-pindahan.png", 'b');
    }

    function ranap5a() {
        ranapIcon("gbr_inap_pasien_meninggal", "pasien-meninggal.png", 'a');
    }

    function ranap5b() {
        ranapIcon("gbr_inap_pasien_meninggal", "pasien-meninggal.png", 'b');
    }

    function ranap6a() {
        ranapIcon("gbr_inap_pasien_covid", "pasien-covid.png", 'a');
    }

    function ranap6b() {
        ranapIcon("gbr_inap_pasien_covid", "pasien-covid.png", 'b');
    }

    function ranap7a() {
        ranapIcon("gbr_inap_pasien_suspek_covid", "pasien-suspect-covid.png", 'a');
    }

    function ranap7b() {
        ranapIcon("gbr_inap_pasien_suspek_covid", "pasien-suspect-covid.png", 'b');
    }

    function ranap8a() {
        ranapIcon("gbr_inap_pasien_restrain", "pasien-restrain.png", 'a');
    }

    function ranap8b() {
        ranapIcon("gbr_inap_pasien_restrain", "pasien-restrain.png", 'b');
    }

    function ranap9a() {
        ranapIcon("gbr_inap_pasien_perilaku_kekerasan", "pasien-perilaku-kekerasan.png", 'a');
    }

    function ranap9b() {
        ranapIcon("gbr_inap_pasien_perilaku_kekerasan", "pasien-perilaku-kekerasan.png", 'b');
    }

    function ranap10a() {
        ranapIcon("gbr_inap_pasien_keracunan", "pasien-keracunan.png", 'a');
    }

    function ranap10b() {
        ranapIcon("gbr_inap_pasien_keracunan", "pasien-keracunan.png", 'b');
    }

    function ranap11a() {
        ranapIcon("gbr_inap_pasien_keterbatasan_bahasa", "pasien-keterbatasan-bahasa.png", 'a');
    }

    function ranap11b() {
        ranapIcon("gbr_inap_pasien_keterbatasan_bahasa", "pasien-keterbatasan-bahasa.png", 'b');
    }

    function ranap12a() {
        ranapIcon("gbr_inap_pasien_difabel", "pasien-difabel.png", 'a');
    }

    function ranap12b() {
        ranapIcon("gbr_inap_pasien_difabel", "pasien-difabel.png", 'b');
    }

    function ranap13a() {
        ranapIcon("gbr_inap_pasien_pulang", "pasien-pulang.png", 'a');
    }

    function ranap13b() {
        ranapIcon("gbr_inap_pasien_pulang", "pasien-pulang.png", 'b');
    }


    // ==========================================
    // JS IRJ: AJAX Operations
    // ==========================================
    let id_irj, dokter_irj, lama_irj, baru_irj;

    $(document).on('click', '#dataTable .btn-edit', function() {
        $(".txtid").val($(this).val());
        $(".txtiddokter").val($(this).data('dokter')).trigger("change");
        $(".txtlama").val($(this).data('lama'));
        $(".txtbaru").val($(this).data('baru'));
    });

    $(document).on('click', '#dataTable .btn-hapus', function(e) {
        let del_id = $(this).val();
        PUAlert.confirmAction({
            text: 'Apakah Anda yakin ingin menghapus data IRJ ini?',
            confirmButtonText: 'Ya, hapus'
        }, function() {
            $.ajax({
                url: 'deleteirjdetail',
                method: 'DELETE',
                data: {
                    id: del_id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        refreshIRJ();
                    } else alert("Error");
                }
            });
        });
    });

    $("#tambahketerangan").on('submit', function(e) {
        e.preventDefault();
        let formData = $(this).serialize();
        $.ajax({
            url: 'tambahirjdetail',
            method: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    $("#tambahketerangan")[0].reset();
                    $("#id_dokter_irj").val("").trigger("change");
                    window.bootstrap.Modal.getOrCreateInstance(document.getElementById('tambah')).hide();
                    alert(response.message);
                    refreshIRJ();
                } else alert(response.message);
            },
            error: function(xhr) {
                let message = xhr.responseJSON?.message || 'Data IRJ gagal disimpan. Silakan coba kembali.';
                alert(message);
            }
        });
    });

    $("#editketerangan").on('submit', function(e) {
        e.preventDefault();
        let formData = $(this).serialize();
        $.ajax({
            url: 'editirjdetail',
            method: 'POST', // Gunakan POST, _method=PUT dari form akan menangani sisanya
            data: formData,
            success: function(response) {
                if (response.success) {
                    window.bootstrap.Modal.getOrCreateInstance(document.getElementById('edit')).hide();
                    alert(response.message);
                    refreshIRJ();
                } else alert(response.message);
            },
            error: function(xhr) {
                let message = xhr.responseJSON?.message || 'Data IRJ gagal diperbarui. Silakan coba kembali.';
                alert(message);
            }
        });
    });

    function refreshIRJ() {
        if (window.Livewire) {
            Livewire.dispatch('refreshIrjDetail');
            return;
        }
        $.ajax({
            type: "get",
            url: 'refresh-irj-detail/',
            success: function(data) {
                $(".tableketerangan").html(data);
            }
        });
    }

    // ==========================================
    // JS IBS: AJAX Operations
    // ==========================================
    let idibs, listdokteroperasi;

    $(document).on('click', '#dataTable2 .btn-edit', function() {
        idibs = $(this).val();

        let d_op = $(this).attr('data-dokteroperasi');
        listdokteroperasi = (d_op && d_op.includes(",")) ? d_op.split(',') : (d_op ? [d_op] : []);

        $('#editibs .txtidibs').val(idibs);
        $('#editibs .txt-nama').val($(this).attr('data-nama'));
        $('#editibs .txt-rm').val($(this).attr('data-rm'));
        $('#editibs .txt-operasi').val(listdokteroperasi).trigger("change");
        $('#editibs .txt-anestesi').val($(this).attr('data-dokteranestesi')).trigger("change");
        $('#editibs .txt-ruangan').val($(this).attr('data-ruangan')).trigger("change");
        $('#editibs .txt-pendamping').val($(this).attr('data-pendamping'));
        $('#editibs .txt-mulai').val($(this).attr('data-jammulai'));
        $('#editibs .txt-selesai').val($(this).attr('data-jamselesai'));
        $('#editibs .txt-diagnosapre').val($(this).attr('data-diagnosapre'));
        $('#editibs .txt-diagnosapost').val($(this).attr('data-diagnosapost'));
    });

    $(document).on('click', '#dataTable2 .btn-hapus', function(e) {
        let del_id = $(this).val();
        PUAlert.confirmAction({
            text: 'Apakah Anda yakin ingin menghapus data IBS ini?',
            confirmButtonText: 'Ya, hapus'
        }, function() {
            $.ajax({
                url: 'deleteibsdetail',
                method: 'DELETE',
                data: {
                    id: del_id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        refreshIBS();
                    } else alert("Error");
                }
            });
        });
    });

    $(".btn-tambahibs").click(function(e) {
        e.preventDefault();
        $("#tambahibs").modal('hide');

        let formData = {
            nama: $("input[name=nama]").val(),
            rm: $("input[name=rm]").val(),
            id_dokter_operasi: $('#id_dokter_operasi').val(),
            id_dokter_anestesi: $("#id_dokter_anestesi").val(),
            id_ruangan: $("#id_ruangan").val(),
            pendamping: $("input[name=pendamping]").val(),
            jam_mulai: $("input[name=jam_mulai]").val(),
            jam_selesai: $("input[name=jam_selesai]").val(),
            diagnosapre: $("textarea[name=diagnosapre]").val(),
            diagnosapost: $("textarea[name=diagnosapost]").val()
        };

        $.ajax({
            url: 'tambahibsdetail',
            method: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    $("#tambahketeranganibs")[0].reset();
                    $("#tambahketeranganibs .select2").val("").trigger("change");
                    alert(response.message);
                    refreshIBS();
                } else alert(response.message);
                },
                error: function(xhr) {
                    alert(xhr.responseJSON?.message || 'Gagal menyimpan data IBS.');
                },
                error: function(xhr) {
                    alert(xhr.responseJSON?.message || 'Gagal menyimpan perubahan data IBS.');
            }
        });
    });

    $(".btn-simpanibs").click(function(e) {
        e.preventDefault();
        $("#editibs").modal('hide');

        let formData = {
            id: $("input[name=idibs]").val(),
            nama: $("input[name=nama2]").val(),
            rm: $("input[name=rm2]").val(),
            id_dokter_operasi: $('#id_dokter_operasi2').val(),
            id_dokter_anestesi: $("#id_dokter_anestesi2").val(),
            id_ruangan: $("#id_ruangan2").val(),
            pendamping: $("input[name=pendamping2]").val(),
            jam_mulai: $("input[name=jam_mulai2]").val(),
            jam_selesai: $("input[name=jam_selesai2]").val(),
            diagnosapre: $("textarea[name=diagnosapre2]").val(),
            diagnosapost: $("textarea[name=diagnosapost2]").val()
        };

        $.ajax({
            url: 'editibsdetail',
            method: 'PUT',
            data: formData,
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    refreshIBS();
                } else alert(response.message);
            }
        });
    });

    function refreshIBS() {
        if (window.Livewire) {
            Livewire.dispatch('refreshIbsDetail');
            return;
        }
        $.ajax({
            type: "get",
            url: 'refresh-ibs-detail/',
            success: function(data) {
                $(".tableketeranganibs").html(data);
            }
        });
    }

    // ==========================================
    // JS CATATAN PASIEN: Modal handlers
    // ==========================================
    let id_istimewa, kamar_istimewa, nama_istimewa, rm_istimewa, diagnosa_istimewa, dpjp_istimewa, kondisi_istimewa;
    let id_baru, kamar_baru, nama_baru, rm_baru, diagnosa_baru, dpjp_baru, kondisi_baru;

    // Set ruangan ID ketika AJAX meload form
    $(document).on('change', '#inap_ruangan', function() {
        $('#formTambahIstimewa input[name=ruangan]').val($(this).val());
        $('#formEditIstimewa input[name=ruangan]').val($(this).val());
        $('#formTambahBaru input[name=ruangan]').val($(this).val());
        $('#formEditBaru input[name=ruangan]').val($(this).val());
    });

    // Handle modal untuk Catatan Pasien Istimewa - edit button
    $(document).on('click', '#dataTableistimewa .btn-edit', function() {
        id_istimewa = $(this).data('id');
        kamar_istimewa = $(this).data('kamar');
        nama_istimewa = $(this).data('nama');
        rm_istimewa = $(this).data('rm');
        diagnosa_istimewa = $(this).data('diagnosa');
        dpjp_istimewa = $(this).data('dpjp');
        kondisi_istimewa = $(this).data('kondisi');
    });

    $('#editistimewa').on('show.bs.modal', function() {
        var $modal = $(this);
                $modal.find('.select2').each(function() {
                    if ($(this).hasClass('select2-hidden-accessible')) {
                        $(this).select2('destroy');
                    }
                    $(this).select2({ dropdownParent: $modal });
                });
        $(".txtidistimewa").val(id_istimewa);
        $(".txt-kamar").val(kamar_istimewa);
        $(".txt-nama").val(nama_istimewa);
        $(".txt-rm").val(rm_istimewa);
        $(".txt-diagnosa").val(diagnosa_istimewa);
        $(".txt-dpjp").select2().val(dpjp_istimewa).trigger("change");
        $(".txt-kondisi").val(kondisi_istimewa);
    });

    // Handle modal untuk Catatan Pasien Baru - edit button
    $(document).on('click', '#dataTablebaru .btn-edit', function() {
        id_baru = $(this).data('id');
        kamar_baru = $(this).data('kamar');
        nama_baru = $(this).data('nama');
        rm_baru = $(this).data('rm');
        diagnosa_baru = $(this).data('diagnosa');
        dpjp_baru = $(this).data('dpjp');
        kondisi_baru = $(this).data('kondisi');
    });

    $('#editbaru').on('show.bs.modal', function() {
        var $modal = $(this);
                $modal.find('.select2').each(function() {
                    if ($(this).hasClass('select2-hidden-accessible')) {
                        $(this).select2('destroy');
                    }
                    $(this).select2({ dropdownParent: $modal });
                });
        $(".txtidbaru").val(id_baru);
        $(".txt-kamar").val(kamar_baru);
        $(".txt-nama").val(nama_baru);
        $(".txt-rm").val(rm_baru);
        $(".txt-diagnosa").val(diagnosa_baru);
        $(".txt-dpjp").select2().val(dpjp_baru).trigger("change");
        $(".txt-kondisi").val(kondisi_baru);
    });

    // Functions for refreshing Catatan tables
    function refreshCatatanIstimewa(ruangan) {
        if (!ruangan) ruangan = $('#inap_ruangan').val();
        if (!ruangan) return;
        if (window.Livewire) {
            Livewire.dispatch('refreshCatatanIstimewa');
            return;
        }
        $.ajax({
            type: "get",
            url: 'refresh-catatan-pasien-istimewa/' + ruangan,
            success: function(data) {
                $(".tableistimewa").html(data);
            }
        });
    }

    function refreshCatatanBaru(ruangan) {
        if (!ruangan) ruangan = $('#inap_ruangan').val();
        if (!ruangan) return;
        if (window.Livewire) {
            Livewire.dispatch('refreshCatatanBaru');
            return;
        }
        $.ajax({
            type: "get",
            url: 'refresh-catatan-pasien-baru/' + ruangan,
            success: function(data) {
                $(".tablebaru").html(data);
            }
        });
    }

    // AJAX Submit Handlers for Istimewa
    $("#formTambahIstimewa").on("submit", function(e) {
        e.preventDefault();
        let form = $(this);
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                if (response.success) {
                    $("#tambahistimewa").modal('hide');
                    form[0].reset();
                    form.find(".select2").val("").trigger("change");
                    alert(response.message);
                    refreshCatatanIstimewa(form.find('input[name=ruangan]').val());
                } else alert(response.message);
            },
            error: function(xhr) {
                alert(xhr.responseJSON?.message || 'Gagal menyimpan catatan pasien.');
            }
        });
    });

    $("#formEditIstimewa").on("submit", function(e) {
        e.preventDefault();
        let form = $(this);
        $.ajax({
            url: form.attr('action'),
            method: 'PUT',
            data: form.serialize(),
            success: function(response) {
                if (response.success) {
                    $("#editistimewa").modal('hide');
                    alert(response.message);
                    refreshCatatanIstimewa(form.find('input[name=ruangan]').val());
                } else alert(response.message);
            },
            error: function(xhr) {
                alert(xhr.responseJSON?.message || 'Gagal mengubah catatan pasien.');
            }
        });
    });

    // AJAX Submit Handlers for Baru
    $("#formTambahBaru").on("submit", function(e) {
        e.preventDefault();
        let form = $(this);
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                if (response.success) {
                    $("#tambahbaru").modal('hide');
                    form[0].reset();
                    form.find(".select2").val("").trigger("change");
                    alert(response.message);
                    refreshCatatanBaru(form.find('input[name=ruangan]').val());
                } else alert(response.message);
            },
            error: function(xhr) {
                alert(xhr.responseJSON?.message || 'Gagal menyimpan catatan pasien.');
            }
        });
    });

    $("#formEditBaru").on("submit", function(e) {
        e.preventDefault();
        let form = $(this);
        $.ajax({
            url: form.attr('action'),
            method: 'PUT',
            data: form.serialize(),
            success: function(response) {
                if (response.success) {
                    $("#editbaru").modal('hide');
                    alert(response.message);
                    refreshCatatanBaru(form.find('input[name=ruangan]').val());
                } else alert(response.message);
            },
            error: function(xhr) {
                alert(xhr.responseJSON?.message || 'Gagal mengubah catatan pasien.');
            }
        });
    });

    // Delete Handlers for Catatan
    $(document).on('click', '#dataTableistimewa .btn-hapus, #dataTablebaru .btn-hapus', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        let tableId = $(this).closest('table').attr('id');
        let isIstimewa = (tableId === 'dataTableistimewa');

        PUAlert.confirmAction({
            text: 'Apakah Anda yakin ingin menghapus data ini?',
            confirmButtonText: 'Ya, hapus'
        }, function() {
            $.ajax({
                url: 'deletecatatanpasien',
                method: 'DELETE',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        if (isIstimewa) {
                            refreshCatatanIstimewa();
                        } else {
                            refreshCatatanBaru();
                        }
                    } else alert("Error");
                },
                error: function(xhr) {
                    alert(xhr.responseJSON?.message || 'Gagal menghapus catatan pasien.');
                }
            });
        });
    });

    function reinitDataTables() {
        if ($.fn.DataTable.isDataTable('#dataTable')) {
            $('#dataTable').DataTable().destroy();
        }
        if ($.fn.DataTable.isDataTable('#dataTable2')) {
            $('#dataTable2').DataTable().destroy();
        }

        if ($('#dataTable').length) {
            $('#dataTable').DataTable({
                "pageLength": 5,
                "ordering": false,
                "lengthMenu": [
                    [5, 10, 25, -1],
                    [5, 10, 25, "Semua"]
                ]
            });
        }

        if ($('#dataTable2').length) {
            $('#dataTable2').DataTable({
                "pageLength": 5,
                "ordering": false,
                "lengthMenu": [
                    [5, 10, 25, -1],
                    [5, 10, 25, "Semua"]
                ]
            });
        }
    }

    if (window.Livewire) {
        Livewire.hook('message.processed', () => {
            setTimeout(reinitDataTables, 0);
        });
    }

    // Set z-index untuk modal agar selalu di atas
    $(document).on('show.bs.modal', '.modal', function() {
        var zIndex = 1040 + (10 * $('.modal.show').length);
        $(this).css('z-index', zIndex);
        setTimeout(function() {
            $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
        }, 0);
    });
</script>
@endpush