@extends('layout.head')

@section('content')

<body>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm content">
                <div class="header">
                    <div class="judul" id="judulShowJasa">
                        <h2>Data Semua Order <b>{{$sopir->nama_sopir}}</b></h2>
                        <h2 id="judulTanggal">{{$month}} {{$year}} </h2>
                    </div>
                    <div class="back" style="text-align : right;">
                        <a href="/sopir/show/{{$sopir->id}}" class="btn btn-danger" style="margin : 10px 0;">Kembali</a>
                    </div>
                    <div class="button-for-moveMonth">
                        <button id="buttonMoveLeft">
                            < </button>
                                <button id="buttonMoveRight"> > </button>
                    </div>
                </div>

                <div class="table-responsive-lg">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nama</th>
                                <th>No Handphone</th>
                                <th>Alamat</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Harga</th>
                                <th>Keterangan</th>
                                <th>Validasi Order</th>
                            </tr>
                        </thead>
                        <?php $i =1; ?>
                        <tbody>
                            @foreach ($data as $d)
                            <tr>
                                <td>{{$i}}</td>
                                <?php $newDateFormat = Date('d M Y' , strtotime($d->tanggal_order));
                                    
                                ?>
                                <input type="hidden" class="status_order" value="{{$d->status_order}}">
                                <td>{{$newDateFormat}}</td>
                                <td>{{$d->nama_pelanggan}}</td>
                                <td>{{$d->notelp_pelanggan}}</td>
                                <td>{{$d->alamat_pelanggan}}</td>
                                <td>{{$d->jumlah_order}}</td>
                                <td>{{$d->status_order}}</td>
                                <td>{{number_format( $d->harga_order )}}</td>
                                <td>{{$d->keterangan_order}}</td>
                                @if ($d->validasi == 0)
                                <td class="custom-icon text-danger"><i class="fas fa-times"></i></td>
                                @else
                                <td class="custom-icon text-success"><i class="fas fa-check"></i></td>
                                @endif
                            </tr>
                            <?php $i++?>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <div class="data">
        <input type="hidden" id="tanggal" value="{{$date}}">
        <input type="hidden" id="idSopir" value="{{$sopir->id}}">
    </div>
</body>

</html>


<script>
function showOrderBulanan(tanggal, idSopir) {
    // var tanggal = Y-m  , 2019-12
    $.ajax({
        url: '/sopir/showAll/' + idSopir + '/' + tanggal,
        method: 'get',
        dataType: 'json',
        success: function(data) {
            $('tbody').empty();
            $(data.data).each(function(i, item) {
                appendData(i, item);
            });
            $('#tanggal').val(data.date);
            $('#judulTanggal').text(data.month + " " + data.year);
        },
        error: function(data) {
            alert('error');
            console.log(data);
        }
    });
}



function appendData(i, data) {
    if (data.validasi == 1) {
        var validasi = '<td class="custom-icon text-success"><i class="fas fa-check"></i></td>';
    } else {
        var validasi = '<td class="custom-icon text-danger"><i class="fas fa-times"></i></td>';
    }
    if (data.keterangan == null) {
        var keterangan = "";
    }
    if (data.status_order == 'Batal') {
        var string = '<tr class="table-danger">' +
            '<td>' + (i + 1) + '</td>' +
            '<td>' + formatDate(data.tanggal_order) + '</td>' +
            '<td>' + data.nama_pelanggan + '</td>' +
            '<td>' + data.notelp_pelanggan + '</td>' +
            '<td>' + data.alamat_pelanggan + '</td>' +
            '<td>' + data.jumlah_order + '</td>' +
            '<td>' + data.status_order + '</td>' +
            '<td>' + addCommas(data.harga_order) + '</td>' +
            '<td>' + keterangan + '</td>' +
            validasi +
            '<tr>';
    } else {
        var string = '<tr>' +
            '<td>' + (i + 1) + '</td>' +
            '<td>' + formatDate(data.tanggal_order) + '</td>' +
            '<td>' + data.nama_pelanggan + '</td>' +
            '<td>' + data.notelp_pelanggan + '</td>' +
            '<td>' + data.alamat_pelanggan + '</td>' +
            '<td>' + data.jumlah_order + '</td>' +
            '<td>' + data.status_order + '</td>' +
            '<td>' + addCommas(data.harga_order) + '</td>' +
            '<td>' + keterangan + '</td>' +
            validasi +
            '<tr>';
    }
    $('tbody').append(string);
}




$(document).ready(function() {
    setSelected('/sopir');
    $('.status_order').each(function(i, elem) {
        var status = $(elem).val();
        if (status == 'Batal') {
            $(elem).parents('tr').addClass('table-danger');
        }
    });

    // untuk mengganti bulan

    $('#buttonMoveLeft').click(function() {
        let tanggal = $('#tanggal').val();
        let idSopir = $('#idSopir').val();
        let strTanggal = tanggal.split('-');
        let tahun = parseInt(strTanggal[0]);
        let bulan = parseInt(strTanggal[1]);
        if (bulan == 1) {
            bulan = 12;
            tahun--;
        } else {
            bulan--;
        }
        let newDate = tahun + '-' + bulan;
        showOrderBulanan(newDate, idSopir);
    });
    $('#buttonMoveRight').click(function() {
        let tanggal = $('#tanggal').val();
        let idSopir = $('#idSopir').val();
        let strTanggal = tanggal.split('-');
        let tahun = parseInt(strTanggal[0]);
        let bulan = parseInt(strTanggal[1]);
        if (bulan == 12) {
            bulan = 1;
            tahun++;
        } else {
            bulan++;
        }
        let newDate = tahun + '-' + bulan;
        showOrderBulanan(newDate, idSopir);
    });


});
</script>

@endsection