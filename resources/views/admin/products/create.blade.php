@extends('layouts.app')

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css" rel="stylesheet" />
@endsection

@section('title')
    Form Produk
@endsection

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <h3>Form Produk</h3>
            <p class="text-subtitle text-muted">Form untuk menambahkan produk baru</p>
        </div>

        <section class="datatable">
            <div class="card">
                <div class="card-header">
                    <h5>Form Produk</h5>
                </div>
                <div class="card-body">
                    <form id="form_product" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6 py-3">
                                <label for="name_product" class="form-label">Nama Produk</label>
                                <input type="text" id="name_product" name="name_product" class="form-control" value="{{ old('name_product') }}" required>
                                @error('name_product')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 py-3">
                                <label for="total_stock" class="form-label">Total Stok</label>
                                <input type="number" id="total_stock" name="total_stock" class="form-control" value="{{ old('total_stock') }}" required>
                                @error('total_stock')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 py-3">
                                <label for="price" class="form-label">Harga</label>
                                <input type="number" step="0.01" id="price" name="price" class="form-control" value="{{ old('price') }}" required>
                                @error('price')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 py-3">
                                <label for="description" class="form-label">Deskripsi</label>
                                <textarea id="description" name="description" class="summernote form-control">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 py-3">
                                <label for="information" class="form-label">Informasi Tambahan</label>
                                <textarea id="information" name="information" class="summernote form-control">{{ old('information') }}</textarea>
                                @error('information')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 py-3">
                                <label for="categories" class="form-label">Pilih Kategori</label>
                                <select id="categories" name="categories[]" class="form-select" multiple required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ in_array($category->id, old('categories', [])) ? 'selected' : '' }}>{{ $category->name_category }}</option>
                                    @endforeach
                                </select>
                                @error('categories')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 py-3">
                                <label for="images" class="form-label">Unggah Gambar Produk</label>
                                <input type="file" name="images[]" class="image-preview-filepond" multiple>
                                @error('images')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
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
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.summernote').each(function() {
                $(this).summernote({
                    placeholder: 'Deskripsi atau informasi produk...',
                    tabsize: 2,
                    height: 120
                });
            });

            FilePond.create(document.querySelector(".image-preview-filepond"), {
                credits: null,
                allowImagePreview: true,
                acceptedFileTypes: ["image/png", "image/jpg", "image/jpeg"],
                storeAsFile: true,
                labelIdle: '📂 <span class="filepond--label-action">Klik atau drop gambar di sini</span>'
            });

            $('#categories').select2({
                tags: true,
                placeholder: "Pilih atau tambahkan kategori",
                tokenSeparators: [',', ' '],
            });
        });
    </script>
@endsection
