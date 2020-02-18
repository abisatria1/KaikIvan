<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- jquery -->
    <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <script type="text/javascript" src="{{ asset('js/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <!-- font -->
    <link href="https://fonts.googleapis.com/css?family=Bebas+Neue|Oswald|Viga|Vollkorn&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Changa+One:400,400i|Libre+Franklin|Roboto|Rubik&display=swap"
        rel="stylesheet">


    <!-- font awesome -->
    <link href="{{asset('awesomefont/css/fontawesome.css')}}" rel="stylesheet">
    <link href="{{asset('awesomefont/css/brands.css')}}" rel="stylesheet">
    <link href="{{asset('awesomefont/css/solid.css')}}" rel="stylesheet">

    <title>Login</title>
</head>

<body>
    <div class="background">

    </div>
    <div class="login">
        <div class="kotak">
            <div class="bulat"><i class="fas fa-user-circle"></i></div>
            <div class="header">
                <div class="logo">
                    <h2>Kak ivan</h2>
                </div>
            </div>
            @if (session('status') == 1)
            <div class="alert alert-success" id="message">
                {{ session('message') }}
            </div>
            @else
            @if(session('status') == -1 )
            <div class="alert alert-danger" id="message">
                {{ session('message') }}
            </div>
            @endif
            @endif
            <form action="/login" method="post">
                @csrf
                <div class="wrapper">
                    <div class="icon">
                        <label for="user">
                            <i class="fas fa-user-tie"></i>
                        </label>
                    </div>
                    <div class="input">
                        <input type="text" class="form-control" id="user" name="user" placeholder="Username" required>
                    </div>
                </div>
                <div class="wrapper">
                    <div class="icon">
                        <label for="password">
                            <i class="fas fa-lock"></i>
                        </label>
                    </div>
                    <div class="input">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                            required>
                    </div>
                    <button type="submit" style="display:none" id="submitBtn"></button>
                </div>
            </form>
            <div class="button">
                <button>Login</button>
            </div>
        </div>
    </div>
</body>

</html>




<script>
$('.button button').click(function() {
    $('#submitBtn').trigger('click');
});
//hide message
if ($('#message').length) {
    $('#message').delay(4000).slideUp(1000);
}
</script>