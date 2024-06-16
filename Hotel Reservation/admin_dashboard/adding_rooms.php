<?php
session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_logged_in']) || $_SESSION['role'] != 'admin') {
    header("Location: admin_login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  require_once "dbcon.php"; // Database connection

  $room_number = $_POST['room_number'];
  $room_type = $_POST['room_type'];
  $hotel_name = $_POST['hotel_name'];
  $location = $_POST['location'];
  $price = $_POST['price'];
  
  // Fetch hotel_id based on hotel name
  $hotel_query = "SELECT hotel_id FROM hotels WHERE name = ?";
  $stmt_hotel = $conn->prepare($hotel_query);
  $stmt_hotel->bind_param("s", $hotel_name);
  $stmt_hotel->execute();
  $stmt_hotel->store_result();
  
  if ($stmt_hotel->num_rows > 0) {
    $stmt_hotel->bind_result($hotel_id);
    $stmt_hotel->fetch();
    
    $image_path = 'C:\xampp\htdocs\Hotel Reservation\uploads' . basename($_FILES['fileToUpload']['name']);

    if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $image_path)) {
      // Insert into database using prepared statement to prevent SQL injection
      $stmt = $conn->prepare("INSERT INTO rooms (room_number, type, hotel_id, hotel_name, location, price, image_path) VALUES (?, ?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("ssissss", $room_number, $room_type, $hotel_id, $hotel_name, $location, $price, $image_path);

      if ($stmt->execute()) {
        echo "<div class='alert alert-success mt-3'>New room added successfully</div>";
      } else {
        echo "<div class='alert alert-danger mt-3'>Error: " . $stmt->error . "</div>";
      }
      $stmt->close();
    } else {
      echo "<div class='alert alert-danger mt-3'>Failed to upload image.</div>";
    }
  } else {
    echo "<div class='alert alert-danger mt-3'>Hotel not found.</div>";
  }

  $stmt_hotel->close();
  $conn->close();
}
?>



<!DOCTYPE html>
<html>

<head>
  <title>Add Rooms | Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet" />
  <style>
    * {
      font-family: "Poppins", sans-serif;
      color: #381f72;
    }

    h5 {
      font-weight: 700;
      color: black;
    }

    .btn {
      width: 150px;
    }

    .t_Area {
      resize: none;
      width: 100%;
      height: 100%;
    }

    .rNum {
      height: 40px;
      width: 100%;
    }

    body {
      display: flex;
      margin: 0;
      background-color: rgb(204, 207, 210);
    }

    #blue-part {
      width: 30%;
      height: 100vh;
      background-color: #663ab5;
      display: flex;
      flex-direction: column;
      align-items: center;
      position: fixed;
      top: 0;
      left: 0;
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
      width: 150%;
      height: 70px;
      border: 0.5px solid rgb(175, 207, 231);
      border-radius: 50px;
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 20px;
      color: #e3eff3;
      font-size: 17.5px;
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

    .flex-container {
      display: flex;
      gap: 20px;
    }

    .card-container {
      flex: 1;
    }

    .textarea-container {
      flex: 2;
      display: flex;
      flex-direction: column;
    }

    .textarea-container h3 {
      margin-bottom: 0;
    }

    .textarea-container textarea {
      flex: 1;
    }

    .custom-bg1 {
      /* For The butoon in the Cards*/
      background-color: #381f72;
      color: white;
      transition: all 0.4s ease;
      padding: 10px 30px 10px;
    }

    .custom-bg1:hover {
      /* For The butoon in the Cards*/
      background-color: #381f72;
      color: white;
      opacity: 80%;
    }

    .h2 {
      color: 381F72;
    }

    .link-class {
      text-decoration: none;
    }

    span {
      color: white;
    }

    @media screen and (max-width: 780px) {
      #home-label {
        font-size: 20px;
        margin-left: 10px;
        text-align: center;
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

    .container {
      margin-left: 30%;
      /* Adjust this value if needed to avoid overlap */
      padding: 20px;
      flex-grow: 1;
    }
  </style>
</head>

<body>
  <div id="blue-part">
    <a href="admin_page.php" id="home-link" class="link-class">
      <div id="home-label">LAGOON HOTEL</div>
    </a>
    <div class="side-group">
      <a class="side" href="adding_rooms.php">
        <img src="img/add.png" /> <span>Add Rooms</span>
      </a>
      <a class="side" href="update_rooms.php">
        <img src="img/update.png" /><span>Update Room</span>
      </a>
      <a class="side" href="users.php">
        <img src="img/user.png" /><span>Users</span>
      </a>
      <a class="side" href="ratings_and_reviews.php">
        <img src="img/rate.png" /><span>Ratings & Review</span>
      </a>
    </div>
  </div>
  <div class="container">
    <h2 style="font-weight: 700; margin-top: 25px">Add Rooms</h2>
    <form action="adding_rooms.php" method="post" enctype="multipart/form-data">
      <div class="row g-3">
        <div class="col-lg-4 mt-4">
          <h5>Room Number</h5>
          <input class="rNum form-control" type="text" id="room_number" name="room_number" required />
        </div>
        <div class="col-lg-4 mt-4">
          <h5>Type of Room</h5>
          <select class="form-select shadow-none" id="room_type" name="room_type" required>
            <option selected disabled>Select Type</option>
            <option value="Standard Room">Standard Room</option>
            <option value="Deluxe Room">Deluxe Room</option>
            <option value="Penthouse Rooms">Penthouse Rooms</option>
          </select>
        </div>
        <div class="col-lg-4 mt-4">
          <h5>Hotel Name</h5>
          <select class="form-select shadow-none" id="hotel_name" name="hotel_name" required>
            <option selected disabled>Select Hotel</option>
            <option value="Sunset Inn">Sunset Inn</option>
            <option value="Mountain View">Mountain View</option>
            <option value="City Central">City Central</option>
          </select>
        </div>
        <div class="col-lg-4 mt-4">
          <h5>Location</h5>
          <select class="form-select shadow-none" id="location" name="location" required>
            <option selected disabled>Select Location</option>
            <option value="123 Ocean Drive Miami">123 Ocean Drive Miami</option>
            <option value="456 Mountain Rd Denver">456 Mountain Rd Denver</option>
            <option value="789 Downtown Blvd, NY">789 Downtown Blvd, NY</option>
          </select>
        </div>
        <div class="col-lg-4 mt-4">
          <h5>Price</h5>
          <input class="rNum form-control" type="text" id="price" name="price" required />
        </div>
      </div>
      <div class="row g-3 mt-4">
        <div class="col-lg-4">
          <h5>Image Upload</h5>
          <input type="file" name="fileToUpload" id="fileToUpload" class="form-control" required />
        </div>
      </div>
      <button type="submit" class="btn custom-bg1 mt-2">Upload</button>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
