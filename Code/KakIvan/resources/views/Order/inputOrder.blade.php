@extends('layout.head')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm content">
            <div class="title">
                <h2>Input Order</h2>
            </div>
            <div class="inputform">
                <form method="post" action="/input" id="input" class="order">
                    @csrf
                    <div class="form-group">
                        <div class="form-group">
                            <input type="text" class="form-control" id="tanggal" name="tanggal" placeholder="tanggal"
                                value="{{$dataTanggal}}" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat"
                                required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="no_Handphone" name="no_Handphone"
                                placeholder="No Handphone" required>
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="Jumlah"
                                required>
                        </div>

                        <div class="form-group clockpicker">
                            <input type="text" class="form-control" placeholder="Waktu" name="waktu" width="80%">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="harga" name="harga" placeholder="Harga"
                                required>
                        </div>
                        <div class="form-group sopirForm" id="sopirForm">
                            <select class="custom-select" id="sopir" name="sopir[]" multiple="multiple">
                                <optgroup>
                                    @foreach ($sopir as $datasopir)
                                    <option value="{{$datasopir->kode_sopir}}">{{$datasopir->kode_sopir}}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="custom-select" id="jasa" name="jasa">
                                <option selected value="">---Jasa---</option>
                                @foreach ($jasa as $data)
                                <option value="{{$data->nama_jasa}}">{{$data->nama_jasa}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="custom-select" id="status" name="status">
                                <option selected value="Proses">---Status---</option>
                                <option value="Proses">Proses</option>
                                <option value="Diselesaikan">Diselesaikan</option>
                                <option value="Batal">Batal</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <textarea name="keterangan" class="form-control" id="keterangan" cols="100%" rows="3"
                                placeholder="Keterangan"></textarea>
                        </div>
                        <div class="hidden">
                            <input type="text" value="{{$dataTanggal}}" name="dataTanggal">
                        </div>
                        <div class="button" style="text-align : right">
                            <button type="submit" class="btn btn-success">Input</button>
                            <a href="/?tanggal={{$dataTanggal}}" class="btn btn-danger">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>

</html>


<script>
// <!-- timepicker -->
$('.clockpicker').clockpicker({
    placement: 'top',
    align: 'left',
    donetext: 'Done',
    autoclose: true,

});

// datepicker
$('#tanggal').daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    minYear: 1901,
    maxYear: parseInt(moment().format('YYYY'), 10),
    locale: {
        "format": "YYYY-M-D",
    }
});
</script>

<script>
$(document).ready(function() {
    setSelected('/');
    $('#sopir').select2({
        placeholder: "--Sopir--",
        allowClear: true
    });
});
</script>



@endsection