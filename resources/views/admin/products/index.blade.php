@extends('layouts.app')

@section('title')
    Data Produk
@endsection

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <h3>Kelola Produk</h3>
        </div>
        @can('kelola-product')
            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('products.create') }}" class="btn btn-primary">Tambah Produk</a>
            </div>
        @endcan
        <div class="card">
            <div class="card-body table-responsive">
                <table id="table-1" class="table table-striped w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Stock</th>
                            <th>Harga</th>
                            <th>Deskripsi</th>
                            <th>Tanggal Dibuat</th>
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
                    <h5 class="modal-title" id="detailModalLabel">Detail Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Deskripsi</th>
                                <td id="detail_description"></td>
                            </tr>
                            <tr>
                                <th>Informasi Ukuran</th>
                                <td id="detail_information"></td>
                            </tr>
                            <tr>
                                <th>Kategori</th>
                                <td id="detail_categories"></td>
                            </tr>
                            <tr>
                                <th>Gambar Produk</th>
                                <td id="detail_image"></td>
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
                    data: 'name_product',
                    name: 'name_product'
                },
                {
                    data: 'total_stock',
                    name: 'total_stock'
                },
                {
                    data: 'price',
                    name: 'price'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
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
                    targets: [5],
                    render: function(data, type, full, meta) {
                        if (full.created_at) {
                            return formatDateIndonesian(full.created_at);
                        }
                        return formatDateIndonesian(data);
                    }
                },
                {
                    targets: [6],
                    data: 'id',
                    render: function(data, type, full, meta) {
                        const detailData = {
                            description: full.description,
                            information: full.information,
                            categories: full.product_categories.map(category => category.category.name_category).join(', '), // Join categories
                            images: full.product_images.map(image => image.image_path), // Collect image paths
                        };
                        const jsonData = JSON.stringify(detailData).replace(/"/g, '&quot;');
                        return `<button class="btn btn-info btn-lg btn-detail" data-info="${jsonData}">
                    Detail
                </button>`;
                    }
                },
                {
                    targets: [7],
                    data: 'id',
                    render: function(data, type, full, meta) {
                        if (userRoles.includes('admin')) {
                            let actions = `
                <div class="dropdown">
                  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton${data}" data-bs-toggle="dropdown" aria-expanded="false">
                    Ubah Status
                  </button>
                  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton${data}">
                    <li><a class="dropdown-item update_status_product" href="#" data-id="${data}" data-action="available">Available</a></li>
                    <li><a class="dropdown-item update_status_product" href="#" data-id="${data}" data-action="out_of_stock">Out of Stock</a></li>
                  </ul>
                </div>
            `;
                            actions += `
                    <a href="/products/${data}/edit" class="btn btn-primary btn-sm edit-btn" data-id="${data}">Edit</a>
                    <button data-delete-url="/products/${data}" onclick="deleteConfirm(this, 'DELETE')" class="btn btn-danger btn-sm delete-btn" data-id="${data}">Hapus</button>
                `;
                            return actions;
                        } else {
                            return '';
                        }
                    }
                }
            ];

            loadAjaxDataTables({
                idTable: '#table-1',
                urlAjax: "{{ route('products.index') }}",
                columns: dataColumns,
                defColumn: columnDef,
            });

            $(document).on('click', '.btn-detail', function() {
                const infoJson = $(this).attr('data-info');
                const c = JSON.parse(infoJson);

                $('#detail_description').html(c.description);
                $('#detail_information').text(c.information);

                // Display categories
                $('#detail_categories').text(c.categories);
                console.log(c.images);
                // Display product images in a carousel
                const images = c.images.map(image => {
                    return `<div class="carousel-item">
                                <img src="/storage/${image}" class="d-block w-100" alt="Product Image">
                            </div>`;
                }).join('');

                const carousel = `
                    <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            ${images}
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                `;

                $('#detail_image').html(carousel);

                $('#detailModal').modal('show');
            });
        });
    </script>
@endsection
