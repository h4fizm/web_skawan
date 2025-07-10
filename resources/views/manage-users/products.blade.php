@extends('layouts.app')

@section('style')
@endsection

@section('title')
    Data Produk
@endsection

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <h3>Kelola Produk</h3>
        </div>
        @can('buat-Produk')
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
                            <th>Kategori</th>
                            <th>Gambar Produk</th>
                            <th>Deskripsi</th>
                            <th>Tanggal Dibuat</th>
                            <th>Status Produk</th>
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
                    data: 'category.name',  // assuming category relationship exists
                    name: 'category.name'
                },
                {
                    data: 'product_image.url',  // assuming product_image relationship exists
                    name: 'product_image.url'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'status',
                    name: 'status'
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
                    targets: [7],
                    render: function(data, type, full, meta) {
                        if (full.created_at) {
                            return formatDateIndonesian(full.created_at);
                        }
                        return formatDateIndonesian(data);
                    }
                },
                {
                    targets: [8],
                    render: function(data, type, full, meta) {
                        let status = data.toUpperCase();
                        let badgeClass = '';

                        if (status === 'AVAILABLE') {
                            badgeClass = 'bg-success';
                        } else if (status === 'OUT OF STOCK') {
                            badgeClass = 'bg-danger';
                        } else {
                            badgeClass = 'bg-secondary';
                        }

                        return `<span class="badge ${badgeClass}">${status}</span>`;
                    }
                },
                {
                    targets: [9],
                    data: 'id',
                    render: function(data, type, full, meta) {
                        const detailData = {
                            description: full.description,
                            information: full.information,
                            image: full.product_image.url
                        };
                        const jsonData = JSON.stringify(detailData).replace(/"/g, '&quot;');
                        return `<button class="btn btn-info btn-lg btn-detail" data-info="${jsonData}">
                    Detail
                </button>`;
                    }
                },
                {
                    targets: [10],
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
                $('#detail_image').html(`<img src="${c.image}" class="img-fluid" />`);

                $('#detailModal').modal('show');
            });

            $(document).on('click', '.update_status_product', function() {
                var id = $(this).data('id');
                var action = $(this).data('action');

                var data = new FormData();
                data.append('id', id);
                data.append('status', action);

                ajaxSaveDatas({
                    url: '{{ route('products.updateStatus') }}',
                    method: 'POST',
                    input: data,
                    processData: false,
                    contentType: false,
                    load_msg: 'Updating product status...',
                    reload: false
                });
            });
        });
    </script>
@endsection
