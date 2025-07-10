@extends('layouts.app')

@section('title', 'Data Konselor')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <h3>Kelola Konselor</h3>
        </div>

        <div class="d-flex justify-content-end mb-3">
            <button id="btnAdd" class="btn btn-primary">Tambah Konselor</button>
        </div>

        <div class="card">
            <div class="card-body table-responsive">
                <table id="table-1" class="table table-striped w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama User</th>
                            <th>Username</th>
                            <th>Kategori</th>
                            <th>NIP</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Detail Modal -->
    <div class="modal fade" id="konselorDetailModal" tabindex="-1" aria-labelledby="konselorDetailLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="konselorDetailLabel">Detail Konselor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Nama</th>
                                <td id="detailName"></td>
                            </tr>
                            <tr>
                                <th>Username</th>
                                <td id="detailUsername"></td>
                            </tr>
                            <tr>
                                <th>Kategori</th>
                                <td id="detailCategory"></td>
                            </tr>
                            <tr>
                                <th>Dibuat Pada</th>
                                <td id="detailCreatedAt"></td>
                            </tr>
                            <tr>
                                <th>Diperbarui Pada</th>
                                <td id="detailUpdatedAt"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div class="modal fade" id="konselorFormModal" tabindex="-1" aria-labelledby="konselorFormLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <form id="konselorForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="konselorFormLabel">Tambah Konselor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <input type="hidden" id="konselorId" name="konselor_id">

                        <div class="mb-3">
                            <label for="user_name" class="form-label">Nama Lengkap</label>
                            <input type="text" id="user_name" name="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="user_username" class="form-label">Username</label>
                            <input type="text" id="user_username" name="username" class="form-control" required>
                        </div>

                        <div class="mb-3 password-group">
                            <label for="user_password" class="form-label">Password</label>
                            <input type="password" id="user_password" name="password" class="form-control">
                            <small class="text-muted">*Isi password hanya saat membuat atau ingin mengubah</small>
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">Kategori</label>
                            <select id="category" name="category" class="form-control" required>
                                <option value="">Pilih Kategori</option>
                                <option value="Pernah Konseling">Pernah Konseling</option>
                                <option value="Pengukuran Psikologi">Pengukuran Psikologi</option>
                                <option value="Permasalahan Umum">Permasalahan Umum</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="user_nip" class="form-label">NIP</label>
                            <input type="text" id="user_nip" name="nip" class="form-control">
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="saveKonselorBtn">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            var dataColumns = [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'user.name',
                    name: 'user.name'
                },
                {
                    data: 'user.username',
                    name: 'user.username'
                },
                {
                    data: 'category',
                    name: 'category'
                },
                {
                    data: 'nip',
                    name: 'nip'
                }
            ];

            var columnDef = [{
                    targets: [0],
                    data: 'id',
                    render: function(data, type, full, meta) {
                        return `<p class="text-center"> ${meta.row + 1} </p>`
                    }
                },
                {
                    targets: 5,
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return `
                    <button class="btn btn-info btn-sm btn-detail" data-id="${data}">Detail</button>
                    <button class="btn btn-warning btn-sm btn-edit" data-id="${data}">Edit</button>
                    <button class="btn btn-danger btn-sm btn-delete" data-id="${data}" data-delete-url="/konselor/${data}" 
                            onclick="deleteConfirm(this, 'DELETE')">Hapus</button>
                `;
                    }
                }
            ];

            loadAjaxDataTables({
                idTable: '#table-1',
                urlAjax: "{{ route('konselor.index') }}",
                columns: dataColumns,
                defColumn: columnDef,
            });

            // Detail button click
            $(document).on('click', '.btn-detail', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: `/konselor/${id}`,
                    type: 'GET',
                    success: function(response) {
                        var k = response.data;
                        $('#detailName').text(k.user.name);
                        $('#detailUsername').text(k.user.username);
                        $('#detailCategory').text(k.category);
                        $('#detailCreatedAt').text(new Date(k.created_at).toLocaleString());
                        $('#detailUpdatedAt').text(new Date(k.updated_at).toLocaleString());
                        $('#konselorDetailModal').modal('show');
                    },
                    error: function() {
                        alert('Gagal mengambil data konselor');
                    }
                });
            });

            // Add Konselor button
            $('#btnAdd').click(function() {
                $('#konselorForm')[0].reset();
                $('#konselorId').val('');
                $('#konselorFormLabel').text('Tambah Konselor');
                $('.password-group').show();
                $('#konselorFormModal').modal('show');
            });

            // Edit Konselor button
            $(document).on('click', '.btn-edit', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: `/konselor/${id}`,
                    type: 'GET',
                    success: function(response) {
                        var k = response.data;
                        $('#konselorId').val(k.id);
                        $('#user_name').val(k.user.name);
                        $('#user_username').val(k.user.username);
                        $('#category').val(k.category);
                        $('#user_nip').val(k.nip || ''); // Set NIP if exists, else empty
                        $('#user_password').val('');
                        $('#konselorFormLabel').text('Edit Konselor');
                        $('.password-group')
                            .hide(); // optional: hide password field on edit unless you want to change password
                        $('#konselorFormModal').modal('show');
                    },
                    error: function() {
                        alert('Gagal mengambil data konselor');
                    }
                });
            });

            // Submit Add/Edit form
            $('#konselorForm').submit(function(e) {
                e.preventDefault();
                var id = $('#konselorId').val();
                var url = id ? `/konselor/${id}` : "{{ route('konselor.store') }}";
                var method = id ? 'PUT' : 'POST';
                var formData = new FormData(this);

                // If password field hidden or empty on edit, remove from formData to avoid overwriting
                if (id && !$('#user_password').val()) {
                    formData.delete('password');
                }

                ajaxSaveDatas({
                    url: url,
                    method: method,
                    input: formData,
                    processData: false,
                    contentType: false,
                    modal: $('#konselorFormModal').modal('hide'),
                    reload: false,
                    forms: this
                });
            });
        });
    </script>
@endsection
