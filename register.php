<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="icon" href="favicon.ico">
    <title>Register</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="form-signin">
            <div class="logo">
                <img src="img/logo.png" alt="Logo">
            </div>
            <div class="logo-heading">TO-DO APP</div>
            <h2 class="form-heading">Register</h2>
            <hr>
            <?php
            if (isset($_SESSION['error'])) {
            echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error'] . '</div>';
            unset($_SESSION['error']);
            }
            ?>
            <form method="POST" action="register_process.php">
                <div id="sgn_u" class="form-group">
                    <input type="text" class="form-control" name="username" placeholder="Username" required="" autofocus="">
                </div>
                <div id="sgn_p" class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Password" required="">
                </div>
                <div id="sgn_p" class="form-group">
                    <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" required="">
                </div>
                <input class="btn btn-lg btn-primary btn-block sgn_btn" type="submit" value="Register">
            </form>
        </div>
    </div> <!-- /container -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
