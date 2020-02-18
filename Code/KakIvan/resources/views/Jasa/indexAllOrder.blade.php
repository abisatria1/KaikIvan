@extends('layout.head')

@section('content')

<script src="{{asset('js/customJs/indexAllOrderJasa.js')}}"></script>



<div class="container-fluid">
    <div class="row">

        <div class="col-sm content">
            <div class="header">
                <div class="judul" id="judulShowJasa">
                    <h2>Data Order <b>{{$dataJasa->nama_jasa}}</b></h2>
                    <h2 id="judul"></h2>
                </div>
                <div class="back" style="text-align : right;">
                    <a href="/jasa/show/{{$dataJasa->id}}" class="btn btn-danger" style="margin : 10px 0;">Kembali</a>
                </div>
                <div class="button-for-moveMonth">
                    <button id="buttonMoveLeft">
                        < </button>
                            <button id="buttonMoveRight"> > </button>
                </div>
            </div>
            <div class="table-responsive-xl table">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama</th>
                            <th>No Handphone</th>
                            <th>Alamat</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Komisi</th>
                            <th>Status Bayar</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <?php $i =1; ?>
                    <tbody>
                        @foreach ($dataOrder as $data)
                        <tr>
                            <td>{{$i}}</td>
                            <?php $newDateFormat = Date('d M Y' , strtotime($data->tanggal_order)) ?>
                            <td>{{$newDateFormat}}</td>
                            <input type="hidden" class="komisi" value="{{$data->komisi_jasa}}">
                            <td>{{$data->nama_pelanggan}}</td>
                            <td>{{$data->notelp_pelanggan}}</td>
                            <td>{{$data->alamat_pelanggan}}</td>
                            <td>{{$data->jumlah_order}}</td>
                            <td>{{number_format( $data->harga_order )}}</td>
                            <td>{{ number_format ($data->komisi_jasa)}}</td>
                            @if ($data->status_bayar == 0 )
                            <td class="custom-icon text-danger"><i class="fas fa-times"></i></td>
                            @else
                            <td class="custom-icon text-success"><i class="fas fa-check"></i></td>
                            @endif
                            <td>{{$data->keterangan_order}}</td>
                        </tr>
                        <?php $i++?>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
<!-- data for js-->
<input type="hidden" id='bulan' name="bulan" value="{{date('Y m')}}">
<input type="hidden" id='idJasa' name="idJasa" value="{{$dataJasa->id}}">
</body>

</html>



@endsection