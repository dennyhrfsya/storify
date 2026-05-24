@php
    $perm = \App\Models\Permission::where('role', Auth::user()->role)
        ->where('module', 'Inventori')
        ->first();
@endphp
@extends('layouts.admin')
@section('title', 'Aset')

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
                @elseif (session('error'))
                    <div id="welcomeNotice" class="dx-notice dx-notice-warning">
                        <h3 class="dx-notice-title">Peringatan !</h3>
                        <div class="dx-notice-icon">
                            <img src="{{ asset('images/icon-warning.png') }}" alt="Peringatan" class="img-fluid">
                        </div>
                        <div class="row dx-notice-body">
                            <div class="dx-notice-body-text" style="--padding-right:calc(10rem + 3rem);">
                                <p>{!! session('error') !!}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <h3 class="dx-table-title dx-with-border dx-table-text-left">Aset</h3>
                <p>Halaman untuk data <strong>Aset</strong></p>

                <div class="row gap-2">
                    <div class="col-12 col-md-5 order-1 d-flex gap-2">
                        @if ($perm && $perm->tambah)
                            <a href="{{ route('aset.tambah') }}" class="dx-btn dx-btn-primary">Tambah</a>
                        @endif
                        <a href="{{ route('aset.export', request()->all()) }}" class="dx-btn dx-btn-success">Excel</a>
                    </div>
                    <div class="col-12 col-md-5 order-2 ms-auto">
                        <form method="GET" action="{{ route('aset.index') }}"
                            class="d-flex justify-content-end align-items-center gap-2">
                            <div class="dx-form-control-full w-50">
                                <select id="select" name="status">
                                    <option value="">Pilih Status...</option>
                                    <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>
                                        Delivered</option>
                                    <option value="tertunda" {{ request('status') == 'tertunda' ? 'selected' : '' }}>
                                        Pending</option>
                                    <option value="permanen" {{ request('status') == 'permanen' ? 'selected' : '' }}>
                                        Permanent</option>
                                    <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>
                                        Available</option>
                                </select>
                            </div>
                            <div class="dx-form-wrapper w-100">
                                <input type="text" class="dx-form-input-src" name="search"
                                    placeholder="Ketik kode, nama, kategori, atau pt..." aria-label="Search"
                                    value="{{ request('search') }}">
                            </div>
                            <button type="submit" class="dx-btn dx-btn-secondary dx-src-btn">
                                Cari
                            </button>
                            @if (request('search') || request('status'))
                                <a href="{{ route('aset.index') }}"
                                    class="dx-btn dx-btn-primary dx-src-btn text-decoration-none">Reset</a>
                            @endif
                        </form>
                    </div>
                </div>

                <div class="dx-table">
                    <div class="table-responsive">
                        <table class="table dx-batch-table">
                            <thead>
                                <tr>
                                    <th scope="col" class="align-middle">No</th>
                                    <th scope="col" class="align-middle dx-sortable">Kode Barang</th>
                                    <th scope="col" class="align-middle dx-sortable">Nama Barang</th>
                                    <th scope="col" class="align-middle">Kategori</th>
                                    <th scope="col" class="align-middle">Tanggal Pembelian</th>
                                    <th scope="col" class="align-middle">PT Pembeban</th>
                                    <th scope="col" class="align-middle">Nama User</th>
                                    <th scope="col" class="align-middle">Status</th>
                                    <th scope="col" class="align-middle">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($asets as $aset)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $aset->kode_barang }}</td>
                                        <td><strong class="d-block">{{ $aset->nama_barang }}</strong>
                                            <small>{{ $aset->total_pemakaian > 0 ? $aset->total_pemakaian . ' times used' : 'Unused' }}</small>
                                        </td>
                                        <td>{{ $aset->kategori }}</td>
                                        <td>{{ $aset->tanggal_pembelian ? $aset->tanggal_pembelian->format('d-m-Y') : '-' }}
                                        </td>
                                        <td>{{ $aset->pt_pembeban }}</td>
                                        <td>{{ $aset->user_aset ? $aset->user_aset : '-' }}</td>
                                        <td>
                                            @if ($aset->status == 'dipinjam')
                                                <span class="dx-badge dx-no-cursor dx-badge-outline-primary">
                                                    Delivered</span>
                                            @elseif ($aset->status == 'tertunda')
                                                <span class="dx-badge dx-no-cursor dx-badge-outline-warning">
                                                    Pending</span>
                                            @elseif ($aset->status == 'permanen')
                                                <span class="dx-badge dx-no-cursor dx-badge-outline-danger">
                                                    Permanent</span>
                                            @else
                                                <span class="dx-badge dx-no-cursor dx-badge-outline-success">
                                                    Available</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('aset.detail', $aset->id) }}"
                                                class="dx-badge dx-badge-info">Detail</a>
                                            <a href="#qrAsetModal{{ $aset->id }}" data-bs-toggle="modal"
                                                data-bs-target="#qrAsetModal{{ $aset->id }}"
                                                class="dx-badge dx-badge-warning">QR</a>
                                            @include('aset.partials.qrcode-modal-aset', [
                                                'aset' => $aset,
                                            ])
                                            @if ($perm && $perm->ubah)
                                                <a href="{{ route('aset.ubah', $aset->id) }}"
                                                    class="dx-badge dx-badge-primary">Ubah</a>
                                            @endif
                                            @if ($perm && $perm->hapus)
                                                <a href="#deleteAsetModal{{ $aset->id }}" data-bs-toggle="modal"
                                                    data-bs-target="#deleteAsetModal{{ $aset->id }}"
                                                    class="dx-badge dx-badge-danger">Hapus</a>
                                            @endif
                                            @include('aset.partials.delete-modal-aset', ['aset' => $aset])
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9">
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
                                @endforelse
                            </tbody>
                        </table>

                        <div class="dx-pagination-wrapper d-flex justify-content-between align-items-center px-2">
                            <div class="dx-pagination-info dx-text-abu-abu-gelap">
                                <small style="letter-spacing: 0.5px;">Menampilkan
                                    <strong>{{ $asets->firstItem() }} - {{ $asets->lastItem() }}</strong>
                                    dari <strong>{{ $asets->total() }}</strong> data</small>
                                <small style="letter-spacing: 0.5px">
                                    @if (request('search'))
                                        (Hasil cari: "{{ request('search') }}")
                                    @endif
                                </small>
                            </div>

                            {{ $asets->links('aset.partials.pagination') }}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
