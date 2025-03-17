<form action="{{ url('/supplier/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Kode Supplier</label>
                    <input type="text" name="supplier_kode" id="supplier_kode" class="form-control" required>
                    <small id="error-supplier_kode" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Nama Supplier</label>
                    <input type="text" name="supplier_nama" id="supplier_nama" class="form-control" required>
                    <small id="error-supplier_nama" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="supplier_alamat" id="supplier_alamat" class="form-control" rows="3" required></textarea>
                    <small id="error-supplier_alamat" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Telepon</label>
                    <input type="text" name="supplier_telepon" id="supplier_telepon" class="form-control" required>
                    <small id="error-supplier_telepon" class="error-text form-text text-danger"></small>
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
                supplier_kode: { required: true, maxlength: 10 },
                supplier_nama: { required: true, maxlength: 100 },
                supplier_alamat: { required: true, maxlength: 255 },
                supplier_telepon: { required: true, maxlength: 15 }
            },
            messages: {
                supplier_kode: {
                    required: "Kode supplier harus diisi",
                    maxlength: "Kode supplier maksimal 10 karakter"
                },
                supplier_nama: {
                    required: "Nama supplier harus diisi",
                    maxlength: "Nama supplier maksimal 100 karakter"
                },
                supplier_alamat: {
                    required: "Alamat harus diisi",
                    maxlength: "Alamat maksimal 255 karakter"
                },
                supplier_telepon: {
                    required: "Telepon harus diisi",
                    maxlength: "Telepon maksimal 15 karakter"
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

                            if(typeof dataSupplier !== 'undefined') {
                                dataSupplier.ajax.reload();
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
