// Tombol buka dan tutup
//* Block scope
const toggleSidebarWithClasses = function () {
  // Ambil elemen berdasarkan kelas atau ID unik
  const sidebar = document.querySelector(".dx-sidebar");
  const section = document.querySelector(".dx-section");
  const closeBtn = document.getElementById("closeBtn");
  const openBtn = document.getElementById("openBtn");

  // Nama kelas yang akan digunakan untuk status 'tertutup'
  const CLOSED_CLASS = "dx-sidebar--closed";

  // Fungsi untuk BUKA Sidebar (Hapus kelas tertutup)
  const openSidebar = () => {
    sidebar.classList.remove(CLOSED_CLASS);
    section.classList.remove(CLOSED_CLASS);
    openBtn.style.display = "none"; // Sembunyikan tombol buka
  };

  // Fungsi untuk TUTUP Sidebar (Tambahkan kelas tertutup)
  const closeSidebar = () => {
    sidebar.classList.add(CLOSED_CLASS);
    section.classList.add(CLOSED_CLASS);
    openBtn.style.display = "block"; // Tampilkan tombol buka
  };

  // Event Listener untuk Tombol Tutup (di dalam Sidebar)
  if (closeBtn) {
    closeBtn.addEventListener("click", closeSidebar);
  }

  // Event Listener untuk Tombol Buka (di Section/Konten)
  if (openBtn) {
    openBtn.addEventListener("click", openSidebar);
  }

  // Inisialisasi: Pastikan tombol buka tersembunyi jika sidebar tidak memiliki kelas CLOSED_CLASS
  if (sidebar && !sidebar.classList.contains(CLOSED_CLASS)) {
    openBtn.style.display = "none";
  }
};

// Panggil fungsi
toggleSidebarWithClasses();

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
{
  // Memilih elemen badge menggunakan const (Block Scope)
  const badge = document.querySelector('#notifBadge');

  /**
   * Arrow Function untuk mengatur tampilan badge
   * @param {number} count - Jumlah notifikasi
   */
  const renderBadge = (count) => {
    // Konversi ke number untuk memastikan validasi
    const value = Number(count);

    if (value > 0) {
      badge.textContent = value > 99 ? '99+' : value;
      badge.style.display = 'flex'; // Munculkan badge
    } else {
      badge.style.display = 'none'; // Sembunyikan jika 0 atau kurang
    }
  };

  // Jalankan pengecekan pertama kali saat halaman dimuat
  renderBadge(badge.textContent);

  // Contoh penggunaan: Panggil fungsi ini saat ada data baru
  // window.updateNotify = (n) => renderBadge(n);

  // Simulasi: Angka berubah dari 0 ke 5 setelah 2 detik
  setTimeout(() => renderBadge(5), 2000);
}