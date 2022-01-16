<?php

$msg = "";

include 'config.php';

if (isset($_GET['reset'])) {
    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE code='{$_GET['reset']}'")) > 0) {
        if (isset($_POST['submit'])) {
            $password = mysqli_real_escape_string($conn, md5($_POST['password']));
            $confirm_password = mysqli_real_escape_string($conn, md5($_POST['confirm-password']));

            if ($password === $confirm_password) {
                $query = mysqli_query($conn, "UPDATE users SET password='{$password}', code='' WHERE code='{$_GET['reset']}'");

                if ($query) {
                    header("Location: index.php");
                }
            } else {
                $msg = "<div class='form__message form__message--error'>Password and confirm Password do not match</div>";
            }
        }
    } else {
        $msg = "<div class='form__message form__message--error'>Reset Link do not match.</div>";
    }
} else {
    header("Location: forgot-password.php");
}

?>

<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="shortcut icon" href="/assets/favicon.ico">
    <link rel="stylesheet" href="main.css" type="text/css" media="all" />
</head>
<body>
    <div class="container">
        <form class="form" action="" method="POST">
            <h1 class="form__title">Change Password</h1>
            <?php echo $msg; ?>

            <div class="form__input-group">
                <input type="password" name="password" class="form__input" autofocus placeholder="Password" required>
             
            </div>
            <div class="form__input-group">
                <input type="password" name="confirm-password" class="form__input" autofocus placeholder="Confirm Password" required>
              
            </div>
            <button class="form__button" name="submit" type="submit">Change Password</button>

            <p class="form__text">
            Back to! 
                <a class="form__link" href="index.php">Login</a>
            </p>
        </form>
    </div>
</body>
</html>