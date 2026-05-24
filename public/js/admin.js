// Tombol buka dan tutup
//* Block scope
const toggleSidebarWithClasses = (function () {
    // Variabel Privat (Closure)
    const MOBILE_BREAKPOINT = 768;

    function init() {
        const sidebar = document.querySelector(".dx-sidebar");
        const section = document.querySelector(".dx-section");
        const closeBtn = document.getElementById("closeBtn");
        const openBtn = document.getElementById("openBtn");
        const CLOSED_CLASS = "dx-sidebar--closed";

        // 1. Fungsi Pembantu: Cek apakah saat ini layar Mobile
        const isMobile = () => window.innerWidth <= MOBILE_BREAKPOINT;

        // 2. Fungsi Reset: Bersihkan style jika pindah ke Mobile
        const resetStyles = () => {
            if (isMobile() && openBtn) {
                openBtn.style.display = ""; // Hapus inline-style agar CSS Media Query menang
            }
        };

        const openSidebar = () => {
            if (isMobile()) return; // Jangan jalankan logika desktop di mobile
            sidebar.classList.remove(CLOSED_CLASS);
            section.classList.remove(CLOSED_CLASS);
            if (openBtn) openBtn.style.display = "none";
        };

        const closeSidebar = () => {
            if (isMobile()) return;
            sidebar.classList.add(CLOSED_CLASS);
            section.classList.add(CLOSED_CLASS);
            if (openBtn) openBtn.style.display = "block";
        };

        // 3. Event Listeners
        if (closeBtn) closeBtn.addEventListener("click", closeSidebar);
        if (openBtn) openBtn.addEventListener("click", openSidebar);

        // 4. Handle Window Resize (Sangat Penting!)
        window.addEventListener("resize", () => {
            resetStyles();
            // Jika user membesarkan layar kembali ke desktop, pastikan state tombol sinkron
            if (!isMobile() && sidebar.classList.contains(CLOSED_CLASS)) {
                if (openBtn) openBtn.style.display = "block";
            }
        });

        // Jalankan reset sekali saat awal load
        resetStyles();
    }

    return {
        run: init
    };
})();

// Jalankan modul
document.addEventListener("DOMContentLoaded", toggleSidebarWithClasses.run);

// Password Hidden
//* Block Scope
const setupPasswordToggle = (inputId, iconId) => {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);

    if (!input || !icon) return; // Guard clause jika elemen tidak ditemukan

    icon.onclick = () => {
        const isPassword = input.type === 'password';

        // Toggle tipe input
        input.type = isPassword ? 'text' : 'password';

        // Toggle gambar icon
        icon.setAttribute('src', isPassword ? 'images/eye.svg' : 'images/eye-slash.svg');

        // Toggle class (menggunakan classList.toggle lebih ringkas)
        input.classList.toggle('form-group', isPassword);
    };
};

// Panggil fungsi untuk masing-masing input
setupPasswordToggle('password-current', 'icon-current-password');
setupPasswordToggle('password-new', 'icon-new-password');

// Counter Animation
//* DOM, Block Scope dan Arrow Function
document.querySelectorAll('.counter').forEach(el => {
    const target = +el.getAttribute('data-target');
    const increment = target / 100;

    const updateCount = () => {
        const current = +el.innerText.replace(/,/g, '');
        if (current < target) {
            el.innerText = Math.ceil(current + increment).toLocaleString();
            setTimeout(updateCount, 20);
        } else {
            el.innerText = target.toLocaleString();
        }
    };
    updateCount();
});

// Ascending dan Descending Data Tables
//* DOM, Block Scope dan Arrow Function
{
    const initTableSort = () => {
        const sortableHeaders = document.querySelectorAll('.dx-sortable');

        sortableHeaders.forEach(headerCell => {
            headerCell.addEventListener('click', () => {
                const tableElement = headerCell.closest('table');
                const tbody = tableElement.querySelector('tbody');

                // 1. Identifikasi baris "Data tidak ditemukan"
                // Kita cari baris yang memiliki class khusus atau yang memiliki colspan besar
                const emptyRow = tbody.querySelector('.dx-empty-row') || tbody.querySelector('[colspan]');

                // Jika baris kosong ditemukan, jangan lakukan sortir
                if (emptyRow && emptyRow.innerText.includes("tidak ditemukan")) {
                    return;
                }

                const headerIndex = Array.from(headerCell.parentElement.children).indexOf(headerCell);
                const currentIsAscending = headerCell.classList.contains('dx-sort-asc');

                // 2. Reset UI Header
                tableElement.querySelectorAll('th').forEach(th =>
                    th.classList.remove('dx-sort-asc', 'dx-sort-desc')
                );

                const direction = currentIsAscending ? 'desc' : 'asc';
                headerCell.classList.add(`dx-sort-${direction}`);

                // 3. Ambil baris data saja (abaikan baris info/kosong)
                const rows = Array.from(tbody.querySelectorAll('tr')).filter(tr => {
                    // Hanya ambil baris yang punya banyak kolom (data asli)
                    return tr.querySelectorAll('td').length > 1;
                });

                if (rows.length === 0) return;

                const sortedRows = rows.sort((a, b) => {
                    const aCell = a.querySelector(`td:nth-child(${headerIndex + 1})`);
                    const bCell = b.querySelector(`td:nth-child(${headerIndex + 1})`);

                    if (!aCell || !bCell) return 0;

                    const aText = aCell.textContent.trim();
                    const bText = bCell.textContent.trim();

                    const aVal = isNaN(aText) || aText === '' ? aText.toLowerCase() : parseFloat(aText);
                    const bVal = isNaN(bText) || bText === '' ? bText.toLowerCase() : parseFloat(bText);

                    if (aVal > bVal) return direction === 'asc' ? 1 : -1;
                    if (aVal < bVal) return direction === 'asc' ? -1 : 1;
                    return 0;
                });

                // 4. Update DOM
                const fragment = document.createDocumentFragment();
                sortedRows.forEach(row => fragment.appendChild(row));

                tbody.innerHTML = '';
                tbody.appendChild(fragment);
            });
        });
    };

    initTableSort();
}

// Tombol Back to Top
//* DOM, Block Scope dan Arrow Function
{
    // Menggunakan block scope untuk mengisolasi variabel agar tidak bentrok
    const backToTopBtn = document.getElementById('dxBackToTop');

    /**
     * Fungsi untuk menangani kemunculan tombol saat scroll
     */
    const handleScroll = () => {
        // Menggunakan window.pageYOffset untuk kompatibilitas browser yang lebih luas
        const scrollPosition = window.scrollY || window.pageYOffset;

        if (scrollPosition > 300) {
            backToTopBtn.classList.add('show');
        } else {
            backToTopBtn.classList.remove('show');
        }
    };

    /**
     * Fungsi untuk scroll ke atas secara halus
     */
    const scrollToTop = () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    };

    // Event Listeners menggunakan arrow function
    window.addEventListener('scroll', handleScroll);
    backToTopBtn.addEventListener('click', scrollToTop);
}

// Fix Header
// const header = document.getElementById('mainHeader');

// window.addEventListener('scroll', () => {
//     if (window.scrollY > 0) {
//         // Jika sudah di-scroll ke bawah
//         header.classList.add('shadow-scrolled');
//     } else {
//         // Jika kembali ke posisi paling atas
//         header.classList.remove('shadow-scrolled');
//     }
// });

//  Notif Badge
//* DOM, Block Scope dan Arrow Function
// {
//     // Memilih elemen badge menggunakan const (Block Scope)
//     const badge = document.querySelector('#notifBadge');

//     /**
//      * Arrow Function untuk mengatur tampilan badge
//      * @param {number} count - Jumlah notifikasi
//      */
//     const renderBadge = (count) => {
//         // Konversi ke number untuk memastikan validasi
//         const value = Number(count);

//         if (value > 0) {
//             badge.textContent = value > 99 ? '99+' : value;
//             badge.style.display = 'flex'; // Munculkan badge
//         } else {
//             badge.style.display = 'none'; // Sembunyikan jika 0 atau kurang
//         }
//     };

//     // Jalankan pengecekan pertama kali saat halaman dimuat
//     renderBadge(badge.textContent);

//     // Contoh penggunaan: Panggil fungsi ini saat ada data baru
//     // window.updateNotify = (n) => renderBadge(n);

//     // Simulasi: Angka berubah dari 0 ke 5 setelah 2 detik
//     setTimeout(() => renderBadge(5), 2000);
// }

//* Validasi
//* DOM, Block Scope dan Arrow Function
// document.addEventListener("DOMContentLoaded", () => {
//   const notice = document.querySelector('#welcomeNotice');

//   // Hapus elemen setelah 5 detik (5000ms)
//   if (notice) {
//     setTimeout(() => notice.remove(), 5000);
//   }
// });
const hideWelcomeNotice = () => {
    const notice = document.querySelector('#welcomeNotice');
    if (!notice) return;

    setTimeout(() => {
        notice.classList.add('hide-notice');

        // Hapus total dari DOM setelah animasi selesai jika perlu
        notice.addEventListener('transitionend', () => notice.remove(), { once: true });
    }, 5000);
};

// Panggil fungsi
hideWelcomeNotice();


//* Sidebar dropdown
//* DOM, Block Scope dan Closure
const SidebarModule = (function () {
    // Ini adalah Closure: variabel di dalamnya terproteksi dari luar

    /**
     * Fungsi Utama untuk Inisialisasi Sidebar
     * @param {Function} onToggleCallback - Callback opsional saat menu dibuka/tutup
     */
    function init(onToggleCallback) {
        const allSubmenuItems = document.querySelectorAll('.dx-has-submenu');
        const currentPath = window.location.pathname.split("/").pop();

        allSubmenuItems.forEach(item => {
            const trigger = item.querySelector('.dx-menu-trigger');
            const subLinks = item.querySelectorAll('.dx-sub-link');

            // 1. Logika Auto-Active
            subLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (href === currentPath && href !== "#") {
                    link.classList.add('active');
                    item.classList.add('active');
                }
            });

            // 2. Logika Klik dengan Callback
            if (trigger) {
                trigger.onclick = function (e) {
                    e.stopPropagation();
                    e.preventDefault();

                    // Tutup menu lain
                    allSubmenuItems.forEach(otherItem => {
                        if (otherItem !== item) otherItem.classList.remove('open');
                    });

                    // Toggle menu saat ini
                    const isOpen = item.classList.toggle('open');

                    // Menjalankan callback jika disediakan
                    if (typeof onToggleCallback === 'function') {
                        onToggleCallback(item, isOpen);
                    }
                };
            }
        });

        // 3. Event Listener Global
        document.addEventListener('click', () => {
            allSubmenuItems.forEach(item => item.classList.remove('open'));
        });

        document.querySelectorAll('.dx-floating-card').forEach(card => {
            card.onclick = (e) => e.stopPropagation();
        });
    }

    // Mengembalikan object agar fungsi 'init' bisa diakses dari luar
    return {
        init: init
    };
})();

//* Sidebar dropdown saat Mobile
//* DOM, Block Scope dan Closure
// Cara Menjalankannya:
document.addEventListener('DOMContentLoaded', function () {
    SidebarModule.init(function (element, isOpen) {
        // Ini adalah Callback yang akan berjalan setiap kali menu di-klik
        console.log(`Menu ${element.id} sekarang dalam keadaan: ${isOpen ? 'Terbuka' : 'Tertutup'}`);
    });
});

const MobileBottomNav = (function () {
    // Variabel di bawah ini bersifat privat (hanya bisa diakses di dalam closure ini)
    const ACTIVE_CLASS = 'active';
    const OPEN_CLASS = 'open';

    /**
     * Fungsi internal untuk mendapatkan nama file dari URL saat ini
     */
    const getCurrentFileName = () => window.location.pathname.split("/").pop();

    /**
     * Logika utama untuk inisialisasi
     */
    function init() {
        const submenuItems = document.querySelectorAll('.dx-has-submenu-ht');
        const allLinks = document.querySelectorAll('.dx-nav-link-ht, .dx-mobile-dropdown a');
        const currentPath = getCurrentFileName();

        // 1. Logika Auto-Active (Self-Invoking di dalam init)
        allLinks.forEach(link => {
            const href = link.getAttribute('href');

            if (href === currentPath && href !== "#") {
                link.classList.add(ACTIVE_CLASS);

                // Aktifkan parent jika ini adalah link di dalam dropdown
                const parentSubmenu = link.closest('.dx-has-submenu-ht');
                if (parentSubmenu) {
                    const trigger = parentSubmenu.querySelector('.dx-nav-link-ht');
                    if (trigger) trigger.classList.add(ACTIVE_CLASS);
                }
            }
        });

        // 2. Logika Klik Dropdown
        submenuItems.forEach(item => {
            const trigger = item.querySelector('.dx-menu-trigger-ht');

            if (trigger) {
                trigger.onclick = function (e) {
                    e.stopPropagation();
                    e.preventDefault(); // Mencegah lonjakan scroll jika menggunakan <a>

                    // Tutup menu lain yang sedang terbuka
                    submenuItems.forEach(other => {
                        if (other !== item) other.classList.remove(OPEN_CLASS);
                    });

                    // Toggle menu yang diklik
                    item.classList.toggle(OPEN_CLASS);
                };
            }
        });

        // 3. Global Click: Tutup dropdown jika klik di luar navbar
        document.addEventListener('click', (e) => {
            // Cek jika klik bukan berasal dari dalam sidebar-ht
            if (!e.target.closest('.dx-sidebar-ht')) {
                submenuItems.forEach(item => item.classList.remove(OPEN_CLASS));
            }
        });
    }

    // Mengembalikan object public API
    return {
        init: init
    };
})();

// Eksekusi saat DOM siap
document.addEventListener('DOMContentLoaded', MobileBottomNav.init);

//* Input Rupiah
//* DOM, Block Scope dan Closure
document.addEventListener('DOMContentLoaded', function () {

    const initCurrencyFormatter = () => {
        const inputs = document.querySelectorAll('.input-currency');

        inputs.forEach(input => {
            // Mencari input hidden yang berada tepat setelahnya atau di dalam group yang sama
            const hiddenInput = input.parentElement.querySelector('input[type="hidden"]');

            input.addEventListener('input', function () {
                // Ambil angka saja
                let rawValue = this.value.replace(/\D/g, '');

                // Format tampilan ke Rupiah (id-ID)
                this.value = rawValue ? new Intl.NumberFormat('id-ID').format(
                    rawValue) : '';

                // Masukkan nilai murni ke hidden input untuk backend (Laravel/database)
                if (hiddenInput) {
                    hiddenInput.value = rawValue;
                }
            });

            // Trigger saat awal (jika ada nilai dari database/edit mode)
            if (input.value) {
                input.dispatchEvent(new Event('input'));
            }
        });
    };

    initCurrencyFormatter();
});
