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
            <h4 class="modal-title">Hapus Barang</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form id="formDelete" action="{{ url('/barang/' . $barang->barang_id . '/destroy_ajax') }}" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-body">
                <p>Apakah anda yakin ingin menghapus data barang berikut?</p>
                <table class="table table-bordered">
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
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger">Hapus</button>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#formDelete').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#myModal').modal('hide');
                Toast.fire({
                    icon: 'success',
                    title: response.success
                });
                $('#table_barang').DataTable().ajax.reload();
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: xhr.responseJSON.error || 'Terjadi kesalahan saat menghapus data'
                });
            }
        });
    });
});
</script>
@endif
