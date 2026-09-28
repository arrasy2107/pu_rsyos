@extends('master.master')

@section('page_title', 'Kelola Blog / Artikel')

@section('custom_style')
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<style>
    .btn-action-group {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .blog-img {
        width: 150px;
        height: 100px;
        object-fit: cover;
        border: 1px solid var(--color-neutral-200);
        border-radius: var(--radius-sm);
        padding: 3px;
        background: white;
    }
</style>
@stop

@section('content')

<x-alert />

<div class="pu-page-header">
    <div>
        <h1>Manajemen Blog</h1>
        <p class="pu-page-subtitle">Kelola artikel, berita, atau pengumuman sistem</p>
    </div>
    <div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah">
            <i class="fas fa-plus"></i> Tulis Artikel Baru
        </button>
    </div>
</div>

<div class="card mb-4 animate-fade-in-up">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h6 class="m-0 fw-bold text-primary"><i class="fas fa-newspaper me-2"></i> Daftar Artikel</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th width="12%">Tanggal</th>
                        <th width="15%" class="text-center">Gambar</th>
                        <th width="20%">Judul</th>
                        <th>Ringkasan</th>
                        <th width="12%">Penulis</th>
                        <th width="12%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(\App\Blog::orderBy('tanggal','desc')->get() as $data)
                    <tr>
                        <td class="align-middle fw-bold">{{ \Carbon\Carbon::parse($data->tanggal)->isoFormat('D MMMM Y') }}</td>
                        <td class="text-center align-middle">
                            <img class="blog-img shadow-sm" src="{{url($data->gambar? 'teeto/images/blog/'.$data->gambar:'teeto/images/blog/noimage.png')}}" alt="Thumbnail">
                        </td>
                        <td class="align-middle fw-bold text-dark">{{ $data->judul }}</td>
                        <td class="align-middle text-muted small">{{ \Illuminate\Support\Str::limit($data->text_preview, 100) }}</td>
                        <td class="align-middle"><span class="badge bg-info">{{ \App\User::where('id',$data->penulis)->pluck('name')->first() }}</span></td>
                        <td class="align-middle">
                            <div class="btn-action-group">
                                <button value="{{ $data->id }}" class="btn btn-sm btn-info btn-edit shadow-sm"
                                    data-judul="{{$data->judul}}"
                                    data-subjudul="{{ $data->subjudul }}"
                                    data-ringkasan="{{$data->text_preview}}"
                                    data-penulis="{{ $data->penulis }}"
                                    data-tanggal="{{ $data->tanggal }}"
                                    data-teks="{{ $data->teks }}"
                                    data-bs-toggle="modal" data-bs-target="#edit" title="Edit Artikel">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('deleteblog', $data->id) }}" method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Yakin ingin menghapus artikel ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger shadow-sm" title="Hapus Artikel">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH --}}
<div id="tambah" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header pu-card-gradient-header text-white">
                <h5 class="modal-title fw-bold"><i class="fas fa-pen-nib me-2"></i> Tulis Artikel Baru</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ route('tambahblog') }}" enctype="multipart/form-data" autocomplete="off">
                {{ csrf_field() }}
                <div class="modal-body bg-light p-4">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="fw-bold">Judul Artikel</label>
                                <input type="text" class="form-control" name="judul" placeholder="Masukkan judul artikel" required />
                            </div>

                            <div class="form-group">
                                <label class="fw-bold">Isi Artikel</label>
                                <textarea class="form-control" id="editor1" name="teks" rows="15" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card shadow-sm mb-3">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="fw-bold">Tanggal</label>
                                        <input type="date" class="form-control" name="tanggal" required value="{{ date('Y-m-d') }}" />
                                    </div>
                                    <div class="form-group">
                                        <label class="fw-bold">Gambar Cover</label>
                                        <div class="custom-file">
                                            <input type="file" name="image" class="custom-file-input" id="customFile" accept="image/*" required>
                                            <label class="custom-file-label" for="customFile">Pilih file gambar</label>
                                        </div>
                                    </div>
                                    <div class="form-group mb-0">
                                        <label class="fw-bold">Ringkasan (Preview)</label>
                                        <textarea class="form-control" name="text_preview" rows="4" placeholder="Tuliskan ringkasan singkat artikel ini..." required></textarea>
                                        <small class="text-muted">Maksimal 150 karakter. Muncul pada halaman daftar blog.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane me-1"></i> Terbitkan Artikel</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL EDIT --}}
<div id="edit" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header pu-card-gradient-header text-white">
                <h5 class="modal-title fw-bold"><i class="fas fa-edit me-2"></i> Edit Artikel</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ route('editblog') }}" enctype="multipart/form-data" autocomplete="off">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <input type="hidden" class="txtid" name="id">

                <div class="modal-body bg-light p-4">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="fw-bold">Judul Artikel</label>
                                <input type="text" class="form-control txt-judul" name="judul" required />
                            </div>

                            <div class="form-group">
                                <label class="fw-bold">Isi Artikel</label>
                                <textarea class="form-control txt-teks" id="editor" name="teks" rows="15" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card shadow-sm mb-3">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="fw-bold">Tanggal</label>
                                        <input type="date" class="form-control txt-tanggal" name="tanggal" required />
                                    </div>
                                    <div class="form-group">
                                        <label class="fw-bold">Gambar Cover</label>
                                        <div class="custom-file">
                                            <input type="file" name="image" class="custom-file-input txt-gambar" id="customFile2" accept="image/*">
                                            <label class="custom-file-label" for="customFile2">Pilih gambar (opsional)</label>
                                        </div>
                                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                                    </div>
                                    <div class="form-group mb-0">
                                        <label class="fw-bold">Ringkasan (Preview)</label>
                                        <textarea class="form-control txt-ringkasan" name="text_preview" rows="4" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-info"><i class="fas fa-save me-1"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('custom_script')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="{{asset('teeto/js/ckeditor/ckeditor.js')}}"></script>

<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        $("#dataTable").DataTable({
            "ordering": false,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json'
            },
            pageLength: 10
        });

        // Custom File Input label update
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });

        // Auto-hide alerts
        setTimeout(function() {
            $(".alert-call").fadeOut(500);
        }, 3500);

        // Initialize CKEditor
        CKEDITOR.replace('editor1', {
            filebrowserUploadUrl: '{{ route('
            upload ',['
            _token ' => csrf_token() ]) }}',
            filebrowserUploadMethod: 'form'
        });

        CKEDITOR.replace('editor', {
            filebrowserUploadUrl: '{{ route('
            upload ',['
            _token ' => csrf_token() ]) }}',
            filebrowserUploadMethod: 'form'
        });

        // Edit button click handler
        let id, judul, ringkasan, penulis, tanggal, teks;
        $("#dataTable").on('click', '.btn-edit', function() {
            id = $(this).val();
            judul = $(this).data('judul');
            ringkasan = $(this).data('ringkasan');
            penulis = $(this).data('penulis');
            tanggal = $(this).data('tanggal');
            teks = $(this).data('teks');
            // populate immediately so modal shows values without extra clicks
            $(".txtid").val(id);
            $(".txt-judul").val(judul);
            $(".txt-ringkasan").val(ringkasan);
            $(".txt-penulis").val(penulis);
            $(".txt-tanggal").val(tanggal);
        });

        $('#edit').on('show.bs.modal', function() {
            $(".txtid").val(id);
            $(".txt-judul").val(judul);
            $(".txt-ringkasan").val(ringkasan);
            $(".txt-penulis").val(penulis);
            $(".txt-tanggal").val(tanggal);

            // Reset file input label
            $(".txt-gambar").val("");
            $("#customFile2").next('.custom-file-label').html("Pilih gambar (opsional)");

            // Wait for CKEditor to be fully loaded before setting data
            setTimeout(function() {
                CKEDITOR.instances['editor'].setData(teks);
            }, 100);
        });

    });
</script>
@stop
