document.addEventListener("DOMContentLoaded", () => {
    // 1. Ambil Element DOM & Konfigurasi dari Data Attributes HTML
    const pageWrapper = document.getElementById('user-page-wrapper');
    if (!pageWrapper) return;

    const config = {
        fetchUrl: pageWrapper.dataset.fetchUrl,
        ubahUrl: pageWrapper.dataset.ubahUrl,
        hapusUrl: pageWrapper.dataset.hapusUrl,
        canUbah: pageWrapper.dataset.permUbah === 'true',
        canHapus: pageWrapper.dataset.permHapus === 'true',
    };

    const DOM = {
        tableSkeleton: document.getElementById('table-skeleton'),
        paginationSkeleton: document.getElementById('pagination-skeleton'),
        tableReal: document.getElementById('table-real'),
        paginationReal: document.getElementById('pagination-real'),
        dataContainer: document.getElementById('user-data-container'),
        paginationInfo: document.getElementById('pagination-info'),
        paginationLinks: document.getElementById('pagination-links-container'),
        searchForm: document.getElementById('search-form'),
        deleteModal: document.getElementById('deleteUserModal'),
        // Tambahkan selector untuk input dan tombol reset
        searchInput: document.querySelector('#search-form input[name="search"]'),
        resetBtn: document.getElementById('reset-search-btn'),
    };

    // State Global untuk mengunci kata kunci pencarian yang aktif
    let currentSearchKeyword = DOM.searchInput ? DOM.searchInput.value : '';

    // 2. Fungsi Fetch Data dengan Async/Await
    const fetchUserData = async (page = 1, searchKeyword = '') => {
        toggleLoading(true);

        // Kunci kata kunci ke state global
        currentSearchKeyword = searchKeyword;

        // Atur visibilitas tombol reset secara dinamis
        toggleResetButton();

        let url = `${config.fetchUrl}?page=${page}`;
        if (currentSearchKeyword) {
            url += `&search=${encodeURIComponent(currentSearchKeyword)}`;
        }

        try {
            const response = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json'
                }
            });

            if (!response.ok) throw new Error('Respon jaringan tidak baik');

            const data = await response.json();
            renderTable(data);

        } catch (error) {
            console.error("Gagal memuat data Storify:", error);
            DOM.dataContainer.innerHTML = `
            <tr>
                <td colspan="5">
                    <div class="dx-empty-batch text-center">
                        <div class="dx-empty-batch-image">
                            <img src="/images/speech-bubble.png" alt="empty-batch" class="img-fluid d-inline">
                        </div>
                        <h5 class="dx-empty-batch-title">Data tidak ditemukan</h5>
                        <p class="dx-empty-batch-content">Untuk keterangan lebih lanjut, silakan baca <a href="#" target="_blank">Link ini.</a></p>
                    </div>
                </td>
            </tr>`;
        } finally {
            toggleLoading(false);
        }
    };

    // 3. Helper Pengatur Tampilan Loading
    const toggleLoading = (isLoading) => {
        DOM.tableReal.style.setProperty('display', isLoading ? 'none' : 'table', 'important');
        DOM.paginationReal.style.setProperty('display', isLoading ? 'none' : 'flex', 'important');
        DOM.tableSkeleton.style.setProperty('display', isLoading ? 'table' : 'none', 'important');
        DOM.paginationSkeleton.style.setProperty('display', isLoading ? 'flex' : 'none', 'important');
    };

    // Helper untuk Menyembunyikan / Menampilkan Tombol Reset
    const toggleResetButton = () => {
        if (!DOM.resetBtn) return;
        if (currentSearchKeyword.trim() !== '') {
            DOM.resetBtn.style.setProperty('display', 'inline-flex', 'important');
            DOM.resetBtn.style.setProperty('justify-content', 'center', 'important');
            DOM.resetBtn.style.setProperty('align-items', 'center', 'important');
        } else {
            DOM.resetBtn.style.setProperty('display', 'none', 'important');
        }
    };

    // 4. Fungsi Render Data HTML (Template Literals)
    const renderTable = (data) => {
        DOM.dataContainer.innerHTML = '';

        if (data.users.length === 0) {
            DOM.dataContainer.innerHTML = renderEmptyState();
            return;
        }

        data.users.forEach((user, index) => {
            const rowNumber = data.meta.from + index;
            let actionButtons = '';

            if (config.canUbah) {
                const urlUbah = config.ubahUrl.replace(':id', user.id);
                actionButtons += `<a href="${urlUbah}" class="dx-badge dx-badge-primary me-1">Ubah</a>`;
            }

            if (config.canHapus) {
                const urlHapus = config.hapusUrl.replace(':id', user.id);
                actionButtons += `<a href="#deleteUserModal"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteUserModal"
                                    data-url="${urlHapus}"
                                    data-name="${user.name}"
                                    class="dx-badge dx-badge-danger btn-trigger-delete">Hapus</a>`;
            }

            DOM.dataContainer.innerHTML += `
                <tr>
                    <td>${rowNumber}</td>
                    <td>${user.name}</td>
                    <td>${user.email}</td>
                    <td>${user.role}</td>
                    <td>${actionButtons}</td>
                </tr>
            `;
        });

        DOM.paginationInfo.innerHTML = `
            <small style="letter-spacing: 0.5px;">Menampilkan
                <strong>${data.meta.from} - ${data.meta.to}</strong> dari <strong>${data.meta.total}</strong> data
            </small>
        `;
        DOM.paginationLinks.innerHTML = data.links;
    };

    const renderEmptyState = () => `
        <tr>
            <td colspan="5">
                <div class="dx-empty-batch text-center">
                    <div class="dx-empty-batch-image">
                        <img src="/images/speech-bubble.png" alt="empty-batch" class="img-fluid d-inline">
                    </div>
                    <h5 class="dx-empty-batch-title">Data tidak ditemukan</h5>
                    <p class="dx-empty-batch-content">Untuk keterangan lebih lanjut, silakan baca <a href="#" target="_blank">Link ini.</a></p>
                </div>
            </td>
        </tr>
    `;

    // 5. Event Listeners (Event Delegation)
    if (DOM.deleteModal) {
        DOM.deleteModal.addEventListener('show.bs.modal', (event) => {
            const button = event.relatedTarget;
            document.getElementById('delete-modal-username').textContent = button.getAttribute('data-name');
            document.getElementById('delete-modal-form').setAttribute('action', button.getAttribute('data-url'));
        });
    }

    if (DOM.searchForm) {
        DOM.searchForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const searchInput = DOM.searchInput ? DOM.searchInput.value : '';
            fetchUserData(1, searchInput); // Reset ke halaman 1 setiap pencarian baru
        });
    }

    if (DOM.paginationLinks) {
        DOM.paginationLinks.addEventListener('click', (e) => {
            const targetLink = e.target.closest('.pagination a, .page-link, a');
            if (targetLink) {
                e.preventDefault();
                const urlString = targetLink.getAttribute('href');
                if (urlString && urlString !== '#') {
                    const urlParams = new URL(urlString).searchParams;
                    const page = urlParams.get('page') || 1;

                    // Menggunakan keyword pencarian yang sedang aktif di state global
                    fetchUserData(page, currentSearchKeyword);
                }
            }
        });
    }

    // Event saat tombol reset diklik
    if (DOM.resetBtn) {
        DOM.resetBtn.addEventListener('click', (e) => {
            e.preventDefault();
            if (DOM.searchInput) DOM.searchInput.value = ''; // Kosongkan input form
            fetchUserData(1, ''); // Ambil data awal dari halaman 1 tanpa filter keyword
        });
    }

    // Jalankan otomatis saat halaman terbuka pertama kali
    fetchUserData(1, currentSearchKeyword);
});
