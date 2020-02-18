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

class SopirController extends Controller
{
    // return data where validasi = 0 and kode_sopir = kode_sopir
    public function getSopirOrderData($kode_sopir) {
        $data = DB::table('sopir')
        ->join ('order_sopir', 'sopir.id' , 'order_sopir.sopir_id')
        ->join ('order' , 'order_sopir.order_id' , 'order.id')
        ->join ('order_pelanggan' , 'order.id' , 'order_pelanggan.order_id')
        ->join ('pelanggan' , 'order_pelanggan.pelanggan_id' , 'pelanggan.id')
        ->select('order.*' , 'pelanggan.*' , 'order_pelanggan.tanggal_order' , 'order_sopir.validasi')
        ->where('kode_sopir' , '=' , $kode_sopir)
        ->where('validasi' , '=' , 0)
        ->orderBy('tanggal_order' , 'asc')
        ->orderBy('status_order' , 'desc')
        ->get();
        return $data;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sopir = Sopir::all();
        return view('Sopir.indexSopir' , [
            'data' => $sopir
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Sopir.inputSopir');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Sopir::create([
            'nama_sopir' => $request->nama , 
            'alamat_sopir' => $request->alamat ,
            'notelp_sopir' => $request->notelp ,
            'kode_sopir' => $request->kode
        ]);
        return redirect('/sopir')->with([
            'message' => 'Data Sopir berhasil ditambahkan!' , 
            'status' => 1
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Sopir $sopir)
    {
        $dataOrder = $this->getSopirOrderData($sopir->kode_sopir);
        return view('Sopir.showSopir' , [
            'dataSopir' => $sopir , 
            'dataOrder' => $dataOrder
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
    public function update(Request $request, Sopir $sopir)
    {
        $sopir->update([
            'nama_sopir' => $request->nama_sopir,
            'notelp_sopir' => $request->notelp_sopir,
            'alamat_sopir' => $request->alamat_sopir,
            'keterangan_sopir' => $request->keterangan_sopir,
            'kode_sopir' => $request->kode_sopir
        ]);
        return redirect('/sopir')->with([
            'message' => 'Data Sopir berhasil diupdate!' , 
            'status' => 1
        ]);;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sopir $sopir)
    {
        $sopir->delete();
        return redirect('/sopir')->with([
            'message' => 'Data Sopir berhasil dihapus!' , 
            'status' => 1
        ]);
    }

    public function showByDate(Request $request) {
        $order =  DB::table('sopir')
                ->join ('order_sopir', 'sopir.id' , 'order_sopir.sopir_id')
                ->join ('order' , 'order_sopir.order_id' , 'order.id')
                ->join ('order_pelanggan' , 'order.id' , 'order_pelanggan.order_id')
                ->join ('pelanggan' , 'order_pelanggan.pelanggan_id' , 'pelanggan.id')
                ->select('order.*' , 'pelanggan.*' , 'order_pelanggan.tanggal_order')
                ->where('kode_sopir' , '=' , $request->sopir)
                ->where('tanggal_order' , '=' , $request->tanggal)
                ->where('validasi' , '=' , 0) 
                ->orderBy('tanggal_order' , 'asc')
                ->get();
        return response()->json([
            'order' => $order
        ]);
    }


    public function getSopir() {
        return response()->json([
            'sopir' => Sopir::all()
        ]);
    }

    public function validasiOrder(Request $request) {
        $data = DB::table('sopir')
            ->join ('order_sopir', 'sopir.id' , 'order_sopir.sopir_id')
            ->join ('order' , 'order_sopir.order_id' , 'order.id')
            ->join ('order_pelanggan' , 'order.id' , 'order_pelanggan.order_id')
            ->join ('pelanggan' , 'order_pelanggan.pelanggan_id' , 'pelanggan.id')
            ->where('tanggal_order' , '=' , $request->tanggal)
            ->where('kode_sopir' , '=' , $request->sopir)
            ->update(['validasi' => 1]);
        $newTanggal = date("d M Y", strtotime($request->tanggal));
        return response()->json([
            'message' => 'Berhasil tandai order tanggal '. $newTanggal , 
        ]);
    }

    public function allOrder(Sopir $sopir) {
        $date = date('Y-m');
        $bulan = [
            'Januari', 'Februari' , 'Maret' , 'April' , 'Mei' ,
            'Juni' , 'Juli' , 'Agustus' , 'September' , 'Oktober' , 'November' , 'Desember'
        ];
        $stringTanggal = explode('-' , $date);
        $data = DB::table('sopir')
            ->join ('order_sopir', 'sopir.id' , 'order_sopir.sopir_id')
            ->join ('order' , 'order_sopir.order_id' , 'order.id')
            ->join ('order_pelanggan' , 'order.id' , 'order_pelanggan.order_id')
            ->join ('pelanggan' , 'order_pelanggan.pelanggan_id' , 'pelanggan.id')
            ->select('order.*' , 'pelanggan.*' , 'order_pelanggan.tanggal_order' , 'order_sopir.validasi')
            ->where('kode_sopir' , '=' , $sopir->kode_sopir)
            ->where('tanggal_order' , '<=' , $date.'-31')
            ->where('tanggal_order' , '>=' , $date.'-1')
            ->orderBy('tanggal_order' , 'asc')
            ->orderBy('status_order' , 'desc')
            ->get();
        $month = $bulan[$stringTanggal[1]-1];
        $year = $stringTanggal[0];
        return view('Sopir.indexAllOrderSopir' , compact('data' , 'sopir' , 'date' , 'month' , 'year'));
    }

    public function orderBulanan (Sopir $sopir , $date) {
        $bulan = [
            'Januari', 'Februari' , 'Maret' , 'April' , 'Mei' ,
            'Juni' , 'Juli' , 'Agustus' , 'September' , 'Oktober' , 'November' , 'Desember'
        ];
        $stringTanggal = explode('-' , $date);
        $data = DB::table('sopir')
        ->join ('order_sopir', 'sopir.id' , 'order_sopir.sopir_id')
        ->join ('order' , 'order_sopir.order_id' , 'order.id')
            ->join ('order_pelanggan' , 'order.id' , 'order_pelanggan.order_id')
            ->join ('pelanggan' , 'order_pelanggan.pelanggan_id' , 'pelanggan.id')
            ->select('order.*' , 'pelanggan.*' , 'order_pelanggan.tanggal_order' , 'order_sopir.validasi')
            ->where('kode_sopir' , '=' , $sopir->kode_sopir)
            ->where('tanggal_order' , '<=' , $date.'-31')
            ->where('tanggal_order' , '>=' , $date.'-1')
            ->orderBy('tanggal_order' , 'asc')
            ->orderBy('status_order' , 'desc')
            ->get();
        return response()->json([
            'data' => $data , 
            'sopir' => $sopir , 
            'month' => $bulan[$stringTanggal[1]-1],
            'date' => $date,
            'year' => $stringTanggal[0]
        ]);
    }

    public function getDataSopir($kode_sopir) {
        return response()->json([
            'dataOrder' => $this->getSopirOrderData($kode_sopir)
        ]);
    }
}