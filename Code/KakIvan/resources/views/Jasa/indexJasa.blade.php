@extends('layout.head')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-sm content">
            <div class="header">
                <div class="judul">
                    <h2>Data Jasa</h2>
                </div>
                <div class="inputJasa">
                    <form action="/jasa/input" method="GET">
                        <button type="submit" class="custom-btn">Input
                            Jasa</button>
                    </form>
                </div>
                @if (session('status') == 1)
                <div class="alert alert-success" id="message">
                    {{ session('message') }}
                </div>
                @endif
                <div class="table-responsive-lg">
                    <table class="table table-hover table-bordered">
                        <col width="50px">
                        <col width="200px">
                        <col width="200px">
                        <col width="300px">
                        <col width="200px">
                        <col width="100px">
                        <col width="200px">
                        <col width="180px">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>No Handphone</th>
                                <th>Alamat</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                                <th>No Rekening</th>
                                <th>Button</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach($dataJasa as $jasa)
                            <tr id="baris{{$jasa->id}}">
                                <td>{{$i}}</td>
                                <td>{{$jasa->nama_jasa}}</td>
                                <td>{{$jasa->notelp_jasa}}</td>
                                <td>{{$jasa->alamat_jasa}}</td>
                                <td>{{$jasa->keterangan_jasa}}</td>
                                <td>{{$jasa->status_jasa}}</td>
                                <td>{{$jasa->norek_jasa}}</td>
                                <td>
                                    <button class="btn btn-info editBtn" value="{{$jasa->id}}"><i
                                            class="fa fa-edit"></i></button>
                                    <form action="/jasa/{{$jasa->id}}" class="formBtn" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger deleteBtn" value="{{$jasa->id}}"
                                            name="deleteBtn"
                                            onclick="return confirm('Apakah anda yakin menghapus data ini ? '); "><i
                                                class="fa fa-trash"></i></button>
                                    </form>
                                    <button class="btn btn-dark viewBtn"
                                        onclick="window.location.href = '/jasa/show/{{$jasa->id}}';"><i
                                            class="fa fa-eye"></i></button>
                                </td>
                            </tr>
                            <tr class="hidden" id="edit{{$jasa->id}}">
                                <form action="/jasa/{{$jasa->id}}" method="post">
                                    @csrf
                                    @method('put')
                                    <td>{{$i}}</td>
                                    <td><input type="text" value="{{$jasa->nama_jasa}}" class="form-control" name="nama"
                                            required></td>
                                    <td><input type="text" value="{{$jasa->notelp_jasa}}" class="form-control"
                                            name="notelp" required></td>
                                    <td><input type="text" value="{{$jasa->alamat_jasa}}" class="form-control"
                                            name="alamat"></td>
                                    <td><input type="text" value="{{$jasa->keterangan_jasa}}" class="form-control"
                                            name="keterangan">
                                    </td>
                                    <td>
                                        <?php $status = ['Aktif' , 'Pasif']; ?>
                                        <select name="status" id="status" class="custom-select">
                                            @foreach($status as $stat)
                                            @if ($stat == $jasa->status)
                                            <option value="{{$stat}}" selected>{{$stat}}</option>
                                            @else
                                            <option value="{{$stat}}">{{$stat}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="text" value="{{$jasa->norek_jasa}}" class="form-control"
                                            name="norek"></td>
                                    <td>
                                        <button type="submit" class="btn btn-success" id="saveBtn"><i
                                                class="fa fa-save"></i></button>
                                        <a href="/jasa" class="cancelBtn btn btn-danger"><i
                                                class="fa fa-window-close"></i></a>
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
    setSelected('/jasa');
    //hide message
    if ($('#message').length) {
        $('#message').delay(4000).slideUp(1000);
    }
    $('.editBtn').click(function() {
        var id = $(this).val();
        $('#baris' + id).addClass('hidden');
        $('#edit' + id).removeClass('hidden');
    });
});
</script>


@endsection