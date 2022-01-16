<?php
    session_start();

    if (isset($_SESSION['SESSION_EMAIL'])) {
        header("Location: welcome.php");
        die();
    }

    include 'config.php';
    $msg = "";

    if (isset($_GET['verification'])) {
        if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE code='{$_GET['verification']}'")) > 0) {
            $query = mysqli_query($conn, "UPDATE users SET code='' WHERE code='{$_GET['verification']}'");
            
            if ($query) {
                $msg = "<div class='form__message form__message--success'>Account verification has been successfully completed.</div>";
            }
        } else {
            header("Location: index.php");
        }
    }

    if (isset($_POST['submit'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, md5($_POST['password']));

        $sql = "SELECT * FROM users WHERE email='{$email}' AND password='{$password}'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);

            if (empty($row['code'])) {
                $_SESSION['SESSION_EMAIL'] = $email;
                header("Location: welcome.php");
            } else {
                $msg = "<div class='form__message form__message--error'>First verify your account and try again.</div>";
            }
        } else {
            $msg = "<div class='form__message form__message--error'>Email or password do not match.</div>";
        }
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
            <h1 class="form__title">Login</h1>
            <?php echo $msg; ?>
            <div class="form__input-group">
                <input type="email" name="email" class="form__input" autofocus placeholder="Email" required>
                <div class="form__input-error-message"></div>
            </div>
            <div class="form__input-group">
                <input type="password" name="password" class="form__input" autofocus placeholder="Password" required>
                <div class="form__input-error-message"></div>
            </div>
            <button class="form__button" name="submit" type="submit">Continue</button>
            <p class="form__text">
                <a href="forgot-password.php" class="form__link">Forgot your password?</a>
            </p>
            <p class="form__text">
            Don't have an account? 
                <a class="form__link" href="register.php">Sign Up</a>
            </p>
        </form>
    </div>
</body>
</html>