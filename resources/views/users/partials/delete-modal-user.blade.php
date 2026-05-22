<div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserLabel"
    aria-modal="true">
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

                <div class="dx-modal-body-input">
                    <h6 id="deleteUserLabel" class="dx-modal-title">Konfirmasi</h6>
                    <p class="text-center dx-text-sm">Apakah Anda yakin ingin
                        menghapus User <strong id="delete-modal-username"></strong>?
                    </p>
                </div>

                <div class="dx-modal-footer">
                    <button type="button" class="dx-btn dx-btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form method="POST" id="delete-modal-form" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="dx-btn dx-btn-primary">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
