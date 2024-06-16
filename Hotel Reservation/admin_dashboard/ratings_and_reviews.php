<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ratings & Reviews | Admin Dashboard</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap"
      rel="stylesheet"
    />
    <style>
      body {
        display: flex;
        height: 100vh;
        margin: 0;
        background-color: white;
        font-family: "Poppins", sans-serif;
      }
      .content {
        flex-grow: 1;
        padding: 20px;
        box-sizing: border-box;
      }
      h1 {
        color: #381f72;
      }
      table {
        width: 100%;
        height: 500px;
        border-collapse: collapse;
        margin-top: 20px;
        background-color: #e0e0e0;
      }
      table th,
      table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
      }
      table th {
        background-color: #f2f2f2;
      }
      #blue-part {
        width: 35%;
        height: 300vh;
        background-color: #663ab5;
        display: flex;
        flex-direction: column;
        align-items: center;
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

      .link-class {
        text-decoration: none;
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
      <h1>Ratings and Reviews</h1>
      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Type of Room</th>
            <th>Rate</th>
            <th>Review</th>
          </tr>
        </thead>
        <tbody>
          <!-- Data will go here -->
        </tbody>
      </table>
    </div>
  </body>
</html>
