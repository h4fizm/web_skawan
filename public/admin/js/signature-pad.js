document.addEventListener('DOMContentLoaded', function () {
    // Helper to initialize and bind signature pad
    function setupSignaturePad(canvasId, savePrefix) {
        const canvas = document.getElementById(canvasId);
        if (!canvas) return;

        const ratio = Math.max(window.devicePixelRatio || 1, 1);

        function resizeCanvas() {
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);
        }

        window.addEventListener('resize', resizeCanvas);
        resizeCanvas();

        const signaturePad = new SignaturePad(canvas, {
            backgroundColor: 'rgb(255,255,255)',
        });

        // Save as PNG
        document.getElementById(`save-png-${savePrefix}`).addEventListener('click', function () {
            if (signaturePad.isEmpty()) {
                alert("Tanda Tangan Anda Kosong! Silahkan tanda tangan terlebih dahulu.");
            } else {
                const data = signaturePad.toDataURL('image/png');
                $('#myModal').modal('show').find('.modal-body').html(
                    `<h4>Format .PNG</h4><img src="${data}"><textarea id="signature64" name="signed" style="display:none">${data}</textarea>`
                );
            }
        });

        // Save as JPEG
        document.getElementById(`save-jpeg-${savePrefix}`).addEventListener('click', function () {
            if (signaturePad.isEmpty()) {
                alert("Tanda Tangan Anda Kosong! Silahkan tanda tangan terlebih dahulu.");
            } else {
                const data = signaturePad.toDataURL('image/jpeg');
                $('#myModal').modal('show').find('.modal-body').html(
                    `<h4>Format .JPEG</h4><img src="${data}"><textarea id="signature64" name="signed" style="display:none">${data}</textarea>`
                );
            }
        });

        // Save as SVG
        document.getElementById(`save-svg-${savePrefix}`).addEventListener('click', function () {
            if (signaturePad.isEmpty()) {
                alert("Tanda Tangan Anda Kosong! Silahkan tanda tangan terlebih dahulu.");
            } else {
                const data = signaturePad.toDataURL('image/svg+xml');
                const decoded = atob(data.split(',')[1]);
                $('#myModal').modal('show').find('.modal-body').text(decoded)
                    .append('<h4><i>"Hanya copy kode di atas ke HTML Anda"</i></h4>');
            }
        });

        return signaturePad;
    }

    // Initialize both pads
    setupSignaturePad('signature-pad-1', '1');
    setupSignaturePad('signature-pad-2', '2');
});
