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
    <link rel="stylesheet" href="css/signup.css">
    <title>Sign up</title>
</head>
<body>
    <div class="body-container">
        <div class="header">
            <img src="img/instagram-logo.png" alt="">
            <span class="d-block">Sign up to see photos and videos from your friends.</span>
        </div>

        <div class="form-container">
            <form action="signup" method="POST">
                @csrf
                <div class="form-floating input-div">
                    <input name="email" type="text" class="form-control input" id="floatingInput" placeholder="name@example.com">
                    <label for="floatingInput" class="input-label">Email address or phone number</label>
                </div>
                <div class="form-floating input-div">
                    <input name="name" type="text" class="form-control input" id="floatingInput" placeholder="Full name">
                    <label for="floatingInput" class="input-label">Full name</label>
                </div>
                <div class="form-floating input-div">
                    <input name="username" type="text" class="form-control input" id="floatingInput" placeholder="username">
                    <label for="floatingInput" class="input-label">Username</label>
                </div>
                <div class="form-floating input-div">
                    <input name="password" type="password" class="form-control input" id="floatingInput" placeholder="password">
                    <label for="floatingInput" class="input-label">Password</label>
                </div>
                <button type="submit" class="btn btn-primary login-btn">Sign up</button>
            </form>
        </div>

    </div>

    <div class="signup-container">
        <span>Already have an account?</span>
        <a href="{{url('/')}}">Log in</a>
    </div>

    <script src="js/bootstrap.bundle.js"></script>
</body>
</html>
