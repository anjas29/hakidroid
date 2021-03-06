<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Paten;

class PatenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $patens = DB::table('paten')
                    ->select('paten.*', 'biodata.nama')
                    ->join('biodata', 'paten.biodata_id', '=', 'biodata.id')
                    ->orderBy('id', 'DESC')
                    ->get();

        return view('admin.paten.index')
                ->with('patens', $patens);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $paten = Paten::with('biodata')
                        ->with('dokumen_subtantif_gambar')
                        ->with('dokumen_subtantif_deskripsi')
                        ->where('paten.id', $id)->firstOrFail();

        return view('admin.paten.detail')
                    ->with('paten', $paten);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $input['status'] = '1';
        $data = Paten::find($id);
        $data->update($input);

        return redirect()->route('admin.paten.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Paten::destroy($id);

        return redirect()->route('admin.paten.index'); 
    }
}
