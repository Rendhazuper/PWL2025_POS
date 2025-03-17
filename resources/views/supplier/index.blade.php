@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <a class="btn btn-sm btn-primary mt-1" href="{{ url('supplier/create') }}">Tambah</a>
            <button onclick="modalAction('{{ url('supplier/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah Ajax</button>
        </div>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered table-striped table-hover table-sm" id="table_supplier">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kode Supplier</th>
                    <th>Nama Supplier</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('css')
@endpush

@push('js')
<script>
function modalAction(url = ''){
    console.log('Opening modal with URL:', url);
    $('#myModal').load(url, function(response, status, xhr){
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

var dataSupplier;
$(document).ready(function() {
    console.log('Page initialized');

    // Tambahkan CSS untuk memastikan SweetAlert muncul sebagai popup
    $('<style>')
        .text(`
            .swal2-popup-modal {
                position: fixed !important;
                top: 50% !important;
                left: 50% !important;
                transform: translate(-50%, -50%) !important;
                z-index: 9999 !important;
            }
        `)
        .appendTo('head');

    // Setup AJAX CSRF
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    dataSupplier = $('#table_supplier').DataTable({
        serverSide: true,
        processing: true,
        ajax: {
            "url": "{{ url('supplier/list') }}",
            "dataType": "json",
            "type": "POST",
            error: function(xhr, error, thrown) {
                console.error('DataTable Error:', error);
            }
        },
        columns: [
            {
                data: "DT_RowIndex",
                className: "text-center",
                orderable: false,
                searchable: false
            },
            {
                data: "supplier_kode",
                orderable: true,
                searchable: true
            },
            {
                data: "supplier_nama",
                orderable: true,
                searchable: true
            },
            {
                data: "supplier_alamat",
                orderable: true,
                searchable: true
            },
            {
                data: "aksi",
                orderable: false,
                searchable: false
            }
        ]
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
