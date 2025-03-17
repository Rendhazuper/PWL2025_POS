@if(empty($barang))
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Error</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            Data barang tidak ditemukan
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Kembali</button>
        </div>
    </div>
</div>
@else
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Detail Barang</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered table-striped table-hover">
                <tr>
                    <td width="30%">Kode Barang</td>
                    <td width="70%">{{ $barang->barang_kode }}</td>
                </tr>
                <tr>
                    <td>Nama Barang</td>
                    <td>{{ $barang->barang_nama }}</td>
                </tr>
                <tr>
                    <td>Kategori</td>
                    <td>{{ $barang->kategori->kategori_nama }}</td>
                </tr>
                <tr>
                    <td>Harga Beli</td>
                    <td>Rp {{ number_format($barang->harga_beli, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Harga Jual</td>
                    <td>Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Deskripsi</td>
                    <td>{{ $barang->deskripsi ?? '-' }}</td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        </div>
    </div>
</div>
@endif
