@if(\App\Models\Laporanumum::where('status',1)->where('id_ruangan',$ruangan)->pluck('jumlah_total_pasien')->last())
<div class="text-xs fw-bold  text-uppercase mb-1"> Jumlah Pasien lama <span ><a  data-bs-toggle="tooltip" data-bs-placement="right" title="Jumlah Pasien Lama Otomatis dari Inputan Dinas Sebelumnya"><i class="fa  fa-exclamation-circle"></i></a></span></div>
     <div class="h5 mb-0 me-3 fw-bold text-gray-800">
            <input type="number" class="form-control" id="inap_pasien_lama" name="inap_pasien_lama" onfocus="ranap1a();" onfocusout="ranap1b();" value="{{\App\Models\Laporanumum::where('status',1)->where('id_ruangan',$ruangan)->pluck('jumlah_total_pasien')->last()}}" autocomplete="off" readonly />
            <a href="#" id="editpasienlama" class="fa fa-edit" style="font-size:16px">Ubah</a>
</div>
@else
<div class="text-xs fw-bold  text-uppercase mb-1"> Jumlah Pasien lama</div>
     <div class="h5 mb-0 me-3 fw-bold text-gray-800">
            <input type="number" class="form-control" id="inap_pasien_lama" name="inap_pasien_lama" onfocus="ranap1a();" onfocusout="ranap1b();"  autocomplete="off"  />

</div>

@endif



<script>
    $("#editpasienlama").on('click', function(e) {

document.getElementById("inap_pasien_lama").readOnly = false;

});
</script>
<script>
$(function () {
  $('[data-bs-toggle="tooltip"]').tooltip()
})
</script>