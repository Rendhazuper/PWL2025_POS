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
            <h4 class="modal-title">Edit Barang</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form id="formEdit" action="{{ url('/barang/' . $barang->barang_id . '/update_ajax') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label for="kategori_id">Kategori <span class="text-danger">*</span></label>
                    <select name="kategori_id" id="kategori_id" class="form-control" required>
                        <option value="">- Pilih Kategori -</option>
                        @foreach($kategori as $item)
                            <option value="{{ $item->kategori_id }}" {{ $item->kategori_id == $barang->kategori_id ? 'selected' : '' }}>
                                {{ $item->kategori_nama }}
                            </option>
                        @endforeach
                    </select>
                    <span class="text-danger" id="kategori_id_error"></span>
                </div>
                <div class="form-group">
                    <label for="barang_kode">Kode Barang <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="barang_kode" name="barang_kode" value="{{ $barang->barang_kode }}" required maxlength="20">
                    <span class="text-danger" id="barang_kode_error"></span>
                </div>
                <div class="form-group">
                    <label for="barang_nama">Nama Barang <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="barang_nama" name="barang_nama" value="{{ $barang->barang_nama }}" required maxlength="100">
                    <span class="text-danger" id="barang_nama_error"></span>
                </div>
                <div class="form-group">
                    <label for="harga_beli">Harga Beli <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="harga_beli" name="harga_beli" value="{{ $barang->harga_beli }}" required min="0">
                    <span class="text-danger" id="harga_beli_error"></span>
                </div>
                <div class="form-group">
                    <label for="harga_jual">Harga Jual <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="harga_jual" name="harga_jual" value="{{ $barang->harga_jual }}" required min="0">
                    <span class="text-danger" id="harga_jual_error"></span>
                </div>
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3">{{ $barang->deskripsi }}</textarea>
                    <span class="text-danger" id="deskripsi_error"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#formEdit').validate({
        rules: {
            kategori_id: {
                required: true
            },
            barang_kode: {
                required: true,
                maxlength: 20
            },
            barang_nama: {
                required: true,
                maxlength: 100
            },
            harga_beli: {
                required: true,
                min: 0
            },
            harga_jual: {
                required: true,
                min: 0
            }
        },
        messages: {
            kategori_id: {
                required: "Kategori harus dipilih"
            },
            barang_kode: {
                required: "Kode barang harus diisi",
                maxlength: "Kode barang maksimal 20 karakter"
            },
            barang_nama: {
                required: "Nama barang harus diisi",
                maxlength: "Nama barang maksimal 100 karakter"
            },
            harga_beli: {
                required: "Harga beli harus diisi",
                min: "Harga beli minimal 0"
            },
            harga_jual: {
                required: "Harga jual harus diisi",
                min: "Harga jual minimal 0"
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function(form) {
            $.ajax({
                url: $(form).attr('action'),
                type: 'POST',
                data: $(form).serialize(),
                success: function(response) {
                    $('#myModal').modal('hide');
                    Toast.fire({
                        icon: 'success',
                        title: response.success
                    });
                    $('#table_barang').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            $('#' + key + '_error').text(value[0]);
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan saat menyimpan data'
                        });
                    }
                }
            });
            return false;
        }
    });
});
</script>
@endif
