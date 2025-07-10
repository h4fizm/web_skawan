@extends('layouts.app')

@section('style')
    <!-- Datatable css -->
    <!-- --------------------------------------------------- -->
    {{-- <link rel="stylesheet" href="{{ asset('css/datatable-style.css') }}"> --}}
    {{-- <link rel="stylesheet" href="../../dist/libs/sweetalert2/dist/sweetalert2.min.css"> --}}
@endsection
@section('title')
    Data Peran
@endsection
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Peran Pengguna</h3>
                    <p class="text-subtitle text-muted">Buat dan Kelola Akses Berdasarkan Peran Pengguna</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Peran</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-2">
                                <h5 class="card-title">
                                    Peran Pengguna
                                </h5>
                            </div>
                            <div class="d-flex justify-content-end">

                                <button type="button" class="btn btn-info btn-rounded m-t-10 mb-2" data-bs-toggle="modal"
                                    data-bs-target=".add-Roles">
                                    Tambah Peran Baru
                                </button>

                            </div>
                            <!-- Add Roles Popup Model -->
                            <div id="scroll-long-outer-modal" class="modal fade in add-Roles" tabindex="-1" role="dialog"
                                aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                                    <div class="modal-content">
                                        <form class="form-horizontal form-material" id="form_store_Roles"
                                            action="{{ route('roles.store') }}" method="POST" data-modal="add-Roles">
                                            <div class="modal-header d-flex align-items-center">
                                                <h4 class="modal-title" id="myModalLabel">
                                                    Tambah Peran Baru
                                                </h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                @csrf
                                                <div class="form-group">
                                                    <label>Nama Peran</label>
                                                    <div class="col-md-12 mb-3">
                                                        <input type="text" name="name" class="form-control"
                                                            placeholder="Nama Peran" required />
                                                    </div>

                                                    <label>Perizinan</label>
                                                    <div class="col-md-12 mb-3">
                                                        @foreach ($permissions as $permission)
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="{{ $permission->name }}" name="permission[]"
                                                                    id="permission-check-{{ $permission->id }}">
                                                                <label class="form-check-label"
                                                                    for="permission-check-{{ $permission->id }}">
                                                                    {{ $permission->name }}
                                                                </label>
                                                            </div>
                                                        @endforeach
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
                            <!-- Edit Roles Popup Model -->
                            <div id="scroll-long-outer-modal" class="modal fade in edit-Roles" tabindex="-1" role="dialog"
                                aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                                    <div class="modal-content">
                                        <form class="form-horizontal form-material" id="form_update_Roles" action="#"
                                            method="POST" data-modal="edit-Roles">
                                            <div class="modal-header d-flex align-items-center">
                                                <h4 class="modal-title" id="myModalLabel">
                                                    Ubah
                                                </h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">

                                                @csrf
                                                <div class="form-group">

                                                    <label>Nama Peran</label>
                                                    <div class="col-md-12 mb-3">
                                                        <input type="text" name="name" class="form-control name_edit"
                                                            placeholder="Nama Peran" required />
                                                    </div>

                                                    <label>Perizinan</label>
                                                    <div class="col-md-12 mb-3">
                                                        @foreach ($permissions as $permission)
                                                            <div class="form-check">
                                                                <input class="form-check-input permission_edit"
                                                                    type="checkbox" value="{{ $permission->name }}"
                                                                    name="permission[]"
                                                                    id="edit_permission-check-{{ $permission->id }}">
                                                                <label class="form-check-label"
                                                                    for="permission-check-{{ $permission->id }}">
                                                                    {{ $permission->name }}
                                                                </label>
                                                            </div>
                                                        @endforeach
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
                                            <input type="hidden" name="id" class="id_edit">
                                        </form>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <div class="table-responsive">
                                <table id="table-1"
                                    class="table table-striped table-bordered border text-inputs-searching text-nowrap">
                                    <thead>
                                        <!-- start row -->
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
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
            $(document).ready(function() {

                $('#form_store_Roles').submit(function(e) {
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

                $('#form_update_Roles').submit(function(e) {
                    e.preventDefault();
                    // alert($(this).data('modal'))

                    let form = $(this);
                    var id = $('.id_edit').val();
                    var url = "{{ route('roles.update', ['role' => ':id']) }}";
                    url = url.replace(':id', id);

                    var arr_params = {
                        url: url,
                        method: 'PUT',
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
                        data: 'name'
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

                        data: 'id',
                        render: function(data, type, full, meta) {
                            var permissions = JSON.stringify(full.permissions);
                            return `<div class="row w-100">
                           <div class="col-12 d-flex">
                              <a class="btn btn-warning btn-lg mr-1"
                                 href="/Roles/${data}/edit"
                                 data-bs-toggle="modal" data-bs-target=".edit-Roles" data-id="${data}"
                                 data-name="${full.name}" data-permissions='${permissions}'
                                 title="Edit"><i class="fas fa-edit"></i></a>
                              <a class="btn btn-danger btn-lg ml-1"
                                 href="#deleteData" data-delete-url="/roles/${data}" 
                                 onclick="return deleteConfirm(this,'delete')"
                                 title="Delete"><i class="fas fa-trash"></i></a>
                           </div>
                     </div>`
                        }
                    },
                ];
                var arrayParams = {
                    idTable: '#table-1',
                    urlAjax: "{{ route('roles.index') }}",
                    columns: dataColumns,
                    defColumn: columnDef,
                    pdf: 'not_print',
                }
                loadAjaxDataTables(arrayParams);
                // table.on('xhr', function() {
                //     jsonTables = table.ajax.json();
                //     // console.log( jsonTables.data[350]["id"] +' row(s) were loaded' );
                // });
                $('.edit-Roles').on('show.bs.modal', function(e) {
                    $('.permission_edit').prop('checked', false);
                    const button = $(e.relatedTarget);
                    $('.id_edit').val(button.data('id'))

                    $('.name_edit').val(button.data('name'))
                    let permissions = button.data('permissions');
                    console.log(button.data('permissions'))
                    $.each(permissions, function(i, item) {
                        var permission_id = item.id;
                        $('#edit_permission-check-' + permission_id).prop('checked', true);
                    });
                });

            });
        </script>
        {{-- <script src="../../dist/js/datatable/datatable-api.init.js"></script> --}}
    @endsection
