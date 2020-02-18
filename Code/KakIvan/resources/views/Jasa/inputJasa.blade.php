@extends('layout.head')

@section('content')

<div class=" container-fluid">
    <div class="row">
        <div class="col-sm content">
            <div class="title">
                <h2>Input Jasa</h2>
            </div>
            <div class="inputform">
                <form action="/jasa" method="post" class="jasa">
                    @csrf
                    <div class="form-group">
                        <div class="form-group">
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="notelp" name="notelp" placeholder="No Handphone"
                                required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat">
                        </div>
                        <div class="form-group">
                            <select class="custom-select" id="status" name="status">
                                <option value="Aktif" selected>--Status Jasa--</option>
                                <option value="Aktif">Aktif</option>
                                <option value="Pasif">Pasif</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <textarea name="keterangan" class="form-control" id="keterangan" cols="100%" rows="3"
                                placeholder="Keterangan"></textarea>
                        </div>
                        <div class="button" style="text-align : right">
                            <button type="submit" class="btn btn-success">Input</button>
                            <a href="/jasa" class="btn btn-danger">Cancel</a>
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
$(document).ready(function() {
    setSelected('/jasa');
});
</script>

@endsection