@if (session()->has('id'))
<script>window.location = "home";</script>
@endif

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/login.css">
    <title>Login</title>
</head>
<body>
    <div class="body-container">
        <div class="header">
            <img src="img/instagram-logo.png" alt="">
        </div>

        <div class="form-container">
            <form action="login" method="POST">
                @csrf
                <input name="username" type="text" placeholder="Username or email address" class="input" >
                <input name="password" type="password" placeholder="Password" class="input" >
                <button type="submit" class="btn btn-primary login-btn">Log in</button>
            </form>
        </div>
        <a href="" class="forgot-password">Forgot your password?</a>

    </div>

    <div class="signup-container">
        <span>Don't have an account?</span>
        <a href="{{url('signup')}}">Sign up</a>
    </div>

    <script src="js/bootstrap.bundle.js"></script>
</body>
</html>
