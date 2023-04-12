<?php

namespace App\Http\Controllers;

use App\Exports\AbsensiEksport;
use App\Exports\AbsendokEksport;
use App\Exports\JadwalDokterEksport;
use App\Imports\JadwalDokterImport;
use App\Models\Absensi;
use App\Models\CutiDokter;
use App\Models\Info;
use App\Models\JadwalDokter;
use App\Models\MapPoli;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class AbsendokController extends Controller
{
    public function index()
    {
        $tanggal_ini = Carbon::today();
        $hari_ini = Carbon::now()->isoFormat('dddd');


        //cek jadwal
        $cekjadwal = JadwalDokter::where('hari', 'like', $hari_ini)->get();
        $cekabsensi = Absensi::where('tanggal', $tanggal_ini)->get();
        if ($cekjadwal->count() > $cekabsensi->count()) {
            foreach ($cekjadwal as $jadwal) {
                Absensi::updateOrCreate([
                    'jadwalid' => $jadwal->jadwalid,
                    'tanggal' => $tanggal_ini,
                    'kodedokter' => $jadwal->kodedokter,
                    'namadokter' => $jadwal->namadokter,
                    'poliklinik' => $jadwal->poliklinik,
                    'hari' => $jadwal->hari,
                    'waktu' => $jadwal->waktu,
                ], [
                    'jam_mulai' => $jadwal->jam_mulai,
                    'jam_selesai' => $jadwal->jam_selesai,
                ]);
            }
        }

        $cekabsenpulang = Absensi::where([
            ['tanggal', '<', $tanggal_ini],
            ['jam_masuk', '!=', null],
            ['jam_pulang', null]
        ])->get();
        if ($cekabsenpulang->count() > 0) {
            foreach ($cekabsenpulang as $jadwal) {
                Absensi::where('absenid', $jadwal->absenid)
                    ->update([
                        'jam_pulang' => '23:30',
                    ]);
            }
        }

        $cekcuti = CutiDokter::whereDate('tglawal', '<=', $tanggal_ini)->whereDate('tglakhir', '>=', $tanggal_ini)->get();
        //  dd($cekcuti);   
        if ($cekcuti->count() > 0) {
            foreach ($cekcuti as $cuti) {
                Absensi::where([
                    ['tanggal', $tanggal_ini],
                    ['kodedokter', $cuti->kodedokter]
                ])
                    ->update([
                        'keterangan' => $cuti->keterangan,
                    ]);
            }
        }

        $jadwal = Absensi::where([
            ['kodedokter', Auth::user()->employee],
            ['tanggal', $tanggal_ini],
            ['jam_masuk', null],
            ['keterangan', null]
        ])->orderBy('jam_mulai')->get();
        $jadwalhariini = Absensi::where([
            ['kodedokter', Auth::user()->employee],
            ['tanggal', $tanggal_ini]
        ])->orderBy('jam_mulai')->get();
        $info = Info::orderBy('waktu')->whereDate('waktu', $tanggal_ini)->get();
        $cek = Absensi::where([
            ['kodedokter', Auth::user()->employee],
            ['jam_masuk', '!=', null],
            ['jam_pulang', null]
        ])
            ->get();
        return view('dashboard', compact('jadwal', 'info', 'cek', 'jadwalhariini'));
    }

    public function absendok(Request $request)
    {
        if ($request->input('jadwal')) {

            $jadwal = Absensi::where('absenid', $request->input('jadwal'))->get();
            if (((strtotime(Carbon::now()->isoFormat('HH:mm')) - strtotime($jadwal[0]->jam_mulai)) / 60) > 15) {
                $status = 'Terlambat';
            } else {
                $status = null;
            }

            Absensi::where([
                ['absenid', $request->input('jadwal')],
                ['tanggal', Carbon::today()]
            ])
                ->update([
                    'jam_masuk' => Carbon::now()->isoFormat('HH:mm'),
                    'selisih_masuk' => (strtotime(Carbon::now()->isoFormat('HH:mm')) - strtotime($jadwal[0]->jam_mulai)) / 60,
                    'keterangan' => $status,
                ]);
            Info::insert([
                'userid' => $jadwal[0]->kodedokter,
                'waktu' => now(),
                'pesan' => $jadwal[0]->namadokter . ' Praktik di ' . $jadwal[0]->poliklinik,
                'created_at' => now()
            ]);
            return redirect('dashboard');
        }

        return redirect('dashboard')->with('gagal', 'Jadwal Dokter Tidak ada!!');
    }

    public function absenpulang($id)
    {
        $data = Absensi::where('absenid', $id)->get();
        Absensi::where('absenid', $id)
            ->update([
                'jam_pulang' => now(),
                'selisih_pulang' => (strtotime(Carbon::now()->isoFormat('HH:mm')) - strtotime($data[0]->jam_selesai)) / 60,
                'updated_at' => now()
            ]);
        Info::insert([
            'userid' => $data[0]->kodedokter,
            'waktu' => now(),
            'pesan' => $data[0]->namadokter . ' Selesai Praktik di ' . $data[0]->poliklinik,
            'created_at' => now()
        ]);

        return redirect('dashboard');
    }

    public function rekapabsen(Request $request)
    {
        $tanggal_ini = Carbon::today();
        $hari_ini = Carbon::now()->isoFormat('dddd');

        //cek jadwal
        $cekjadwal = JadwalDokter::where('hari', 'like', $hari_ini)->get();
        $cekabsensi = Absensi::where('tanggal', $tanggal_ini)->get();
        if ($cekjadwal->count() > $cekabsensi->count()) {
            foreach ($cekjadwal as $jadwal) {
                Absensi::updateOrCreate([
                    'jadwalid' => $jadwal->jadwalid,
                    'tanggal' => $tanggal_ini,
                    'kodedokter' => $jadwal->kodedokter,
                    'namadokter' => $jadwal->namadokter,
                    'poliklinik' => $jadwal->poliklinik,
                    'hari' => $jadwal->hari,
                    'waktu' => $jadwal->waktu,
                ], [
                    'jam_mulai' => $jadwal->jam_mulai,
                    'jam_selesai' => $jadwal->jam_selesai,
                ]);
            }
        }

        $cekcuti = CutiDokter::whereDate('tglawal', '<=', $tanggal_ini)->whereDate('tglakhir', '>=', $tanggal_ini)->get();
        //  dd($cekcuti);   
        if ($cekcuti->count() > 0) {
            foreach ($cekcuti as $cuti) {
                Absensi::where([
                    ['tanggal', $tanggal_ini],
                    ['kodedokter', $cuti->kodedokter]
                ])
                    ->update([
                        'keterangan' => $cuti->keterangan,
                    ]);
            }
        }

        if ($request->input('dari') <= $request->input('sampai')) {
            $absen = DB::connection('pgsql')
                ->table('absensi')
                ->join('map_poli', 'absensi.poliklinik', '=', 'map_poli.poliklinik')
                ->whereDate('tanggal', '>=', $request->input('dari') ?? $tanggal_ini)
                ->whereDate('tanggal', '<=', $request->input('sampai') ?? $tanggal_ini)
                ->get();

            $cuti = DB::connection('pgsql')
                ->table('absensi')
                ->join('map_poli', 'absensi.poliklinik', '=', 'map_poli.poliklinik')
                ->whereDate('tanggal', '>=', $request->input('dari') ?? $tanggal_ini)
                ->whereDate('tanggal', '<=', $request->input('sampai') ?? $tanggal_ini)
                ->whereIn('keterangan', ['Cuti', 'Tidak Praktek'])
                ->get();
            $absenekse = $absen->where('kategori', 'Eksekutif')->count() - $cuti->where('kategori', 'Eksekutif')->count();
            $absenreg = $absen->where('kategori', 'Reguler')->count() - $cuti->where('kategori', 'Reguler')->count();
            $jumlahabsen = $absen->where('jam_masuk', '!=', null)->count();
            $jumlahabsenekse = $absen->where('jam_masuk', '!=', null)->where('kategori', 'Eksekutif')->count();
            $jumlahabsenreg = $absen->where('jam_masuk', '!=', null)->where('kategori', 'Reguler')->count();
            $terlambat = $absen->where('keterangan', 'Terlambat')->count();
            $terlambatekse = $absen->where('keterangan', 'Terlambat')->where('kategori', 'Eksekutif')->count();
            $terlambatreg = $absen->where('keterangan', 'Terlambat')->where('kategori', 'Reguler')->count();


            $avg = $absen->where('keterangan', 'Terlambat')
                ->average('selisih_masuk');
            $avgekse = $absen->where('keterangan', 'Terlambat')->where('kategori', 'Eksekutif')
                ->average('selisih_masuk');
            $avgreg = $absen->where('keterangan', 'Terlambat')->where('kategori', 'Reguler')
                ->average('selisih_masuk');


            return view('absendok.rekap', compact(
                'absen',
                'cuti',
                'avg',
                'avgekse',
                'avgreg',
                'absenekse',
                'absenreg',
                'jumlahabsen',
                'jumlahabsenekse',
                'jumlahabsenreg',
                'terlambat',
                'terlambatekse',
                'terlambatreg'
            ));
        } else {
            return Redirect::back()->withErrors(['msg' => 'Tanggal tidak boleh Lebih kecil dari sebelumnya']);
        }
    }

    public function rekapabsendok(Request $request)
    {
        $tanggal_ini = Carbon::today();
        $hari_ini = Carbon::now()->isoFormat('dddd');

        $dokter = User::where('department','Dokter Spesialis')->orderBy('name')->get();
        //cek jadwal
        $cekjadwal = JadwalDokter::where('hari', 'like', $hari_ini)->get();
        $cekabsensi = Absensi::where('tanggal', $tanggal_ini)->get();
        if ($cekjadwal->count() > $cekabsensi->count()) {
            foreach ($cekjadwal as $jadwal) {
                Absensi::updateOrCreate([
                    'jadwalid' => $jadwal->jadwalid,
                    'tanggal' => $tanggal_ini,
                    'kodedokter' => $jadwal->kodedokter,
                    'namadokter' => $jadwal->namadokter,
                    'poliklinik' => $jadwal->poliklinik,
                    'hari' => $jadwal->hari,
                    'waktu' => $jadwal->waktu,
                ], [
                    'jam_mulai' => $jadwal->jam_mulai,
                    'jam_selesai' => $jadwal->jam_selesai,
                ]);
            }
        }

        $cekcuti = CutiDokter::whereDate('tglawal', '<=', $tanggal_ini)->whereDate('tglakhir', '>=', $tanggal_ini)->get();
        //  dd($cekcuti);   
        if ($cekcuti->count() > 0) {
            foreach ($cekcuti as $cuti) {
                Absensi::where([
                    ['tanggal', $tanggal_ini],
                    ['kodedokter', $cuti->kodedokter]
                ])
                    ->update([
                        'keterangan' => $cuti->keterangan,
                    ]);
            }
        }

        if ($request->input('dari') <= $request->input('sampai')) {
            $absen = DB::connection('pgsql')
                ->table('absensi')
                ->join('map_poli', 'absensi.poliklinik', '=', 'map_poli.poliklinik')
                ->where('kodedokter',$request->dr)
                ->whereDate('tanggal', '>=', $request->input('dari') ?? $tanggal_ini)
                ->whereDate('tanggal', '<=', $request->input('sampai') ?? $tanggal_ini)
                ->get();

            $cuti = DB::connection('pgsql')
                ->table('absensi')
                ->join('map_poli', 'absensi.poliklinik', '=', 'map_poli.poliklinik')
                ->whereDate('tanggal', '>=', $request->input('dari') ?? $tanggal_ini)
                ->whereDate('tanggal', '<=', $request->input('sampai') ?? $tanggal_ini)
                ->whereIn('keterangan', ['Cuti', 'Tidak Praktek'])
                ->get();
            $absenekse = $absen->where('kategori', 'Eksekutif')->count() - $cuti->where('kategori', 'Eksekutif')->count();
            $absenreg = $absen->where('kategori', 'Reguler')->count() - $cuti->where('kategori', 'Reguler')->count();
            $jumlahabsen = $absen->where('jam_masuk', '!=', null)->count();
            $jumlahabsenekse = $absen->where('jam_masuk', '!=', null)->where('kategori', 'Eksekutif')->count();
            $jumlahabsenreg = $absen->where('jam_masuk', '!=', null)->where('kategori', 'Reguler')->count();
            $terlambat = $absen->where('keterangan', 'Terlambat')->count();
            $terlambatekse = $absen->where('keterangan', 'Terlambat')->where('kategori', 'Eksekutif')->count();
            $terlambatreg = $absen->where('keterangan', 'Terlambat')->where('kategori', 'Reguler')->count();


            $avg = $absen->where('keterangan', 'Terlambat')
            ->average('selisih_masuk');
            $avgekse = $absen->where('keterangan', 'Terlambat')->where('kategori', 'Eksekutif')
            ->average('selisih_masuk');
            $avgreg = $absen->where('keterangan', 'Terlambat')->where('kategori', 'Reguler')
            ->average('selisih_masuk');


            return view('absendok.rekapdok', compact(
                'absen',
                'cuti',
                'avg',
                'avgekse',
                'avgreg',
                'absenekse',
                'absenreg',
                'jumlahabsen',
                'jumlahabsenekse',
                'jumlahabsenreg',
                'terlambat',
                'terlambatekse',
                'terlambatreg',
                'dokter'
            ));
        } else {
            return Redirect::back()->withErrors(['msg' => 'Tanggal tidak boleh Lebih kecil dari sebelumnya']);
        }
    }
    
    public function chatgroup(Request $request)
    {
        DB::connection('pgsql')
            ->table('chat_groups')
            ->insert([
                'userid' => auth()->user()->employee,
                'waktu' => now(),
                'pesan' => $request->input('pesan'),
                'created_at' => now()
            ]);
    }
    public function getchatgroup(Request $request)
    {    
        $chat = DB::connection('pgsql')
            ->table('chat_groups')
            ->join('users', 'chat_groups.userid', '=', 'users.employee')
            ->orderBy('waktu')
            ->whereDate('waktu', Carbon::today())
            ->get();
        return view('absendok.chat', compact('chat'));
    }
    public function cekinfo(Request $request)
    {
            $info = Info::orderBy('waktu')
                    ->whereDate('waktu', Carbon::today())
                    ->count();
                $chat = DB::connection('pgsql')
                    ->table('chat_groups')
                    ->whereDate('waktu', Carbon::today())
                    ->count();
                
            return response()->json(array('info' => $info, 'chat' => $chat), 200);
        
    }
    public function getinfo(Request $request)
    {
        $info = Info::orderBy('waktu')
            ->whereDate('waktu', Carbon::today())
            ->get();
        return view('absendok.info', compact('info'));
    }
    public function export(Request $request)
    {
        if ($request->input('dari') <= $request->input('sampai')) {
            $absen = DB::connection('pgsql')
                ->table('absensi')
                ->join('map_poli', 'absensi.poliklinik', '=', 'map_poli.poliklinik')
                ->whereDate('tanggal', '>=', $request->input('dari'))
                ->whereDate('tanggal', '<=', $request->input('sampai'))
                ->get();
            
            $cuti = DB::connection('pgsql')
                ->table('absensi')
                ->join('map_poli', 'absensi.poliklinik', '=', 'map_poli.poliklinik')
                ->whereDate('tanggal', '>=', $request->input('dari'))
                ->whereDate('tanggal', '<=', $request->input('sampai'))
                ->whereIn('keterangan', ['Cuti', 'Tidak Praktek'])
                ->get();
            $absenekse = $absen->where('kategori', 'Eksekutif')->count() - $cuti->where('kategori', 'Eksekutif')->count();
            $absenreg = $absen->where('kategori', 'Reguler')->count() - $cuti->where('kategori', 'Reguler')->count();
            $jumlahabsen = $absen->where('jam_masuk', '!=', null)->count();
            $jumlahabsenekse = $absen->where('jam_masuk', '!=', null)->where('kategori', 'Eksekutif')->count();
            $jumlahabsenreg = $absen->where('jam_masuk', '!=', null)->where('kategori', 'Reguler')->count();
            $terlambat = $absen->where('keterangan', 'Terlambat')->count();
            $terlambatekse = $absen->where('keterangan', 'Terlambat')->where('kategori', 'Eksekutif')->count();
            $terlambatreg = $absen->where('keterangan', 'Terlambat')->where('kategori', 'Reguler')->count();


            $avg = $absen->where('keterangan', 'Terlambat')
                ->average('selisih_masuk');
            $avgekse = $absen->where('keterangan', 'Terlambat')->where('kategori', 'Eksekutif')
                ->average('selisih_masuk');
            $avgreg = $absen->where('keterangan', 'Terlambat')->where('kategori', 'Reguler')
            ->average('selisih_masuk');
            $tanggal = Carbon::parse($request->input('dari'))->isoFormat('DD MMMM YYYY') . ' - ' . Carbon::parse($request->input('sampai'))->isoFormat('DD MMMM YYYY');

            return Excel::download(new AbsensiEksport($cuti, $tanggal, $absen, $absenekse, $absenreg, $jumlahabsen, $jumlahabsenekse, $jumlahabsenreg, $terlambat, $terlambatekse, $terlambatreg, $avg, $avgekse, $avgreg), 'Absensi ' . $tanggal . '.xlsx');
        } else {
            return Redirect::back()->withErrors(['msg' => 'Tanggal tidak boleh Lebih kecil dari sebelumnya']);
        }
    }

    public function exportdok(Request $request)
    {
        if ($request->input('dari') <= $request->input('sampai')) {
            $absen = DB::connection('pgsql')
                ->table('absensi')
                ->join('map_poli', 'absensi.poliklinik', '=', 'map_poli.poliklinik')
                ->where('kodedokter',$request->dr)
                ->whereDate('tanggal', '>=', $request->input('dari'))
                ->whereDate('tanggal', '<=', $request->input('sampai'))
                ->get();
            
            $dokters = User::where('employee',$request->dr)->get();
            $dokter = $dokters[0]->name;
            $cuti = DB::connection('pgsql')
                ->table('absensi')
                ->join('map_poli', 'absensi.poliklinik', '=', 'map_poli.poliklinik')
                ->where('kodedokter', $request->dr)
                ->whereDate('tanggal', '>=', $request->input('dari'))
                ->whereDate('tanggal', '<=', $request->input('sampai'))
                ->whereIn('keterangan', ['Cuti', 'Tidak Praktek'])
                ->get();
            
            $absenekse = $absen->where('kategori', 'Eksekutif')->count() - $cuti->where('kategori', 'Eksekutif')->count();
            $absenreg = $absen->where('kategori', 'Reguler')->count() - $cuti->where('kategori', 'Reguler')->count();
            $jumlahabsen = $absen->where('jam_masuk', '!=', null)->count();
            $jumlahabsenekse = $absen->where('jam_masuk', '!=', null)->where('kategori', 'Eksekutif')->count();
            $jumlahabsenreg = $absen->where('jam_masuk', '!=', null)->where('kategori', 'Reguler')->count();
            $terlambat = $absen->where('keterangan', 'Terlambat')->count();
            $terlambatekse = $absen->where('keterangan', 'Terlambat')->where('kategori', 'Eksekutif')->count();
            $terlambatreg = $absen->where('keterangan', 'Terlambat')->where('kategori', 'Reguler')->count();


            $avg = $absen->where('keterangan', 'Terlambat')
            ->average('selisih_masuk');
            $avgekse = $absen->where('keterangan', 'Terlambat')->where('kategori', 'Eksekutif')
            ->average('selisih_masuk');
            $avgreg = $absen->where('keterangan', 'Terlambat')->where('kategori', 'Reguler')
            ->average('selisih_masuk');
            $tanggal = Carbon::parse($request->input('dari'))->isoFormat('DD MMMM YYYY') . ' - ' . Carbon::parse($request->input('sampai'))->isoFormat('DD MMMM YYYY');

            return Excel::download(new AbsendokEksport($cuti, $tanggal, $absen, $absenekse, $absenreg, $jumlahabsen, $jumlahabsenekse, $jumlahabsenreg, $terlambat, $terlambatekse, $terlambatreg, $avg, $avgekse,$avgreg, $dokter), 'Absensi ' . $tanggal . '.xlsx');
        } else {
            return Redirect::back()->withErrors(['msg' => 'Tanggal tidak boleh Lebih kecil dari sebelumnya']);
        }
    }

    public function jadwal()
    {
        $jadwal = JadwalDokter::all();
        $random = Str::random(6);
        $dokter = JadwalDokter::distinct()->get(['kodedokter', 'namadokter']);
        $cuti = CutiDokter::whereDate('tglawal', '<=', Carbon::today())->whereDate('tglakhir', '>=', Carbon::today())->get();
        $poliklinik = JadwalDokter::distinct()->get(['poliklinik']);
        $userdokter = User::where('department', 'Dokter Spesialis')->get();
        $absensi = Absensi::whereDate('tanggal',Carbon::today())->get();

        return view('absendok.jadwal', compact('jadwal', 'random', 'dokter', 'cuti', 'poliklinik', 'userdokter', 'absensi'));
    }

    public function jadwalstore(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        Excel::import(new JadwalDokterImport, $request->file('file'));

        return redirect('jadwaldokter')->with('sukses', 'Data Jadwal Dokter Berhasil Diimport!');
    }

    public function hapusjadwal(Request $request)
    {
        if ($request->input('random') === $request->input('konfirmasi')) {
            JadwalDokter::truncate();
            MapPoli::truncate();
            Absensi::where('tanggal', Carbon::today())->delete();
            return redirect('jadwaldokter')->with('sukses', 'Data Jadwal Dokter Berhasil Dihapus!');
        } else {
            return redirect('jadwaldokter')->with('gagal', 'Kode Konfirmasi Salah!!');
        }
    }

    public function xjadwal()
    {
        $jadwal = JadwalDokter::all();
        return Excel::download(new JadwalDokterEksport($jadwal), 'Jadwal Dokter.xlsx');
    }

    public function jadwalcuti(Request $request)
    {
        if ($request->input('absenid')) {
            $this->validate($request, [
                'absenid' => 'required',
            ]);
            $result = $request->input('absenid');
            $result_explode = explode('|', $result);
            Absensi::find($result_explode[0])->update([
                'keterangan'=>'Tidak Praktek'
            ]);
            return redirect('jadwaldokter')->with('sukses', 'Cuti Dokter Berhasil di Input');
        }
        $this->validate($request, [
            'namadokter' => 'required',
            'tglawal' => 'required',
            'tglakhir' => 'required',
        ]);
        $result = $request->input('namadokter');
        $result_explode = explode('|', $result);
        if ($request->input('tglawal') <= $request->input('tglakhir')) {
            CutiDokter::create([
                'kodedokter' => $result_explode[0],
                'namadokter' => $result_explode[1],
                'tglawal' => $request->input('tglawal'),
                'tglakhir' => $request->input('tglakhir'),
                'keterangan' => 'Cuti',
            ]);
            return redirect('jadwaldokter')->with('sukses', 'Cuti Dokter Berhasil di Input');
        } else {
            return redirect('jadwaldokter')->with('gagal', 'Tanggal tidak boleh Lebih kecil dari sebelumnya!!');
        }
    }

    public function hapuscuti(Request $request)
    {
        if($request->input('absenid')){
            Absensi::find($request->input('absenid'))->update(['keterangan'=>null]);
            return redirect('jadwaldokter')->with('sukses', 'TP Dokter Berhasil di Hapus');
        }
        
        $cuti = CutiDokter::find($request->input('id'));
        Absensi::where([
            ['kodedokter', $cuti->kodedokter],
            ['tanggal', Carbon::today()]
        ])->update([
            'keterangan' => null
        ]);
        $cuti->delete();
        return redirect('jadwaldokter')->with('sukses', 'Cuti Dokter Berhasil di Hapus');
    }

    public function inputjadwal(Request $request)
    {
        // dd($request);
        $this->validate($request, [
            'namadokter' => 'required',
            'poliklinik' => 'required',
            'hari' => 'required',
            'waktu' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required'
        ]);

        if ($request->input('kodedokter')) {
            JadwalDokter::find($request->jadwalid)
                ->update([
                    'namadokter' => $request->input('namadokter'),
                    'poliklinik' => $request->input('poliklinik'),
                    'hari' => $request->input('hari'),
                    'waktu' => $request->input('waktu'),
                    'jam_mulai' => $request->input('jam_mulai'),
                    'jam_selesai' => $request->input('jam_selesai')
                ]);
            Absensi::where([
                ['jadwalid', $request->input('jadwalid')],
                ['tanggal', Carbon::today()]
            ])->update([
                'namadokter' => $request->input('namadokter'),
                'poliklinik' => $request->input('poliklinik'),
                'hari' => $request->input('hari'),
                'waktu' => $request->input('waktu'),
                'jam_mulai' => $request->input('jam_mulai'),
                'jam_selesai' => $request->input('jam_selesai')
            ]);
            return redirect('jadwaldokter')->with('sukses', 'Jadwal Dokter Berhasil di Ubah');
        }
        $result = $request->input('namadokter');
        $result_explode = explode('|', $result);
        // dd($result_explode[0]);
        JadwalDokter::updateOrCreate(
            [
                'kodedokter' => $result_explode[0],
                'namadokter' => $result_explode[1],
                'poliklinik' => $request->input('poliklinik'),
                'hari' =>  $request->input('hari'),
                'waktu' =>  $request->input('waktu'),
            ],
            [
                'jam_mulai' => $request->input('jam_mulai'),
                'jam_selesai' => $request->input('jam_selesai'),
            ]
        );

        return redirect('jadwaldokter')->with('sukses', 'Jadwal Dokter Berhasil di Input');
    }

    public function xhapusjadwal($id)
    {
        JadwalDokter::where('jadwalid', $id)->delete();
        Absensi::where('jadwalid', $id)->where('tanggal', Carbon::today())->delete();
        return redirect('jadwaldokter')->with('sukses', 'Jadwal Dokter Berhasil dihapus');
    }

    public function mapping()
    {
        $cekjadwal = JadwalDokter::distinct('poliklinik')->get();
        $cekmapping = MapPoli::count();

        if ($cekjadwal->count() != $cekmapping) {
            $cekpoli = [];
            foreach ($cekjadwal as $cek) {
                $poli = str_replace(".", "-", $cek["poliklinik"]);
                $cekpoli[] = $poli;
                MapPoli::updateOrCreate(['poliklinik' => $cek->poliklinik]);
            }
            MapPoli::whereNotIn('poliklinik', $cekpoli)->delete();
        }

        $belum = MapPoli::where('kategori', null)->get();
        $reguler = MapPoli::where('kategori', 'Reguler')->get();
        $eksekutif = MapPoli::where('kategori', 'Eksekutif')->get();

        return view('absendok.mapping', compact('belum', 'reguler', 'eksekutif'));
    }

    public function mappingstore(Request $request)
    {

        if ($request->input('kategori') == 'x') {
            $mapping = MapPoli::find($request->input('id'));
            $mapping->kategori = null;
            $mapping->save();

            return redirect('mappingpoli');
        }

        $mapping = MapPoli::find($request->input('id'));
        $mapping->kategori = $request->input('kategori');
        $mapping->save();

        return redirect('mappingpoli');
    }

    public function viewjadwal()
    {
        $jadwal = JadwalDokter::where('kodedokter', Auth::user()->employee)->orderBy('jam_mulai', 'asc')->get();
        $senin = $jadwal->where('hari', 'Senin');
        $selasa = $jadwal->where('hari', 'Selasa');
        $rabu = $jadwal->where('hari', 'Rabu');
        $kamis = $jadwal->where('hari', 'Kamis');
        $jumat = $jadwal->where('hari', 'Jumat');
        $sabtu = $jadwal->where('hari', 'Sabtu');
        $minggu = $jadwal->where('hari', 'Minggu');

        return view('absendok.viewjadwal', compact('jadwal', 'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'));
    }

    public function ubahjadwal($id)
    {
        $dokter = JadwalDokter::find($id);
        $poliklinik = JadwalDokter::distinct()->get(['poliklinik']);

        return view('absendok.ubahjadwal', compact('dokter', 'poliklinik'));
    }
}
