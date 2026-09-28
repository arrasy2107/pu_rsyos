@extends('master.master')

@section('page_title', 'Data Jenis SDMK')

@section('custom_style')
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<style>
    .btn-action-group {
        display: flex;
        gap: 0.5rem;
    }
</style>
@stop

@section('content')

<x-alert />

<x-page-header title="Manajemen Jenis SDMK" subtitle="Kelola data jenis Sumber Daya Manusia Kesehatan">
    <x-slot name="actions">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah">
            <i class="fas fa-plus"></i> Tambah Jenis SDMK
        </button>
    </x-slot>
</x-page-header>

<x-data-card title="Daftar Jenis SDMK" icon="fas fa-tags">
    <div class="table-responsive">
        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Subrumpun SDMK</th>
                    <th>Jenis SDMK</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                @foreach(\App\Models\sdmk_jenis::where('status',1)->get() as $data)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td>{{ \App\Models\sdmk_subrumpun::where('id',$data->id_subrumpun)->pluck('subrumpun')->first() }}</td>
                    <td class="fw-bold">{{ $data->jenis }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <button value="{{ $data->id }}" class="btn btn-sm btn-info btn-edit"
                                data-nama="{{$data->jenis}}" data-subrumpun="{{ $data->id_subrumpun }}"
                                data-bs-toggle="modal" data-bs-target="#edit" title="Edit Data">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('deletejenissdmk', $data->id) }}" method="POST"
                                class="d-inline"
                                onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus Data">
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
</x-data-card>

{{-- MODAL TAMBAH --}}
<div id="tambah" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><i class="fas fa-plus-circle me-2 text-primary"></i> Tambah Jenis SDMK</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ route('tambahjenissdmk') }}" autocomplete="off">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <label>Subrumpun SDMK</label>
                        <select class="form-control" name="id_subrumpun" required>
                            <option value="" selected disabled hidden>Pilih Subrumpun...</option>
                            @foreach(\App\Models\sdmk_subrumpun::where('status',1)->get() as $mb)
                            <option value="{{ $mb->id }}">{{ $mb->subrumpun }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-0">
                        <label>Nama Jenis SDMK</label>
                        <div class="pu-input-icon-wrap">
                            <span class="pu-input-prefix"><i class="fas fa-tag"></i></span>
                            <input type="text" class="form-control" name="jenis" placeholder="Masukkan nama jenis SDMK" required />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL EDIT --}}
<div id="edit" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><i class="fas fa-edit me-2 text-info"></i> Ubah Jenis SDMK</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ route('editjenissdmk') }}" autocomplete="off">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <input type="hidden" class="txtid" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Subrumpun SDMK</label>
                        <select class="form-control txt-subrumpun" name="id_subrumpun" required>
                            <option value="" selected disabled hidden>Pilih Subrumpun...</option>
                            @foreach(\App\Models\sdmk_subrumpun::where('status',1)->get() as $mb)
                            <option value="{{ $mb->id }}">{{ $mb->subrumpun }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-0">
                        <label>Nama Jenis SDMK</label>
                        <div class="pu-input-icon-wrap">
                            <span class="pu-input-prefix"><i class="fas fa-tag"></i></span>
                            <input type="text" class="form-control txt-nama" name="jenis" required />
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

<script>
    $(document).ready(function() {
        $("#dataTable").DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json'
            },
            pageLength: 10
        });

        let id, nama, subrumpun;
        $("#dataTable").on('click', '.btn-edit', function() {
            id = $(this).val();
            nama = $(this).data('nama');
            subrumpun = $(this).data('subrumpun');

            // populate immediately so modal shows values without extra clicks
            $(".txtid").val(id);
            $(".txt-nama").val(nama);
            $(".txt-subrumpun").val(subrumpun);
        });

        $('#edit').on('show.bs.modal', function() {
            $(".txtid").val(id);
            $(".txt-nama").val(nama);
            $(".txt-subrumpun").val(subrumpun);
        });


        setTimeout(function() {
            $(".alert-call").fadeOut(500);
        }, 3500);
    });
</script>
@stop
