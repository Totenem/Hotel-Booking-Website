<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_name = $_POST['user_name'];
    $password = $_POST['pass'];
    require_once "dbcon.php"; // Database connection

    $sql = "SELECT * FROM users WHERE username = '$user_name'";
    $result = mysqli_query($conn, $sql);
    $users = mysqli_fetch_array($result, MYSQLI_ASSOC);

    if ($users) {
        if (password_verify($password, $users["password"])) {
            // Store user info in session
            $_SESSION['user_logged_in'] = true;
            $_SESSION['user_name'] = $users["username"];
            $_SESSION['role'] = $users["role"];

            // Redirect based on role
            if ($users["role"] == 'admin') {
                header("Location: admin_page.php");
            } else {
                header("Location: admin_login.php");
            }
            exit();
        } else {
            $error_message = "Wrong Password!";
        }
    } else {
        $error_message = "Account not existing!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lagoon Hotel | Log In</title>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 3;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: url('img/joshua-de-mendonca-lofi.jpg') no-repeat;
            background-size: cover;
            background-position: center;
        }

        .wrapper {
            width: 420px;
            background-color: #381F72;
            color: white;
            border-radius: 10px;
            padding: 45px 35px;
            box-shadow: 10px 10px 10px rgba(174, 20, 235, 0.1);
        }

        .wrapper h1 {
            font-size: 50px;
            text-align: center;
        }

        .wrapper h2 {
            font-size: 25px;
            text-align: center;
            margin-top: 30px;
            font-family: sans-serif;
        }

        .wrapper .input-box {
            position: relative;
            width: 100%;
            height: 50px;
            margin: 30px 0;
        }

        .input-box input {
            width: 100%;
            height: 100%;
            background: transparent;
            border: none;
            outline: none;
            border: 2px solid gray;
            border-radius: 40px;
            font-size: 16px;
            color: white;
            padding: 20px 45px 20px 20px;
        }

        .input-box input::placeholder {
            color: white;
        }

        .input-box box-icon {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 20px;
        }

        .wrapper .Register {
            font-size: 14.5px;
            text-align: center;
            margin-top: 20px;
        }

        .Register p a {
            color: white;
            text-decoration: none;
            font-weight: 600px;
        }

        .Register a {
            font-weight: 800;
        }

        .wrapper .btn {
            width: 100%;
            height: 45px;
            background: white;
            border: none;
            outline: none;
            border-radius: 45px;
            box-shadow: 0 0 10px rgba(0, 0, 0, .1);
            cursor: pointer;
            font-size: 16px;
            color: rgb(31, 30, 30);
            font-weight: 600;
        }

        .alert {
            margin-top: 10px;
            padding: 10px;
            background-color: #f44336;
            color: white;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <form action="admin_login.php" method="post">
            <h1>Lagoon Hotel</h1>
            <h2>Admin Log In</h2>
            <?php
            if (isset($error_message)) {
                echo "<div class='alert'>{$error_message}</div>";
            }
            ?>
            <div class="input-box">
                <input type="text" name="user_name" placeholder="Admin Name" required>
                <box-icon name='user' color='#ffffff'></box-icon>
            </div>
            <div class="input-box">
                <input type="password" name="pass" placeholder="Password" required>
                <box-icon name='lock-alt' color='#ffffff'></box-icon>
            </div>
            <button type="submit" class="btn">Log In</button>
            <div class="Register">
                <p>Don't have an account? <a href="sign_up.php">Sign Up Here</a></p>
            </div>
        </form>
    </div>
</body>

</html>
