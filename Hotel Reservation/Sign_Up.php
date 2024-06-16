<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lagoon Hotel | Sign Up</title>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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

        /* Szing of the content in the middle */
        .wrapper {
            width: 420px;
            background-color: #381F72;
            color: white;
            border-radius: 10px;
            padding: 45px 35px;
            box-shadow: 10px 10px 10px rgba(174, 20, 235, 0.1);
        }

        /* Design and postioning of the log in box */
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

        /*Button properties */

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
    </style>
</head>

<body>
    <div class="wrapper">
        <?php
        if (isset($_POST['submit'])) {
            $full_name = $_POST['full_name'];
            $user_name = $_POST['username'];
            $email = $_POST['email'];
            $pass = $_POST['password'];
            $con_pass = $_POST['con_password'];
            $role = "user";
            
            $pass_hash = password_hash($pass, PASSWORD_DEFAULT);
            $errors = array();

            if (!preg_match('/^[a-zA-Z0-9_]+$/', $user_name)) {
                array_push($errors, "Username should only contain letters, numbers, and underscores");
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($errors, "Email is Not Valid");
            }

            if (strlen($pass) < 8) {
                array_push($errors, "Passowrd is Not Valid");
            }

            if ($pass !== $con_pass) {
                array_push($errors, "Passowrd is not Equal");
            }

            require_once "dbcon.php"; //Data base connection
            $sql = "SELECT *  FROM users WHERE email = '$email'"; //Checking if email already exist
            $result = mysqli_query($conn,$sql);
            $count_rows = mysqli_num_rows($result);

            if($count_rows > 0){
                array_push($errors, "Email already exist");
            }

            if (count($errors) > 0) {
                foreach ($errors as  $error) {
                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>$error</strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                }
            } else {
                $sql = "INSERT INTO users(full_name, username, email, password,  role) VALUES (?, ?, ?, ?, ?)"; //Inserting dATA
                $stmt = mysqli_stmt_init($conn);
                $preparestmt = mysqli_stmt_prepare($stmt, $sql);

                if ($preparestmt) {
                    mysqli_stmt_bind_param($stmt,"sssss", $full_name, $user_name, $email, $pass_hash, $role); //INSERTING DATA P2
                    mysqli_stmt_execute($stmt);
                    echo "<div class='alert alert-success'>Sucessfuly Registered! </div>";
                    header("Location: http://localhost/Hotel%20Reservation/login.php");
                } else{
                    die("Something went wrong");
                }
            }
        }


        ?>
        <form action="Sign_Up.php" method="post">
            <h1>Lagoon Hotel</h1>
            <h2>Sign Up</h2>
            <div class="input-box">
                <input name="full_name" type="text" placeholder="Full Name" required>
                <box-icon name='user' color='#ffffff'></box-icon>
            </div>
            <div class="input-box">
                <input name="username" type="text" placeholder="Username" required>
                <box-icon name='user' color='#ffffff'></box-icon>
            </div>
            <div class="input-box">
                <input name="email" type="email" placeholder="Email" required>
                <box-icon name='envelope' color='#ffffff'></box-icon>
            </div>
            <div class="input-box">
                <input name="password" type="password" placeholder="Password" required>
                <box-icon name='lock-alt' color='#ffffff'></box-icon>
            </div>
            <div class="input-box">
                <input name="con_password" type="password" placeholder="Confirm Password" required>
                <box-icon name='lock-alt' color='#ffffff'></box-icon>
            </div>
            <button type="submit" class="btn" name="submit" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Sign Up</button>
            <div class="Register">
                <p>Already Have an Account? <a href="login.php">Log In Here</a></p>
            </div>
        </form>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>