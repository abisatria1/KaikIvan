@extends('layout.head')
@section('head')
<link rel="stylesheet" href="{{ asset('css/showSopir.css') }}">
@endsection
@section('content')





<body>
    <!-- Modal HTML embedded directly into document -->
    <div class="showSopir" id="modal">
        <div class="table-responsive-lg">
            <table class="table table-bordered" id="showTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nama</th>
                        <th>No Telpon</th>
                        <th>Alamat</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Harga</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody id="modalBodyTable">

                </tbody>
            </table>
            <div class="btn" style="text-align : center; margin : auto;width:100%">
                <a href="" rel="modal:close" class="btn btn-success" id="save">Tandai Order</a>
                <a href="#" rel="modal:close" class="btn btn-danger" id="cancelBtn">Kembali</a>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm content">
                <div class="header">
                    <div class="judul" id="judulShowJasa">
                        <h2>Data Pekerjaan <b> {{$dataSopir->nama_sopir}} </b></h2>
                    </div>

                    <form id="dateShowForm" style="display : inline !important;">
                        @csrf
                        <input name="tanggalPilih" class="form-control" id="datepicker"
                            style="width : 200px ; display : inline-block !important;" value="{{date('Y-m-d')}}"
                            required>
                        <input type="hidden" value="{{$dataSopir->kode_sopir}}" id="idSopir">
                        <a href="#modal" class="btn btn-primary hidden" style="margin-top : 8px" id="lihatOrder">Lihat
                            Order Sopir</a>
                        <label for="tanggalPilih" style="color : grey">Pilih Tanggal untuk melihat pekerjaan yang belum
                            dicek</label>
                    </form>
                    <div class="back" style="text-align : right; float : right ; margin-bottom : 20px ; display:inline">
                        <a href="{{ action('SopirController@allOrder' , [$dataSopir->id]) }}"
                            class="btn btn-primary">Lihat
                            Semua Kerja Sopir</a>
                        <a href="/sopir" class="btn btn-danger">Kembali</a>
                    </div>

                </div>
                <div class="showPesan">
                    @if (session('status') == 1)
                    <div class="alert alert-success" id="message">
                        {{ session('message') }}
                    </div>
                    @endif
                </div>
                <div class="table-responsive-lg table">
                    <table class="table table-hover table-bordered bodyTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nama</th>
                                <th>No Telpon</th>
                                <th>Alamat</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Harga</th>
                                <th>Keterangan</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1?>
                            @foreach($dataOrder as $data)
                            <tr class="data">
                                <?php  $newDateFormat = date('d M Y' , strToTime( $data->tanggal_order)) ?>
                                <input type="hidden" value="{{$data->tanggal_order}}" class="tanggalOrder">
                                <td>{{$i}}</td>
                                <td>{{$newDateFormat}}</td>
                                <td>{{$data->nama_pelanggan}}</td>
                                <td>{{$data->notelp_pelanggan}}</td>
                                <td>{{$data->alamat_pelanggan}}</td>
                                <td>{{$data->jumlah_order}}</td>
                                <td name="status">{{$data->status_order}}</td>
                                <td>{{number_format($data->harga_order)}}</td>
                                <td>{{$data->keterangan_order}}</td>
                            </tr>
                            <?php $i++; ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<script>
function hideMessage() {
    //hide message
    if ($('#message').length) {
        $('#message').delay(4000).slideUp(1000);
    }
}

function reCreateTable() {
    $.ajax({
        url: '/getSopirOrder/' + $('#idSopir').val(),
        type: 'get',
        dataType: 'json',
        success: function(data) {
            console.log(data);
            $('.bodyTable tbody').empty();

            $(data.dataOrder).each(function(i, item) {
                if (item.keterangan == null) {
                    var keterangan = "";
                }
                if (item.status_order == 'Batal') {
                    var row = '<tr class="data table-danger" >'
                } else {
                    var row = '<tr class="data" >'
                }
                var string =
                    row +
                    "<input type='hidden' value='" + item.tanggal_order +
                    "' class='tanggalOrder' >" +
                    "<td>" + (i + 1) + "</td>" +
                    "<td>" + formatDate(item.tanggal_order) + "</td>" +
                    "<td>" + item.nama_pelanggan + "</td>" +
                    "<td>" + item.notelp_pelanggan + "</td>" +
                    "<td>" + item.alamat_pelanggan + "</td>" +
                    "<td>" + item.jumlah_order + "</td>" +
                    "<td>" + item.status_order + "</td>" +
                    "<td>" + item.harga_order + "</td>" +
                    "<td>" + keterangan + "</td>" +
                    "</tr>";
                $('.bodyTable tbody').append(string);
            });
        },
        error: function() {
            alert('error');
        }
    });
}

function saveValidasiOrder(tanggal, idSopir) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: "POST",
        url: '/sopir/validasi',
        data: {
            tanggal: tanggal,
            sopir: idSopir
        },
        dataType: 'json',
        success: function(data) {
            reCreateTable();
            $('.showPesan').append(
                '<div class="alert alert-success" id="message">' +
                data.message +
                '</div>'
            )
            hideMessage();
        },
        error: function(data) {
            alert('error');
        }
    });
}
</script>

<script>
$(document).ready(function() {
    var modal = $('#modal').iziModal({
        radius: 5,
        transitionIn: 'bounceInDown',
        transitionOut: 'bounceOutUp',
        setHeader: true,
        closeButton: false
    });
    modal.iziModal('setWidth', '20%');
    modal.iziModal('setSubtitle', 'Silahkan cek data kerjaan sopir dan tandai jika sudah benar')
    setSelected('/sopir');
    hideMessage();
    //datepicker
    const $datepicker = $('#datepicker').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        minYear: 1901,
        maxYear: parseInt(moment().format('YYYY'), 10),
        locale: {
            "format": "YYYY-M-D",
        }
    });

    // datePicker
    $datepicker.on('apply.daterangepicker', function(ev, picker) {
        //do something, like clearing an input
        $('#lihatOrder').trigger('click');
    });

    $('td[name = "status"]').each(function(i, elem) {
        var string = $(elem).text().trim();
        if (string == 'Batal') {
            $(this).parents('tr').addClass('table-danger');
        }
    });


    //modal config
    $('a[href="#modal"]').click(function() {
        if ($('input[name="tanggalPilih"]').val() != "") {
            $('#lihatOrder').attr('rel', 'modal:open');

            return false;
        } else {
            return alert('Tolong isi data tanggal dengan Benar!!');
        }
    });

    $('#cancelBtn').click(function() {
        $('#modal').iziModal('close');
    });

    $(document).on('closing', '#modal', function(e) {
        $('#showTable > tbody').empty();
    });
    //ajax
    $('#save').click(function(e) {
        e.preventDefault();
        var tanggal = $('input[name="tanggalPilih"]').val();
        var idSopir = $('#idSopir').val();
        $.confirm({
            title: "Peringatan",
            content: "Apakah anda yakin ingin memvalidasi pekerjaan tanggal " + $(
                '#dataTanggal').text() + " ? ",
            type: 'dark',
            typeAnimated: true,
            buttons: {
                ok: {
                    text: 'Konfirmasi',
                    btnClass: 'btn-dark',
                    action: function() {
                        saveValidasiOrder(tanggal, idSopir);
                        modal.iziModal('close');
                    }
                },
                close: {
                    text: "Tutup",
                    action: function() {
                        modal.iziModal('close');
                    }
                }
            }
        });

    });

    $('body').on('click', '.bodyTable > tbody > tr', function() {
        var tanggal = $('.tanggalOrder', this).val();
        $('input[name="tanggalPilih"]').val(tanggal);
        $('#lihatOrder').trigger('click');
    });

    $('#lihatOrder').click(function(e) {
        $('#modal').iziModal('open');
        e.preventDefault();
        var tanggal = $('input[name="tanggalPilih"]').val();
        var idSopir = $('#idSopir').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "GET",
            url: '/sopir/show',
            data: {
                tanggal: tanggal,
                sopir: idSopir
            },
            dataType: 'json',
            success: function(data) {
                var tanggal = $('input[name="tanggalPilih"]').val();
                //set date
                var myDate = new Date(tanggal);
                var month = ["Jan", "Febr", "Mar", "Ap", "May", "Jun",
                    "Jul", "Aug", "Sept", "Oct", "Nov", "Dec"
                ];
                var getMonth = month[myDate.getMonth()];
                var str = myDate.getDate() + " " + getMonth + " " + myDate
                    .getFullYear();
                $('#dataTanggal').text(str);
                modal.iziModal('setTitle', 'Data Order Tanggal ' + str);
                if (data.order.length != 0) {
                    $('#save').removeClass('hidden');
                    data.order.forEach(addDataTable);
                } else {
                    $('#save').addClass('hidden');
                }
            },
            error: function(data) {
                alert('error');
            }
        });
    });

    //foreach data
    function addDataTable(item, index) {
        var tanggal = $('input[name="tanggalPilih"]').val();
        //set date
        var myDate = new Date(tanggal);
        var month = ["Jan", "Febr", "Mar", "Ap", "May", "Jun",
            "Jul", "Aug", "Sept", "Oct", "Nov", "Dec"
        ];
        var getMonth = month[myDate.getMonth()];
        var str = myDate.getDate() + " " + getMonth + " " + myDate.getFullYear();
        var nama = item.nama_pelanggan;
        var notelp = item.notelp_pelanggan;
        var alamat = item.alamat_pelanggan;
        var jumlah = item.jumlah_order;
        var status = item.status_order;
        var harga = item.harga_order;
        var keterangan = item.keterangan_order;
        if (keterangan == null) {
            keterangan = "";
        }

        if (status != 'Batal') {
            var str =
                "<tr>" +
                "<td>" + (index + 1) + "</td>" +
                "<td>" + str + "</td>" +
                "<td>" + nama + "</td>" +
                "<td>" + notelp + "</td>" +
                "<td>" + alamat + "</td>" +
                "<td>" + jumlah + "</td>" +
                "<td>" + status + "</td>" +
                "<td>" + harga + "</td>" +
                "<td>" + keterangan + "</td>" +
                "</tr>";
        } else {
            var str =
                "<tr class='table-danger' >" +
                "<td>" + (index + 1) + "</td>" +
                "<td>" + str + "</td>" +
                "<td>" + nama + "</td>" +
                "<td>" + notelp + "</td>" +
                "<td>" + alamat + "</td>" +
                "<td>" + jumlah + "</td>" +
                "<td>" + status + "</td>" +
                "<td>" + harga + "</td>" +
                "<td>" + keterangan + "</td>" +
                "</tr>";
        }
        $('#modalBodyTable').append(
            str
        );
    }


});
</script>

@endsection