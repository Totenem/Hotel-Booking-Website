<?php
session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_logged_in']) || $_SESSION['role'] != 'admin') {
    header("Location: admin_login.php");
    exit;
}

require_once "dbcon.php"; // Include your database connection script

// Query to get room counts by type
$room_counts = [
    'Standard Room' => 0,
    'Deluxe Room' => 0,
    'Suite Room' => 0,
    'Penthouse Room' => 0,
];

$sql = "SELECT type, COUNT(*) as count FROM rooms GROUP BY type";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Ensure the type from the database matches the keys in the array
        switch (strtolower($row['type'])) {
            case 'standard room':
                $room_counts['Standard Room'] = $row['count'];
                break;
            case 'deluxe room':
                $room_counts['Deluxe Room'] = $row['count'];
                break;
            case 'suite room':
                $room_counts['Suite Room'] = $row['count'];
                break;
            case 'penthouse room':
                $room_counts['Penthouse Room'] = $row['count'];
                break;
        }
    }
}

$total_available = array_sum($room_counts);

$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Lagoon Hotels | Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <style>
        body {
            display: flex;
            height: 100vh;
            margin: 0;
            background-color: rgb(204, 207, 210);
            font-family: "Poppins", sans-serif;
        }

        #blue-part {
            width: 35%;
            height: 100vh;
            /* Make it fit the viewport height */
            background-color: #663ab5;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: fixed;
            /* Make it fixed */
            top: 0;
            /* Align it to the top */
            left: 0;
            /* Align it to the left */
        }

        #home-label {
            margin-top: 20px;
            font-weight: bold;
            font-size: 35px;
            color: rgb(224, 212, 235);
        }

        #avail-label {
            margin-top: 20px;
            font-weight: bold;
            font-size: 35px;
            color: rgb(224, 212, 235);
            align-items: center;
            justify-content: center;
            display: flex;
        }

        #mid-label {
            margin-top: 20px;
            font-weight: bold;
            font-size: 35px;
            color: rgb(120, 74, 163);
        }

        .side-group {
            display: flex;
            flex-wrap: wrap;
            margin-top: 50px;
        }

        .side {
            background-color: #381f72;
            width: 100%;
            height: 70px;
            border: 0.5px solid rgb(175, 207, 231);
            border-radius: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 20px;
            color: #e3eff3;
            font-size: 20px;
            transition: background-color 0.3s ease;
            box-shadow: 3px 3px 6px rgba(159, 154, 169, 0.7);
            text-decoration: none;
        }

        .side:hover {
            background-color: #b6a3e1;
            color: #fff;
        }

        .side img {
            margin-right: 10px;
            height: 30px;
            width: 30px;
        }

        .box-group {
            width: 65%;
            /* Adjusted to fit remaining width */
            margin-left: 35%;
            /* Added to push it right of the fixed menu */
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-content: baseline;
        }

        .box {
            width: 25%;
            height: 150px;
            background-color: #663ab5;
            border: 1px solid #87ceeb;
            box-shadow: 6% 6% 8% rgba(106, 52, 220, 0.5);
            margin-top: 0.5%;
            margin-bottom: 0.1px;
            margin-right: 20px;
            margin-left: 25px;
            border-radius: 30px;
            align-content: center;
            padding-left: 20px;
            margin: 20px;
        }

        .vbox {
            width: 100%;
            height: 80px;
            background-color: #663ab5;
            border: 1px solid #87ceeb;
            border-radius: 5%;
            box-shadow: 3px 3px 4px rgba(106, 52, 220, 0.5);
            margin-top: 25px;
            margin-right: 20px;
            margin-left: 25px;
            border-radius: 30px;
            justify-content: center;
            align-items: center;
        }

        .box-label {
            font-size: 20px;
            color: #ffffff;
            align-items: center;
            justify-content: center;
            display: flex;
            margin-top: 20px;
        }

        .box-number {
            font-size: 30px;
            font-weight: bold;
            display: flex;
            margin-top: 10%;
            justify-content: center;
            align-items: center;
        }

        @media screen and (max-width: 780px) {
            #home-label {
                font-size: 20px;
            }

            #avail-label {
                font-size: 30px;
            }

            .side {
                font-size: 20px;
            }

            .side img {
                margin-right: 0;
            }

            .side span {
                display: none;
            }
        }

        @media screen and (max-width: 880px) {
            .box {
                width: 100%;
                height: 300px;
                background-color: #663ab5;
                border: 1px solid #87ceeb;
                box-shadow: 6% 6% 8% rgba(106, 52, 220, 0.5);
                margin-top: 0.5%;
                margin-bottom: 0.1px;
                margin-right: 20px;
                margin-left: 25px;
                border-radius: 30px;
                align-content: center;
                padding-left: 20px;
                margin: 20px;
            }

            .box-label {
                font-size: 25px;
                color: #ffffff;
                align-items: center;
                justify-content: center;
                display: flex;
                margin-top: 20px;
            }

            .box-number {
                font-size: 40px;
                font-weight: bold;
                display: flex;
                margin-top: 10%;
                justify-content: center;
                align-items: center;
            }
        }
    </style>
</head>

<body>
    <div id="blue-part">
        <div id="home-label">LAGOON HOTEL</div>
        <div class="side-group">
            <a class="side" href="adding_rooms.php"><img src="img/add.png" /><span>Add Rooms</span></a>
            <a class="side" href="update_rooms.php"><img src="img/update.png" /><span>Update Room</span></a>
            <a class="side" href="users.php"><img src="img/user.png" /><span>Users</span></a>
            <a class="side" href="ratings_and_reviews.php"><img src="img/rate.png" /><span>Ratings & Review</span></a>
        </div>
    </div>
    <div class="box-group">
        <div class="vbox">
            <div id="avail-label">AVAILABLE ROOMS</div>
        </div>
        <div class="box">
            <div class="box-label">STANDARD ROOM</div>
            <div class="box-number"><?php echo $room_counts['Standard Room']; ?></div>
        </div>
        <div class="box">
            <div class="box-label">DELUXE ROOM</div>
            <div class="box-number"><?php echo $room_counts['Deluxe Room']; ?></div>
        </div>
        <div class="box">
            <div class="box-label">SUITE ROOM</div>
            <div class="box-number"><?php echo $room_counts['Suite Room']; ?></div>
        </div>
        <div class="box">
            <div class="box-label">PENTHOUSE ROOM</div>
            <div class="box-number"><?php echo $room_counts['Penthouse Room']; ?></div>
        </div>
        <div class="box">
            <div class="box-label">TOTAL AVAILABLE</div>
            <div class="box-number"><?php echo $total_available; ?></div>
        </div>
    </div>
</body>

</html>
