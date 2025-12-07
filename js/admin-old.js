//* Block scope
const toggleSidebarWithClasses = function () {
  // Ambil elemen berdasarkan kelas atau ID unik
  const sidebar = document.querySelector(".sidebar");
  const section = document.querySelector(".section");
  const closeBtn = document.getElementById("closeBtn");
  const openBtn = document.getElementById("openBtn");

  // Nama kelas yang akan digunakan untuk status 'tertutup'
  const CLOSED_CLASS = "sidebar--closed";

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
