var table, jsonTables, newUrl;
// {{-- function load datatables  --}}
function loadAjaxDataTables(params) {
    newUrl = params.urlAjax;
    table = $('#table-1').DataTable({
        responsive: params.responsive,
        fixedHeader: {
            header: true,
            // footer: true
        },
        scrollX: true,
        dom: 'lBfrtip',
        buttons: {
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: `<i class="fas fa-file-excel"></i> Export to Excel`,
                    className: 'btn btn-outline-success mt-3 me-2 mb-3', // Bootstrap 5.3 classes (me-2 for margin-end)
                    titleAttr: 'Export ke Excel',
                    title: document.title + ' - ' + formatDateIndonesian(new Date().toDateString()), // Use page title
                    autoFilter: true,
                    footer: true,
                    sheetName: 'Exported data',
                    exportOptions: {
                        columns: ':not(:last-child)',
                        orthogonal: 'exportxls',
                        format: {
                            header: function (data, index, node) {
                                var cleanHeader = data.replace(/<\/?[^>]+(>|$)/g, ""); // Strip HTML tags
                                return cleanHeader.trim().toUpperCase();
                            }
                        }
                    },
                },
                {
                    extend: 'pdfHtml5',
                    text: `<i class="fas fa-file-pdf"></i> Export to PDF`,
                    className: 'btn btn-outline-danger mt-3 me-2 mb-3',
                    titleAttr: 'Export ke PDF',
                    orientation: 'landscape',
                    pageSize: 'A4',
                    download: 'open', // 'open' to preview in browser; use 'save' to force download
                    footer: true,
                    title: document.title + ' - ' + formatDateIndonesian(new Date().toDateString()),
                    customize: function (doc) {
                        doc.styles.tableHeader = {
                            bold: true,
                            fontSize: 11,
                            color: 'black',
                            fillColor: '#eeeeee',
                            alignment: 'center'
                        };
                        doc.styles.title = {
                            fontSize: 14,
                            bold: true,
                            alignment: 'center',
                            margin: [0, 0, 0, 10]
                        };
                        // Adjust table layout
                        doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                    },
                    exportOptions: {
                        columns: ':not(:last-child)',
                        format: {
                            header: function (data) {
                                var cleanHeader = data.replace(/<\/?[^>]+(>|$)/g, "");
                                return cleanHeader.trim().toUpperCase();
                            }
                        }
                    }
                }
            ],
            dom: {
                button: {
                    className: 'btn' // Bootstrap 5.3 base button class
                }
            }
        },
        processing: true,
        ajax: params.urlAjax,
        columns: params.columns,
        columnDefs: params.defColumn,
    });


}

// console.log(table);
// ajax store data
function ajaxSaveDatas(params) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // If the method is PUT, add _method=PUT to FormData
    if (params.method === 'PUT' && params.input instanceof FormData) {
        params.input.append('_method', 'PUT');
        params.method = 'POST'; // Use POST to simulate PUT
    }

    $.ajax({
        url: params.url,
        method: params.method,
        async: true,
        dataType: 'json',
        data: params.input,
        processData: params.processData !== null ? params.processData : true,
        contentType: params.contentType !== null ? params.contentType : 'application/x-www-form-urlencoded',
        beforeSend: function (xhr) {
            Swal.fire({
                title: params.load_msg ? params.load_msg : 'Sedang menyimpan data...',
                html: 'Mohon ditunggu!',
                timerProgressBar: true,
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        },
        success: function (data) {
            if (params.reload == null || params.reload == false) {
                if (typeof table !== 'undefined' && table != null) {
                    table.ajax.reload();
                }
            }
            $('.summernote').each(function () {
                $(this).summernote('code', '');
            });
            Swal.close();
            Swal.fire({
                toast: true,
                position: 'top-right',
                icon: 'success',
                title: 'Yayy!',
                text: data.message,
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true
            });

            if (params.forms) params.forms.reset();
            if (params.modal) params.modal.hide();

            if (params.reload === true) {
                location.reload();
            }

            if (params.redirect) {
                window.location.href = params.redirect;
            }
        },
        error: function (xhr) {
            Swal.close();
            var validationErrors = xhr.responseJSON.errors;
            var message = 'Ada yang salah saat menyimpan data. Coba lagi!';

            if (typeof validationErrors === 'object') {
                for (var fieldName in validationErrors) {
                    if (validationErrors.hasOwnProperty(fieldName)) {
                        var errorMessages = validationErrors[fieldName];
                        message = errorMessages.join(', ');
                        break;
                    }
                }
            }

            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: message
            });
        }
    });
}

function deleteConfirm(event, params = null, isTable = true, callback = null) {
    Swal.fire({
        title: 'Konfirmasi Hapus!',
        text: 'Apakah Anda yakin ingin menghapus data ini?',
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Tidak',
        confirmButtonText: 'Iya',
        confirmButtonColor: 'red'
    }).then(dialog => {
        var method = 'GET',
            valueHeaders = '';
        if (params != null) {
            method = params;
            valueHeaders = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            };
        }
        if (dialog.isConfirmed) {
            // window.location.assign(event.dataset.deleteUrl);
            $.ajax({
                headers: valueHeaders,
                url: event.dataset.deleteUrl,
                type: method,
                dataType: "JSON",
                beforeSend: function (xhr) {
                    Swal.fire({
                        title: 'Sedang menyimpan data...',
                        html: 'Mohon ditunggu!',
                        timerProgressBar: true,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    })
                },
                error: function (xhr) {
                    var message;
                    var validationErrors = xhr.responseJSON.errors
                    for (var fieldName in validationErrors) {
                        if (validationErrors.hasOwnProperty(fieldName)) {
                            var errorMessages = validationErrors[fieldName];

                            // Handle each error message for the current field
                            console.log('Validation Errors for ' + fieldName + ':',
                                errorMessages);
                            message = errorMessages
                        }
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Ada yang salah saat menghapus data. Coba lagi! ' +
                            (xhr.responseJSON &&
                                xhr.statusText ? xhr.statusText :
                                message ?
                                    message : ""),
                    })
                    console.log("statustext: " + xhr.statusText + "responsetxt: " + xhr
                        .responseText)
                },
                success: function (data) {
                    if (isTable) {
                        table.ajax.reload()
                    } else {
                        $(event).closest(".form-row").remove();
                    }
                    if (typeof callback === "function") {
                        callback();
                    }
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        showCloseButton: true,
                        timer: 5000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal
                                .resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'success',
                        title: data.message
                    });
                }
            });
        }
    })
}

function approveConfirm(event, params = null, isTable = true, text = 'Yakin ingin menyetujui Peserta ini?', modal = '') {
    Swal.fire({
        title: 'Konfirmasi Persetujuan!',
        text: text,
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Tidak',
        confirmButtonText: 'Iya',
        confirmButtonColor: 'red'
    }).then(dialog => {
        var method = 'GET',
            valueHeaders = '';
        if (params != null) {
            method = params;
            valueHeaders = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            };
        }
        if (dialog.isConfirmed) {
            // window.location.assign(event.dataset.deleteUrl);
            $.ajax({
                headers: valueHeaders,
                url: event.dataset.deleteUrl,
                type: method,
                dataType: "JSON",
                beforeSend: function (xhr) {
                    Swal.fire({
                        title: 'Sedang menyimpan data...',
                        html: 'Mohon ditunggu!',
                        timerProgressBar: true,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    })
                },
                error: function (xhr) {
                    Swal.close()
                    var message;
                    var validationErrors = xhr.responseJSON.errors
                    for (var fieldName in validationErrors) {
                        if (validationErrors.hasOwnProperty(fieldName)) {
                            var errorMessages = validationErrors[fieldName];

                            // Handle each error message for the current field
                            console.log('Validation Errors for ' + fieldName + ':',
                                errorMessages);
                            message = errorMessages
                        }
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Ada yang salah saat menyetujui data. Coba lagi! ' +
                            (xhr.responseJSON &&
                                xhr.statusText ? xhr.statusText :
                                message ?
                                    message : ""),
                    })
                    console.log("statustext: " + xhr.statusText + "responsetxt: " + xhr
                        .responseText)
                },
                success: function (data) {
                    console.log(data)
                    // Swal.close()
                    if (isTable) {
                        // console.log("table");
                        table.ajax.reload()
                    } else if (modal != '') {
                        console.log(modal)
                        $(modal).modal('hide');
                        table.ajax.reload()
                        // $(event).closest(".form-row").remove();
                    }
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        showCloseButton: true,
                        timer: 5000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal
                                .resumeTimer)
                        }
                    })
                    if (data.status == 'success') {
                        Toast.fire({
                            icon: 'success',
                            title: data.message
                        });
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: data.message
                        });
                    }

                }
            });
        }
    })
}
