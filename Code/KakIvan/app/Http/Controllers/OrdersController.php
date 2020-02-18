<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sopir;
use App\Jasa;
use App\Order;
use App\Pelanggan;


class OrdersController extends Controller
{
    private $komisi;

    public function isiKomisi(int $harga , int $jum , String $status) {
        if ($status == 'Batal') {
            $this->komisi = 0;
        }else {
            if ($harga < 400000) {
                $this->komisi = 50000 * $jum;
            }else if ($harga >= 400000 && $harga <=500000) {
                $this->komisi = 100000 * $jum;
            }else if ($harga > 500000) {
                $this->komisi = $harga * 0.2 * $jum;
            }
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (isset($_GET['tanggal'])){
            $tanggal = $_GET['tanggal'];
        }else {
            $tanggal = date("Y-m-d");
        }
        $order = Order::with(
            [ 'pelanggan' => function($query) use ($tanggal){ 
                $query->wherePivot('tanggal_order' , $tanggal);
            }] , 
            'jasa' , 
            'sopir'
            )
            ->orderBy('status_order' , 'desc')
            ->orderBy('jam_order' , 'asc')
            ->get();
        $jasa = Jasa::all();
        $sopir = Sopir::all();  
        
        // return $order;
        return view("Order.index" , [
            'order' => $order,
            'dataTanggal' => $tanggal,
            'dataSopir' => $sopir , 
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
        //set tanggal langsung sesuai yang dipilih dari halaman index
        if (isset($_GET['inputOrder'])){
            $inputOrder = $_GET['inputOrder'];
        }else {
            $inputOrder = date("Y-m-d");
        }

        //query data sopir dan jasa
        $jasa = Jasa::all();
        $sopir = Sopir::all();  
        return view('Order.inputOrder' , [
            'sopir' => $sopir ,
            'jasa' => $jasa ,
            'dataTanggal' => $inputOrder
        ]);


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        // create order
        $order = Order::create([
            'jumlah_order' => $request->jumlah,
            'jam_order' => $request->waktu,
            'status_order' => $request->status,
            'harga_order' => $request->harga,
            'keterangan_order' => $request->keterangan,
        ]);        
        //create pelanggan
        $pelanggan = Pelanggan::create([
            'nama_pelanggan' => $request->nama,
            'alamat_pelanggan' => $request->alamat,
            'notelp_pelanggan' => $request->no_Handphone,
            ]);
        //create relation
        $order->pelanggan()->attach($pelanggan , [
            'tanggal_order' => $request->tanggal
        ]);
        
        //create relation sopir and order
        if (count($request->sopir) != 0) {
            foreach($request->sopir as $sopir) {   
                try {
                    $data = Sopir::where('kode_sopir' , $sopir)->firstOrFail();
                    $data->order()->attach($order);
                }catch  (exception $e) {
                    
                    // echo "gagal add relation sopir dan order";
                }
                
            }
        }
        

        //create relation jasa and order
        if ($request->jasa != null ) {
            $harga = (int)$request->harga;
            $jum = (int)$request->jumlah;
            $this->isiKomisi($harga,$jum,$request->status);
            try {
                $jasa = Jasa::where('nama_jasa' , $request->jasa)->firstOrFail();
                $jasa->order()->attach($order , [
                    'komisi_jasa' => $this->komisi
                ]);
            }catch (exception $e){
                echo "gagal add relation jasa dan order";
            }
        }

        return redirect('/?tanggal='.$request->tanggal)->with([
            'message' => 'Data berhasil ditambahkan!!' , 
            'status' => 1
        ]);
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $sopir = $request->sopir;

        //delete all sopir
        $order->sopir()->detach();

        //delete relasi jasa
        if ($request->jasa == null) {
            $order->jasa()->detach();
        };

        //update order
        $order->update([
            'jumlah_order' => $request->jumlahOrder,
            'jam_order' => $request->jamOrder,
            'status_order' => $request->status,
            'harga_order' => $request->hargaOrder,
            'keterangan_order' => $request->keterangan
        ]);
        
        //update pelanggan
        $pelanggan = $order->pelanggan()->get();
        foreach ($pelanggan as $data) {
            $data->update([
                'nama_pelanggan' => $request->nama, 
                'alamat_pelanggan' => $request->alamat,
                'notelp_pelanggan' => $request->notelp
            ]);
        }

        //update relasi
        if ($sopir != null) {
            foreach($sopir as $s){
                $so = Sopir::where('kode_sopir' , $s)->first();
                $order->sopir()->attach($so->id);
            }
        }
        if ($request->jasa != null) {
            $harga = (int) $request->hargaOrder;
            $jum = (int) $request->jumlahOrder;
            $this->isiKomisi($harga,$jum,$request->status);
            $jasa = Jasa::where ('nama_jasa' , $request->jasa)->first();
            $order->jasa()->sync([
                $jasa->id => ['komisi_jasa' => $this->komisi]
            ]);
        }
        return redirect()->back()->with([
            'message' => 'Data Order berhasil diupdate!!' , 
            'status' => 1
        ]);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order , Request $request)
    {
        $pelanggan = $order->pelanggan()->get();
        Pelanggan::destroy($pelanggan[0]->id);
        Order::destroy($order->id);
        return redirect('/'."?tanggal=".$request->dataTanggal)->with([
            'message' => 'Data Order berhasil dihapus!!' , 
            'status' => 1
        ]);
    }
}