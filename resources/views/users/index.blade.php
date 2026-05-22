@php
    $perm = \App\Models\Permission::where('role', Auth::user()->role)
        ->where('module', 'User')
        ->first();
@endphp

@extends('layouts.admin')
@section('title', 'Users')

@section('content')
    <div class="container-fluid">

        <div class="row mx-auto">
            <div class="col">

                @if (session('success'))
                    <div id="welcomeNotice" class="dx-notice dx-notice-success">
                        <div class="dx-notice-title">Sukses !</div>
                        <div class="dx-notice-icon">
                            <img src="{{ asset('images/icon-success.png') }}" alt="Sukses" class="img-fluid">
                        </div>
                        <div class="row dx-notice-body">
                            <div class="dx-notice-body-text">
                                <p>{!! session('success') !!}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <h3 class="dx-table-title dx-with-border dx-table-text-left">Users</h3>
                <p>Halaman untuk data <strong>User</strong></p>

                <div class="row gap-2">
                    <div class="col-12 col-md-5 order-1 d-flex gap-2">
                        @if ($perm && $perm->tambah)
                            <a href="{{ route('users.tambah') }}" class="dx-btn dx-btn-primary">Tambah</a>
                        @endif
                        <a href="{{ route('users.hak-akses') }}" class="dx-btn dx-btn-warning">Hak Akses</a>
                    </div>
                    <div class="col-12 col-md-5 order-2 ms-auto">
                        <form method="GET" action="{{ route('users.index') }}"
                            class="d-flex justify-content-end align-items-center gap-2">
                            <div class="dx-form-wrapper w-100">
                                <input type="text" class="dx-form-input-src" name="search"
                                    placeholder="Ketik nama atau role..." aria-label="Search"
                                    value="{{ request('search') }}">
                            </div>
                            <button type="submit" class="dx-btn dx-btn-secondary dx-src-btn">
                                Cari
                            </button>
                            @if (request('search'))
                                <a href="{{ route('users.index') }}"
                                    class="dx-btn dx-btn-primary dx-src-btn text-decoration-none">Reset</a>
                            @endif
                        </form>
                    </div>
                </div>

                <div class="dx-table dx-skeleton-table">
                    <div class="table-responsive">

                        <table class="table dx-batch-table" id="table-skeleton">
                            <thead>
                                <tr>
                                    <th scope="col" class="align-middle">No</th>
                                    <th scope="col" class="align-middle">Nama</th>
                                    <th scope="col" class="align-middle">Email</th>
                                    <th scope="col" class="align-middle">Role</th>
                                    <th scope="col" class="align-middle">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Loop sebanyak 5 baris tiruan menggunakan helper blade @foreach --}}
                                @foreach (range(1, 5) as $index)
                                    <tr>
                                        <td>
                                            <div class="dx-skeleton dx-sk-25"></div>
                                        </td>
                                        <td>
                                            <div class="dx-skeleton dx-sk-140"></div>
                                        </td>
                                        <td>
                                            <div class="dx-skeleton dx-sk-140"></div>
                                        </td>
                                        <td>
                                            <div class="dx-skeleton dx-sk-25"></div>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <div class="dx-skeleton dx-sk-btn"></div>
                                                <div class="dx-skeleton dx-sk-btn"></div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <table class="table dx-batch-table" id="table-real" style="display: none !important;">
                            <thead>
                                <tr>
                                    <th scope="col" class="align-middle">No</th>
                                    <th scope="col" class="align-middle dx-sortable">Nama</th>
                                    <th scope="col" class="align-middle dx-sortable">Email</th>
                                    <th scope="col" class="align-middle">Role</th>
                                    <th scope="col" class="align-middle">Aksi</th>
                                </tr>
                            </thead>

                            <tbody id="user-data-container">
                                {{-- @forelse ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->role }}</td>
                                        <td>
                                            @if ($perm && $perm->ubah)
                                                <a href="{{ route('users.ubah', $user->id) }}"
                                                    class="dx-badge dx-badge-primary">Ubah</a>
                                            @endif
                                            @if ($perm && $perm->hapus)
                                                <a href="#deleteUserModal{{ $user->id }}" data-bs-toggle="modal"
                                                    data-bs-target="#deleteUserModal{{ $user->id }}"
                                                    class="dx-badge dx-badge-danger">Hapus</a>
                                            @endif
                                            @include('users.partials.delete-modal-user', [
                                                'user' => $user,
                                            ])

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">
                                            <div class="dx-empty-batch text-center">
                                                <div class="dx-empty-batch-image">
                                                    <img src="{{ asset('images/speech-bubble.png') }}" alt="empty-batch"
                                                        class="img-fluid d-inline">
                                                </div>
                                                <h5 class="dx-empty-batch-title">Data tidak ditemukan
                                                </h5>
                                                <p class="dx-empty-batch-content">Untuk keterangan lebih
                                                    lanjut, silahkan baca <a href="#" target="_blank">Link
                                                        ini.</a></p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse --}}

                            </tbody>
                        </table>

                        <div class="dx-pagination-wrapper d-flex justify-content-between align-items-center mt-5 mb-4 px-2"
                            id="pagination-skeleton">
                            <div>
                                <div class="dx-skeleton dx-sk-page-info"></div>
                            </div>
                            <div class="d-flex gap-1">
                                <div class="dx-skeleton dx-sk-page-box"></div>
                                <div class="dx-skeleton dx-sk-page-box"></div>
                            </div>
                        </div>

                        <div class="dx-pagination-wrapper d-flex justify-content-between align-items-center px-2"
                            id="pagination-real" style="display: none !important;">
                            <div class="dx-pagination-info dx-text-abu-abu-gelap" id="pagination-info">
                                {{-- <small style="letter-spacing: 0.5px;">Menampilkan
                                    <strong>{{ $users->firstItem() }} - {{ $users->lastItem() }}</strong>
                                    dari <strong>{{ $users->total() }}</strong> data</small>
                                <small style="letter-spacing: 0.5px">
                                    @if (request('search'))
                                        (Hasil cari: "{{ request('search') }}")
                                    @endif
                                </small> --}}
                            </div>

                            <div id="pagination-links-container">
                            </div>
                            {{-- {{ $users->links('users.partials.pagination') }} --}}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('users.partials.delete-modal-user')

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const deleteModal = document.getElementById('deleteUserModal');
            if (deleteModal) {
                deleteModal.addEventListener('show.bs.modal', function(event) {
                    // Tombol yang memicu modal muncul
                    const button = event.relatedTarget;

                    // Ekstrak data dari atribut data-* tombol yang diklik
                    const userName = button.getAttribute('data-name');
                    const deleteUrl = button.getAttribute('data-url');

                    // Isi komponen di dalam modal dengan data spesifik user tersebut
                    document.getElementById('delete-modal-username').textContent = userName;
                    document.getElementById('delete-modal-form').setAttribute('action', deleteUrl);
                });
                // 1. Ambil data pertama kali saat halaman dibuka
                fetchUserData();

                // 2. Tangkap form pencarian bawaan agar tidak reload halaman
                const searchForm = document.querySelector('form[action="{{ route('users.index') }}"]');
                if (searchForm) {
                    searchForm.addEventListener('submit', function(e) {
                        e.preventDefault();
                        const searchInput = this.querySelector('input[name="search"]').value;
                        fetchUserData(1, searchInput); // Reset ke halaman 1 saat cari data baru
                    });
                }

                // 3. TANGKAP KLIK PADA TOMBOL PAGINATION (Mencegah Reload Halaman)
                const paginationLinksContainer = document.getElementById('pagination-links-container');
                if (paginationLinksContainer) {
                    paginationLinksContainer.addEventListener('click', function(e) {
                        // Cari apakah yang diklik adalah tag <a> di dalam pagination
                        const targetLink = e.target.closest('.pagination a, .page-link, a');

                        if (targetLink) {
                            e.preventDefault(); // Cegah browser reload halaman

                            // Ambil URL dari href tombol (Contoh: http://localhost/users?page=2)
                            const urlString = targetLink.getAttribute('href');
                            if (urlString && urlString !== '#') {
                                const urlParams = new URL(urlString);
                                // Ekstrak nomor halaman dan keyword pencarian yang aktif
                                const page = urlParams.searchParams.get('page') || 1;
                                const search = urlParams.searchParams.get('search') || '';

                                // Sinkronkan input pencarian di layar jika ada filter aktif
                                const searchInput = document.querySelector('input[name="search"]');
                                if (searchInput && search) {
                                    searchInput.value = search;
                                }

                                // Panggil ulang data untuk halaman tersebut
                                fetchUserData(page, search);
                            }
                        }
                    });
                }
            }
        });

        // Tambahkan parameter page (default = 1) pada fungsi fetch
        function fetchUserData(page = 1, searchKeyword = '') {
            const tableSkeleton = document.getElementById('table-skeleton');
            const paginationSkeleton = document.getElementById('pagination-skeleton');
            const tableReal = document.getElementById('table-real');
            const paginationReal = document.getElementById('pagination-real');
            const dataContainer = document.getElementById('user-data-container');
            const paginationInfo = document.getElementById('pagination-info');
            const paginationLinks = document.getElementById('pagination-links-container');

            // Kondisi Awal: Nyalakan Skeleton loading
            tableReal.style.setProperty('display', 'none', 'important');
            paginationReal.style.setProperty('display', 'none', 'important');
            tableSkeleton.style.setProperty('display', 'table', 'important');
            paginationSkeleton.style.setProperty('display', 'flex', 'important');

            // Susun URL Request dengan menyertakan parameter halaman (?page=X)
            let url = `{{ route('users.index') }}?page=${page}`;
            if (searchKeyword) {
                url += `&search=${encodeURIComponent(searchKeyword)}`;
            }

            fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    dataContainer.innerHTML = '';

                    if (data.users.length === 0) {
                        dataContainer.innerHTML = `
                    <tr>
                        <td colspan="5">
                            <div class="dx-empty-batch text-center">
                                <div class="dx-empty-batch-image">
                                    <img src="{{ asset('images/speech-bubble.png') }}" alt="empty-batch"
                                        class="img-fluid d-inline">
                                </div>
                                <h5 class="dx-empty-batch-title">Data tidak ditemukan
                                </h5>
                                <p class="dx-empty-batch-content">Untuk keterangan lebih
                                    lanjut, silahkan baca <a href="#" target="_blank">Link
                                        ini.</a></p>
                            </div>
                        </td>
                    </tr>
                `;
                    } else {
                        data.users.forEach((user, index) => {
                            let rowNumber = data.meta.from + index;

                            let actionButtons = '';

                            @if ($perm && $perm->ubah)
                                // 1. Siapkan URL Ubah dari Laravel Route, gunakan :id sebagai placeholder
                                let urlUbah = "{{ route('users.ubah', ':id') }}";
                                // 2. Ganti :id dengan ID user asli dari JavaScript
                                urlUbah = urlUbah.replace(':id', user.id);

                                actionButtons +=
                                    `<a href="${urlUbah}" class="dx-badge dx-badge-primary me-1">Ubah</a>`;
                            @endif

                            @if ($perm && $perm->hapus)
                                // 1. Siapkan Route hapus seperti trik cara ke-2 kemarin
                                let urlHapus = "{{ route('users.hapus', ':id') }}";
                                urlHapus = urlHapus.replace(':id', user.id);

                                // 2. Masukkan data urlHapus dan nama user ke dalam attribute tombol
                                actionButtons += `<a href="#deleteUserModal"
                        data-bs-toggle="modal"
                        data-bs-target="#deleteUserModal"
                        data-url="${urlHapus}"
                        data-name="${user.name}"
                        class="dx-badge dx-badge-danger btn-trigger-delete">Hapus</a>`;
                            @endif

                            let rowHTML = `
                        <tr>
                            <td>${rowNumber}</td>
                            <td>${user.name}</td>
                            <td>${user.email}</td>
                            <td>${user.role}</td>
                            <td>${actionButtons}</td>
                        </tr>
                    `;
                            dataContainer.innerHTML += rowHTML;
                        });
                    }

                    // Update Info Text
                    paginationInfo.innerHTML = `
                <small style="letter-spacing: 0.5px;">Menampilkan
                    <strong>${data.meta.from} - ${data.meta.to}</strong>
                    dari <strong>${data.meta.total}</strong> data
                </small>
            `;

                    // Suntikkan struktur tombol link pagination baru dari server
                    paginationLinks.innerHTML = data.links;

                    // Akhir Proses: Matikan Skeleton, Munculkan Data Real
                    tableSkeleton.style.setProperty('display', 'none', 'important');
                    paginationSkeleton.style.setProperty('display', 'none', 'important');
                    tableReal.style.setProperty('display', 'table', 'important');
                    paginationReal.style.setProperty('display', 'flex', 'important');
                })
                .catch(error => {
                    console.error("Gagal memuat data:", error);
                });
        }
    </script>
@endsection
