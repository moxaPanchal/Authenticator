<?php
    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    session_start();
    if (isset($_SESSION['SESSION_EMAIL'])) {
        header("Location: welcome.php");
        die();
    }

    //Load Composer's autoloader
    require 'vendor/autoload.php';

    include 'config.php';
    $msg = "";

    if (isset($_POST['submit'])) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, md5($_POST['password']));
        $confirm_password = mysqli_real_escape_string($conn, md5($_POST['confirm-password']));
        $code = mysqli_real_escape_string($conn, md5(rand()));

        if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE email='{$email}'")) > 0) {
            $msg = "<div class='form__message form__message--error'>{$email} - This email already exists.</div>";
        } else {
            if ($password === $confirm_password) {
                $sql = "INSERT INTO users (name, email, password, code) VALUES ('{$name}', '{$email}', '{$password}', '{$code}')";

                $result = mysqli_query($conn, $sql);

                if ($result) {
                    echo "<div style='display: none;'>";
                    //Create an instance; passing `true` enables exceptions
                    $mail = new PHPMailer(true);

                    try {
                        //Server settings
                        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                        $mail->isSMTP();                                            //Send using SMTP
                        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                        $mail->Username   = 'developer.programmer20@gmail.com';                     //SMTP username
                        $mail->Password   = 'Webdevelopment_247';                               //SMTP password
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                        //Recipients
                        $mail->setFrom('developer.programmer20@gmail.com');
                        $mail->addAddress($email);

                        //Content
                        $mail->isHTML(true);                                  //Set email format to HTML
                        $mail->Subject = 'do-not-reply';
                        $mail->Body    = '<p>This is an automatically generated e-mail.</p><p>Thank you for creating an account with us. Please click on this link to verify your email. <b><a href="https://register--user.herokuapp.com/?verification='.$code.'">https://register--user.herokuapp.com/?verification='.$code.'</a></b></p><br><p>-------------------------</p><p>Sincerely,</p><p>Moxa Panchal</p>';

                        $mail->send();
                        
                        echo 'Message has been sent';
                    } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
                    echo "</div>";
                    $msg = "<div class='form__message form__message--info'>We've send a verification link to your email address.</div>";
                } else {
                    $msg = "<div class='form__message form__message--error'>Something went wrong.</div>";
                }
            } else {
                $msg = "<div class='form__message form__message--error'>Password and confirm Password do not match</div>";
            }
        }
    }
?>


<!DOCTYPE html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <title>Sign Up Form</title>
    <link rel="shortcut icon" href="/assets/favicon.ico">
    <link rel="stylesheet" href="main.css" type="text/css" media="all" />
</head>

<body>
    <div class="container">
        <form action="" method="POST" class="form form--hidden">
            <h1 class="form__title">Create Account</h1>
            <?php echo $msg; ?>
            <div class="form__input-group">
                <input type="text" class="form__input" name="name" autofocus placeholder="Username" value="<?php if (isset($_POST['submit'])) {echo $name;} ?>" required>
               
            </div>
            <div class="form__input-group">
                <input type="email" name="email" class="form__input" autofocus placeholder="Email Address" value="<?php if (isset($_POST['submit'])) {echo $email;} ?>" required>
              
            </div>
            <div class="form__input-group">
                <input type="password" name="password" class="form__input" autofocus placeholder="Password" required>
              
            </div>
            <div class="form__input-group">
                <input type="password" name="confirm-password" class="form__input" autofocus placeholder="Confirm password" required>
              
            </div>
            <button class="form__button" name="submit" type="submit">Continue</button>
            <p class="form__text">
                Already have an account?
                <a class="form__link" href="index.php">Log in</a>
            </p>
        </form>
    </div>
</body>
</html>