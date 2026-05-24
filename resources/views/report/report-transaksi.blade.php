@php
    $perm = \App\Models\Permission::where('role', Auth::user()->role)
        ->where('module', 'Report Transaksi')
        ->first();
@endphp
@extends('layouts.admin')
@section('title', 'Report Transaksi')

@section('content')
    <div class="container-fluid">

        <div class="row mx-auto">
            <div class="col">

                @error('sampai_tanggal')
                    <div id="welcomeNotice" class="dx-notice dx-notice-error">
                        <div class="dx-notice-title">Gagal !</div>
                        <div class="dx-notice-icon">
                            <img src="{{ asset('images/icon-danger.png') }}" alt="Gagal" class="img-fluid">
                        </div>
                        <div class="row dx-notice-body">
                            <div class="dx-notice-body-text">
                                <p class="dx-text-merah dx-text-sm dx-margin-bottom-0">{{ $message }}</p>
                            </div>
                        </div>
                    </div>
                @enderror

                <h3 class="dx-table-title dx-with-border dx-table-text-left">Report</h3>
                <p>Halaman untuk data <strong>Riwayat Transaksi</strong></p>

                <form action="{{ route('report.transaksi') }}" method="GET">
                    <div class="row d-flex justify-content-center align-items-center">
                        <div class="col-auto col-lg-4">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="pencarian">Pencarian</label>
                                    <input type="text" id="pencarian" name="search" value="{{ request('search') }}"
                                        placeholder="Ketik kode atau nama barang..." autofocus>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="start_date">Dari Tanggal</label>
                                    <div class="dx-input-wrapper">
                                        <input type="date" id="dari_tanggal" name="dari_tanggal"
                                            value="{{ request('dari_tanggal') }}" placeholder="Pilih tanggal" />
                                        <span class="dx-icon">
                                            <img src="{{ asset('images/icon-calendar.svg') }}" alt="ava calendar"
                                                class="dx-h-6 dx-ml-4"></a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="end_date">Sampai Tanggal</label>
                                    <div class="dx-input-wrapper">
                                        <input type="date" id="sampai_tanggal" name="sampai_tanggal"
                                            value="{{ request('sampai_tanggal') }}" placeholder="Pilih tanggal" />
                                        <span class="dx-icon">
                                            <img src="{{ asset('images/icon-calendar.svg') }}" alt="ava calendar"
                                                class="dx-h-6 dx-ml-4"></a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="d-flex gap-2">
                                <button type="submit" class="dx-btn dx-btn-primary">Filter</button>
                                <a href="{{ route('report.transaksi') }}" class="dx-btn dx-btn-secondary">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </form>

                @if ($reportTransaksis->isEmpty())
                    <div class="dx-table">
                        <div class="table-responsive">
                            <table class="table dx-batch-table">
                                <tbody>
                                    <tr>
                                        <td colspan="9">
                                            <div class="dx-empty-batch text-center">
                                                <div class="dx-empty-batch-image">
                                                    <img src="{{ asset('images/bg-laporan.svg') }}" alt="empty-batch"
                                                        class="img-fluid d-inline w-25">
                                                </div>
                                                <h5 class="dx-empty-batch-title">Silahkan pilih rentang tanggal dan klik
                                                    tombol
                                                </h5>
                                                <p class="dx-empty-batch-content">Untuk menampilkan data laporan!</p>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="row mt-4">
                        <div class="col-12 d-flex gap-2">
                            <a href="{{ route('report.transaksi.pdf', request()->all()) }}"
                                class="dx-btn dx-btn-danger">PDF</a>
                            <a href="{{ route('report.transaksi.export', request()->all()) }}"
                                class="dx-btn dx-btn-success">Excel</a>
                        </div>
                    </div>

                    <div class="dx-table">
                        <div class="table-responsive">
                            <table class="table dx-batch-table">
                                <thead>
                                    <tr>
                                        <th scope="col" class="align-middle">No</th>
                                        <th scope="col" class="align-middle">Kode Transaksi</th>
                                        <th scope="col" class="align-middle">Nama Barang</th>
                                        <th scope="col" class="align-middle">User</th>
                                        <th scope="col" class="align-middle">Departemen</th>
                                        <th scope="col" class="align-middle">Tanggal</th>
                                        <th scope="col" class="align-middle">Status</th>
                                        <th scope="col" class="align-middle">Stok Awal</th>
                                        <th scope="col" class="align-middle">Keluar</th>
                                        <th scope="col" class="align-middle">Stok Akhir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reportTransaksis as $rt)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $rt->kode_transaksi }}</td>
                                            <td><strong class="d-block">{{ $rt->stokBarang->kode_barang }}</strong>
                                                {{ $rt->stokBarang->nama_barang }}
                                            </td>
                                            <td>{{ $rt->nama_user }}</td>
                                            <td>{{ $rt->departemen }}</td>
                                            <td>{{ \Carbon\Carbon::parse($rt->tanggal_transaksi)->format('d-m-Y') }}</td>
                                            <td>
                                                @php
                                                    $badgeClass = match (Str::lower($rt->status)) {
                                                        'dipinjamkan' => 'dx-badge-primary',
                                                        'diberikan' => 'dx-badge-success',
                                                        default => 'dx-badge-danger',
                                                    };
                                                @endphp

                                                <span class="dx-badge dx-no-cursor {{ $badgeClass }}">
                                                    {{ ucfirst($rt->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $rt->stok_awal ?? '-' }}</td>
                                            <td>{{ $rt->jumlah }}</td>
                                            <td>{{ $rt->stok_akhir ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="dx-pagination-wrapper d-flex justify-content-between align-items-center px-2">
                                <div class="dx-pagination-info dx-text-abu-abu-gelap">
                                    @if (request('start_date') && request('end_date'))
                                        <small style="letter-spacing: 0.5px;">Menampilkan laporan dari
                                            <strong>{{ date('d M Y', strtotime(request('start_date'))) }}</strong>
                                            sampai
                                            <strong>{{ date('d M Y', strtotime(request('end_date'))) }}</strong></small>
                                    @endif
                                </div>
                                {{ $reportTransaksis->links('report.partials.pagination') }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('js/report-transaksi.js') }}"></script>
    @endpush
@endsection
