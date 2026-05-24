<?php

use App\Http\Controllers\AsetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ReportPeminjamanPengembalianController;
use App\Http\Controllers\ReportTransaksiController;
use App\Http\Controllers\StokBarangController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::redirect('/', '/login');
});

Route::middleware('auth')->group(function () {
    //* Dashboard
    Route::view('/dashboard', 'dashboard.index')->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //* User
    Route::get('/users', [UserController::class, 'index'])->middleware('permission:User,all')->name('users.index');
    Route::get('/users/tambah',[UserController::class, 'tambah'])->middleware('permission:User,tambah')->name('users.tambah');
    Route::post('/users', [UserController::class, 'simpan'])->middleware('permission:User,tambah')->name('users.simpan');
    Route::get('/users/{id}/ubah', [UserController::class, 'ubah'])->middleware('permission:User,ubah')->name('users.ubah');
    Route::put('/users/{id}', [UserController::class, 'update'])->middleware('permission:User,ubah')->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'hapus'])->middleware('permission:User,hapus')->name('users.hapus');

    //* Permissions
    Route::get('/users/hak-akses', [PermissionController::class, 'index'])->middleware('permission:User,all')->name('users.hak-akses');
    Route::post('/users/hak-akses/update', [PermissionController::class, 'update'])->name('users.hak-akses.update');

    //* Aset
    Route::get('/aset', [AsetController::class, 'index'])->middleware('permission:Inventori,all')->name('aset.index');
    Route::get('/aset/tambah',[AsetController::class, 'tambah'])->middleware('permission:Inventori,tambah')->name('aset.tambah');
    Route::post('/aset', [AsetController::class, 'simpan'])->middleware('permission:Inventori,tambah')->name('aset.simpan');
    Route::get('/aset/export', [AsetController::class, 'exportExcel'])->middleware('permission:Inventori,all')->name('aset.export');
    Route::get('/aset/{id}', [AsetController::class, 'detail'])->middleware('permission:Inventori,all')->name('aset.detail');
    Route::get('/aset/{id}/ubah', [AsetController::class, 'ubah'])->middleware('permission:Inventori,ubah')->name('aset.ubah');
    Route::put('/aset/{id}', [AsetController::class, 'update'])->middleware('permission:Inventori,ubah')->name('aset.update');
    Route::delete('/aset/{id}', [AsetController::class, 'hapus'])->middleware('permission:Inventori,hapus')->name('aset.hapus');
    Route::get('/aset/{id}/qr-pdf', [AsetController::class, 'downloadQRPDF'])->name('aset.qr.pdf');

    //* Peminjaman
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->middleware('permission:Peminjaman,all')->name('peminjaman.index');
    Route::get('/peminjaman/tambah', [PeminjamanController::class, 'tambah'])->middleware('permission:Peminjaman,tambah')->name('peminjaman.tambah');
    Route::post('/peminjaman', [PeminjamanController::class, 'simpan'])->middleware('permission:Peminjaman,tambah')->name('peminjaman.simpan');
    Route::get('/peminjaman/detail/{kode_peminjaman}', [PeminjamanController::class, 'detail'])->middleware('permission:Peminjaman,all')->name('peminjaman.detail');
    Route::put('/peminjaman/batalkan/{id}', [PeminjamanController::class, 'batalkanPeminjaman'])->name('peminjaman.batalkan');

    //* Pengembalian
    Route::get('/pengembalian', [PengembalianController::class, 'index'])->middleware('permission:Pengembalian,all')->name('pengembalian.index');
    Route::post('/peminjaman/pengembalian', [PengembalianController::class, 'simpan'])->middleware('permission:Pengembalian,tambah')->name('peminjaman.pengembalian.simpan');
    Route::get('/pengembalian/detail/{kode_pengembalian}', [PengembalianController::class, 'detail'])->middleware('permission:Pengembalian,all')->name('pengembalian.detail');

    //* Stok Barang
    // Route::prefix('stok-barang')->group(function () {
    Route::get('/stok', [StokBarangController::class, 'index'])->middleware('permission:Stok,all')->name('stok.index');
    Route::get('/stok/tambah',[StokBarangController::class, 'tambah'])->middleware('permission:Stok,tambah')->name('stok.tambah');
    Route::post('/stok',[StokBarangController::class, 'simpan']) ->middleware('permission:Stok,tambah')->name('stok.simpan');
    Route::get('/stok/{id}/ubah', [StokBarangController::class, 'ubah'])->middleware('permission:Stok,ubah')->name('stok.ubah');
    Route::put('/stok/{id}', [StokBarangController::class, 'update'])->middleware('permission:Stok,ubah')->name('stok.update');
    Route::delete('/stok/{id}', [StokBarangController::class, 'hapus'])->middleware('permission:Stok,hapus')->name('stok.hapus');
    // });

    //* Transaksi
    Route::get('/transaksi', [TransaksiController::class, 'index'])
        ->middleware('permission:Transaksi,all') // Menyesuaikan modul Anda
        ->name('transaksi.index');
    Route::get('/transaksi/tambah', [TransaksiController::class, 'tambah'])->middleware('permission:Transaksi,tambah')->name('transaksi.tambah');
    Route::post('/transaksi', [TransaksiController::class, 'simpan'])->middleware('permission:Transaksi,tambah')->name('transaksi.simpan');
    Route::get('/transaksi/{id}/ubah', [TransaksiController::class, 'ubah'])->middleware('permission:Transaksi,ubah')->name('transaksi.ubah');
    Route::put('/transaksi/{id}/update', [TransaksiController::class, 'update'])->middleware('permission:Transaksi,ubah')->name('transaksi.update');
    Route::delete('/transaksi/{id}', [TransaksiController::class, 'hapus'])->middleware('permission:Transaksi,hapus')->name('transaksi.hapus');

    //* Reports
    Route::get('/report-transaksi', [ReportTransaksiController::class, 'index'])->middleware('permission:Report Transaksi,all')->name('report.transaksi');
    Route::get('/report-transaksi/export', [ReportTransaksiController::class, 'exportExcel'])->middleware('permission:Report Transaksi,all')->name('report.transaksi.export');
    Route::get('/report-transaksi/pdf', [ReportTransaksiController::class, 'exportPdf'])->middleware('permission:Report Transaksi,all')->name('report.transaksi.pdf');
    Route::get('/report-peminjaman-pengembalian', [ReportPeminjamanPengembalianController::class, 'index'])->middleware('permission:Report Peminjaman Pengembalian,all')->name('report.peminjaman-pengembalian');
    Route::get('/report-peminjaman-pengembalian/export', [ReportPeminjamanPengembalianController::class, 'exportExcel'])->middleware('permission:Report Peminjaman Pengembalian,all')->name('report.peminjaman-pengembalian.export');
    Route::get('/report-peminjaman-pengembalian/pdf', [ReportPeminjamanPengembalianController::class, 'exportPdf'])->middleware('permission:Report Peminjaman Pengembalian,all')->name('report.peminjaman-pengembalian.pdf');
    // Tes route
    // Route::view('/aset/ubah', 'aset.ubah')->name('aset.ubah');
    // CRUD --resource
    // Route::resource('asets', AsetController::class);

    //* 404 Not Found
    Route::fallback(function () {
        return response()->view('errors.404', [], 404);
    });
});

