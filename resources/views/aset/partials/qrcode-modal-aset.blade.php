<div class="modal fade" id="qrAsetModal{{ $aset->id }}" tabindex="-1" role="dialog"
    aria-labelledby="qrAsetModal{{ $aset->id }}" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="dx-modal-exit" role="button" tabindex="0" data-bs-dismiss="modal" aria-label="Close">
                    <svg width="18" height="18" viewBox="0 0 52 52" fill="#2880CE"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M26 0C11.664 0 0 11.663 0 26C0 40.337 11.664 52 26 52C40.336 52 52 40.337 52 26C52 11.663 40.336 0 26 0ZM26 50C12.767 50 2 39.233 2 26C2 12.767 12.767 2 26 2C39.233 2 50 12.767 50 26C50 39.233 39.233 50 26 50Z">
                        </path>
                        <path
                            d="M35.707 16.293C35.316 15.902 34.684 15.902 34.293 16.293L26 24.586L17.707 16.293C17.316 15.902 16.684 15.902 16.293 16.293C15.902 16.684 15.902 17.316 16.293 17.707L24.586 26L16.293 34.293C15.902 34.684 15.902 35.316 16.293 35.707C16.488 35.902 16.744 36 17 36C17.256 36 17.512 35.902 17.707 35.707L26 27.414L34.293 35.707C34.488 35.902 34.744 36 35 36C35.256 36 35.512 35.902 35.707 35.707C36.098 35.316 36.098 34.684 35.707 34.293L27.414 26L35.707 17.707C36.098 17.316 36.098 16.684 35.707 16.293Z">
                        </path>
                    </svg>
                </div>

                <div class="dx-modal-body-input text-center">
                    <h6 id="qrAsetModal{{ $aset->id }}" class="dx-modal-title">QR Code</h6>
                    <div id="print-area-{{ $aset->id }}" class="d-flex justify-content-center">
                        {!! \Milon\Barcode\Facades\DNS2DFacade::getBarcodeSVG($aset->kode_barang, 'QRCODE', 4, 4) !!}
                    </div>
                    <p class="dx-text-base dx-font-regular dx-text-biru dx-mt-4">
                        {{ $aset->kode_barang }}
                    </p>
                </div>

                <div class="dx-modal-footer">
                    <button type="button" class="dx-btn dx-btn-primary" onclick="printSticker_{{ $aset->id }}()">
                        Cetak Stiker
                    </button>
                    <button type="button" class="dx-btn dx-btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function printSticker_{{ $aset->id }}() {
        let printContainer = document.createElement('div');
        printContainer.className = 'dx-thermal-sticker-container';

        // Hanya mengambil HTML dari print-area (murni kode QR SVG saja)
        let qrHtml = document.getElementById('print-area-{{ $aset->id }}').innerHTML;

        // Menyusun HTML tanpa menyertakan elemen teks kode barang
        printContainer.innerHTML = `
            <div class="dx-sticker-qr-box">${qrHtml}</div>
        `;

        printContainer.querySelectorAll('svg').forEach(svgElement => {
            svgElement.removeAttribute('width');
            svgElement.removeAttribute('height');
            if (!svgElement.getAttribute('viewBox')) {
                svgElement.setAttribute('viewBox', '0 0 100 100');
            }
        });

        document.body.appendChild(printContainer);
        window.print();
        document.body.removeChild(printContainer);
    }
</script>
