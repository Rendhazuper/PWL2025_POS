@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">

    <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Transaksi Penjualan</h3>

              <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                  <div class="input-group-append">
                    <button type="submit" class="btn btn-default">
                      <i class="fas fa-search"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0" style="height: 300px;">
              <table class="table table-head-fixed text-nowrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kasir</th>
                        <th>Pembeli</th>
                        <th>Tanggal</th>
                        <th>Barang</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rekap as $data)
                    <tr>
                        <td>{{ $data->penjualan_id }}</td>
                        <td>{{ $data->user->nama }}</td>
                        <td>{{ $data->pembeli }}</td>
                        <td>{{ $data->penjualan_tanggal }}</td>
                        <td>
                            @foreach($data->detailPenjualan as $detail)
                                {{ $detail->barang->barang_nama }}<br>
                            @endforeach
                        </td>
                        <td>
                            @foreach($data->detailPenjualan as $detail)
                                {{ $detail->harga }}<br>
                            @endforeach
                        </td>
                        <td>
                            @foreach($data->detailPenjualan as $detail)
                                {{ $detail->jumlah }}<br>
                            @endforeach
                        </td>
                    </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
</div>

<div class="card card-outline card-primary mt-3">
    <div class="card-header">
        <h3 class="card-title">Form Transaksi</h3>
    </div>
    <div class="card-body">
        <form id="transactionForm">
            <div class="form-group">
                <label for="kasir_id">Kasir</label>
                <select name="kasir_id" id="kasir_id" class="form-control">
                    @foreach($kasir as $k)
                    <option value="{{ $k->user_id }}">{{ $k->nama }}</option>
                    @endforeach
                </select>
                <small id="error-kasir_id" class="error-text form-text text-danger"></small>
            </div>
            <div class="form-group">
                <label for="pembeli">Nama Pembeli</label>
                <input type="text" name="pembeli" id="pembeli" class="form-control" required>
                <small id="error-pembeli" class="error-text form-text text-danger"></small>
            </div>
            <table class="table table-bordered" id="transactionTable">
                <thead>
                    <tr>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Stok Tersedia</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <select name="barang_id[]" class="form-control barang-select">
                                <option value="" disabled selected>Pilih Barang</option>
                                @foreach($barang as $b)
                                <option value="{{ $b->barang_id }}" 
                                        data-price="{{ $b->harga_jual }}" 
                                        data-stock="{{ $b->stok->stok_jumlah ?? 0 }}"> 
                                    {{ $b->barang_nama }}
                                </option>
                                @endforeach
                            </select>
                            <small class="error-text form-text text-danger"></small>
                        </td>
                        <td>
                            <input type="number" name="jumlah[]" class="form-control jumlah-input" min="1" required>
                            <small class="error-text form-text text-danger"></small>
                        </td>
                        <td>
                            <input type="text" class="form-control stok-display" readonly>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm remove-row" style="display: none;">Hapus</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <button type="button" id="addRow" class="btn btn-success btn-sm mt-2">Tambah Barang</button>
            <button type="submit" class="btn btn-primary mt-3">Simpan</button>
        </form>
    </div>
</div>

<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" databackdrop="static" 
data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('css')
@endpush

@push('js')
<script>

$(document).ready(function() {
        function updateStokDisplay(row) {
            var selectedOption = row.find('.barang-select').find(':selected');
            var stock = selectedOption.data('stock') || 0;
            row.find('.stok-display').val(stock);
        }

        $('#transactionTable').on('change', '.barang-select', function() {
            var row = $(this).closest('tr');
            updateStokDisplay(row);
        });

        $('#transactionTable').on('change', '.jumlah-input', function() {
            var row = $(this).closest('tr');
            updateStokDisplay(row);
        });

        $('#addRow').on('click', function() {
            var newRow = `
                <tr>
                    <td>
                       <select name="barang_id[]" class="form-control barang-select">
                                <option value="" disabled selected>Pilih Barang</option>
                                @foreach($barang as $b)
                                <option value="{{ $b->barang_id }}" 
                                        data-price="{{ $b->harga_jual }}" 
                                        data-stock="{{ $b->stok->stok_jumlah ?? 0 }}"> 
                                    {{ $b->barang_nama }}
                                </option>
                                @endforeach
                            </select>
                        <small class="error-text form-text text-danger"></small>
                    </td>
                    <td>
                        <input type="number" name="jumlah[]" class="form-control jumlah-input" min="1" required>
                        <small class="error-text form-text text-danger"></small>
                    </td>
                    <td>
                        <input type="text" class="form-control stok-display" readonly>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-row">Hapus</button>
                    </td>
                </tr>
            `;
            $('#transactionTable tbody').append(newRow);
        });

        $('#transactionTable').on('click', '.remove-row', function() {
            $(this).closest('tr').remove();
        });
    });

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
                url: "{{ url('transaksi/list') }}",
                type: "GET"
            },
            columns: [
        { data: 'DT_RowIndex', className: "text-center", orderable: false, searchable: false },
        { data: 'kasir', className: "", orderable: true, searchable: true },
        { data: 'pembeli', className: "", orderable: true, searchable: true },
        { data: 'barang', className: "", orderable: true, searchable: true },
        { data: 'jumlah', className: "", orderable: true, searchable: true },
        { data: 'nominal', className: "", orderable: true, searchable: true },
        { data: 'tanggal', className: "", orderable: true, searchable: true },
        { data: 'aksi', className: "text-center", orderable: false, searchable: false }
    ]
        });

            $(document).ready(function() {
            $('#barang_id').on('change', function() {
                var selectedOption = $(this).find(':selected');
                var stock = selectedOption.data('stock') || 0;
                $('#stok').val(stock);
            });
            });

        function calculateNominal() {
            var price = $('#barang_id').find(':selected').data('price') || 0;
            var quantity = $('#jumlah').val() || 0;
            var nominal = price * quantity;
            $('#nominal').val(nominal);
        }

        $('#barang_id, #jumlah').on('change', calculateNominal);

        $('#transactionForm').on('submit', function(event) {
            event.preventDefault();
            var form = $(this);

            $.ajax({
                url: "{{ url('transaksi/ajax') }}",
                type: "POST",
                data: form.serialize(),
                success: function(response) {
                    if (response.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message
                        });
                        $('#tabel_stok').DataTable().ajax.reload();
                        form[0].reset();
                        $('#nominal').val('');
                    } else {
                        $('.error-text').text('');
                        $.each(response.errors, function(prefix, val) {
                            $('#error-' + prefix).text(val[0]);
                        });
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: response.message
                        });
                    }
                }
            });
        });
    });
</script>
@endpush


