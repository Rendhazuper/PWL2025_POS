@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <a class="btn btn-sm btn-primary mt-1" href="{{ url('barang/create') }}">Tambah</a>
            <button onclick="modalAction('{{ url('barang/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah Ajax</button>
        </div>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered table-striped table-hover table-sm" id="table_barang">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('css')
<style>
    .dataTables_wrapper {
        min-height: 200px;
    }
    .dataTables_processing {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 250px;
        margin-left: -125px;
        margin-top: -15px;
        padding: 10px;
        border: 1px solid #ddd;
        text-align: center;
        color: #999;
        font-size: 14px;
        background-color: white;
        z-index: 1;
    }
</style>
@endpush

@push('js')
<script>
function modalAction(url = '') {
    console.log('Opening modal with URL:', url);
    $('#myModal').load(url, function(response, status, xhr) {
        if (status == 'error') {
            console.error('Error loading modal:', xhr.status, xhr.statusText);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Gagal memuat form',
                customClass: {
                    popup: 'swal2-popup-modal'
                }
            });
            return;
        }
        console.log('Modal loaded successfully');
        $('#myModal').modal('show');
    });
}

// Inisialisasi SweetAlert2 Default Config
const swalConfig = {
    customClass: {
        popup: 'swal2-popup-modal'
    },
    buttonsStyling: true,
    confirmButtonClass: 'btn btn-primary',
    cancelButtonClass: 'btn btn-danger'
};

// Extend default config untuk Toast
const Toast = Swal.mixin({
    ...swalConfig,
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

var dataBarang;
$(document).ready(function() {
    console.log('Page initialized');

    // Setup AJAX CSRF
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    dataBarang = $('#table_barang').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        ajax: {
            url: "{{ url('barang/list') }}",
            type: "POST",
            dataType: "json",
            error: function(xhr, error, thrown) {
                console.error('DataTable Error:', error);
            }
        },
        columns: [
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                className: "text-center",
                orderable: false,
                searchable: false
            },
            {
                data: "barang_kode",
                name: "barang_kode",
                orderable: true,
                searchable: true
            },
            {
                data: "barang_nama",
                name: "barang_nama",
                orderable: true,
                searchable: true
            },
            {
                data: "kategori.kategori_nama",
                name: "kategori.kategori_nama",
                orderable: true,
                searchable: true
            },
            {
                data: "harga_beli",
                name: "harga_beli",
                className: "text-right",
                orderable: true,
                searchable: true,
                render: function(data, type, row) {
                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(data);
                }
            },
            {
                data: "harga_jual",
                name: "harga_jual",
                className: "text-right",
                orderable: true,
                searchable: true,
                render: function(data, type, row) {
                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(data);
                }
            },
            {
                data: "aksi",
                name: "aksi",
                className: "text-center",
                orderable: false,
                searchable: false
            }
        ],
        order: [[1, 'asc']],
        language: {
            processing: 'Memproses data...',
            searchPlaceholder: 'Cari data...',
            search: '',
            lengthMenu: '_MENU_ data per halaman',
            zeroRecords: 'Tidak ada data yang ditemukan',
            info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
            infoEmpty: 'Menampilkan 0 sampai 0 dari 0 data',
            infoFiltered: '(difilter dari _MAX_ total data)',
            paginate: {
                first: 'Pertama',
                last: 'Terakhir',
                next: 'Selanjutnya',
                previous: 'Sebelumnya'
            }
        },
        drawCallback: function(settings) {
            // Reinitialize tooltips after DataTable redraw
            $('[data-toggle="tooltip"]').tooltip();
        }
    });

    // Handle modal events
    $(document).on('hidden.bs.modal', '#myModal', function () {
        console.log('Modal hidden - clearing content');
        $(this).empty();
    });

    // Global AJAX Error Handler
    $(document).ajaxError(function(event, xhr, settings, error) {
        console.error('Global AJAX Error:', error);
        console.log('Status:', xhr.status);
        console.log('Response:', xhr.responseText);
    });
});
</script>
@endpush
