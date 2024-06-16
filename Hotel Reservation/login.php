<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_name = $_POST['user_name'];
    $password = $_POST['pass'];
    require_once "dbcon.php"; // Include your database connection script

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user_name);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        if (password_verify($password, $user["password"])) {
            // Login successful
            $_SESSION['user_logged_in'] = true;
            $_SESSION['user_id'] = $user['user_id']; // Assuming user_id is the column name in your users table
            $_SESSION['role'] = $user["role"];

            if ($user["role"] == 'user') {
                header("Location: index.php");
            } else {
               header("Location: admin_dashboard/admin_login.php");
            }
            exit();
        } else {
            $error_message = "Wrong Password!";
        }
    } else {
        $error_message = "Account not existing!";
    }

    $stmt->close();
    $conn->close();
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
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

        /* Sizing of the content in the middle */
        .wrapper {
            width: 420px;
            background-color: #381F72;
            color: white;
            border-radius: 10px;
            padding: 45px 35px;
            box-shadow: 10px 10px 10px rgba(174, 20, 235, 0.1);
        }

        /* Design and positioning of the login box */
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

        /* Button properties */
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
            margin-top: 20px;
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
        <form action="login.php" method="POST">
            <h1>Lagoon Hotel</h1>
            <h2>Log In</h2>
            <?php
            if (isset($error_message)) {
                echo "<div class='alert'>{$error_message}</div>";
            }
            ?>
            <div class="input-box">
                <input name="user_name" type="text" placeholder="Username" required>
                <box-icon name='user' color='#ffffff'></box-icon>
            </div>
            <div class="input-box">
                <input name="pass" type="password" placeholder="Password" required>
                <box-icon name='lock-alt' color='#ffffff'></box-icon>
            </div>
            <button name="login" type="submit" class="btn">Log In</button>
            <div class="Register">
                <p>Don't have an account? <a href="Sign_Up.php">Sign Up Here</a></p>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>
