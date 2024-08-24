<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\KaryawanResource;
use App\Http\Resources\PostResource;
use App\Models\Cuti;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeesController extends Controller
{
    public function getAllEmployee(){
        $data = Karyawan::all();
        return new PostResource(true, 'Success get all data karyawan', $data, 200);
    }

    public function getEmployeeFirstJoin(Request $request){
        $data = Karyawan::orderBy('tanggal_bergabung', 'asc')->take(3)->get();
        return new PostResource(true, 'Success get data karyawan', $data, 200);
    }

    public function gethistoryOffEmployees()
    {
        $karyawanIds = Cuti::distinct()->pluck('nomor_induk');
        $data = Karyawan::whereIn('nomor_induk', $karyawanIds)->get();
        return new PostResource(true, 'Success get data karyawan yang pernah cuti', $data, 200);
    }

    public function getRemainingDaysOff(){
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
        return new PostResource(true, 'Success get data karyawan yang pernah cuti', $sisaCuti, 200);
    }

    public function updateDataEmployee(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return response([
                'status' => false,
                'required' => $validator->errors()
            ], 400);
        }

        $check_data = Karyawan::where('id', $request->id)->get();

        if(count($check_data) > 0){
            $update = Karyawan::where('id', $check_data[0]->id)->update([
                "nomor_induk" => $request->nomor_induk ? $request->nomor_induk : $check_data[0]->nomor_induk,
                "nama" => $request->nama ? $request->nama : $check_data[0]->nama,
                "alamat" => $request->alamat ? $request->alamat : $check_data[0]->alamat,
                "tanggal_lahir" => $request->tanggal_lahir ? $request->tanggal_lahir : $check_data[0]->tanggal_lahir,
                "updated_at" => date('Y-m-d H:i:s')
            ]);

            $updated = Karyawan::where('id', $check_data[0]->id)->get();

            return new PostResource(true, 'Success Update data', $updated, 200);
        }else {
            return new PostResource(false, 'Data not found', null, 404);
        }
    }

    public function destroy(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return response([
                'status' => false,
                'required' => $validator->errors()
            ], 400);
        }

        $data = Karyawan::where('id', $request->id)->delete();
        return new PostResource(true, 'Success delete data', null, 200);
    }
}
