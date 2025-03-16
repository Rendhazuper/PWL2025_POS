@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <a href="{{ url('level') }}" class="btn btn-sm btn-default">Kembali</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th width="200">ID</th>
                <td>{{ $level->level_id }}</td>
            </tr>
            <tr>
                <th>Kode Level</th>
                <td>{{ $level->level_kode }}</td>
            </tr>
            <tr>
                <th>Nama Level</th>
                <td>{{ $level->level_nama }}</td>
            </tr>
            <tr>
                <th>Dibuat pada</th>
                <td>{{ $level->created_at }}</td>
            </tr>
            <tr>
                <th>Diperbarui pada</th>
                <td>{{ $level->updated_at }}</td>
            </tr>
        </table>
    </div>
</div>
@endsection
