<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Jasa;
use App\Order;
use App\Pelanggan;
use App\Sopir;
class KomisiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request , Jasa $jasa)
    {
        try {
            $jasa->komisi()->create([
                'tanggal_pembayaran' => $request->tanggalAkhir ,
                'jumlah_bayar' => $request->jumlahBayar
            ]);
            //update pivot
            $update = DB::table('order_jasa')
                    ->join('order' , 'order_jasa.order_id' , 'order.id')
                    ->join('order_pelanggan' , 'order.id' , 'order_pelanggan.order_id')
                    ->where('order_pelanggan.tanggal_order' , '<=' , $request->tanggalAkhir)
                    ->where('status_bayar' , '=' , 0)
                    ->where('jasa_id' , '=' , $jasa->id)
                    ->update(['status_bayar' => 1]);
            return redirect()->back();
        }catch(Exception $e) {
            alert('error create data komisi!');
            return redirect()->back();
        }
        
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}