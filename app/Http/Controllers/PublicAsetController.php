<?php

namespace App\Http\Controllers;

use App\Models\Aset;

class PublicAsetController extends Controller
{
    public function handleScan($kode_barang)
    {
        // Decode jika kode barang mengandung garis miring (misal: BRG%2F001 -> BRG/001)
        $cleanKode = urldecode($kode_barang);

        // Validasi ketersediaan data di database
        $asetExists = Aset::where('kode_barang', $cleanKode)->exists();

        if (!$asetExists) {
            // Jika aset fiktif, lempar ke halaman 404 custom atau beri pesan error
            abort(404, 'Data aset barang tidak terdaftar di sistem Storify.');
        }

        // Teruskan ke halaman detail publik dengan kode barang yang aman di URL
        return redirect()->route('public.aset.detail', ['kode_barang' => urlencode($cleanKode)]);
    }

    public function asetDetail($kode_barang)
    {
        $cleanKode = urldecode($kode_barang);

        // Mengambil data aset beserta relasi peminjaman dan pengembalian yang melekat di dalamnya
        $aset = Aset::with(['peminjaman.pengembalian'])
                    ->where('kode_barang', $cleanKode)
                    ->firstOrFail();

        return view('public.aset.detail', compact('aset'));
    }
}
