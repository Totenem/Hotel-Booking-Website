<?php
session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_logged_in']) || $_SESSION['role'] != 'admin') {
  header("Location: admin_login.php");
  exit;
}

require 'dbcon.php'; // Include your database connection file

// Initialize variables
$room = [
  'room_id' => '',
  'room_number' => '',
  'type' => '',
  'location' => '',
  'hotel_name' => '',
  'image' => ''
];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
  // Search for the room
  $room_id = $_POST['room_id'];

  $query = $conn->prepare("SELECT * FROM rooms WHERE room_id = ?");
  $query->bind_param("i", $room_id);
  $query->execute();
  $result = $query->get_result();

  if ($result->num_rows > 0) {
    $room = $result->fetch_assoc();
  } else {
    $error = "Room not found.";
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
  // Update room details
  $room_id = $_POST['room_id'];
  $room_number = $_POST['room_number'];
  $room_type = $_POST['room_type'];
  $location = $_POST['location'];
  $hotel_name = $_POST['hotel_name'];
  $image = $_FILES['fileToUpload']['name'];

  // Handle file upload
  if ($image) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image);
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
  } else {
    $target_file = $room['image']; // Use existing image if no new image uploaded
  }

  $query = $conn->prepare("UPDATE rooms SET room_number = ?, type = ?, location = ?, hotel_name = ?, image_path = ? WHERE room_id = ?");
  $query->bind_param("sssssi", $room_number, $room_type, $location, $hotel_name, $target_file, $room_id);
  if ($query->execute()) {
    $success = "Room updated successfully.";
  } else {
    $error = "Failed to update room.";
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Update Rooms | Admin Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <style>
    body {
      display: flex;
      height: 100vh;
      margin: 0;
      background-color: white;
      font-family: "Poppins", sans-serif;
    }

    #blue-part {
      width: 35%;
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

    .content {
      margin-left: 35%;
      padding: 20px;
      box-sizing: border-box;
      flex-grow: 1;
      overflow: auto;
    }

    h2 {
      color: #381f72;
      margin-bottom: 20px;
    }

    .form-group {
      display: flex;
      margin-bottom: 20px;
    }

    .form-group label {
      width: 150px;
      font-weight: bold;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
      flex-grow: 1;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 5px;
      margin-left: 10px;
    }

    .form-group textarea {
      height: 100px;
    }

    .buttons {
      display: flex;
      justify-content: space-between;
    }

    .buttons button {
      width: 48%;
      padding: 15px;
      background-color: #e0e0e0;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .buttons button:hover {
      background-color: #d0d0d0;
    }

    .rNum {
      height: 40px;
      width: 100%;
    }

    .custom-bg1 {
      background-color: #381f72;
      color: white;
      transition: all 0.4s ease;
    }

    .custom-bg1:hover {
      background-color: #381f72;
      color: white;
      opacity: 80%;
    }

    .custom-bg2 {
      background-color: #381f72;
      color: white;
      transition: all 0.4s ease;
      padding: 10px 30px 10px;
    }

    .custom-bg2:hover {
      background-color: #381f72;
      color: white;
      opacity: 80%;
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

    h5 {
      font-weight: 700;
    }

    .link-class {
      text-decoration: none;
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
  </style>
</head>

<body>
  <div id="blue-part">
    <a href="admin_page.php" id="home-link" class="link-class">
      <div id="home-label">LAGOON HOTEL</div>
    </a>
    <div class="side-group">
      <a class="side" href="adding_rooms.php">
        <img src="img/add.png" /><span>Add Rooms</span>
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
  <div class="content">
    <form method="post" enctype="multipart/form-data">
      <div class="container">
        <h2 style="font-weight: 600">Search Room</h2>
        <div class="row align-items-end">
          <div class="col-lg-4">
            <h5>Room ID</h5>
            <input class="rNum form-control" type="text" name="room_id" value="<?php echo htmlspecialchars($room['room_id']); ?>" required />
          </div>
          <div class="col-lg-4">
            <button type="submit" name="search" class="btn custom-bg1 mt-md-2 mt-2">Search</button>
          </div>
        </div>
        <?php if (isset($error)) {
          echo "<p style='color: red;'>$error</p>";
        } ?>
      </div>
      <div class="container">
        <h2 style="font-weight: 600" class="mt-3">New Details</h2>
        <div class="row g-3">
          <div class="col-lg-4 mt-4">
            <h5>Room Number</h5>
            <input class="rNum form-control" type="text" name="room_number" value="<?php echo htmlspecialchars($room['room_number']); ?>" required />
          </div>
          <div class="col-lg-4 mt-4">
            <h5>Type of Room</h5>
            <select class="form-select shadow-none" name="room_type" required>
              <option value="" selected disabled></option>
              <option value="Standard Room" <?php if ($room['room_type'] == 'Standard Room') echo 'selected'; ?>>Standard Room</option>
              <option value="Deluxe Room" <?php if ($room['room_type'] == 'Deluxe Room') echo 'selected'; ?>>Deluxe Room</option>
              <option value="Penthouse Rooms" <?php if ($room['room_type'] == 'Penthouse Rooms') echo 'selected'; ?>>Penthouse Rooms</option>
              <option value="All" <?php if ($room['room_type'] == 'All') echo 'selected'; ?>>All</option>
            </select>
          </div>
          <div class="col-lg-4 mt-4">
            <h5>Location</h5>
            <select class="form-select shadow-none" name="location" required>
              <option value="" selected disabled>Select Location</option>
              <option value="123 Ocean Drive Miami" <?php if ($room['location'] == '123 Ocean Drive Miami') echo 'selected'; ?>>123 Ocean Drive Miami</option>
              <option value="456 Mountain Rd Denver" <?php if ($room['location'] == '456 Mountain Rd Denver') echo 'selected'; ?>>456 Mountain Rd Denver</option>
              <option value="789 Downtown Blvd, NY" <?php if ($room['location'] == '789 Downtown Blvd, NY') echo 'selected'; ?>>789 Downtown Blvd, NY</option>
            </select>
          </div>
          <div class="col-lg-4 mt-4">
            <h5>Hotel Name</h5>
            <select class="form-select shadow-none" id="hotel_name" name="hotel_name" required>
              <option value="" selected disabled>Select Hotel</option>
              <option value="Sunset Inn" <?php if ($room['hotel_name'] == 'Sunset Inn') echo 'selected'; ?>>Sunset Inn</option>
              <option value="Mountain View" <?php if ($room['hotel_name'] == 'Mountain View') echo 'selected'; ?>>Mountain View</option>
              <option value="City Central" <?php if ($room['hotel_name'] == 'City Central') echo 'selected'; ?>>City Central</option>
            </select>
          </div>
          <div class="col-lg-4 mt-4">
            <h5>Image Upload</h5>
            <input type="file" name="fileToUpload" id="fileToUpload" class="form-control" />
            <?php if ($room['image']) {
              echo "<img src='{$room['image']}' alt='Room Image' style='width: 100px; margin-top: 10px;'>";
            } ?>
          </div>
        </div>
        <button type="submit" name="update" class="btn custom-bg2 mt-2">Update</button>
        <?php if (isset($success)) {
          echo "<p style='color: green;'>$success</p>";
        } ?>
      </div>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>