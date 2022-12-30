<?php

namespace App\Http\Controllers;

use App\Imports\UserImport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class UsersController extends Controller
{
    public function index()
    {
        $user = User::all();

        return view('user.index', compact('user'));
    }
    public function ubahpassword(Request $request)
    {
        $this->validate($request, [
            'password' => 'required'
        ]);
        User::where('id',$request->input('id'))->update(['password' => Hash::make($request->input('password'))]);
        return redirect('daftaruser');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        Excel::import(new UserImport, $request->file('file'));

        return redirect('daftaruser')->with('sukses', 'Data User Berhasil Diimport!');
    }
    public function hapus($id)
    {
        User::where('id',$id)->delete();
        return redirect('daftaruser')->with('sukses', 'User Berhasil dihapus!');
    }
}
