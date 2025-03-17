<form action="{{ url('/barang/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Kode Barang</label>
                    <input type="text" name="barang_kode" id="barang_kode" class="form-control" required>
                    <small id="error-barang_kode" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Nama Barang</label>
                    <input type="text" name="barang_nama" id="barang_nama" class="form-control" required>
                    <small id="error-barang_nama" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <select name="kategori_id" id="kategori_id" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->kategori_id }}">{{ $kategori->kategori_nama }}</option>
                        @endforeach
                    </select>
                    <small id="error-kategori_id" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Harga Beli</label>
                    <input type="number" name="harga_beli" id="harga_beli" class="form-control" required>
                    <small id="error-harga_beli" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Harga Jual</label>
                    <input type="number" name="harga_jual" id="harga_jual" class="form-control" required>
                    <small id="error-harga_jual" class="error-text form-text text-danger"></small>
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
    $(document).ready(function() {
        console.log('Form initialized');

        $("#form-tambah").validate({
            rules: {
                barang_kode: { required: true, maxlength: 10 },
                barang_nama: { required: true, maxlength: 100 },
                kategori_id: { required: true },
                harga_beli: { required: true, number: true, min: 0 },
                harga_jual: { required: true, number: true, min: 0 }
            },
            messages: {
                barang_kode: {
                    required: "Kode barang harus diisi",
                    maxlength: "Kode barang maksimal 10 karakter"
                },
                barang_nama: {
                    required: "Nama barang harus diisi",
                    maxlength: "Nama barang maksimal 100 karakter"
                },
                kategori_id: {
                    required: "Kategori harus dipilih"
                },
                harga_beli: {
                    required: "Harga beli harus diisi",
                    number: "Harga beli harus berupa angka",
                    min: "Harga beli tidak boleh negatif"
                },
                harga_jual: {
                    required: "Harga jual harus diisi",
                    number: "Harga jual harus berupa angka",
                    min: "Harga jual tidak boleh negatif"
                }
            },
            submitHandler: function(form) {
                console.log('Form submitted');
                $('.error-text').text('');

                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    dataType: 'json',
                    beforeSend: function() {
                        console.log('Sending request...');
                        $('button[type="submit"]').prop('disabled', true);
                    },
                    success: function(response) {
                        console.log('Response received:', response);
                        if(response.status) {
                            $('#myModal').modal('hide');
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            });

                            Toast.fire({
                                icon: 'success',
                                title: response.message
                            });

                            if(typeof dataBarang !== 'undefined') {
                                dataBarang.ajax.reload();
                            }
                        } else {
                            console.log('Validation errors:', response.msgField);
                            if(response.msgField) {
                                $.each(response.msgField, function(prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message || 'Terjadi kesalahan saat menyimpan data',
                                confirmButtonText: 'Ok'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                        console.log('Status:', status);
                        console.log('Response:', xhr.responseText);

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan saat menghubungi server',
                            customClass: {
                                popup: 'swal2-popup-modal'
                            }
                        });
                    },
                    complete: function() {
                        $('button[type="submit"]').prop('disabled', false);
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
