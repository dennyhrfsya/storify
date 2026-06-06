<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="keywords" content="AxD">
    <meta name="description" content="For Storify">
    <title>Detail Aset - {{ $aset->kode_barang }}</title>
    <link rel="icon" href="{{ asset('images/favicon-16x16.png') }}" type="image/x-icon">

    <!-- From Google Fonts - Quicksand -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/storify-base-style-v2.css') }}">
</head>

<body>

    @php
        if (!function_exists('getOrdinal')) {
            function getOrdinal($number)
            {
                $ends = ['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'];
                if ($number % 100 >= 11 && $number % 100 <= 13) {
                    return $number . 'th';
                } else {
                    return $number . $ends[$number % 10];
                }
            }
        }
    @endphp

    <div class="dx-bg-phone">
        <header class="dx-header">
            <img src="{{ asset('images/logo-storify-white.png') }}" alt="Storify Logo" class="dx-logo-image">
        </header>

        <div class="dx-body">
            <main class="dx-main-content">
                <div class="dx-title-content">
                    <h1 class="dx-title-nama">{{ $aset->nama_barang }}</h1>
                    <p class="dx-title-kd">{{ $aset->kode_barang }}</p>
                    <p class="dx-title-ktg">{{ $aset->kategori }}</p>
                </div>
                {{-- Looping data dari relasi $aset->peminjaman --}}
                @forelse($aset->peminjaman->sortByDesc('tanggal_peminjaman') as $pinjam)
                    <div class="dx-item">
                        <div class="dx-item-info">
                            <h3>{{ $pinjam->user_aset }}</h3>
                            <p>{{ $pinjam->departemen }}</p>

                            <p class="dx-fw-light">Tanggal pinjam
                                {{ \Carbon\Carbon::parse($pinjam->tanggal_peminjaman)->translatedFormat('d M Y') }}</p>

                            @if ($pinjam->pengembalian)
                                <p class="dx-fw-light">Tanggal kembali
                                    {{ \Carbon\Carbon::parse($pinjam->pengembalian->tanggal_pengembalian)->translatedFormat('d M Y') }}
                                </p>
                            @else
                                <p class="dx-fw-light text-center">Tanggal kembali -</p>
                            @endif
                        </div>
                        <div class="dx-badge">
                            <span class="dx-badge-text">
                                {{ getOrdinal($loop->count - $loop->index) }} Usage
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="dx-empty-state">
                        <img src="{{ asset('images/hardwork-detail-barang.png') }}" alt="Detail Barang"
                            class="dx-empty-image">
                        <p class="dx-empty-text">Aset ini belum memiliki riwayat pemakaian</p>
                    </div>
                @endforelse

            </main>

            <nav class="dx-nav-capsule">

                <a href="{{ route('public.aset.detail', ['kode_barang' => base64_encode($aset->kode_barang)]) }}"
                    class="dx-nav-item is-active">
                    <img src="{{ asset('images/checks-bold.svg') }}" alt="Data Icon" class="dx-nav-icon">
                    <span class="dx-nav-text">Data</span>
                </a>

                <a href="{{ route('login') }}" class="dx-nav-item">
                    <img src="{{ asset('images/sign-in-bold.svg') }}" alt="Sign In" class="dx-nav-icon">
                    <span class="dx-nav-text">Login</span>
                </a>

            </nav>

        </div>
    </div>

</body>

</html>
