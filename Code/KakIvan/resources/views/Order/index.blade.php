<?php $tanggal = date("Y-m-d"); 
    


?>


<?php  
    $newDateFormat = date("d M Y", strtotime($dataTanggal));
?>
@extends('layout.head')


@section('content')





<div class="container-fluid">
    <div class="row">
        <div class="col content">
            <div class="header">
                <div class="judul">
                    <h2>Data Order</h2>
                    <h2>{{$newDateFormat}}</h2>
                </div>
                <div class="tanggal form-group">
                    <form action="/" method="GET">
                        <label for="datepicker">--Tanggal Order--</label>
                        <input name="tanggal" id="datepicker" style="width : 200px" value="{{$dataTanggal}}"
                            class="form-control">
                        <button type="submit" id="submitTanggal" class="custom-btn hidden"
                            display="float : right">Pilih</button>
                    </form>
                </div>
                <div class="inputOrder">
                    <form action="/input" method="GET">
                        <button type="submit" class="custom-btn" name="inputOrder" value="{{$dataTanggal}}">Input
                            Order</button>
                    </form>
                </div>
            </div>
            @if (session('status') == 1)
            <div class="alert alert-success" id="message">
                {{ session('message') }}
            </div>
            @endif
            <div class="table-responsive-lg">
                <table class="table table-hover table-bordered table-sm" style="text-align : center">
                    <col width="10px">
                    <col width="100px">
                    <col width="220px">
                    <col width="150px">
                    <col width="100px">
                    <col width="10px">
                    <col width="10px">
                    <col width="150px">
                    <col width="100px">
                    <col width="100px">
                    <col width="120px">
                    <col width="120px">
                    <thead>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Handphone</th>
                        <th>Waktu</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Sopir</th>
                        <th>Jasa</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Button</th>
                    </thead>
                    <?php $i = 1 ?>
                    @foreach ($order as $data)
                    <?php 
                            $newSopir = [];
                            foreach($data->sopir as $datasopir) {
                                array_push($newSopir , $datasopir->kode_sopir);
                            }
                        ?>
                    @if($data->pelanggan->count() != 0)
                    <tbody>
                        <tr class="baris{{$data->id}} tampil">
                            <td>{{$i}}</td>
                            @foreach($data->pelanggan as $pelanggan)
                            <td class="hidden data" data-nama="{{$pelanggan->nama_pelanggan}}"
                                data-alamat="{{$pelanggan->alamat_pelanggan}}"
                                data-notelp="{{$pelanggan->notelp_pelanggan}}" data-harga="{{$data->harga_order}}"
                                data-keterangan="{{$data->keterangan_order}}" data-jam="{{$data->jam_order}}">
                            </td>

                            <td>{{$pelanggan->nama_pelanggan}}</td>
                            <td>{{$pelanggan->alamat_pelanggan}}</td>
                            <td>{{$pelanggan->notelp_pelanggan}}</td>
                            @endforeach
                            <td>{{$data->jam_order}}</td>
                            <td>{{$data->jumlah_order}}</td>
                            <td>{{number_format(  $data->harga_order )}}
                            </td>
                            @if ($data->sopir->count() != 0)
                            <td>
                                <?php $j = 1; ?>
                                @foreach ($data->sopir as $sopir)
                                @if($j != count($data->sopir) )
                                <p class="telponSopir" data-telpon="{{$sopir->notelp_sopir}}" data-id="{{$data->id}}">
                                    {{$sopir->kode_sopir}} </p> ,
                                @else
                                <p class="telponSopir" data-telpon="{{$sopir->notelp_sopir}}" data-id="{{$data->id}}">
                                    {{$sopir->kode_sopir}} </p>
                                @endif
                                <?php $j++; ?>
                                @endforeach
                            </td>
                            @else
                            <td></td>
                            @endif
                            @if ($data->jasa->count() != 0)
                            @foreach ($data->jasa as $jasa)
                            <td>{{$jasa->nama_jasa}}</td>
                            @endforeach
                            @else
                            <td></td>
                            @endif
                            <td id="status" name="status" value="{{$data->status_order}}">{{$data->status_order}}
                            </td>
                            <td>{{$data->keterangan_order}}</td>
                            <td>
                                <button class="btn btn-info editBtn" value="{{$data->id}}"><i
                                        class="fas fa-edit"></i></button>
                                <form action="/{{$data->id}}" method="post" class="formBtn">
                                    @method('delete')
                                    @csrf
                                    <input type="hidden" value="{{$dataTanggal}}" name="dataTanggal">
                                    <button class=" btn btn-danger deleteBtn" type="submit" value="{{$data->id}}"><i
                                            class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        <tr class="edit{{$data->id}} hidden">
                            <form method="post" action="{{$data->id}}" id="updateForm{{$data->id}}">
                                @csrf
                                @method('put')
                                <td>{{$i}}</td>
                                @foreach($data->pelanggan as $pelanggan)
                                <td>
                                    <input type="text" class="form-control" value="{{$pelanggan->nama_pelanggan}}"
                                        name="nama" required>
                                </td>
                                <td>
                                    <input type="text" class="form-control" value="{{$pelanggan->alamat_pelanggan}}"
                                        name="alamat" required>
                                </td>
                                <td><input type="text" class="form-control" value="{{$pelanggan->notelp_pelanggan}}"
                                        name="notelp" required>
                                </td>
                                @endforeach
                                <td><input type="text" class="form-control" value="{{$data->jam_order}}" name="jamOrder"
                                        required>
                                </td>
                                <td><input type="number" class="form-control" value="{{$data->jumlah_order}}"
                                        name="jumlahOrder" required>
                                </td>
                                <td><input type="text" class="form-control" value=" {{$data->harga_order}} "
                                        name="hargaOrder" required>
                                </td>

                                <td class="editSopirRow">
                                    <select class="custom-select sopir" id="editSopir{{$data->id}}" multiple="multiple"
                                        name="sopir[]">
                                        @foreach($dataSopir as $sopir)
                                        <?php $key = in_array($sopir->kode_sopir , $newSopir); ?>
                                        @if($key == true)
                                        <option value="{{$sopir->kode_sopir}}" selected>{{$sopir->kode_sopir}}
                                        </option>
                                        @else
                                        <option value="{{$sopir->kode_sopir}}">{{$sopir->kode_sopir}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </td>


                                @if ($data->jasa->count() != 0)
                                @foreach ($data->jasa as $jasa )
                                <td>
                                    <select name="jasa" class="custom-select">
                                        <option value=""></option>
                                        @foreach ($dataJasa as $datajasa)
                                        @if ($datajasa->nama_jasa != $jasa->nama_jasa)
                                        <option value="{{$datajasa->nama_jasa}}">{{$datajasa->nama_jasa}}</option>
                                        @else
                                        <option value="{{$datajasa->nama_jasa}}" selected>{{$datajasa->nama_jasa}}
                                        </option>
                                        @endif
                                        @endforeach
                                    </select>
                                </td>

                                @endforeach
                                @else
                                <td>
                                    <select name="jasa" class="custom-select">
                                        <option value=""></option>
                                        @foreach ($dataJasa as $datajasa)
                                        <option value="{{$datajasa->nama_jasa}}">{{$datajasa->nama_jasa}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                @endif
                                <td>
                                    <select name="status" class="custom-select">
                                        <?php 
                                                $arr = ['Diselesaikan' , 'Proses' , 'Batal'];
                                            ?>
                                        @foreach($arr as $dataStatus)
                                        @if ($dataStatus != $data->status_order)
                                        <option value="{{$dataStatus}}">{{$dataStatus}}</option>
                                        @else
                                        <option value="{{$dataStatus}}" selected>{{$dataStatus}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" value="{{$data->keterangan_order}}"
                                        name="keterangan">
                                </td>
                                <td>
                                    <button type="submit" id="saveBtn" value="{{$data->id}}"
                                        class="btn btn-success save"><i class="fas fa-save"></i></button>
                            </form>
                            <a href="/?tanggal={{$dataTanggal}}" class="cancelBtn btn btn-danger"
                                value="{{$data->id}}"><i class="fa fa-window-close"></i></a>
                            </td>
                        </tr>
                    </tbody>
                    <?php $i++;?>
                    @endif
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>




</body>

</html>


<script>
var $timepicker = $('.timepicker').timepicker({
    format: 'HH:MM',
    header: true,
    footer: true,
    uiLibrary: 'bootstrap',
    modal: true,
    mode: '24hr'
});

var datepicker = $('#datepicker').daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    minYear: 1901,
    maxYear: parseInt(moment().format('YYYY'), 10),
    locale: {
        "format": "YYYY-M-D",
    }
})

// datePicker
$('#datepicker').on('apply.daterangepicker', function(ev, picker) {
    //do something, like clearing an input
    $('#submitTanggal').trigger('click');
});
</script>


<!-- own jquery for action listener -->
<script>
$(document).ready(function() {
    setSelected('/');
    //hide message
    if ($('#message').length) {
        $('#message').delay(4000).slideUp(1000);
    }


    // select2
    $('.sopir').select2();
    //mengubah warna setiap baris berdasarkan status order
    $('td[name = "status"]').each(function(i, elem) {
        var string = $(elem).text().trim();
        if (string == 'Proses') {
            $(this).parents('tr').addClass('table-warning');
        } else if (string == 'Batal') {
            $(this).parents('tr').addClass('table-danger');
        } else if (string == 'Diselesaikan') {
            $(this).parents('tr').addClass('table-info')
        }
    });

    $('.editBtn').click(function() {
        var id = $(this).val();
        var string = ($('.edit' + id).find('select[name="status"]').val());
        console.log(string);
        if (string == 'Proses') {
            $('.edit' + id).addClass('table-warning');
        } else if (string == 'Batal') {
            $('.edit' + id).addClass('table-danger');
        } else if (string == 'Diselesaikan') {
            $('.edit' + id).addClass('table-info')
        }
        $('.baris' + id).addClass('hidden');
        $('.edit' + id).removeClass('hidden');
    });

    $('#toogleMenuBtn').click(function() {
        var jenis = $('.content').attr('class');
        console.log(jenis);
        $('.sidebar').slideToggle('slow');
        if (jenis == 'col-sm-10 content' || jenis == 'content col-sm-10') {
            $('.content').removeClass('col-sm-10').addClass('col-sm-12');
        } else {
            $('.content').removeClass('col-sm-12').addClass('col-sm-10');
            $('.sidebar').addClass('col-2');
        }
    });

    $('.deleteBtn').click(function() {
        // var id = $(this).val();
        // $('.baris' + id).css('background-color', 'rgb(237, 146, 130)');
        return confirm('Apakah anda yakin menghapus data ini ? ');
    });


    $('.telponSopir').click(function(e) {
        let telpon = $(this).data('telpon');
        let id = $(this).data('id');
        telpon = '62' + telpon.substring(1, telpon.length);
        let baris = $(`.baris${id} .data`);
        // data text
        let namaPelanggan = baris.data('nama');
        let alamatPelanggan = baris.data('alamat');
        let notelp = baris.data('notelp');
        let harga = 'Rp ' + addCommas(baris.data('harga'));
        let jam = baris.data('jam');
        let keterangan = baris.data('keterangan');
        let string =
            ` nama : ${namaPelanggan} 
        %0a alamat : ${alamatPelanggan}
        %0a nomer : ${notelp}
        %0a harga : ${harga} 
        %0a jamOrder : ${jam}
        %0a keterangan : ${keterangan}
        `
        console.log(string);
        let url = `https://wa.me/${telpon}?text=${string}`;
        window.open(url);

    });
});
</script>







@endsection