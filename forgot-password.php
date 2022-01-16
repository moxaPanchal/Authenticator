<?php

session_start();
if (isset($_SESSION['SESSION_EMAIL'])) {
    header("Location: welcome.php");
    die();
}

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

include 'config.php';
$msg = "";

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $code = mysqli_real_escape_string($conn, md5(rand()));

    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE email='{$email}'")) > 0) {
        $query = mysqli_query($conn, "UPDATE users SET code='{$code}' WHERE email='{$email}'");

        if ($query) {        
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
                $mail->Body    = '<p>This is an automatically generated e-mail.</p><p>We have received a password reset request from your account. If you have not issued a password reset request, you can safely ignore this mail, and your account will not be affected.</p><p>To reset your password, click the link below :</p><b><a href="http://localhost/login/change-password.php?reset='.$code.'">http://localhost/login/change-password.php?reset='.$code.'</a></b><br><p>-------------------------</p><p>Sincerely,</p><p>Moxa Panchal</p>';

                $mail->send();
                echo 'Message has been sent';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
            echo "</div>";   
            $msg = "<div class='form__message form__message--info'>We've send a password reset link to your email address.</div>";
        }
    } else {
        $msg = "<div class='form__message form__message--error'>$email - This email address do not found.</div>";
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
            <h1 class="form__title">Forgot Password</h1>
            <?php echo $msg; ?>
            <div class="form__input-group">
                <input type="email" name="email" class="form__input" autofocus placeholder="Email" required>
                <div class="form__input-error-message"></div>
            </div>
            
            <button class="form__button" name="submit" type="submit">Send Reset Link</button>
            
            <p class="form__text">
            Back to! 
                <a class="form__link" href="index.php">Login</a>
            </p>
        </form>
    </div>
</body>
</html>