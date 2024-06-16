<?php
session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_logged_in']) || $_SESSION['role'] != 'admin') {
  header("Location: admin_login.php");
  exit;
}

require 'dbcon.php'; // Include your database connection file

// Fetch all users with the role 'user'
$query = "SELECT full_name, username, password, email FROM users WHERE role = 'user'";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Users | Admin Dashboard</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
      rel="stylesheet"
    />
    <style>
      /* Add your existing CSS styles here */
      * {
        font-family: "Poppins", sans-serif;
      }
      .card-title {
        text-align: center;
        font-weight: bold;
        color: #381f72;
      }
      .card-body {
        width: 100%;
        flex-wrap: wrap;
        justify-content: center;
        color: #381f72;
      }
      body {
        display: flex;
        margin: 0;
        background-color: rgb(204, 207, 210);
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
        overflow: auto;
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
      }
      .table {
        margin-top: 20px;
        width: 100%;
        color: #381f72;
      }
      .card {
        color: #381f72;
        font-family: "Gill Sans", "Gill Sans MT", "Calibri", "Trebuchet MS", "sans-serif";
      }
      .table th,
      .table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
        color: #381f72;
      }
      .table th {
        background-color: #f2f2f2;
        height: 50px;
        color: #381f72;
      }
      .table tbody tr:hover {
        background-color: #f1f1f1;
        color: #381f72;
      }
      /* Setting specific column widths */
      .table th:nth-child(1),
      .table td:nth-child(1) {
        width: 5%;
      }
      .table th:nth-child(2),
      .table td:nth-child(2) {
        width: 25%;
      }
      .table th:nth-child(3),
      .table td:nth-child(3) {
        width: 25%;
      }
      .table th:nth-child(4),
      .table td:nth-child(4) {
        width: 10%;
      }
      .table th:nth-child(5),
      .table td:nth-child(5) {
        width: 35%;
      }
      .h1 {
        color: #381f72;
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
      .content {
        margin-left: 35%;
        padding: 20px;
        flex-grow: 1;
        overflow: auto;
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
      <h1 class="h1">Users</h1>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Username</th>
            <th scope="col">Password</th>
            <th scope="col">Email</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($result->num_rows > 0) {
            $index = 1;
            while ($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<th scope='row'>" . $index++ . "</th>";
              echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
              echo "<td>" . htmlspecialchars($row['username']) . "</td>";
              echo "<td>********</td>";
              echo "<td>" . htmlspecialchars($row['email']) . "</td>";
              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan='5'>No users found.</td></tr>";
          }
          ?>
        </tbody>
      </table>
      <h1 class="h1">Admin</h1>
      <div class="row row-cols-1 row-cols-md-4 g-4">
        <div class="col">
          <div class="card h-200 p-4">
            <img src="img/admin1.jpg" class="card-img-top" alt="..." />
            <div class="card-body">
              <h5 class="card-title">Admin 1</h5>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card h-200 p-4">
            <img src="img/admin2.jpg" class="card-img-top" alt="..." />
            <div class="card-body">
              <h5 class="card-title">Admin 2</h5>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card h-200 p-4">
            <img src="img/admin3.jpg" class="card-img-top" alt="..." />
            <div class="card-body">
              <h5 class="card-title">Admin 3</h5>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card h-200 p-4">
            <img src="img/admin4.jpg" class="card-img-top" alt="..." />
            <div class="card-body">
              <h5 class="card-title">Admin 4</h5>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
