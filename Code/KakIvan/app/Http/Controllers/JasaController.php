<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Jasa;
use App\Order;
use App\Pelanggan;
use App\Sopir;
use App\Komisi;

class JasaController extends Controller
{

    public function allOrder(Jasa $jasa) {
        $bulan = Date('Y-m');
        //query semua data
        $dataOrder = DB::table('jasa')
                ->join('order_jasa' , 'jasa.id' , 'order_jasa.jasa_id')
                ->join('order' , 'order_jasa.order_id' , 'order.id')
                ->join('order_pelanggan' , 'order.id' , 'order_pelanggan.order_id')
                ->join('pelanggan' , 'order_pelanggan.order_id' , 'pelanggan.id')
                ->where('nama_jasa' , '=' , $jasa->nama_jasa)
                ->where('tanggal_order' , '>=' , $bulan.'-1')
                ->where('tanggal_order' , '<=' , $bulan.'-31')
                ->select('order.*' , 'pelanggan.*' , 'order_pelanggan.tanggal_order' , 'order_jasa.status_bayar' , 'order_jasa.komisi_jasa')
                ->orderBy('tanggal_order')
                ->get();
        return view('Jasa.indexAllOrder' , [
            'dataJasa' => $jasa,
            'dataOrder' => $dataOrder
        ]);
    }

    public function allOrderByMonth(Jasa $jasa , $bulan) {
        $dataOrder = DB::table('jasa')
            ->join('order_jasa' , 'jasa.id' , 'order_jasa.jasa_id')
            ->join('order' , 'order_jasa.order_id' , 'order.id')
            ->join('order_pelanggan' , 'order.id' , 'order_pelanggan.order_id')
            ->join('pelanggan' , 'order_pelanggan.order_id' , 'pelanggan.id')
            ->where('nama_jasa' , '=' , $jasa->nama_jasa)
            ->where('tanggal_order' , '>=' , $bulan.'-1')
            ->where('tanggal_order' , '<=' , $bulan.'-31')
            ->select('order.*' , 'pelanggan.*' , 'order_pelanggan.tanggal_order' , 'order_jasa.status_bayar' , 'order_jasa.komisi_jasa')
            ->orderBy('tanggal_order')
            ->get();
        return response()->json([
            'dataOrder' => $dataOrder , 
            'bulan' => $bulan.'-1'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jasa = Jasa::all();
        return view('Jasa.indexJasa' , [
            'dataJasa' => $jasa
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Jasa.inputJasa');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            Jasa::create([
                'nama_jasa' => $request->nama ,
                'notelp_jasa' => $request->notelp ,
                'keterangan_jasa' => $request->keterangan ,
                'status_jasa' => $request->status ,
            ]);
            return redirect('/jasa')->with([
                'message' => 'Data Jasa berhasil ditambahkan!' , 
                'status' => 1
            ]);
        }catch (Exception $e) {
            return alert('Error create Jasa Data!!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Jasa $jasa)
    {
        $countAllOrder = Order::whereHas('jasa' , function($query) use($jasa) {
            $query->where('nama_jasa' , $jasa->nama_jasa);
        })->count();
        $dataJasa = DB::table('jasa') 
                    ->join('order_jasa' , 'jasa.id' , 'order_jasa.jasa_id')
                    ->join('order' , 'order_jasa.order_id' , 'order.id')
                    ->join('order_pelanggan' , 'order.id' , 'order_pelanggan.order_id')
                    ->join('pelanggan' , 'order_pelanggan.order_id' , 'pelanggan.id')
                    ->where('nama_jasa' , '=' , $jasa->nama_jasa)
                    ->where('status_bayar' , '=' , '0')
                    ->select('order.*' , 'pelanggan.*' , 'order_pelanggan.tanggal_order' , 'order_jasa.status_bayar' ,'order_jasa.komisi_jasa')
                    ->orderBy('tanggal_order')
                    ->get();
        $min = DB::table('jasa') 
            ->join('order_jasa' , 'jasa.id' , 'order_jasa.jasa_id')
            ->join('order' , 'order_jasa.order_id' , 'order.id')
            ->join('order_pelanggan' , 'order.id' , 'order_pelanggan.order_id')
            ->join('pelanggan' , 'order_pelanggan.order_id' , 'pelanggan.id')
            ->where('nama_jasa' , '=' , $jasa->nama_jasa)
            ->where('status_bayar' , '=' , '0')
            ->select('tanggal_order')
            ->min('tanggal_order');
        return view('Jasa.showJasa' , [
            'dataOrder' => $dataJasa,
            'dataJasa' => $jasa,
            'jumAllOrder' => $countAllOrder,
            'min' => $min ,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jasa $jasa)
    {
        $jasa->update([
            'nama_jasa' => $request->nama,
            'notelp_jasa' => $request->notelp,
            'alamat_jasa' => $request->alamat,
            'keterangan_jasa' => $request->keterangan,
            'status_jasa' => $request->status,
            'norek_jasa' => $request->norek
        ]);
        return redirect('/jasa')->with([
            'message' => 'Data Jasa berhasil diupdate!' , 
            'status' => 1
        ]); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jasa $jasa)
    {
        try {
            $jasa->delete();
            return redirect('/jasa')->with([
                'message' => 'Data Jasa berhasil dihapus!' , 
                'status' => 1
            ]); ;
        }catch(Exception $e) {
            alert('Error delete Jasa Data!!');
            return redirect('/jasa');
        }
    }

    public function updateKomisi(Request $request , Jasa $jasa , Order $order) {
        if ($request->komisi_jasa == null) {
            
        }
        $jasa->order()->updateExistingPivot($order->id , ['komisi_jasa' => $request->komisi_jasa] , false);
        return redirect()->back()->with([
            'message' => 'Komisi berhasil diupdate!' , 
            'status' => 1
        ]); ;
    }

    public function getRiwayatBayar (Request $request) {
        $komisi = Komisi::where('jasa_id' , '=' , $request->jasaId)->get();
        return response()->json([
            'data' => $komisi , 
        ]);
    }

    public function showByDate(Jasa $jasa , $tanggal) {
        $strTgl = explode(' s.d ', $tanggal);
        $awal = $strTgl[0];
        $akhir = $strTgl[1];
        $countAllOrder = Order::whereHas('jasa' , function($query) use($jasa) {
            $query->where('nama_jasa' , $jasa->nama_jasa);
        })->count();
        $dataJasa = DB::table('jasa') 
                    ->join('order_jasa' , 'jasa.id' , 'order_jasa.jasa_id')
                    ->join('order' , 'order_jasa.order_id' , 'order.id')
                    ->join('order_pelanggan' , 'order.id' , 'order_pelanggan.order_id')
                    ->join('pelanggan' , 'order_pelanggan.order_id' , 'pelanggan.id')
                    ->where('nama_jasa' , '=' , $jasa->nama_jasa)
                    ->where('status_bayar' , '=' , '0')
                    ->where('tanggal_order' ,'>=' ,$awal)
                    ->where('tanggal_order' , '<=' , $akhir)
                    ->select('order.*' , 'pelanggan.*' , 'order_pelanggan.tanggal_order' , 'order_jasa.status_bayar' ,'order_jasa.komisi_jasa')
                    ->orderBy('tanggal_order')
                    ->get();
        return view('Jasa.showJasa' , [
            'dataOrder' => $dataJasa,
            'dataJasa' => $jasa,
            'jumAllOrder' => $countAllOrder,
            'min' => $awal ,
            'now' => $akhir
        ]);
    }
}