@extends('layouts.app')

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
@endsection


@section('title')
    Form Konseling
@endsection

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <h3>Form Konseling</h3>
            <p class="text-subtitle text-muted">Layanan Konseling UPTBK
                Universitas Negeri Medan
                diperuntukkan bagi sivitas UI
                (mahasiswa aktif, dosen, atau
                pegawai UI). Jika Anda adalah
                sivitas Unimed, silakan
                mengisi formulir berikut.</p>
        </div>

        <section class="datatable">
            <div class="card">
                <div class="card-header">
                    <h5>Form Konseling</h5>
                </div>
                <div class="card-body">
                    <form id="form_counseling" action="{{ route('counseling.store') }}" method="POST" class="modal-content">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6 py-3">
                                <label for="full_name" class="form-label">Nama Lengkap</label>
                                <input type="text" id="full_name" name="full_name" class="form-control" required>
                            </div>
                            <div class="col-md-6 py-3">
                                <label for="age" class="form-label">Umur</label>
                                <input type="text" id="age" name="age" class="form-control" required>
                            </div>

                            <div class="col-md-6 py-3">
                                <label for="status" class="form-label">Status</label>
                                <select id="status" name="status" class="form-select" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="mahasiswa_unimed">Mahasiswa Unimed</option>
                                    <option value="pegawai_unimed">Pegawai Unimed</option>
                                </select>
                            </div>
                            <div class="col-md-6 py-3">
                                <label for="gender" class="form-label">Jenis Kelamin</label>
                                <select id="gender" name="gender" class="form-select" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Pria">Pria</option>
                                    <option value="Wanita">Wanita</option>
                                </select>
                            </div>

                            <div class="col-md-6 py-3">
                                <label for="work_unit" class="form-label">Fakultas/ Jurusan/ Semester atau Unit
                                    Kerja</label>
                                <input type="text" id="work_unit" name="work_unit" class="form-control" required>
                            </div>
                            <div class="col-md-6 py-3">
                                <label for="phone_number" class="form-label">Nomor Telepon</label>
                                <input type="text" id="phone_number" name="phone_number" class="form-control" required>
                            </div>

                            <div class="col-md-6 py-3">
                                <label for="address" class="form-label">Alamat Domisili</label>
                                <textarea id="address" name="address" class="summernote form-control" required></textarea>
                            </div>

                            <div class="col-md-6 py-3">
                                <label for="ever_counseling" class="form-label">Apakah Pernah di Diagnosis masalah kesehatan
                                    mental sebelumnya?</label>
                                <select id="ever_counseling" name="ever_counseling" class="form-select" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Ya">Ya</option>
                                    <option value="Tidak">Tidak</option>
                                </select>
                            </div>

                            <div class="col-md-6 py-3">
                                <label for="label_konselor_id" class="form-label label_konselor_id">Konselor</label>
                                <select id="select_konselor_id" name="konselor_id" class="form-select" required>

                                </select>
                            </div>
                            <div class="col-md-6 py-3">
                                <label for="counseling_reason" class="form-label">Apa yang mendorong klien untuk mencari
                                    bantuan saat ini?</label>
                                <textarea id="counseling_reason" name="counseling_reason" class="summernote form-control"></textarea>
                            </div>

                            <div class="col-md-6 py-3">
                                <label for="counseling_problem" class="form-label">Masalah atau keluhan utama yang ingin
                                    dibahas dalam konseling ?</label>
                                <textarea id="counseling_problem" name="counseling_problem" class="summernote form-control"></textarea>
                            </div>
                            <div class="col-md-6 py-3">
                                <label for="counseling_goal" class="form-label">Konseling Harapan atau tujuan dari sesi
                                    konseling</label>
                                <textarea id="counseling_goal" name="counseling_goal" class="summernote form-control"></textarea>
                            </div>

                            <div class="col-md-6 py-3">
                                <label for="counseling_type" class="form-label">Bentuk Konseling</label>
                                <select id="counseling_type" name="counseling_type" class="form-select" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="online">Online</option>
                                    <option value="offline">Offline</option>
                                </select>
                            </div>
                            <div class="col-md-6 py-3">
                                <label for="counseling_option" class="form-label">Pilihan Konseling</label>
                                <select id="counseling_option" name="counseling_option" class="form-select" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="individu">Individu</option>
                                    <option value="group">Kelompok</option>
                                </select>
                            </div>
                             <div class="col-md-12 py-3">
                                <label for="counseling_option" class="form-label">Tanggal Konseling</label>
                                <input type="datetime-local" name="counseling_date" class="form-control" required>
                            </div>
                        </div>

                        <div class="mt-3 text-end">
                            <button type="submit" class="btn btn-lg btn-primary">Kirim</button>
                        </div>

                    </form>
                </div>
            </div>
        </section>

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

            $('#form_counseling').on('submit', function(e) {
                e.preventDefault();

                let form = this;
                let formData = new FormData(form);

                // Sync summernote content into FormData
                $('.summernote').each(function() {
                    formData.set($(this).attr('name'), $(this).summernote('code'));
                });

                ajaxSaveDatas({
                    url: $(form).attr('action'),
                    method: $(form).attr('method'),
                    input: formData,
                    processData: false,
                    contentType: false,
                    load_msg: 'Sedang menyimpan data...',
                    forms: form,
                    reload: false,
                    redirect: "/counseling"
                });
            });

            const konselorSelect = document.getElementById('select_konselor_id');
            const everCounselingSelect = document.getElementById('ever_counseling');

            everCounselingSelect.addEventListener('change', function() {
                const selectedValue = this.value;

                // Clear konselor options first
                konselorSelect.innerHTML = '<option value="">-- Memuat Konselor --</option>';

                if (!selectedValue) {
                    konselorSelect.innerHTML = '<option value="">-- Pilih Konselor --</option>';
                    return;
                }

                fetch(`/fetch/konselors?ever_counseling=${encodeURIComponent(selectedValue)}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Gagal mengambil data konselor');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Clear and add default option
                        konselorSelect.innerHTML = '<option value="">-- Pilih Konselor --</option>';

                        // Assume data is an array of konselor objects with id and name
                        data.data.forEach(konselor => {
                            const option = document.createElement('option');
                            option.value = konselor.user.id;
                            option.textContent = konselor.user.name + ' (' + konselor.category + ')';
                            konselorSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        konselorSelect.innerHTML =
                            '<option value="">-- Gagal memuat konselor --</option>';
                        console.error('Error fetching konselors:', error);
                    });
            });

        });
    </script>
@endsection
