<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cuti;
use App\Models\Karyawan;
use App\Http\Resources\CutiResource;
use App\Http\Resources\KaryawanResource;

class CutiController extends Controller
{
    public function index()
    {
        $cutis = Cuti::with('karyawan')->get();
        return CutiResource::collection($cutis);
    }

    public function karyawanYangPernahCuti()
    {
        $karyawanIds = Cuti::distinct()->pluck('nomor_induk');
        $karyawans = Karyawan::whereIn('nomor_induk', $karyawanIds)->get();
        return KaryawanResource::collection($karyawans);
    }

    public function sisaCuti()
    {
        $karyawans = Karyawan::all();
        $sisaCuti = $karyawans->map(function ($karyawan) {
            $totalCuti = Cuti::where('nomor_induk', $karyawan->nomor_induk)->sum('lama_cuti');
            $sisaCuti = 12 - $totalCuti;
            return [
                'nomor_induk' => $karyawan->nomor_induk,
                'nama' => $karyawan->nama,
                'sisa_cuti' => $sisaCuti,
            ];
        });
        return response()->json($sisaCuti);
    }


}
