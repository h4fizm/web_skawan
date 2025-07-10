@extends('layouts.app')

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
@endsection

@section('title')
    Data Konseling
@endsection

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <h3>Kelola Konseling</h3>
            {{-- <p class="text-subtitle text-muted">Buat dan Kelola Konseling</p> --}}
        </div>
        <div class="card">
            <div class="card-body table-responsive">
                <table id="table-1" class="table table-striped w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username (NIM/ NIP)</th>
                            <th>Nama</th>
                            <th>Usia</th>
                            <th>Status</th>
                            <th>Jenis Kelamin</th>
                            <th>Unit Civitas</th>
                            <th>No. Hp</th>
                            <th>Jenis Konseling</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Status Konseling</th>
                            <th>Detail</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Konseling</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Alamat</th>
                                <td id="detail_address"></td>
                            </tr>
                            <tr>
                                <th>Pernah Konseling</th>
                                <td id="detail_ever_counseling"></td>
                            </tr>
                            <tr>
                                <th>Alasan Konseling</th>
                                <td id="detail_counseling_reason"></td>
                            </tr>
                            <tr>
                                <th>Masalah Konseling</th>
                                <td id="detail_counseling_problem"></td>
                            </tr>
                            <tr>
                                <th>Tujuan Konseling</th>
                                <td id="detail_counseling_goal"></td>
                            </tr>
                            <tr>
                                <th>Opsi Konseling</th>
                                <td id="detail_counseling_option"></td>
                            </tr>
                            <tr>
                                <th>Hasil Konseling</th>
                                <td id="detail_counseling_result"></td>
                            </tr>
                        </tbody>
                    </table>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Detail Modal -->
    <div class="modal fade" id="konselingResult" tabindex="-1" aria-labelledby="konselingResultLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <form id="konselorForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="konselingResultLabel">Hasil Konseling</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body form_docs_counseling">
                        <div class="mb-3">
                            <label for="user_username" class="form-label">Detail Konseling</label>
                            <textarea id="counseling_result" name="counseling_result" class="summernote form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="counseling_id" name="counseling_id">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="saveKonselorBtn">Simpan dan Preview PDF</button>
                    </div>
                </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.summernote').each(function() {
                const placeholderText = $(this).attr('placeholder') || '';
                $(this).summernote({
                    placeholder: placeholderText,
                    tabsize: 2,
                    height: 120,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        // ['insert', ['link', 'picture', 'video']],
                        ['view', ['fullscreen',
                            //  'codeview',
                            'help'
                        ]]
                    ]
                });
            });
            $('#konselorForm').submit(function(e) {
                e.preventDefault();
                var id = $('#counseling_id').val();
                var url = $(this).attr('action') || `/result/counseling/${id}`;
                var redirect_url = $(this).data('redirect_url');
                var method = 'POST';
                var formData = new FormData(this);

                ajaxSaveDatas({
                    url: url,
                    method: method,
                    input: formData,
                    processData: false,
                    contentType: false,
                    modal: $('#konselingResult').modal('hide'),
                    redirect: redirect_url,
                    // reload: false,
                    forms: this
                });
            });
            var userRoles = @json(auth()->user()->getRoleNames());
            var dataColumns = [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'user_counseling.user.username',
                },
                {
                    data: 'user_counseling.full_name',
                },
                {
                    data: 'user_counseling.age',
                    name: ''
                },
                {
                    data: 'user_counseling.status',
                    name: ''
                },
                {
                    data: 'user_counseling.gender',
                    name: ''
                },
                {
                    data: 'user_counseling.work_unit',
                    name: ''
                },
                {
                    data: 'user_counseling.phone_number',
                    name: ''
                },
                {
                    data: 'counseling_type',
                    name: ''
                },
                {
                    data: 'created_at',
                    name: ''
                },
                {
                    data: 'counseling_status',
                    name: ''
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
                    targets: [9],
                    render: function(data, type, full, meta) {
                        return formatDateIndonesian(data);
                    }
                },
                {
                    targets: [10],
                    render: function(data, type, full, meta) {
                        if (data == 'pending') {
                            return 'Menunggu konfirmasi maks 1x24 jam';
                        } else {
                            let status = data.toUpperCase();
                            let badgeClass = '';

                            if (status === 'APPROVE') {
                                badgeClass = 'bg-success';
                            } else if (status === 'REJECT') {
                                badgeClass = 'bg-danger';
                            } else {
                                badgeClass = 'bg-secondary';
                            }

                            return `<span class="badge ${badgeClass}">${status}</span>`;
                        }
                    }
                },
                {
                    targets: [11],
                    data: 'id',
                    render: function(data, type, full, meta) {
                        const detailData = {
                            address: full.user_counseling.address,
                            ever_counseling: full.ever_counseling,
                            counseling_reason: full.counseling_reason,
                            counseling_problem: full.counseling_problem,
                            counseling_goal: full.counseling_goal,
                            counseling_option: full.counseling_option,
                            counseling_result: full.counseling_result
                        };
                        const jsonData = JSON.stringify(detailData).replace(/"/g, '&quot;');
                        return `<button class="btn btn-info btn-lg btn-detail" data-info="${jsonData}">
                    Detail
                </button>`;

                    }
                },
                {
                    targets: [12],
                    data: 'id',
                    render: function(data, type, full, meta) {
                        const result = JSON.stringify(full?.counseling_result)?.replace(/"/g, '&quot;')
                        // data-counseling_result="${JSON.stringify(full.counseling_result).replace(/"/g, '&quot;');}"
                        if (userRoles.includes('konselor') || userRoles.includes('admin')) {
                            return `<button class="btn btn-success btn-docs-counseling" data-id="${data}"
                            data-counseling_result="${result}" data-counseling_option="${full.counseling_option}"
                            >
                    Buat Dokumentasi
                </button>`
                        }
                    }
                }
            ];

            loadAjaxDataTables({
                idTable: '#table-1',
                urlAjax: "{{ route('counseling.approved') }}",
                columns: dataColumns,
                defColumn: columnDef,
            });

            $(document).on('click', '.btn-detail', function() {
                const infoJson = $(this).attr('data-info');
                const c = JSON.parse(infoJson);

                $('#detail_address').html(c.address);
                $('#detail_ever_counseling').text(c.ever_counseling);
                $('#detail_counseling_reason').html(c.counseling_reason);
                $('#detail_counseling_problem').html(c.counseling_problem);
                $('#detail_counseling_goal').html(c.counseling_goal);
                $('#detail_counseling_option').text(c.counseling_option);
                $('#detail_counseling_result').html(c.counseling_result);

                $('#detailModal').modal('show');
            });

            $(document).on('click', '.btn-docs-counseling', function() {
                const id = $(this).attr('data-id');
                const counseling_result = $(this).attr('data-counseling_result');
                const counseling_option = $(this).attr('data-counseling_option');
                $('#counseling_id').val(id);
                $('#counseling_result').summernote('code', counseling_result);
                if (counseling_option === 'group') {
                    actionUrl = `{{ route('dokumentasi-konseling-groups.store') }}`;
                    redirectUrl =
                        "{{ route('dokumentasi-konseling-groups.show', ['dokumentasi_konseling_group' => '__ID__']) }}"
                        .replace('__ID__', id);
                    showUrl =
                        "{{ route('dokumentasi-konseling-groups.show', ['dokumentasi_konseling_group' => '__ID__']) }}"
                        .replace('__ID__', id);

                    formHtml = `
            <div class="mb-3">
                <label for="activity_name" class="form-label">Nama Kegiatan</label>
                <input type="text" id="activity_name" name="activity_name" class="form-control">
            </div>
            <div class="mb-3">
                <label for="place" class="form-label">Tempat Konseling</label>
                <input type="text" id="place" name="place" class="form-control">
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Tanggal Konseling</label>
                <input type="date" id="date" name="date" class="form-control">
            </div>
            <div class="mb-3">
                <label for="time" class="form-label">Waktu Konseling</label>
                <input type="time" id="time" name="time" class="form-control">
            </div>
            <div class="mb-3">
                <label for="total_participants" class="form-label">Jumlah Peserta</label>
                <input type="number" id="total_participants" name="total_participants" class="form-control">
            </div>
            <div class="mb-3">
                <label for="desc_counseling_goal" class="form-label">Tujuan Konseling</label>
                <textarea id="desc_counseling_goal" name="desc_counseling_goal" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <label for="desc_counseling_material" class="form-label">Materi Konseling</label>
                <textarea id="desc_counseling_material" name="desc_counseling_material" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <label for="desc_counseling_process" class="form-label">Proses Konseling</label>
                <textarea id="desc_counseling_process" name="desc_counseling_process" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <label for="desc_counseling_result" class="form-label">Hasil Konseling</label>
                <textarea id="desc_counseling_result" name="desc_counseling_result" class="summernote form-control"></textarea>
            </div>
            <div class="mb-3">
                <label for="desc_counseling_follow_up" class="form-label">Tindak Lanjut</label>
                <textarea id="desc_counseling_follow_up" name="desc_counseling_follow_up" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <label for="desc_counseling_notes" class="form-label">Catatan Konselor</label>
                <textarea id="desc_counseling_notes" name="desc_counseling_notes" class="form-control"></textarea>
            </div>
        `;
                } else if (counseling_option === 'individu') {
                    actionUrl = `{{ route('dokumentasi-konseling-individus.store') }}`;
                    redirectUrl =
                        "{{ route('dokumentasi-konseling-individus.show', ['dokumentasi_konseling_individu' => '__ID__']) }}"
                        .replace('__ID__', id);
                    showUrl =
                        "{{ route('dokumentasi-konseling-individus.show', ['dokumentasi_konseling_individu' => '__ID__']) }}"
                        .replace('__ID__', id);

                    formHtml = `
            <div class="mb-3">
                <label for="place" class="form-label">Tempat Konseling</label>
                <input type="text" id="place" name="place" class="form-control">
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Tanggal Konseling</label>
                <input type="date" id="date" name="date" class="form-control">
            </div>
            <div class="mb-3">
                <label for="desc_counseling_problem" class="form-label">Masalah Konseling</label>
                <textarea id="desc_counseling_problem" name="desc_counseling_problem" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <label for="diagnosis" class="form-label">Diagnosis</label>
                <textarea id="diagnosis" name="diagnosis" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <label for="prognosis" class="form-label">Prognosis</label>
                <textarea id="prognosis" name="prognosis" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <label for="desc_counseling_goal" class="form-label">Tujuan Konseling</label>
                <textarea id="desc_counseling_goal" name="desc_counseling_goal" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <label for="desc_counseling_process" class="form-label">Proses Konseling</label>
                <textarea id="desc_counseling_process" name="desc_counseling_process" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <label for="desc_counseling_result" class="form-label">Hasil Konseling</label>
                <textarea id="desc_counseling_result" name="desc_counseling_result" class="summernote form-control"></textarea>
            </div>
            <div class="mb-3">
                <label for="desc_counseling_follow_up" class="form-label">Tindak Lanjut</label>
                <textarea id="desc_counseling_follow_up" name="desc_counseling_follow_up" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <label for="desc_counseling_notes" class="form-label">Catatan Konselor</label>
                <textarea id="desc_counseling_notes" name="desc_counseling_notes" class="form-control"></textarea>
            </div>
        `;
                }

                // Inject the form HTML and set form attributes
                $('#konselorForm').attr('action', actionUrl);
                $('#konselorForm').attr('data-redirect_url', redirectUrl);
                $('.form_docs_counseling').html(formHtml);
                $('.form_docs_counseling textarea').each(function() {
                    const placeholderText = $(this).attr('placeholder') || '';
                    $(this).summernote({
                        placeholder: placeholderText,
                        tabsize: 2,
                        height: 120,
                        toolbar: [
                            ['style', ['style']],
                            ['font', ['bold', 'underline', 'clear']],
                            ['color', ['color']],
                            ['para', ['ul', 'ol', 'paragraph']],
                            ['table', ['table']],
                            // ['insert', ['link', 'picture', 'video']],
                            ['view', ['fullscreen',
                                //  'codeview',
                                'help'
                            ]]
                        ]
                    });
                });
                $('#konselingResult').modal('show');

                // Fetch and populate existing data if id is provided
                if (id) {
                    $.ajax({
                        url: showUrl,
                        method: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            const data = response.data || {};

                            Object.entries(data).forEach(([key, value]) => {
                                const $field = $(`#konselorForm [name="${key}"]`);
                                if ($field.length) {
                                    if ($field.is('textarea') || $field.is(
                                            '.summernote')) {
                                        $field.summernote('code', value);
                                    } else if ($field.is(
                                            'input')) {
                                        $field.val(value);
                                    }
                                }
                            });
                        },
                        error: function() {
                            console.error('Failed to fetch data from show API');
                        }
                    });
                }
            });

        });
    </script>
@endsection
