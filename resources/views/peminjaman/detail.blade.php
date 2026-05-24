@extends('layouts.admin')
@section('title', 'Peminjaman - Detail')

@section('content')
    <div class="container-fluid">

        <div class="row mx-auto">
            <div class="col">

                <h5 class="dx-text-lg dx-text-biru dx-mb-10 text-center">Detail <span
                        class="dx-text-kuning dx-font-bold dx-text-2xl">Peminjaman</span>
                </h5>

                <div class="row justify-content-center">
                    <div class="col-md-8">

                        <div>
                            <h2 class="dx-font-bold mb-2">{{ $peminjaman->aset->kode_barang }}</h2>
                            <p class="dx-text-xl dx-font-regular dx-font-semi-bold mb-3 d-block">
                                {{ $peminjaman->aset->nama_barang }}
                                @php
                                    $suffix = 'th';
                                    if (
                                        $peminjaman->urutan_pemakaian % 100 < 11 ||
                                        $peminjaman->urutan_pemakaian % 100 > 13
                                    ) {
                                        switch ($peminjaman->urutan_pemakaian % 10) {
                                            case 1:
                                                $suffix = 'st';
                                                break;
                                            case 2:
                                                $suffix = 'nd';
                                                break;
                                            case 3:
                                                $suffix = 'rd';
                                                break;
                                        }
                                    }
                                @endphp
                                @if ($peminjaman->urutan_pemakaian)
                                    <small class="d-block">{{ $peminjaman->urutan_pemakaian }}{{ $suffix }}
                                        usage</small>
                                @else
                                    <small class="d-block">No record</small>
                                @endif
                            </p>

                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <span class="d-block">Kode Pinjam</span>
                                    <strong>{{ $peminjaman->kode_peminjaman }}</strong>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <span class="d-block">Peminjam</span>
                                    <strong>{{ $peminjaman->user_aset ?? '-' }}</strong>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <span class="d-block">PT User</span>
                                    <strong>{{ $peminjaman->pt_user ?? '-' }}</strong>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <span class="d-block">Tanggal Pinjam</span>
                                    <strong>{{ $peminjaman->tanggal_peminjaman ? $peminjaman->tanggal_peminjaman->format('d-m-Y') : '-' }}
                                    </strong>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <span class="d-block">Departemen</span>
                                    <strong>{{ $peminjaman->departemen ?? '-' }}</strong>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <span class="d-block">Lokasi</span>
                                    <strong>{{ $peminjaman->lokasi ?? '-' }}</strong>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <span class="d-block">Kondisi</span>
                                    <span
                                        class="dx-font-bold {{ $peminjaman->aset->kondisi == 'baik' ? 'dx-text-hijau' : 'dx-text-merah' }}">
                                        {{ ucfirst($peminjaman->aset->kondisi) }}
                                    </span>
                                </div>

                                <div class="col-md-6 mb-2">
                                    <span class="d-block">Status</span>
                                    <strong>
                                        @if ($peminjaman->status == 'dipinjam')
                                            <span class="dx-badge dx-no-cursor dx-badge-outline-primary">Delivered</span>
                                        @elseif ($peminjaman->status == 'dikembalikan')
                                            <span class="dx-badge dx-no-cursor dx-badge-outline-success">Returned</span>
                                        @elseif ($peminjaman->status == 'dibatalkan')
                                            <span class="dx-badge dx-no-cursor dx-badge-outline-danger">Canceled</span>
                                        @elseif ($peminjaman->status == 'permanen')
                                            <span class="dx-badge dx-no-cursor dx-badge-outline-warning">Permanent</span>
                                        @else
                                            Tidak diketahui
                                        @endif
                                    </strong>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="mb-2">
                                        <span class="d-block">Bukti Pinjam</span>
                                        @if ($peminjaman->foto_peminjaman)
                                            @php
                                                $extension = strtolower(
                                                    pathinfo($peminjaman->foto_peminjaman, PATHINFO_EXTENSION),
                                                );
                                            @endphp

                                            @if (in_array($extension, ['jpg', 'jpeg', 'png']))
                                                <div class="mt-2">
                                                    <a href="{{ asset('storage/' . $peminjaman->foto_peminjaman) }}"
                                                        target="_blank">
                                                        <img src="{{ asset('storage/' . $peminjaman->foto_peminjaman) }}"
                                                            alt="Upload Bukti Pinjam" class="img-thumbnail mb-2"
                                                            style="max-width: 300px; cursor: pointer;"
                                                            title="Klik untuk memperbesar">
                                                    </a>
                                                </div>
                                            @elseif ($extension === 'pdf')
                                                <small class="dx-text-xs dx-font-bold dx-text-abu-abu-gelap">Dokumen
                                                    PDF</small>
                                                <a href="{{ asset('storage/' . $peminjaman->foto_peminjaman) }}"
                                                    target="_blank" class="dx-badge dx-badge-danger">
                                                    Lihat Dokumen PDF
                                                </a>
                                            @endif
                                        @else
                                            <span class="dx-text-merah dx-text-sm">Tidak ada
                                                bukti</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 text-center mb-2">
                                    <a href="{{ route('peminjaman.index') }}" class="dx-btn dx-btn-primary">Kembali</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
