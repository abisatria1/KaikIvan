@extends('layout.head')
@section('head')
<link rel="stylesheet" href="{{ asset('css/showJasa.css') }}">
@endsection
@section('content')

<!-- Modal HTML embedded directly into document -->
<div id="modal" style="min-width : 700px">
    <form action="/jasa/show/{{$dataJasa->id}}" method="post">
        @csrf
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tanggal Awal</th>
                    <th>Tanggal Akhir</th>
                    <th>Jumlah Order</th>
                    <th>Jumlah Bayar</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td id="tanggal_awal"></td>
                    <input type="hidden" name="tanggalAkhir" value="{{date('Y-m-d')}}">
                    <input type="hidden" name="jumlahBayar">
                    <td id="tanggal_akhir"></td>
                    <td id="jumlah_order"></td>
                    <td id="jumlah_bayar"></td>
                </tr>
            </tbody>
        </table>
        <div class="btn" style="text-align : center; margin : auto;width:100%">
            <button type="submit" class="btn btn-success" id="bayarBtn">Bayar</button>
            <a href="#" class="btn btn-danger" id="cancelBtn">Kembali</a>
        </div>
    </form>
</div>

<div id="riwayatBayar" class="modal" style="min-width : 700px">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Bayar</th>
                <th>Jumlah Bayar</th>
            </tr>
        </thead>
        <tbody id="riwayatBody">

        </tbody>
    </table>
    <div class="btn" style="text-align : center; margin : auto;width:100%">
        <a href="#" class="btn btn-danger" id="cancelBtnRiwayatBayar">Kembali</a>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm content">
            <div class="header">
                <div class="judul" id="judulShowJasa">
                    <h2>Data Order <b> {{$dataJasa->nama_jasa}} </b></h2>
                    <h2 id="dataTanggal">
                    </h2>
                </div>
                <div class="flex">


                    <div class="tanggalPilih">
                        <form action="" id="submitRangeDate">
                            <input type="text" class="form-control" name="tanggalPilih" id="tanggalPilih" />
                        </form>
                    </div>
                    <div class="button">
                        @if ($jumAllOrder != 0)
                        <form action="/jasa/showAll/{{$dataJasa->id}}" method="get"
                            style="display : inline; text-align : right">
                            @csrf
                            <button type="submit" class="btn btn-primary">Semua Order</button>
                        </form>
                        <a href="#riwayatBayar" class="btn btn-secondary" rel="modal:open">Riwayat Bayar</a>
                        <input type="hidden" id="idJasa" value="{{$dataJasa->id}}">
                        @endif
                        <div class="back" style="display : inline">
                            <a href="/jasa" class="btn btn-danger">Kembali</a>
                        </div>
                    </div>


                </div>
                @if (session('status') == 1)
                <div class="alert alert-success" id="message">
                    {{ session('message') }}
                </div>
                @endif
                @if ($dataOrder->count() != 0)
                <div class="table-responsive-xl table" style="margin-top : 10px">
                    <table class="table table-hover table-bordered">
                        <col width="10px">
                        <col width="200px">
                        <col width="200px">
                        <col width="200px">
                        <col width="400px">
                        <col width="80px">
                        <col width="100px">
                        <col width="150px">
                        <col width="200px">
                        <col width="150px">
                        <col width="160px">
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
                                <th>Button</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $i = 1; 
                                ?>

                            @foreach($dataOrder as $dataorder)
                            <!-- hitung komisi -->
                            <tr id="row{{$dataorder->id}}">
                                <td>{{$i}}</td>
                                <?php 
                                    $newDateFormat = date("d M Y", strtotime($dataorder->tanggal_order));
                                    $date = $dataorder->tanggal_order;
                                    ?>
                                <td>{{$newDateFormat}}</td>
                                <input type="hidden" value="{{$newDateFormat}}" name="tanggal">
                                <input type="hidden" value="{{$dataJasa->nama_jasa}}" id="namaJasa">
                                <td>{{$dataorder->nama_pelanggan}}</td>
                                <td>{{$dataorder->notelp_pelanggan}}</td>
                                <td>{{$dataorder->alamat_pelanggan}}</td>
                                <td>{{$dataorder->jumlah_order}}</td>
                                <input type="hidden" value="{{$dataorder->jumlah_order}}" name="hitungOrder">
                                <td>{{number_format( $dataorder->harga_order )}}</td>
                                <td name="komisi">{{number_format($dataorder->komisi_jasa)}}</td>
                                <input type="hidden" value="{{$dataorder->komisi_jasa}}" name="hitungKomisi">
                                @if ($dataorder->status_bayar == 0)
                                <td class="custom-icon text-danger"><i class="fas fa-times"></i></td>
                                @else
                                <td class="custom-icon text-success"><i class="fas fa-check"></i></td>
                                @endif
                                <td>{{$dataorder->keterangan_order}}</td>
                                <td>
                                    <button class="btn btn-info editBtn" style="display : inline;"
                                        value="{{$dataorder->id}}"><i class="fa fa-edit"></i></button>
                                    <button onclick="window.location.href = '/?tanggal={{$dataorder->tanggal_order}}'  "
                                        class="btn btn-dark"><i class="fa fa-eye"></i></button>
                                </td>
                            </tr>
                            <tr class="hidden" id="hidden{{$dataorder->id}}">
                                <form action="/jasa/show/{{$dataJasa->id}}/{{$dataorder->id}}" method="post">
                                    @csrf
                                    @method('put')
                                    <td>{{$i}}</td>
                                    <td>{{$newDateFormat}}</td>
                                    <td>{{$dataorder->nama_pelanggan}}</td>
                                    <td>{{$dataorder->notelp_pelanggan}}</td>
                                    <td>{{$dataorder->alamat_pelanggan}}</td>
                                    <td>{{$dataorder->jumlah_order}}</td>
                                    <td>{{number_format( $dataorder->harga_order )}}</td>
                                    <td>
                                        <input type="number" name="komisi_jasa" class="form-control"
                                            value="{{$dataorder->komisi_jasa}}" required>
                                    </td>
                                    @if ($dataorder->status_bayar == 0)
                                    <td class="custom-icon text-danger"><i class="fas fa-times"></i></td>
                                    @else
                                    <td class="custom-icon text-success"><i class="fas fa-check"></i></td>
                                    @endif
                                    <td>{{$dataorder->keterangan_order}}</td>
                                    <td>
                                        <button type="submit" id="saveBtn" class="btn btn-success"><i
                                                class="fa fa-save"></i></button>
                                        <a href="/jasa/show/{{$dataJasa->id}}" class="cancelBtn btn btn-danger"><i
                                                class="fa fa-window-close"></i></a>
                                    </td>
                                </form>
                            </tr>
                            <?php $i++; ?>
                            @endforeach
                            <tr>
                                <td colspan="6" id="totalOrder" style="font-weight : bold;"></td>
                                <td colspan="5" id="total" style="font-weight : bold;"></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <div class="bayar" style="text-align : right">
                    <a href="#modal" class="btn btn-success" style="display : inline-block; width : 150px">Bayar</a>
                </div>
                @endif
            </div>
        </div>
    </div>
    <input type="hidden" id="min" value="{{$min}}">
    <input type="hidden" id="idJasa" value="{{$dataJasa->id}}">
    @if (isset($now))
    <input type="hidden" id="now" value="{{$now}}">
    @else
    <input type="hidden" id="now" value="{{date('Y-m-d')}}">
    @endif
</div>
</body>

</html>
<script>
//riwayat bayar
function riwayatBayar() {
    var id = $('#idJasa').val();
    $.ajax({
        type: "GET",
        url: '/jasa/getRiwayat',
        data: {
            jasaId: id
        },
        dataType: 'json',
        success: function(response) {
            console.log(response);
            $(response.data).each(function(i, item) {
                var tanggal = item.tanggal_pembayaran;
                var jumlah = item.jumlah_bayar;
                console.log(jumlah);
                $('#riwayatBody').append(
                    "<tr>" +
                    "<td>" + (i + 1) + "</td>" +
                    "<td>" + formatDate(tanggal) + "</td>" +
                    "<td>" + "Rp " + addCommas(jumlah) + "</td>" +
                    "</tr>"
                )
            });
        },
        error: function(data) {
            alert('error');
        }
    });
}

function setDisplayTanggal(awal, akhir) {
    //set judul dan default tanggal ke awal dan akhir
    //set value tanggal
    if (awal == "" || akhir == null) {
        $('.tanggalPilih').hide();
        return null;
    } else {
        awal = formatDate(awal);
        akhir = formatDate(akhir);
        $('#dataTanggal').text(`${awal} - ${akhir}`);
    }
}

function pilihOrderDenganRange(string) {
    var id = $('#idJasa').val();
    $('#submitRangeDate').attr('method', 'get');
    $('#submitRangeDate').attr('action', `/jasa/show/${id}/${string}`);
    $('#submitRangeDate').trigger('submit');
}


$(document).ready(function() {
    var modal2 = $('#riwayatBayar').iziModal({
        radius: 5,
        transitionIn: 'bounceInDown',
        transitionOut: 'bounceOutUp',
        setHeader: true,
        closeButton: false
    });
    var modal = $('#modal').iziModal({
        radius: 5,
        transitionIn: 'bounceInDown',
        transitionOut: 'bounceOutUp',
        setHeader: true,
        closeButton: false
    });
    modal.iziModal('setWidth', '40%');
    modal.iziModal('setTitle', 'Pembayaran Jasa ' + '<b>' + $('#namaJasa').val() + '</b>');
    modal.iziModal('setSubtitle', 'Silahkan cek kembali data pembayaran dan klik bayar jika sudah valid');

    modal2.iziModal('setWidth', '40%');
    modal2.iziModal('setTitle', 'Riwayat Pembayaran Jasa ' + '<b>' + $('#namaJasa').val() + '</b>');
    modal2.iziModal('setSubtitle', 'Informasi tentang terakhir pembayaran jasa');
    $(document).on('closing', '#riwayatBayar', function(e) {
        $('#riwayatBody').empty();
    });

    $('#cancelBtn').click(function() {
        modal.iziModal('close');
    });
    $('a[href="#bayar"]').click(function() {
        modal.iziModal('open');
    });


    setSelected('/jasa');

    //hide message
    if ($('#message').length) {
        $('#message').delay(4000).slideUp(1000);
    }
    //variabel inisiasi
    var total = 0;
    var totalOrder = 0;
    var min = $('#min').val();
    if (min != "") {
        min = formatDate(min);
    }
    var now = $('#now').val();
    // set default range tanggal
    setDisplayTanggal(min, now);
    //end of deklarasi variabel

    // datepicker
    $datepicker = $('#tanggalPilih').daterangepicker({
        "autoApply": true,
        ranges: {
            'Hari Ini': [moment(), moment()],
            'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
            '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
            'Bulan ini': [moment().startOf('month'), moment().endOf('month')],
            'Bulan terakhir': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                    'month')
                .endOf('month')
            ]
        },
        "locale": {
            "format": "YYYY-MM-DD",
            "separator": " s.d ",
            "applyLabel": "Pilih",
            "cancelLabel": "Batal",
            "fromLabel": "From",
            "toLabel": "To",
            "customRangeLabel": "Custom",
            "weekLabel": "W",
            "daysOfWeek": [
                "Su",
                "Mo",
                "Tu",
                "We",
                "Th",
                "Fr",
                "Sa"
            ],
            "monthNames": [
                "January",
                "February",
                "March",
                "April",
                "May",
                "June",
                "July",
                "August",
                "September",
                "October",
                "November",
                "December"
            ],
            "firstDay": 1
        },
        "startDate": $('#min').val(),
        "endDate": now,
        "opens": "center"
    }, function(start, end, label) {
        console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format(
            'YYYY-MM-DD') + ' (predefined range: ' + label + ')');
    });


    $('td[name = "komisi"]').each(function(i, elem) {
        var string = $(elem).text().trim();
        if (string == 0) {
            $(this).parents('tr').addClass('table-danger');
        }
    });

    $('#tanggalPilih').on('apply.daterangepicker', function(ev, picker) {
        pilihOrderDenganRange($('#tanggalPilih').val());
    });


    //setting total komisi
    $('input[name="hitungKomisi"]').each(function(i, elem) {
        var current = $(elem).val();
        total = total + parseInt(current);
    });
    $('#total').text('Total = Rp ' + addCommas(total));

    //setting total order
    $('input[name="hitungOrder"]').each(function(i, elem) {
        var order = $(elem).val();
        totalOrder = totalOrder + parseInt(order);
    });
    $('#totalOrder').text('Total Order = ' + totalOrder);

    $('a[href="#riwayatBayar"]').click(riwayatBayar);

    //set text on modal
    $('#tanggal_awal').text(min);
    $('#tanggal_akhir').text(formatDate(now));
    $('#jumlah_order').text(totalOrder);
    $('#jumlah_bayar').text("Rp " + addCommas(total));
    //set value for modal
    $('input[name="jumlahBayar"]').val(total);


    //edit function
    $('.editBtn').click(function() {
        var id = $(this).val();
        console.log(id);
        $('#row' + id).addClass('hidden');
        $('#hidden' + id).removeClass('hidden');
    });

    $('#cancelBtnRiwayatBayar').click(function() {
        modal2.iziModal('close');
    });

});
</script>


@endsection