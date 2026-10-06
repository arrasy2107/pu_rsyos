<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/3.3.3/js/dataTables.fixedColumns.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        const ruanganSelect = $('#inap_ruangan');

        if (ruanganSelect.length && $.fn.select2) {
            ruanganSelect.select2({
                width: '100%',
                placeholder: 'Pilih Ruangan',
                allowClear: true
            });
        }

        // DataTables Initialization
        const irjTable = $("#dataTableIRJ").DataTable({
            "scrollY": "48vh",
            "scrollX": true,
            "scrollCollapse": true,
            "ordering": false,
            "paging": false,
            "searching": false,
            "info": false,
            "responsive": false,
            "autoWidth": false
        });

        $('#irjSearch').on('input', function() {
            irjTable.column(2).search(this.value).draw();
        });

        $('#irjSdmkFilter').on('change', function() {
            irjTable.column(1).search(this.value).draw();
        });

        $('#irjResetFilter').on('click', function() {
            $('#irjSearch, #irjSdmkFilter').val('');
            irjTable.search('').columns().search('').draw();
        });

        $('#irjExportCsv').on('click', function() {
            const headers = irjTable.columns().header().toArray().map(header => $(header).text().trim());
            const rows = irjTable.rows({ search: 'applied' }).nodes().toArray().map(row =>
                $(row).find('td').toArray().map(cell => $(cell).text().replace(/\s+/g, ' ').trim())
            );
            const csv = [headers, ...rows]
                .map(row => row.map(value => '"' + value.replace(/"/g, '""') + '"').join(','))
                .join('\n');
            const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = 'laporan-irj.csv';
            link.click();
            URL.revokeObjectURL(url);
        });

        $('#irjPrint').on('click', function() {
            const printWindow = window.open('', '_blank', 'width=1200,height=800');
            if (!printWindow) return;
            printWindow.document.write('<html><head><title>Laporan IRJ</title>');
            printWindow.document.write('<style>body{font-family:Arial,sans-serif;padding:24px}table{width:100%;border-collapse:collapse;font-size:12px}th,td{border:1px solid #cbd5e1;padding:8px;text-align:left}th{background:#eef4fb}</style>');
            printWindow.document.write('</head><body><h2>Laporan IRJ</h2>' + $('#dataTableIRJ').prop('outerHTML') + '</body></html>');
            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
        });

        const ibsTable = $("#dataTableIBS").DataTable({
            "scrollY": "52vh",
            "scrollX": true,
            "scrollCollapse": true,
            "ordering": false,
            "paging": false,
            "searching": false,
            "info": false,
            "responsive": false,
            "autoWidth": false
        });

        $('#ibsSearch').on('input', function() {
            ibsTable.search(this.value).draw();
        });

        $('#ibsRoomFilter').on('change', function() {
            ibsTable.column(5).search(this.value).draw();
        });

        $('#ibsDoctorFilter').on('input', function() {
            ibsTable.column(2).search(this.value).draw();
        });

        $('#ibsResetFilter').on('click', function() {
            $('#ibsSearch, #ibsDoctorFilter').val('');
            $('#ibsRoomFilter').val('');
            ibsTable.search('').columns().search('').draw();
        });

        $('#ibsExportCsv').on('click', function() {
            const headers = ibsTable.columns().header().toArray().map(header => $(header).text().trim());
            const rows = ibsTable.rows({ search: 'applied' }).nodes().toArray().map(row =>
                $(row).find('td').toArray().map(cell => $(cell).text().replace(/\s+/g, ' ').trim())
            );
            const csv = [headers, ...rows]
                .map(row => row.map(value => '"' + value.replace(/"/g, '""') + '"').join(','))
                .join('\n');
            const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = 'laporan-ibs.csv';
            link.click();
            URL.revokeObjectURL(url);
        });

        $('#ibsPrint').on('click', function() {
            const printWindow = window.open('', '_blank', 'width=1200,height=800');
            if (!printWindow) return;
            printWindow.document.write('<html><head><title>Laporan IBS</title>');
            printWindow.document.write('<style>body{font-family:Arial,sans-serif;padding:24px}table{width:100%;border-collapse:collapse;font-size:12px}th,td{border:1px solid #cbd5e1;padding:8px;text-align:left}th{background:#eef4fb}details{display:block}summary{display:none}</style>');
            printWindow.document.write('</head><body><h2>Laporan IBS</h2>' + $('#dataTableIBS').prop('outerHTML') + '</body></html>');
            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
        });

        // #dataTableRuangan sudah diganti dengan card grid \u2014 tidak perlu DataTable init

        function selectKpi(target) {
            $('.pu-kpi-card[data-kpi-target]').each(function() {
                const card = this;
                const isSelected = card.getAttribute('data-kpi-target') === target;
                const wasSelected = card.classList.contains('is-selected');

                card.classList.toggle('is-selected', isSelected);
                card.setAttribute('aria-selected', isSelected ? 'true' : 'false');

                if (isSelected && !wasSelected) {
                    card.classList.remove('is-activating');
                    void card.offsetWidth;
                    card.classList.add('is-activating');
                    window.setTimeout(function() {
                        card.classList.remove('is-activating');
                    }, 400);
                }
            });
        }

        $('.pu-kpi-card[data-kpi-target]').on('click', function() {
            const target = this.getAttribute('data-kpi-target');
            const tab = document.querySelector('#dashboardTabs .nav-link[data-bs-target="' + target + '"]');
            if (tab && window.bootstrap) {
                window.bootstrap.Tab.getOrCreateInstance(tab).show();
            }
            selectKpi(target);
        }).on('keydown', function(event) {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                $(this).trigger('click');
            }
        });

        $('#dashboardTabs').on('shown.bs.tab', '.nav-link', function() {
            selectKpi(this.getAttribute('data-bs-target'));
        });

        const activeDashboardTab = document.querySelector('#dashboardTabs .nav-link.active');
        selectKpi(activeDashboardTab ? activeDashboardTab.getAttribute('data-bs-target') : '#panel-igd');

        // Filter Ruangan — client-side: tampilkan/sembunyikan card sesuai pilihan
        $("#inap_ruangan").on('change', function() {
            const val = $(this).val();
            $('#ruanganCardGrid .ruangan-card').each(function() {
                const ruanganId = String($(this).data('ruangan-id') || '');
                $(this).toggle(!val || ruanganId === String(val));
            });
        });

        // Modal Istimewa — delegasi event ke #ruanganCardGrid (card grid baru)
        $(document).on('click', '#ruanganCardGrid .btn-istimewa', function() {
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

        // Modal Pasien Baru — delegasi event ke document (card grid baru)
        $(document).on('click', '#ruanganCardGrid .btn-baru', function() {
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

        // Modal Permasalahan — delegasi event ke document (card grid baru)
        $(document).on('click', '#ruanganCardGrid .btn-permasalahan', function() {
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

        const tabs = document.querySelector('.pu-review-tabs .nav-tabs');
        if (tabs) {
            const updateTabHint = function() {
                tabs.classList.toggle('has-overflow', tabs.scrollWidth > tabs.clientWidth);
                tabs.classList.toggle('is-scrolled', tabs.scrollLeft > 4);
            };
            updateTabHint();
            tabs.addEventListener('scroll', updateTabHint, { passive: true });
            window.addEventListener('resize', updateTabHint);
        }
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