@extends('layouts.admin')
@section('title', 'Aset - Detail')

@section('content')
    <div class="container-fluid">

        <div class="row mx-auto">
            <div class="col">

                <h5 class="dx-text-lg dx-text-biru text-center">Detail <span
                        class="dx-text-kuning dx-font-bold dx-text-2xl">Aset</span>
                </h5>

                <div class="row justify-content-center">
                    <div class="col-md-8">

                        <div>
                            <h2 class="dx-font-bold mb-2">{{ $aset->kode_barang }}</h2>
                            <p class="dx-text-xl dx-font-regular dx-font-semi-bold mb-2">{{ $aset->nama_barang }}
                                <small class="d-block">
                                    {{ $aset->total_pemakaian > 0 ? $aset->total_pemakaian . ' times used' : 'Unused' }}</small>
                            </p>

                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <span class="d-block">Kategori</span>
                                    <strong>{{ $aset->kategori }}</strong>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <span class="d-block">Nomor Seri</span>
                                    <strong>{{ $aset->nomor_seri }}</strong>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <span class="d-block">Tanggal Pembelian</span>
                                    <strong>{{ $aset->tanggal_pembelian ? $aset->tanggal_pembelian->format('d-m-Y') : '-' }}</strong>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <span class="d-block">Tanggal Garansi </span>
                                    <strong>{{ $aset->tanggal_garansi ? $aset->tanggal_garansi->format('d-m-Y') : '-' }}
                                    </strong>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <span class="d-block">Status Garansi</span> <strong>
                                        <span
                                            class="dx-badge dx-no-cursor
                                                @if ($aset->garansi_status === 'Garansi sudah habis') dx-badge-danger
                                                @elseif($aset->garansi_status === 'Masa tenggang garansi') dx-badge-warning
                                                @else dx-badge-success @endif">
                                            {{ $aset->garansi_status }}
                                            @if ($aset->garansi_sisa)
                                                ({{ $aset->garansi_sisa }})
                                            @endif
                                        </span>
                                    </strong>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <span class="d-block">Quantity </span>
                                    <strong>{{ $aset->kuantitas }}</strong>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <span class="d-block">Harga </span>
                                    <strong>Rp.{{ number_format($aset->harga, 0, ',', '.') }}</strong>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <span class="d-block">PT Pembeban </span>
                                    <strong>{{ $aset->pt_pembeban }}</strong>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <span class="d-block">User </span>
                                    <strong>{{ $aset->user_aset ? $aset->user_aset : '-' }}</strong>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <span class="d-block">Departemen </span>
                                    <strong>{{ $aset->departemen ? $aset->departemen : '-' }}</strong>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <span class="d-block">Lokasi</span>
                                    <strong>{{ $aset->lokasi ? $aset->lokasi : '-' }}</strong>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <span class="d-block">Grade Barang </span>
                                    <strong>{{ ucfirst($aset->grade_barang) }}</strong>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <span class="d-block">Kondisi </span>
                                    <strong
                                        class="dx-font-bold {{ $aset->kondisi == 'baik' ? 'dx-text-hijau' : 'dx-text-merah' }}">{{ ucfirst($aset->kondisi) }}</strong>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <span class="d-block">Status</span>
                                    <strong>
                                        @if ($aset->status == 'dipinjam')
                                            <span class="dx-badge dx-no-cursor dx-badge-outline-primary">Delivered</span>
                                        @elseif ($aset->status == 'tertunda')
                                            <span class="dx-badge dx-no-cursor dx-badge-outline-warning">Pending</span>
                                        @elseif ($aset->status == 'permanen')
                                            <span class="dx-badge dx-no-cursor dx-badge-outline-danger">Permanent</span>
                                        @else
                                            <span class="dx-badge dx-no-cursor dx-badge-outline-success">Available</span>
                                        @endif
                                    </strong>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <span class="d-block">Keterangan </span>
                                    <strong>{{ $aset->keterangan }}</strong>
                                </div>
                                <div class="col-12 mb-2">
                                    <span class="d-block">Bukti Aset</span>
                                    @if ($aset->upload_bukti_aset)
                                        @php
                                            $extension = strtolower(
                                                pathinfo($aset->upload_bukti_aset, PATHINFO_EXTENSION),
                                            );
                                        @endphp

                                        @if (in_array($extension, ['jpg', 'jpeg', 'png']))
                                            <div class="mt-2">
                                                <a href="{{ asset('storage/' . $aset->upload_bukti_aset) }}"
                                                    target="_blank">
                                                    <img src="{{ asset('storage/' . $aset->upload_bukti_aset) }}"
                                                        alt="Upload Bukti Aset" class="img-thumbnail mb-2"
                                                        style="max-width: 300px; cursor: pointer;"
                                                        title="Klik untuk memperbesar">
                                                </a>
                                            </div>
                                        @elseif ($extension === 'pdf')
                                            <small class="dx-text-xs dx-font-bold dx-text-abu-abu-gelap">Dokumen
                                                PDF</small>
                                            <a href="{{ asset('storage/' . $aset->upload_bukti_aset) }}" target="_blank"
                                                class="dx-badge dx-badge-danger">
                                                Lihat Dokumen PDF
                                            </a>
                                        @endif
                                    @else
                                        <span class="dx-text-merah dx-text-sm">Tidak ada
                                            bukti</span>
                                    @endif
                                </div>
                                <div class="col-12 text-center mb-2">
                                    <a href="{{ route('aset.index') }}" class="dx-btn dx-btn-primary">Kembali</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
