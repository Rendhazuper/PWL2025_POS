@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <a class="btn btn-sm btn-primary mt-1" href="{{ url('stok/create') }}">Tambah</a>
            <button onclick= "modalAction('{{ url('stok/create') }}')" class = "btn btn-sm btn-success mt-1">Tambah ajax</button>
        </div>
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped table-hover table-sm" id="tabel_stok">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Barang</th>
                    <th>Jumlah Stok</th>
                    <th>Supplier</th>
                    <th>Petugas Input</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" databackdrop="static" 
data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('css')
@endpush

@push('js')
<script>
    function modalAction(url = '') {
      $('#myModal').load(url,function(){
        $('#myModal').modal('show');
});
}
    $(document).ready(function() {
        $('#tabel_stok').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('stok/list') }}",
                type: "POST"
            },
            columns: [
                {
                    data: 'DT_RowIndex',
                    className: "text-center",
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'barang.barang_nama',
                    className: "",
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'stok_jumlah',
                    className: "",
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'supplier.supplier_nama',
                    className: "",
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'user.nama',
                    className: "",
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'aksi',
                    className: "text-center",
                    orderable: false,
                    searchable: false
                }
            ]
        });
    });
</script>
@endpush
