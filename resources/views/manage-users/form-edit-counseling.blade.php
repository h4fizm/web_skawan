@extends('layouts.app')

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
@endsection

@section('title')
    Edit Form Konseling
@endsection

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <h3>Edit Form Konseling</h3>
            <p class="text-subtitle text-muted">Layanan Konseling UPTBK Universitas Negeri Medan diperuntukkan bagi sivitas
                UI (mahasiswa aktif, dosen, atau pegawai UI). Jika Anda adalah sivitas Unimed, silakan mengedit formulir
                berikut.</p>
        </div>

        <section class="datatable">
            <div class="card">
                <div class="card-header">
                    <h5>Edit Form Konseling</h5>
                </div>
                <div class="card-body">
                    <form id="form_counseling" action="{{ route('counseling.update', $counseling->userCounseling->id) }}"
                        method="POST" class="modal-content">
                        @csrf
                        @method('PUT')
                        @if ($counseling->userCounseling->user->id == auth()->user()->id)
                            <div class="row mb-3">
                                <div class="col-md-6 py-3">
                                    <label for="full_name" class="form-label">Nama Lengkap</label>
                                    <input type="text" id="full_name" name="full_name" class="form-control"
                                        value="{{ old('full_name', $counseling->userCounseling->full_name) }}" required>
                                </div>
                                <div class="col-md-6 py-3">
                                    <label for="age" class="form-label">Umur</label>
                                    <input type="text" id="age" name="age" class="form-control"
                                        value="{{ old('age', $counseling->userCounseling->age) }}" required>
                                </div>

                                <div class="col-md-6 py-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select id="status" name="status" class="form-select" required>
                                        <option value="mahasiswa_unimed"
                                            {{ $counseling->userCounseling->status == 'mahasiswa_unimed' ? 'selected' : '' }}>
                                            Mahasiswa Unimed</option>
                                        <option value="pegawai_unimed"
                                            {{ $counseling->userCounseling->status == 'pegawai_unimed' ? 'selected' : '' }}>
                                            Pegawai Unimed</option>
                                    </select>
                                </div>
                                <div class="col-md-6 py-3">
                                    <label for="gender" class="form-label">Jenis Kelamin</label>
                                    <select id="gender" name="gender" class="form-select" required>
                                        <option value="Pria"
                                            {{ $counseling->userCounseling->gender == 'Pria' ? 'selected' : '' }}>Pria
                                        </option>
                                        <option value="Wanita"
                                            {{ $counseling->userCounseling->gender == 'Wanita' ? 'selected' : '' }}>Wanita
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-6 py-3">
                                    <label for="work_unit" class="form-label">Fakultas/ Jurusan/ Semester atau Unit
                                        Kerja</label>
                                    <input type="text" id="work_unit" name="work_unit" class="form-control"
                                        value="{{ old('work_unit', $counseling->userCounseling->work_unit) }}" required>
                                </div>
                                <div class="col-md-6 py-3">
                                    <label for="phone_number" class="form-label">Nomor Telepon</label>
                                    <input type="text" id="phone_number" name="phone_number" class="form-control"
                                        value="{{ old('phone_number', $counseling->userCounseling->phone_number) }}"
                                        required>
                                </div>

                                <div class="col-md-6 py-3">
                                    <label for="address" class="form-label">Alamat Domisili</label>
                                    <textarea id="address" name="address" class="summernote form-control" required>{{ old('address', $counseling->userCounseling->address) }}</textarea>
                                </div>

                                <div class="col-md-6 py-3">
                                    <label for="ever_counseling" class="form-label">Apakah Pernah di Diagnosis masalah
                                        kesehatan
                                        mental sebelumnya?</label>
                                    <select id="ever_counseling" name="ever_counseling" class="form-select" required>
                                        <option value="Ya"
                                            {{ $counseling->ever_counseling == 'Ya' ? 'selected' : '' }}>Ya
                                        </option>
                                        <option value="Tidak"
                                            {{ $counseling->ever_counseling == 'Tidak' ? 'selected' : '' }}>
                                            Tidak</option>
                                    </select>
                                </div>

                                <div class="col-md-6 py-3">
                                    <label for="select_konselor_id" class="form-label">Konselor</label>
                                    <select id="select_konselor_id" name="konselor_id" class="form-select" required>
                                        <!-- Populate konselor options here -->
                                    </select>
                                </div>

                                <div class="col-md-6 py-3">
                                    <label for="counseling_reason" class="form-label">Apa yang mendorong klien untuk mencari
                                        bantuan saat ini?</label>
                                    <textarea id="counseling_reason" name="counseling_reason" class="summernote form-control">{{ old('counseling_reason', $counseling->counseling_reason) }}</textarea>
                                </div>

                                <div class="col-md-6 py-3">
                                    <label for="counseling_problem" class="form-label">Masalah atau keluhan utama yang ingin
                                        dibahas dalam konseling?</label>
                                    <textarea id="counseling_problem" name="counseling_problem" class="summernote form-control">{{ old('counseling_problem', $counseling->counseling_problem) }}</textarea>
                                </div>
                                <div class="col-md-6 py-3">
                                    <label for="counseling_goal" class="form-label">Konseling Harapan atau tujuan dari sesi
                                        konseling</label>
                                    <textarea id="counseling_goal" name="counseling_goal" class="summernote form-control">{{ old('counseling_goal', $counseling->counseling_goal) }}</textarea>
                                </div>

                                <div class="col-md-6 py-3">
                                    <label for="counseling_type" class="form-label">Bentuk Konseling</label>
                                    <select id="counseling_type" name="counseling_type" class="form-select" required>
                                        <option value="online"
                                            {{ $counseling->counseling_type == 'online' ? 'selected' : '' }}>Online
                                        </option>
                                        <option value="offline"
                                            {{ $counseling->counseling_type == 'offline' ? 'selected' : '' }}>Offline
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-6 py-3">
                                    <label for="counseling_option" class="form-label">Pilihan Konseling</label>
                                    <select id="counseling_option" name="counseling_option" class="form-select" required>
                                        <option value="individu"
                                            {{ $counseling->counseling_option == 'individu' ? 'selected' : '' }}>Individu
                                        </option>
                                        <option value="group"
                                            {{ $counseling->counseling_option == 'group' ? 'selected' : '' }}>Kelompok
                                        </option>
                                    </select>
                                </div>
                        @endif
                        @if (
                            $counseling->userCounseling->user->id == auth()->user()->id ||
                                auth()->user()->hasRoles('konselor') ||
                                auth()->user()->hasRoles('admin'))
                            <div class="col-md-6 py-3">
                                <label for="counseling_option" class="form-label">Tanggal Konseling</label>
                                <input type="datetime-local" name="counseling_date" class="form-control"
                                    value="{{ $counseling->counseling_date }}" required>
                            </div>
                            <div class="col-md-6 py-3">
                                <label for="resched_reason" class="form-label">Alasan mengubah jadwal konseling? (Isi
                                    hanya jika melakukan perubahan jadwal konseling)</label>
                                <textarea id="resched_reason" name="resched_reason" class="summernote form-control">{{ old('resched_reason', $counseling->resched_reason) }}</textarea>
                            </div>
                        @endif
                </div>

                <div class="mt-3 text-end">
                    <button type="submit" class="btn btn-lg btn-primary">Update</button>
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

            const everCounselingSelect = document.getElementById('ever_counseling');
            const konselorSelect = document.getElementById('select_konselor_id');
            const selectedKonselorId =
                "{{ old('konselor_id', $counseling->konselor_id) }}"; // Pass the initial konselor_id from the backend

            // Function to populate the Konselor dropdown based on ever_counseling value
            function loadKonselors() {
                const selectedValue = everCounselingSelect.value;

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
                            option.textContent = konselor.user.name;
                            konselorSelect.appendChild(option);
                        });

                        // After fetching and populating options, select the previously selected konselor if available
                        if (selectedKonselorId) {
                            konselorSelect.value = selectedKonselorId;
                        }
                    })
                    .catch(error => {
                        konselorSelect.innerHTML = '<option value="">-- Gagal memuat konselor --</option>';
                        console.error('Error fetching konselors:', error);
                    });
            }

            // Trigger the change event on page load to populate the dropdown if a value is already selected
            if (everCounselingSelect.value) {
                loadKonselors();
            }

            // Add event listener for change event
            everCounselingSelect.addEventListener('change', loadKonselors);

        });
    </script>
@endsection
