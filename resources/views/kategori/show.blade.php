@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <a href="{{ url('kategori') }}" class="btn btn-sm btn-default">Kembali</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th width="200">ID</th>
                <td>{{ $kategori->kategori_id }}</td>
            </tr>
            <tr>
                <th>Kode Kategori</th>
                <td>{{ $kategori->kategori_kode }}</td>
            </tr>
            <tr>
                <th>Nama Kategori</th>
                <td>{{ $kategori->kategori_nama }}</td>
            </tr>
            <tr>
                <th>Dibuat pada</th>
                <td>{{ $kategori->created_at }}</td>
            </tr>
            <tr>
                <th>Diperbarui pada</th>
                <td>{{ $kategori->updated_at }}</td>
            </tr>
        </table>
    </div>
</div>
@endsection
