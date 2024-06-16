<?php
session_start();

// Handle check_login query parameter
if (isset($_GET['check_login'])) {
    echo isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true ? 'true' : 'false';
    exit();
}

// Database connection
require_once "dbcon.php";

// Base SQL query
$sql = "SELECT rooms.room_id, rooms.room_number, rooms.type, rooms.location, rooms.price, hotels.name AS hotel_name, rooms.hotel_id
        FROM rooms
        INNER JOIN hotels ON rooms.hotel_id = hotels.hotel_id
        LEFT JOIN reservation ON rooms.room_id = reservation.room_id
        WHERE reservation.room_id IS NULL";

// Handle location filter
if (isset($_GET['location']) && $_GET['location'] !== 'All') {
    $location = $conn->real_escape_string($_GET['location']);
    $sql .= " AND hotels.name = '$location'";
}

// Handle type filter
if (isset($_GET['type']) && $_GET['type'] !== 'All') {
    $type = $conn->real_escape_string($_GET['type']);
    $sql .= " AND rooms.type = '$type'";
}

$result = $conn->query($sql);

// Check for errors
if (!$result) {
    echo "Error fetching rooms: " . $conn->error;
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rooms | Lagoon Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">

    <style>
        /*
        Component/elemnt color: 663AB5
        Background color: white
        Button color: 6947BB / 381F72
        cards: #381F72

        */

        * {
            font-family: 'Poppins', sans-serif;
        }

        .navbar {
            background: #381F72;
        }

        .nav-item {
            margin-right: 20px;
        }

        #navbarSupportedContent {
            margin-left: 270px;
        }

        /* Button Main Design */
        .custom-bg {
            background-color: #6947BB;
            color: white;
            transition: all .4s ease;
        }

        .custom-bg:hover {
            background-color: #6947BB;
            color: white;
            opacity: 80%;
        }

        .custom-bg1 {
            /* For The butoon in the Cards*/
            background-color: #381F72;
            color: white;
            transition: all .4s ease;
        }

        .custom-bg1:hover {
            /* For The butoon in the Cards*/
            background-color: #381F72;
            color: white;
            opacity: 80%;
        }

        .card {
            border: none;
            outline: none;
            background: #381F72;
        }

        .card-title {
            color: #6947BB;
            font-weight: 650;
            text-align: justify;
        }

        .card-title1 {
            color: black;
            font-weight: 650;
            text-align: justify;
        }

        .card-text {
            color: white;
            font-weight: 500;
            text-align: justify;
        }

        /* Button Secondary Design */
        .custom-outline {
            margin-left: 10px;
            border: 1px solid #6947BB;
            background: none;
            color: white;
        }

        .custom-outline:hover {
            border: 1px solid #6947BB;
            background: #6947BB;
            transition: .4s ease;
            color: white;
        }

        .custom-outline1 {
            margin-left: 10px;
            border: 1px solid #381F72;
            background: none;
            color: #381F72;
        }

        .custom-outline1:hover {
            border: 1px solid #381F72;
            background: #381F72;
            transition: .4s ease;
            color: white;
        }

        .modal-title {
            font-size: 30px;
            color: #381F72;
            font-weight: 600;
        }

        .modal-body {
            text-align: left;
        }

        .conta {
            background: none;
        }

        #about_us {
            margin-top: 85px;
        }

        .badge {
            background: #381F72;
        }

        .main-content {
            height: calc(100vh - 120px);
            /* Adjust height as needed */
            overflow-y: auto;
        }

        @media screen and (max-width: 575px) {

            /*Just incase needed extra responsive*/
            #navbarSupportedContent {
                margin-left: 0px;
            }
        }
    </style>
</head>

<body style="background: #FAF9F6;">
    <!-- Nav Bar-->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand me-5 fw-bold fs-4 text-light" href="index.php">Lagoon Hotel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <box-icon name='menu' color='#ffffff'></box-icon>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ">
                    <li class="nav-item">
                        <a class="nav-link active text-light" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="#rooms">Rooms</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="#about_us">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="#contact_us">Contact Us</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <a href="logout_func.php"><box-icon name='power-off' color='#ffffff' size="md"></box-icon></a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Header-->
    <div class="my-4 px-4 mb-4">
        <h1 style="text-align: center; font-size: 50px; color: #381F72; font-weight: 600;"> Available Rooms </h1>
    </div>

    <!--Left Menu-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-12 mb-lg-0 mb-4 px-lg-4">
                <nav class="navbar navbar-expand-lg rounded">
                    <div class="container-fluid flex-lg-column align-items-stretch">
                        <!--Filtering-->
                        <h4 class="navbar-brand text-center text-white" style="font-weight:600; font-size: 25px"> Filter</h4>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidemenu" aria-controls="sidemenu" aria-expanded="false" aria-label="Toggle navigation">
                            <box-icon name='menu' color='#ffffff'></box-icon>
                        </button>
                        <div class="collapse flex-column navbar-collapse" id="sidemenu">
                            <div class="p-1 mb-1 rounded text-white">
                                <form action="rooms.php" method="get">
                                    <h5 class="mb-3" style="font-size: 18px; font-weight:600;">Location</h5>
                                    <select class="form-select shadow-none" name="location">
                                        <option <?php if (!isset($_GET['location']) || $_GET['location'] === 'All') echo 'selected'; ?> value="All">All</option>
                                        <option <?php if (isset($_GET['location']) && $_GET['location'] === 'Sunset Inn') echo 'selected'; ?> value="Sunset Inn">Sunset Inn</option>
                                        <option <?php if (isset($_GET['location']) && $_GET['location'] === 'City Central') echo 'selected'; ?> value="City Central">City Central</option>
                                        <option <?php if (isset($_GET['location']) && $_GET['location'] === 'Mountain View') echo 'selected'; ?> value="Mountain View">Mountain View</option>
                                        <option <?php if (isset($_GET['location']) && $_GET['location'] === 'Lake Resort') echo 'selected'; ?> value="Lake Resort">Lake Resort</option>
                                    </select>

                                    <h5 class="mb-3" style="font-size: 18px; font-weight:600;">Type Of Room</h5>
                                    <select class="form-select shadow-none" name="type">
                                        <option <?php if (!isset($_GET['type']) || $_GET['type'] === 'All') echo 'selected'; ?> value="All">All</option>
                                        <option <?php if (isset($_GET['type']) && $_GET['type'] === 'Standard Room') echo 'selected'; ?> value="Standard Room">Standard Room</option>
                                        <option <?php if (isset($_GET['type']) && $_GET['type'] === 'Deluxe Room') echo 'selected'; ?> value="Deluxe Room">Deluxe Room</option>
                                        <option <?php if (isset($_GET['type']) && $_GET['type'] === 'Penthouse Room') echo 'selected'; ?> value="Penthouse Room">Penthouse Room</option>
                                    </select>

                                    <button type="submit" class="mt-3 btn ps-5 pe-5 custom-bg">Search</button>
                                </form>

                            </div>
                        </div>
                </nav>
            </div>
            <!--Main-->
            <div class="col-lg-9 col-md-12 px-4 main-content">
                <!--Sample Rooms (with edit with bacn end soon)-->
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <div class="card mb-4 border-0 shadow">
                        <div class="row g-0 p-3 align-items-center">
                            <div class="col-md-5 mb-lg-0 mb-md-0 mb-3">
                                <!-- Image -->
                                <!-- Adjust the image source based on your requirements -->
                                <?php
                                // Determine the image name based on the hotel id
                                $imageName = '';
                                if (isset($row['hotel_id'])) {
                                    switch ($row['hotel_id']) {
                                        case 1:
                                            $imageName = '1.jpg';
                                            break;
                                        case 2:
                                            $imageName = '5.jpg';
                                            break;
                                        case 3:
                                            $imageName = '7.jpg';
                                            break;
                                        default:
                                            // Default image name if hotel id doesn't match any case
                                            $imageName = 'default.jpg';
                                            break;
                                    }
                                } else {
                                    // Default image name if hotel_id is not set in $row
                                    $imageName = 'default.jpg';
                                }
                                ?>
                                <img src="admin_dashboard/uploads/<?php echo $imageName; ?>" class="img-fluid rounded-start" alt="Room Image">
                            </div>
                            <div class="col-md-5 px-lg-3 px-md-3 px-0">
                                <h4 style="color: white; font-weight:600;"><?php echo $row['type']; ?> | Room #<?php echo $row['room_number']; ?></h4>
                                <div class="features mb-3">
                                    <h6 class="mb-1" style="color: white; font-weight:600;">Hotel</h6>
                                    <span class="badge rounded-pill text-white mb-3 tex-wrap lh-base"><?php echo $row['hotel_name']; ?></span>

                                    <h6 class="mb-1" style="color: white; font-weight:600;">Location</h6>
                                    <span class="badge rounded-pill text-white mb-3 tex-wrap lh-base"><?php echo $row['location']; ?></span>
                                </div>
                            </div>
                            <div class="col-md-2 text-center pe-2">
                                <h5 class="card-title text-center text-white mb-4">PHP <?php echo $row['price']; ?></h5>
                                <button class="btn btn text-light w-100 custom-bg mb-2 ms-1 ms-md-3 book-now-btn" data-room-number="<?php echo $row['room_number']; ?>" data-room-type="<?php echo $row['type']; ?>" data-hotel-name="<?php echo $row['hotel_name']; ?>" data-location="<?php echo $row['location']; ?>" data-price="<?php echo $row['price']; ?>" data-room-id="<?php echo $row['room_id']; ?>" type="button">
                                    Book Now
                                </button>

                            </div>
                        </div>
                    </div>
                <?php } ?>

                <!-- other room cards go here -->
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Booking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="process_booking.php" method="POST">
                        <div class="mb-3">
                            <label for="customer-name" class="form-label">Full Name:</label>
                            <input type="text" class="form-control" id="customer-name" name="full_name">
                        </div>
                        <div class="mb-3">
                            <label for="check-in-date" class="form-label">Check In:</label>
                            <input type="date" class="form-control" id="check-in-date" name="check_in_date">
                        </div>
                        <div class="mb-3">
                            <label for="check-out-date" class="form-label">Check Out:</label>
                            <input type="date" class="form-control" id="check-out-date" name="check_out_date">
                        </div>
                        <input type="hidden" id="room_id" name="room_id">
                        <button type="submit" class="btn custom-bg mb-3" id="bookNowBtn">Book</button>
                    </form>
                    <h5>Room Details:</h5>
                    <div class="container mt-3">
                        <div class="col-lg-4">
                            <p>Room Number: <span id="modal-room-number" style="font-weight: bolder;"></span></p>
                        </div>
                        <div class="col-lg-8">
                            <p>Room Type: <span id="modal-room-type" style="font-weight: bolder;"></span></p>
                        </div>
                        <div class="col-lg-8">
                            <p>Hotel Location: <span id="modal-location" style="font-weight: bolder;"></span></p>
                        </div>
                        <div class="col-lg-8">
                            <p>Price: <span id="modal-price" style="font-weight: bolder;"></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bookNowButtons = document.querySelectorAll('.book-now-btn');
            const modal = new bootstrap.Modal(document.getElementById('staticBackdrop'));

            bookNowButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    fetch('rooms.php?check_login=true')
                        .then(response => response.text())
                        .then(isLoggedIn => {
                            console.log('Login status:', isLoggedIn); // Debug statement
                            if (isLoggedIn === 'true') {
                                // Get room details from data attributes
                                const roomNumber = this.getAttribute('data-room-number');
                                const roomType = this.getAttribute('data-room-type');
                                const hotelName = this.getAttribute('data-hotel-name');
                                const location = this.getAttribute('data-location');
                                const price = this.getAttribute('data-price');
                                const roomId = this.getAttribute('data-room-id'); // Assuming this attribute is set in your PHP loop

                                // Populate modal with room details
                                document.getElementById('modal-room-number').textContent = roomNumber;
                                document.getElementById('modal-room-type').textContent = roomType;
                                document.getElementById('modal-location').textContent = location;
                                document.getElementById('modal-price').textContent = 'PHP ' + price;

                                // Set hidden input value for room_id in the booking form
                                document.getElementById('room_id').value = roomId;

                                // Show the modal
                                modal.show();
                            } else {
                                // Redirect to login page or handle authentication status
                                window.location.href = 'login.php';
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            });
        });
    </script>
</body>

</html>
