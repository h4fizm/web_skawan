@extends('layouts.app')

@push('style')
@endpush
@section('title')
    Data Pengguna
@endsection
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Kelola Pengguna</h3>
                    <p class="text-subtitle text-muted">Buat dan Kelola Pengguna Beserta Perannya</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('counseling.index') }}">Beranda</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Kelola Pengguna</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-2">
                                <h5 class="card-title">
                                    Pengguna
                                </h5>
                            </div>
                            <div class="d-flex justify-content-end">

                                <button type="button" class="btn btn-info btn-rounded m-t-10 mb-2" data-bs-toggle="modal"
                                    data-bs-target=".add-employees">
                                    Tambahkan Pengguna Baru
                                </button>

                            </div>
                            <!-- Add employees Popup Model -->
                            <div id="scroll-long-outer-modal" class="modal fade in add-employees" tabindex="-1"
                                role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                                    <div class="modal-content">
                                        <form class="form-horizontal form-material" id="form_store_employees"
                                            action="{{ route('manage-users.store') }}" method="POST"
                                            data-modal="add-employees">
                                            <div class="modal-header d-flex align-items-center">
                                                <h4 class="modal-title" id="myModalLabel">
                                                    Tambahkan Pengguna Baru
                                                </h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">

                                                @csrf
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <div class="col-md-12 mb-3">
                                                        <input type="email" name="email" class="form-control"
                                                            placeholder="Email" required />
                                                    </div>
                                                    <label>Nama</label>
                                                    <div class="col-md-12 mb-3">
                                                        <input type="text" name="name" class="form-control"
                                                            placeholder="Nama" required />
                                                    </div>
                                                    <label>Peran Pengguna</label>
                                                    <div class="col-md-12 mb-3">
                                                        <select class="form-select update_status" name="role"
                                                            id="roleSelect1" required>
                                                            <option value="">Pilih Peran...</option>
                                                            @foreach ($roles as $role)
                                                                <option value="{{ $role->name }}">
                                                                    {{ ucwords($role->name) }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div id="rtRwGroup">
                                                        <label>RT/RW</label>
                                                        <div class="col-md-12 mb-3">
                                                            <input type="text" name="rt_rw"
                                                                class="form-control rtRwInput" placeholder="RT/RW" />
                                                        </div>
                                                        <small id="error-message" style="color: red; display: none;">Format
                                                            harus seperti 001/003</small>
                                                    </div>
                                                    <label>Kata Sandi</label>
                                                    <div class="col-md-12 mb-3 position-relative">
                                                        <input type="password" name="password" id="password"
                                                            class="form-control" placeholder="Kata Sandi" required />
                                                        <span class="position-absolute end-0 top-50 translate-middle-y me-3"
                                                            onclick="togglePasswordVisibility('password', 'togglePasswordIcon1')"
                                                            style="cursor: pointer;">
                                                            <i id="togglePasswordIcon1" class="bi bi-eye-slash"></i>
                                                        </span>
                                                    </div>
                                                    <label>Konfirmasi Kata Sandi</label>
                                                    <div class="col-md-12 mb-3 position-relative">
                                                        <input type="password" name="password_confirmation"
                                                            class="form-control" placeholder="Kata Sandi" id="confirm-password" required />
                                                        <span class="position-absolute end-0 top-50 translate-middle-y me-3"
                                                            onclick="togglePasswordVisibility('confirm-password', 'togglePasswordIcon2')"
                                                            style="cursor: pointer;">
                                                            <i id="togglePasswordIcon2" class="bi bi-eye-slash"></i>
                                                        </span>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-info waves-effect">
                                                    Simpan
                                                </button>
                                                <button type="button" class="btn btn-default waves-effect"
                                                    data-bs-dismiss="modal">
                                                    Kembali
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>

                            <!-- edit employees Popup Model -->
                            <div id="scroll-long-outer-modal" class="modal fade in edit-employees" tabindex="-1"
                                role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                                    <div class="modal-content">
                                        <form class="form-horizontal form-material" id="form_update_employees"
                                            data-route="{{ route('manage-users.update', ['manage_user' => 'PLACEHOLDER']) }}"
                                            action="" method="POST" data-modal="edit-employees">
                                            <div class="modal-header d-flex align-items-center">
                                                <h4 class="modal-title" id="myModalLabel">
                                                    Ubah Pengguna
                                                </h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">

                                                @csrf
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <div class="col-md-12 mb-3">
                                                        <input type="email" name="email"
                                                            class="form-control email_edit" placeholder="Email"
                                                            required />
                                                    </div>
                                                    <label>Nama</label>
                                                    <div class="col-md-12 mb-3">
                                                        <input type="text" name="name"
                                                            class="form-control name_edit" placeholder="Nama" required />
                                                    </div>
                                                    <label>Peran Pengguna</label>
                                                    <div class="col-md-12 mb-3">
                                                        <select class="form-select role_edit" name="role"
                                                            id="roleSelect2">
                                                            <option value="">Pilih Peran...</option>
                                                            @foreach ($roles as $role)
                                                                <option value="{{ $role->name }}">
                                                                    {{ ucwords($role->name) }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div id="rtRwGroup_edit">
                                                        <label>RT/RW</label>
                                                        <div class="col-md-12 mb-3">
                                                            <input type="text" name="rt_rw"
                                                                class="form-control rtRwInput rt_rw_edit"
                                                                placeholder="RT/RW" />
                                                        </div>
                                                        <small id="error-message"
                                                            style="color: red; display: none;">Format harus seperti
                                                            001/003</small>
                                                    </div>
                                                    <span class="text-danger mt-2 mb-2">* Isi Kata Sandi Hanya Jika Ingin
                                                        Mengubah Kata Sandi</span><br>
                                                    <label>Kata Sandi</label>
                                                    <div class="col-md-12 mb-3 position-relative">
                                                        <input type="password" name="password" id="password-edit"
                                                            class="form-control" placeholder="Kata Sandi" required />
                                                        <span class="position-absolute end-0 top-50 translate-middle-y me-3"
                                                            onclick="togglePasswordVisibility('password-edit', 'togglePasswordIcon4')"
                                                            style="cursor: pointer;">
                                                            <i id="togglePasswordIcon4" class="bi bi-eye-slash"></i>
                                                        </span>
                                                    </div>
                                                    <label>Konfirmasi Kata Sandi</label>
                                                    <div class="col-md-12 mb-3 position-relative">
                                                        <input type="password" name="password_confirmation"
                                                            class="form-control" placeholder="Kata Sandi" id="confirm-password-edit" required />
                                                        <span class="position-absolute end-0 top-50 translate-middle-y me-3"
                                                            onclick="togglePasswordVisibility('confirm-password-edit', 'togglePasswordIcon3')"
                                                            style="cursor: pointer;">
                                                            <i id="togglePasswordIcon3" class="bi bi-eye-slash"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-info waves-effect">
                                                    Simpan
                                                </button>
                                                <button type="button" class="btn btn-default waves-effect"
                                                    data-bs-dismiss="modal">
                                                    Kembali
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <div class="table-responsive">
                                <table id="table-1"
                                    class="table table-striped table-bordered border text-inputs-searching w-100">
                                    <thead>
                                        <!-- start row -->
                                        <tr>
                                            <th>No</th>
                                            <th>Email</th>
                                            <th>Nama</th>
                                            <th>Peran Pengguna</th>
                                            <th>Tindakan</th>
                                        </tr>
                                        <!-- end row -->
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endsection

    @section('scripts')
        <script>
            function togglePasswordVisibility(passwordFieldId, iconId) {
                const passwordField = document.getElementById(passwordFieldId);
                const icon = document.getElementById(iconId);

                if (passwordField.type === "password") {
                    passwordField.type = "text";
                    icon.classList.remove("bi-eye-slash");
                    icon.classList.add("bi-eye");
                } else {
                    passwordField.type = "password";
                    icon.classList.remove("bi-eye");
                    icon.classList.add("bi-eye-slash");
                }
            }
            // Hide both rtRwGroup elements initially
            const rtRwGroup = document.getElementById('rtRwGroup');
            const rtRwGroup_edit = document.getElementById('rtRwGroup_edit');
            rtRwGroup.style.display = 'none';
            rtRwGroup_edit.style.display = 'none';

            function toggleRtRwVisibility() {
                const role1 = document.getElementById('roleSelect1').value;
                const role2 = document.getElementById('roleSelect2').value;

                // Show or hide rtRwGroup based on the role selected in roleSelect1
                if (role1 === 'pelanggan') {
                    rtRwGroup.style.display = 'block';
                } else {
                    rtRwGroup.style.display = 'none';
                }

                // Show or hide rtRwGroup_edit based on the role selected in roleSelect2
                if (role2 === 'pelanggan') {
                    rtRwGroup_edit.style.display = 'block';
                } else {
                    rtRwGroup_edit.style.display = 'none';
                }
            }
            document.addEventListener('DOMContentLoaded', function() {
                // Add event listeners to both select elements
                document.getElementById('roleSelect1').addEventListener('change', toggleRtRwVisibility);
                document.getElementById('roleSelect2').addEventListener('change', toggleRtRwVisibility);
            })

            $('.rtRwInput').on('input', function() {
                const input = $(this).val();
                const regex = /^\d{3}\/\d{3}$/; // Regular expression for 3 digits / 3 digits format

                const $errorMessage = $('#error-message');

                if (regex.test(input)) {
                    $(this).removeClass('is-invalid');
                    $errorMessage.hide();
                } else {
                    $(this).addClass('is-invalid');
                    $errorMessage.show();
                }
            });

            $(document).ready(function() {
                $('#form_store_employees').submit(function(e) {
                    e.preventDefault();
                    // alert($(this).data('modal'))

                    let form = $(this);
                    var arr_params = {
                        url: form.attr('action'),
                        method: 'POST',
                        input: form.serialize(),
                        forms: form[0],
                        modal: $('.' + form.data('modal')).modal('hide'),
                        reload: false,
                    }
                    ajaxSaveDatas(arr_params)
                });

                var dataColumns = [{
                        data: 'id'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'roles[0].name'
                    },
                    {
                        data: 'id'
                    },
                ];
                var columnDef = [{
                        targets: [0],
                        data: 'id',
                        render: function(data, type, full, meta) {
                            return `<p class="text-center"> ${meta.row + 1} </p>`
                        }
                    },

                    {
                        targets: [2],
                        render: function(data, type, full, meta) {
                            switch (data) {
                                case 'admin':
                                    return `<span class="badge bg-light-primary rounded-3 py-2 text-primary fw-semibold d-inline-flex align-items-center gap-1"><i class="ti ti-circle fs-4"></i>Admin</span>`;
                                case 'ppl':
                                    return `<span class="badge bg-light-success rounded-3 py-2 text-success fw-semibold d-inline-flex align-items-center gap-1"><i class="ti ti-circle fs-4"></i>P. Lapangan</span>`;
                                case 'bendahara':
                                    return `<span class="badge bg-light-warning rounded-3 py-2 text-warning fw-semibold d-inline-flex align-items-center gap-1"><i class="ti ti-circle fs-4"></i>Bendahara</span>`;
                                case 'pelanggan':
                                    return `<span class="badge bg-light-info rounded-3 py-2 text-info fw-semibold d-inline-flex align-items-center gap-1"><i class="ti ti-circle fs-4"></i>Pelanggan</span>`;
                                default:
                                    return data;
                            }

                        }
                    },
                    {
                        targets: [4],

                        data: 'id',
                        render: function(data, type, full, meta) {
                            return `<div class="btn-group" role="group" aria-label="Action Buttons">
  
  <a class="btn btn-warning" 
     href="#edit" 
     data-bs-toggle="modal" 
     data-bs-target=".edit-employees" 
     data-full='${JSON.stringify(full)}' 
     title="Edit">
     <i class="fas fa-edit"></i>
  </a>
  
  <a class="btn btn-danger" 
     href="#deleteData" 
     data-delete-url="/manage-users/${data}" 
     onclick="return deleteConfirm(this,'delete')" 
     title="Delete">
     <i class="fas fa-trash"></i>
  </a>
</div>
`
                        }
                    },
                ];
                var arrayParams = {
                    idTable: '#table-1',
                    urlAjax: "{{ route('manage-users.index') }}",
                    columns: dataColumns,
                    defColumn: columnDef,
                    pdf: 'not_print'
                }
                loadAjaxDataTables(arrayParams);

                $('.edit-employees').on('show.bs.modal', function(e) {
                    const button = $(e.relatedTarget);
                    let full = button.data('full');
                    console.log(full)
                    $('.name_edit').val(full.name)
                    $('.email_edit').val(full.email)
                    $('.rt_rw_edit').val(full.rt_rw)
                    $('.role_edit').val(full.roles[0]?.name).trigger('change')
                    toggleRtRwVisibility()
                    var routeTemplate = $('#form_update_employees').data('route');
                    var actionUrl = routeTemplate.replace('PLACEHOLDER', full.id);

                    $('#form_update_employees').attr('action', actionUrl);


                });

                $('#form_update_employees').submit(function(e) {
                    e.preventDefault();
                    // alert($(this).data('modal'))

                    let form = $(this);
                    var arr_params = {
                        url: form.attr('action'),
                        method: 'PUT',
                        input: form.serialize(),
                        forms: form[0],
                        modal: $('.' + form.data('modal')).modal('hide'),
                        reload: false,
                    }
                    ajaxSaveDatas(arr_params)
                });

            });
        </script>
    @endsection

    {{-- <a class="btn btn-primary" 
    href="#verifData" 
    data-delete-url="/manage-users/${data}/verif" 
    onclick="return approveConfirm(this,'GET')" 
    title="Verif">Setujui Pelanggan</a> --}}
