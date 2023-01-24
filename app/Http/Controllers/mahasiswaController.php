<?php

namespace App\Http\Controllers;

use App\Models\mahasiswa;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session as FacadesSession;
use Symfony\Component\HttpFoundation\Session\Session as SessionSession;

class mahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $katakunci = $request->katakunci;
       
        if(strlen($katakunci)){
            $data = mahasiswa::where('nim','like',"%$katakunci%")->orwhere('nama','like',"%$katakunci%")->orwhere('jurusan','like',"%$katakunci%")->paginate(3);
        }else{
            $data = mahasiswa::orderBy('nim','desc')->paginate(3);
        }
        return view('mahasiswa.index')->with('data', $data);
    } 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('mahasiswa.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      

        $request->validate([
            'nim' => 'required|numeric|unique:mahasiswa,nim',
            'nama' => 'required',
            'jurusan' => 'required',
        ],[
            'nim.required' => 'NIM Wajid Diisi!!!',
            'nim.numeric' => 'NIM Wajid Berisikan Angka!!!',
            'nim.unique' => 'NIM Yang Diisikan Sudah Ada!!!',
            'nama.required' => 'Nama Wajid Diisi!!!',
            'jurusan.required' => 'Jurusan Wajid Diisi!!!',
        ]);
        $data = [
            'nim'=>$request->nim,
            'nama'=>$request->nama,
            'jurusan'=>$request->jurusan,
        ];
        mahasiswa::create($data);
        return redirect()->to('mahasiswa')->with('seccess','Berhasil menambahkan data');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = mahasiswa::where('nim', $id)->first();
        return view('mahasiswa.edit')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            
            'nama' => 'required',
            'jurusan' => 'required',
        ],[
            
            'nama.required' => 'Nama Wajid Diisi!!!',
            'jurusan.required' => 'Jurusan Wajid Diisi!!!',
        ]);
        $data = [
           
            'nama'=>$request->nama,
            'jurusan'=>$request->jurusan,
        ];
        mahasiswa::where('nim', $id)->update($data);
        return redirect()->to('mahasiswa')->with('seccess','Berhasil update data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        mahasiswa::where('nim', $id)->delete();
        return redirect()->to('mahasiswa')->with('success','berhasil melakukan delete data');
    }

    public function Home(){
        return view('maahasiswa.index');
    }
}
