@extends('layouts.app')

@section('style')
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
        @can('buat-konseling')
            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('counseling.create') }}" class="btn btn-primary">Tambah
                    Konseling</a>
            </div>
        @endcan
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
                                <th>Konselor Pilihan</th>
                                <td id="choosen_konselor"></td>
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
                            <tr>
                                <th>Alasan Mengubah Jadwal</th>
                                <td id="detail_resched_reason"></td>
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
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
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
                        if (full.counseling_date) {
                            return formatDateIndonesian(full.counseling_date);
                        }
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
                            counseling_result: full.counseling_result,
                            choosen_konselor: full.konselor.name,
                            resched_reason: full?.resched_reason
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
                        if (userRoles.includes('konselor') || userRoles.includes('admin')) {
                            let actions = `
                <div class="dropdown">
                  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton${data}" data-bs-toggle="dropdown" aria-expanded="false">
                    Change Status
                  </button>
                  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton${data}">
                    <li><a class="dropdown-item update_status_counseling" href="#" data-id="${data}" data-action="approve">Approve</a></li>
                    <li><a class="dropdown-item update_status_counseling" href="#" data-id="${data}" data-action="reject">Reject</a></li>
                  </ul>
                </div>
            `;
                            if (userRoles.includes('admin')) {
                                actions += `
                    <a href="/counseling/${data}/edit" class="btn btn-primary btn-sm edit-btn" data-id="${data}">Edit</a>
                    <button data-delete-url="/counseling/${data}" onclick="deleteConfirm(this, 'DELETE')" class="btn btn-danger btn-sm delete-btn" data-id="${data}">Hapus</button>
                `;
                            }
                            return actions;
                        } else if (userRoles.includes('user_konseling')) {
                            let action_user =
                                `<a href="/counseling/${data}/edit" class="btn btn-primary btn-sm edit-btn" data-id="${data}">Edit</a>`;
                            if (full.counseling_status != 'approve') {
                                action_user += `
                                    <button data-delete-url="/counseling/${data}" onclick="deleteConfirm(this, 'DELETE')" class="btn btn-danger btn-sm delete-btn" data-id="${data}">Hapus</button>
                                `;
                            }
                            if (full.counseling_status == 'approve' && full.konselor.id == 20) {
                                let konselorPhone = full.konselor.phone_number ? full.konselor.phone_number
                                    .replace(/^0/, '62') : '628116586666';
                                let userName = full.user_counseling.full_name;
                                // full.konselor.name
                                let konselorName = 'Rafael Lisinus Ginting, S.Pd., M.Pd.';
                                let counselingDate = formatDateIndonesian(full.counseling_date);
                                let waMessage =
                                    `Halo Bapak ${konselorName}, perkenalkan saya ${userName}.%0A%0A📅 Tanggal pengajuan: ${counselingDate}%0A%0ATerima kasih 😊😊`;
                                let waLink = `https://wa.me/${konselorPhone}?text=${waMessage}`;

                                action_user += `
                                    <a href="${waLink}" target="_blank" class="btn btn-success btn-sm">WA Konselor</a>
                                `;
                            }
                            return action_user;
                        } else {
                            return '';
                        }
                    }
                }
            ];

            loadAjaxDataTables({
                idTable: '#table-1',
                urlAjax: "{{ route('counseling.index') }}",
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
                $('#choosen_konselor').html(c.choosen_konselor);
                $('#detail_resched_reason').html(c?.resched_reason || 'Tidak ada perubahan jadwal');

                $('#detailModal').modal('show');
            });

            $(document).on('click', '.update_status_counseling', function() {
                var id = $(this).data('id');
                var action = $(this).data('action');

                var data = new FormData();
                data.append('id', id);
                data.append('status', action);

                ajaxSaveDatas({
                    url: '{{ route('counseling.updateStatus') }}',
                    method: 'POST',
                    input: data,
                    processData: false,
                    contentType: false,
                    load_msg: 'Updating counseling status...',
                    reload: false
                });
            });


        });
    </script>
@endsection
