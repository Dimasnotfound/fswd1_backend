<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Http\Resources\KaryawanResource;
use Illuminate\Support\Facades\Validator;

class KaryawanController extends Controller
{
    public function index()
    {
        return KaryawanResource::collection(Karyawan::all());
    }

    public function show(Karyawan $karyawan)
    {
        return new KaryawanResource($karyawan);
    }

    public function store(Request $request)
    {
        $karyawan = Karyawan::create($request->all());
        return new KaryawanResource($karyawan);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
            'alamat' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'tanggal_bergabung' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $karyawan = Karyawan::findOrFail($id);

        if ($request->input('nomor_induk') != $karyawan->nomor_induk) {
            $karyawan->cutis()->update(['nomor_induk' => $request->input('nomor_induk')]);
        }

        $karyawan->update($request->all());

        return new KaryawanResource($karyawan);
    }


    public function destroy(Karyawan $karyawan)
    {
        $karyawan->delete();
        return response()->json(null, 204);
    }


    public function firstJoined()
    {
        $karyawans = Karyawan::orderBy('tanggal_bergabung')->take(3)->get();
        return KaryawanResource::collection($karyawans);
    }

    public function test(){
        $data = 'test';

        return response()->json($data, 200);
    }

}
