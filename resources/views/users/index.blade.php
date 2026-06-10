@php
    $perm = \App\Models\Permission::where('role', Auth::user()->role)
        ->where('module', 'User')
        ->first();
@endphp

@extends('layouts.admin')
@section('title', 'Users')

@section('content')
    <div class="container-fluid" id="user-page-wrapper" data-fetch-url="{{ route('users.index') }}"
        data-ubah-url="{{ route('users.ubah', ':id') }}" data-hapus-url="{{ route('users.hapus', ':id') }}"
        data-perm-ubah="{{ $perm && $perm->ubah ? 'true' : 'false' }}"
        data-perm-hapus="{{ $perm && $perm->hapus ? 'true' : 'false' }}">

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
                        <form method="GET" id="search-form" action="{{ route('users.index') }}"
                            class="d-flex justify-content-end align-items-center gap-2">
                            <div class="dx-form-wrapper w-100">
                                <input type="text" class="dx-form-input-src" name="search"
                                    placeholder="Ketik nama atau role..." aria-label="Search"
                                    value="{{ request('search') }}">
                            </div>
                            <button type="submit" class="dx-btn dx-btn-secondary dx-src-btn">
                                Cari
                            </button>
                            <a href="#" id="reset-search-btn"
                                class="dx-btn dx-btn-primary dx-src-btn text-decoration-none">Reset</a>
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
                            </div>
                            <div id="pagination-links-container">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('users.partials.delete-modal-user')
@endsection

@push('scripts')
    @vite('resources/js/pages/users.js')
@endpush
