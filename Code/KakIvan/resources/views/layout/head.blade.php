@if (session('user') === null)
<?php 
header(url("/login")); 
?>
@endif


<script>
function formatDate(tanggal) {
    var myDate = new Date(tanggal);
    var month = ["Jan", "Febr", "Mar", "Ap", "May", "Jun",
        "Jul", "Aug", "Sept", "Oct", "Nov", "Dec"
    ];
    var getMonth = month[myDate.getMonth()];
    return myDate.getDate() + " " + getMonth + " " + myDate.getFullYear();
}



function addCommas(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function setSelected(str) {
    $(`.navbar a[href="${str}"]`).attr('id', 'selected');
}
</script>



<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- jquery -->
    <script type="text/javascript" src="{{ asset('asset/public/js/jquery.min.js') }}"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('asset/public/css/bootstrap.min.css') }}">
    <script type="text/javascript" src="{{ asset('asset/public/js/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset/public/js/bootstrap.min.js') }}"></script>

    <!-- own css -->
    <link rel="stylesheet" href="{{ asset('asset/public/css/index.css') }}">


    <!-- another add on -->
    <!-- select2 -->
    <link rel="stylesheet" href="{{ asset('asset/public/css/select2.min.css') }}">
    <script type="text/javascript" src="{{ asset('asset/public/js/select2.min.js') }}"></script>

    <!-- timePicker -->
    <script type="text/javascript" src="{{ asset('asset/public/gijgo/js/gijgo.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('asset/public/gijgo/css/gijgo.min.css') }}">

    <!-- date and range date picker -->
    <script type="text/javascript" src="{{ asset('asset/public/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset/public/js/daterangepicker.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('asset/public/css/daterangepicker.css') }}">

    <!-- another timepicker -->
    <link rel="stylesheet" type="text/css"
        href=" {{asset('asset/public/timePicker/dist/jquery-clockpicker.min.css' )}}">
    <link rel="stylesheet" type="text/css"
        href=" {{asset('asset/public/timePicker/assets/asset/public/css/github.min.css')}}">
    <script type="text/javascript" src="{{asset('asset/public/timePicker/dist/jquery-clockpicker.min.js')}}"></script>


    <!-- jQuery Modal -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Viga&display=swap" rel="stylesheet"> -->

    <!-- font -->
    <link href="https://fonts.googleapis.com/css?family=Bebas+Neue|Oswald|Viga|Vollkorn&display=swap" rel="stylesheet">

    <!-- font awesome -->
    <link href="{{asset('asset/public/awesomefont/css/fontawesome.css')}}" rel="stylesheet">
    <link href="{{asset('asset/public/awesomefont/css/brands.css')}}" rel="stylesheet">
    <link href="{{asset('asset/public/awesomefont/css/solid.css')}}" rel="stylesheet">

    <!-- dialog add on -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

    <!-- jquery modal -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izimodal/1.5.1/css/iziModal.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izimodal/1.5.1/js/iziModal.js"></script>

    @yield('head')
    <title>Index</title>
</head>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">KAK IVAN</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/jasa">Jasa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/sopir">Sopir</a>
                </li>
                <li class="nav-item logout">
                    <a href="/logout" class="nav-link">Log Out</a>
                </li>
            </ul>

        </div>
    </div>
</nav>

@yield('content')