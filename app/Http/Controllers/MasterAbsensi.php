<?php

namespace App\Http\Controllers;

use App\Models\AlasanTelat;
use App\Models\JadwalDokter;
use App\Models\KirimAbsen;
use App\Models\MappingNS;
use App\Models\NurseStation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterAbsensi extends Controller
{
    public function alasan()
    {
        $alasan = AlasanTelat::all();
        return view('master.alasan',compact('alasan'));
    }

    public function alasanedit($id)
    {
        $alasan = AlasanTelat::find($id);
        return view('master.editalasan', compact('alasan'));
    }

    public function alasanstore(Request $request)
    {
        $request->validate([
            'jenis_telat' => 'required',
            'eksklusi' => 'required',
        ]);
        AlasanTelat::create([
           'jenis_telat' => $request->jenis_telat,
           'eksklusi' => ($request->eksklusi == 'Ya')? true : false,
        ]);
        return redirect()->route('jenis.alasan');
    }

    public function alasanupdate(Request $request, string $id)
    {
        $request->validate([
            'jenis_telat' => 'required',
            'eksklusi' => 'required',
        ]);
        AlasanTelat::find($id)->update([
            'jenis_alasan' => $request->jenis_alasan,
            'eksklusi' => ($request->eksklusi == 'Ya')? true : false,
        ]);
        return redirect()->route('jenis.alasan');
    }

    public function alasandelete(string $id)
    {
        AlasanTelat::find($id)->delete();
        return redirect()->route('jenis.alasan');
    }

    public function alasanterlambat(Request $request, string $id)
    {
        $alasan = AlasanTelat::find($request->alasan);
        KirimAbsen::where('absenid',$id)->update([
            'status' => $alasan->jenis_telat,
            'eksklusi' => $alasan->eksklusi
        ]);
        return redirect()->route('dashboard');
    }

    public function ns()
    {
        $ns = NurseStation::all();
        return view('master.ns',compact('ns'));
    }

    public function nsedit($id)
    {
        $ns = NurseStation::find($id);
        return view('master.editns', compact('ns'));
    }

    public function nsstore(Request $request)
    {
        $request->validate([
            'kodens' => 'required',
            'namans' => 'required',
        ]);
        NurseStation::create([
            'kodens' => $request->kodens,
            'namans' => $request->namans,
        ]);
        return redirect()->route('index.ns');
    }

    public function nsupdate(Request $request, string $id)
    {
        $request->validate([
            'kodens' => 'required',
            'namans' => 'required',
        ]);
        NurseStation::find($id)->update([
            'kodens' => $request->kodens,
            'namans' => $request->namans,
        ]);
        return redirect()->route('index.ns');
    }

    public function nsdelete(string $id)
    {
        NurseStation::find($id)->delete();
        return redirect()->route('index.ns');
    }
    public function mappingns()
    {
        $mappingns = DB::connection('pgsql')->table('mapping_n_s')
            ->join('nurse_station','mapping_n_s.ns','=','nurse_station.kodens')
            ->select(['mapping_n_s.id as idmapping','poliklinik', 'namans', 'kasir'])
            ->get();
        $ns = NurseStation::all();
        $poli = [];
        foreach ($mappingns as $map){
            $poli[] = $map->poliklinik;
        }
        $polibm = JadwalDokter::distinct()
            ->whereNotIn('poliklinik',$poli)
            ->orderBy('poliklinik')
            ->get('poliklinik');
        $poliklinik = JadwalDokter::distinct()->orderBy('poliklinik')->get('poliklinik');
        return view('master.mappingns',compact('mappingns', 'poliklinik', 'ns', 'polibm'));
    }

    public function mappingnsedit($id)
    {
        $mappingns = MappingNS::find($id);
        $ns = NurseStation::all();
        $poliklinik = JadwalDokter::distinct()->get('poliklinik');
        return view('master.editmappingns', compact('mappingns', 'ns', 'poliklinik'));
    }

    public function mappingnsstore(Request $request)
    {
        $request->validate([
            'poliklinik' => 'required',
            'ns' => 'required',
            'kasir' => 'required',
        ]);
        MappingNS::updateOrCreate([
            'poliklinik' => $request->poliklinik
        ],[
            'ns' => $request->ns,
            'kasir' => $request->kasir
        ]);
        return redirect()->route('index.mappingns');
    }

    public function mappingnsupdate(Request $request, string $id)
    {
        $request->validate([
            'poliklinik' => 'required',
            'ns' => 'required',
            'kasir' => 'required',
        ]);
        MappingNS::find($id)->update([
            'poliklinik' => $request->poliklinik,
            'ns' => $request->ns,
            'kasir' => $request->kasir
        ]);
        return redirect()->route('index.mappingns');
    }

    public function mappingnsdelete(string $id)
    {
        MappingNS::find($id)->delete();
        return redirect()->route('index.mappingns');
    }
}
