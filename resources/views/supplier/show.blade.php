@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <a href="{{ url('supplier') }}" class="btn btn-sm btn-default">Kembali</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th width="200">ID</th>
                <td>{{ $supplier->supplier_id }}</td>
            </tr>
            <tr>
                <th>Kode Supplier</th>
                <td>{{ $supplier->supplier_kode }}</td>
            </tr>
            <tr>
                <th>Nama Supplier</th>
                <td>{{ $supplier->supplier_nama }}</td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td>{{ $supplier->supplier_alamat }}</td>
            </tr>
            <tr>
                <th>Dibuat pada</th>
                <td>{{ $supplier->created_at }}</td>
            </tr>
            <tr>
                <th>Diperbarui pada</th>
                <td>{{ $supplier->updated_at }}</td>
            </tr>
        </table>
    </div>
</div>
@endsection
