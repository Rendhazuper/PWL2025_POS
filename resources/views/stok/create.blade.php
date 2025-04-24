<form action="{{ url('/stok/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Stok</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label>Pilih Barang</label>
                    <select name="barang_id" id="barang_id" class="form-control">
                        @foreach($barang as $b)
                        <option value="{{ $b->barang_id }}">{{ $b->barang_nama }}</option>
                        @endforeach
                    </select>
                    <small id="error-barang_id" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Pilih Supplier</label>
                    <select name="supplier_id" id="supplier_id" class="form-control">
                        @foreach($supplier as $s)
                        <option value="{{ $s->supplier_id}}">{{ $s->supplier_nama}}</option>
                        @endforeach
                    </select>
                    <small id="error-supplier_id" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Jumlah Stok</label>
                    <input type="number" name="stok_jumlah" id="stok_jumlah" class="form-control" min="1" required>
                    <small id="error-stok_jumlah" class="error-text formm-text text-danger"></small>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function () {
        $("#form-tambah").validate({
            rules: {
                barang_id: { required: true },
                supplier_id: { required: true },
                stok_jumlah: { required: true, digits: true, min: 1 }
            },
            messages: {
                barang_id: { required: "Barang harus dipilih" },
                stok_jumlah: {
                    required: "Jumlah stok harus diisi",
                    digits: "Masukkan angka bulat",
                    min: "Jumlah minimal 1"
                }
            },
            submitHandler: function (form) {
                $.ajax({
                    url: form.action,
                    method: form.method,
                    data: $(form).serialize(),
                    success: function (res) {
                        if (res.status) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: res.message
                            });
                            dataStok.ajax.reload(); // ganti ini kalau kamu pakai nama datatable lain
                        } else {
                            $('.error-text').text('');
                            $.each(res.msgField, function (prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: res.message
                            });
                        }
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
