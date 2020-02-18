@extends('layout.head')

@section('content')

<body>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg content">
                <div class="header">
                    <div class="judul">
                        <h2>Data Sopir</h2>
                    </div>
                    <div class="inputSopir">
                        <form action="/sopir/input" method="GET" style="margin-bottom : 20px">
                            <button type="submit" class="custom-btn">Input
                                Sopir</button>
                        </form>
                    </div>
                    @if (session('status') == 1)
                    <div class="alert alert-success" id="message">
                        {{ session('message') }}
                    </div>
                    @endif
                    <div class="table-responsive-lg">
                        <table class="table table-hover table-bordered ">
                            <col width="50px">
                            <col width="200px">
                            <col width="200px">
                            <col width="200px">
                            <col width="200px">
                            <col width="100px">
                            <col width="120px">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>No Handphone</th>
                                    <th>Alamat</th>
                                    <th>Keterangan</th>
                                    <th>Kode</th>
                                    <th>Button</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1?>
                                @foreach($data as $dataSopir)
                                <tr id="row{{$dataSopir->id}}">
                                    <td>{{$i}}</td>
                                    <td>{{$dataSopir->nama_sopir}}</td>
                                    <td>{{$dataSopir->notelp_sopir}}</td>
                                    <td>{{$dataSopir->alamat_sopir}}</td>
                                    <td>{{$dataSopir->keterangan_sopir}}</td>
                                    <td>{{$dataSopir->kode_sopir}}</td>
                                    <td>
                                        <button class="editBtn btn btn-info" value="{{$dataSopir->id}}"><i
                                                class="fa fa-edit"></i></button>
                                        <form action="/sopir/{{$dataSopir->id}}" method="post"
                                            style="display : inline;">
                                            @csrf
                                            @method('delete')
                                            <button class="deleteBtn btn btn-danger"
                                                onclick="return confirm('Apakah anda ingin menghapus data ini ? ');"> <i
                                                    class="fa fa-trash"></i> </button>
                                        </form>
                                        <button class="viewBtn btn btn-dark"
                                            onclick="window.location.href = '/sopir/show/{{$dataSopir->id}}' "><i
                                                class="fa fa-eye"></i></button>
                                    </td>
                                </tr>
                                <tr class="hidden" id="hidden{{$dataSopir->id}}">
                                    <form action="/sopir/{{$dataSopir->id}}" method="post">
                                        @csrf
                                        @method('put')
                                        <td>{{$i}}</td>
                                        <td><input class="form-control" type="text" value="{{$dataSopir->nama_sopir}}"
                                                name="nama_sopir" required></td>
                                        <td><input class="form-control" type="text" value="{{$dataSopir->notelp_sopir}}"
                                                name="notelp_sopir" required></td>
                                        <td><input class="form-control" type="text" value="{{$dataSopir->alamat_sopir}}"
                                                name="alamat_sopir">
                                        </td>
                                        <td><input class="form-control" type="text"
                                                value="{{$dataSopir->keterangan_sopir}}" name="keterangan_sopir"></td>
                                        <td><input class="form-control" type="text" value="{{$dataSopir->kode_sopir}}"
                                                name="kode_sopir" required></td>
                                        <td>
                                            <button type="submit" id="saveBtn" class="btn btn-success"><i
                                                    class="fa fa-save"></i></button>
                                            <a href="/sopir" class="cancelBtn btn btn-danger"><i
                                                    class="fa fa-window-close"></i> </a>
                                        </td>
                                    </form>
                                </tr>
                                <?php $i++; ?>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>



<script>
$(document).ready(function() {
    setSelected('/sopir');

    //hide message
    if ($('#message').length) {
        $('#message').delay(4000).slideUp(1000);
    }
    $('.editBtn').click(function() {
        var id = $(this).val();
        $('#row' + id).addClass('hidden');
        $('#hidden' + id).removeClass('hidden');
    });
});
</script>


@endsection