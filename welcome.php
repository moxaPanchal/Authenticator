<?php
    session_start();
    if (!isset($_SESSION['SESSION_EMAIL'])) {
        header("Location: index.php");
        die();
    }

    include 'config.php';
    $msg = "";

    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='{$_SESSION['SESSION_EMAIL']}'");

    if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>

    <link rel="shortcut icon" href="/assets/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="main.css">
</head>

<body>
    <div class="container">
        <h1 class="form__title form__title"><img src="https://img.icons8.com/ios-glyphs/30/000000/user--v1.png" /><?php echo "Welcome " . $row['name'] ?></h1>
        <h3 class="form__title" >You're logged in</h3>
        <a href="logout.php" class="form__button--style" ><button class="form__button" name="submit" type="submit">Logout</button></a>
       
    </div>

</body>

</html>