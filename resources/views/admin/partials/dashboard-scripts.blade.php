<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/3.3.3/js/dataTables.fixedColumns.min.js"></script>
<script>
    $(document).ready(function() {
        // DataTables Initialization
        $("#dataTableIRJ").DataTable({
            "pageLength": 5,
            "ordering": false,
            "lengthMenu": [
                [5, 10, 25, -1],
                [5, 10, 25, "Semua"]
            ]
        });

        $("#dataTableIBS").DataTable({
            "pageLength": 5,
            "ordering": false,
            "lengthMenu": [
                [5, 10, 25, -1],
                [5, 10, 25, "Semua"]
            ]
        });

        $('#dataTableRuangan').DataTable({
            scrollX: true,
            ordering: false,
            paging: false,
            searching: false,
            info: false,
            fixedColumns: {
                leftColumns: 1
            }
        });

        // Load Laporan Ruangan (Livewire if available, fallback to AJAX)
        $("#inap_ruangan").change(function() {
            let val = $(this).val();
            if (window.Livewire) {
                Livewire.dispatch('ruanganChanged', val);
            } else {
                $(".tablelaporan").html('<div class="text-center py-4 text-primary"><i class="fas fa-circle-notch fa-spin fa-2x mb-2"></i><p>Memuat data ruangan...</p></div>');
                $.ajax({
                    type: "get",
                    url: 'refresh-laporan-umum-pu/' + val,
                    data: {
                        ruangan: val
                    },
                    success: function(data) {
                        $(".tablelaporan").html(data);
                    }
                });
            }
        });

        // AJAX Modals
        $("#dataTableRuangan").on('click', '.btn-istimewa', function() {
            let idlaporan = $(this).data('id');
            let ruangan = $(this).data('ruangan');
            if (window.Livewire) {
                Livewire.dispatch('openIstimewaModal', {
                    idlaporan: idlaporan,
                    idruangan: ruangan
                });
                $('#istimewa').modal('show');
            } else {
                $(".tableistimewa").html('<div class="text-center text-gray-500 py-3"><i class="fas fa-circle-notch fa-spin fa-2x mb-3"></i><p>Memuat data...</p></div>');
                $.ajax({
                    type: "get",
                    url: 'refresh-istimewa/' + idlaporan + '/' + ruangan,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        idlaporan: idlaporan,
                        idruangan: ruangan
                    },
                    success: function(data) {
                        $(".tableistimewa").html(data);
                    }
                });
            }
        });

        $("#dataTableRuangan").on('click', '.btn-baru', function() {
            let idlaporan = $(this).data('id');
            let ruangan = $(this).data('ruangan');
            if (window.Livewire) {
                Livewire.dispatch('openBaruModal', {
                    idlaporan: idlaporan,
                    idruangan: ruangan
                });
                $('#baru').modal('show');
            } else {
                $(".tablebaru").html('<div class="text-center text-gray-500 py-3"><i class="fas fa-circle-notch fa-spin fa-2x mb-3"></i><p>Memuat data...</p></div>');
                $.ajax({
                    type: "get",
                    url: 'refresh-baru/' + idlaporan + '/' + ruangan,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        idlaporan: idlaporan,
                        idruangan: ruangan
                    },
                    success: function(data) {
                        $(".tablebaru").html(data);
                    }
                });
            }
        });

        $("#dataTableRuangan").on('click', '.btn-permasalahan', function() {
            let idlaporan = $(this).data('id');
            let ruangan = $(this).data('ruangan');
            if (window.Livewire) {
                Livewire.dispatch('openPermasalahanModal', {
                    idlaporan: idlaporan,
                    idruangan: ruangan
                });
                $('#permasalahan').modal('show');
            } else {
                $(".tablemasalah").html('<div class="text-center text-gray-500 py-3"><i class="fas fa-circle-notch fa-spin fa-2x mb-3"></i><p>Memuat data...</p></div>');
                $.ajax({
                    type: "get",
                    url: 'refresh-permasalahan/' + idlaporan + '/' + ruangan,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        idlaporan: idlaporan,
                        idruangan: ruangan
                    },
                    success: function(data) {
                        $(".tablemasalah").html(data);
                    }
                });
            }
        });
        // Perbaikan DataTables di dalam Bootstrap 5 Tabs
        // Paksa hitung ulang lebar kolom saat tab ditampilkan
        $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
            $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
        });
    });


    // Icon Hover Effects for IGD
    const iconPaths = {
        normal: '{{asset("sb-admin/icon/igd/")}}/',
        hover: '{{asset("sb-admin/icon/warna/igd/")}}/'
    };

    const igdIcons = [{
            id: 1,
            file: 'pasien-dirawat.png'
        },
        {
            id: 2,
            file: 'pasien-pulang.png'
        },
        {
            id: 3,
            file: 'pasien-emergency.png'
        },
        {
            id: 4,
            file: 'pasien-non-emergency.png'
        },
        {
            id: 5,
            file: 'pasien-tidak-bisa-dirawat.png'
        },
        {
            id: 6,
            file: 'pasien-doa.png'
        },
        {
            id: 7,
            file: 'sisrute.png'
        },
        {
            id: 8,
            file: 'sisrute-terima.png'
        },
        {
            id: 9,
            file: 'sisrute-tolak.png'
        }
    ];

    // Dynamically create hover functions to match legacy inline calls
    igdIcons.forEach(icon => {
        window['igd' + icon.id + 'a'] = function() {
            document.getElementById('gbr_igd_' + icon.id).setAttribute('src', iconPaths.hover + icon.file);
        };
        window['igd' + icon.id + 'b'] = function() {
            document.getElementById('gbr_igd_' + icon.id).setAttribute('src', iconPaths.normal + icon.file);
        };
    });

    $(document).on('mouseenter', '.icon-hover-container', function() {
        const iconId = $(this).data('icon-id');
        if (window['igd' + iconId + 'a']) {
            window['igd' + iconId + 'a']();
        }
    }).on('mouseleave', '.icon-hover-container', function() {
        const iconId = $(this).data('icon-id');
        if (window['igd' + iconId + 'b']) {
            window['igd' + iconId + 'b']();
        }
    });
</script>