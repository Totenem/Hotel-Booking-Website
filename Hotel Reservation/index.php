<?php
session_start();
/*var_dump($_SESSION); // Debug line to inspect session variables*/

// Handle check_login query parameter
if (isset($_GET['check_login'])) {
    echo isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true ? 'true' : 'false';
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lagoon Hotel | Home</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <style>
    /*
        Component/elemnt color: #663AB5
        Background color: white
        Button color: #6947BB / #381F72
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
      border: 1px solid #6947BB;
      background: none;
      color: #381F72;
    }

    .custom-outline1:hover {
      border: 1px solid #6947BB;
      background: #6947BB;
      transition: .4s ease;
      color: white;
    }

    .conta {
      background: none;
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

    #about_us {
      margin-top: 85px;
    }

    #carousel {
      margin-top: 75px;
    }

    #rating {
      background: none;
    }

    #ayokona {
      color: white;
      font-size: 65px;
      margin-top: 20%;
      margin-bottom: 5%;
    }

    .badge {
      background: #381F72;
    }

    .form-avail {
      margin-top: -70px;
      z-index: 2;
    }

    #navbarSupportedContent {
      margin-left: 270px;
    }

    iframe {
      border: #381F72 2px solid;
    }

    /* Reponsiveness for small devices*/
    @media screen and (max-width: 575px) {
      .form-avail {
        margin-top: 0px;
      }

      .header-responsive {
        margin-bottom: 10px;
      }

      #button-main {
        margin-bottom: 10px;
        margin-left: 0px
      }

      #ayokona {
        font-size: 30px;
      }

      .nav-item {
        margin-right: 0px;
      }

      #navbarSupportedContent {
        margin-left: 0px;
      }

      .respo-our-rooms {
        margin-top: 15px;
        margin-left: 25px;
      }

      .respo-img-aboutus {
        margin-left: 73px;
      }

      .respo-aboutus {
        text-align: center;
        font-size: xx-large;
      }
    }
  </style>

</head>

<body style="background: #FAF9F6;">
  <!--Navbar-->
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
  <!-- Header Image-->
  <div class="header-responsive container-fluid" style="background: #381F72;">
    <div class="row justify-content-center">
      <div class="col-6 p-3">
        <h1 class="fw-bold" id="ayokona">Enjoy Paradise In Lagoon Hotel</h1>
        <button type="button" class="btn ps-4 pe-4 custom-bg shadow-lg" id="button-main" onclick="window.location.href='http://localhost/Hotel%20Reservation/rooms.php';">Book Now</button>
        <button class="btn ps-4 pe-4 custom-outline" id="button-main" onclick="window.location.href='#rooms'">Learn More</button>
      </div>
      <div class="col-6 text-center">
        <img src="img/Header Img.png" class="img-fluid" style="max-height: 85%; min-height:80%;">
      </div>
    </div>
  </div>

  <!--Checking Rooms-->
  <div class="container form-avail" id="bookings">
    <div class="row">
      <div class="text-white col-lg-12 p-4 shadow" style="background: #663AB5; border-radius: 15px;">
        <h4 style="font-weight: 500;" class="mb-1">Check Available Rooms</h4>
        <form>
          <div class="row align-items-end">
            <div class="col-lg-5 mb-3">
              <label class="form-label mt-3" style="font-weight: 600;">Location</label>
              <select class="form-select shadow-none">
                <option selected></option>
                <option value="1">Sunset Inn</option>
                <option value="2">Mountain View</option>
                <option value="3">City Central</option>
                <option value="4">All</option>
              </select>
            </div>
            <div class="col-lg-5 mb-3">
              <label class="form-label mt-3" style="font-weight: 600;">Type Of Room</label>
              <select class="form-select shadow-none">
                <option selected></option>
                <option value="1">Standard Room</option>
                <option value="2">Deluxe Room</option>
                <option value="3">Penthouse Rooms</option>
                <option value="4">All</option>
              </select>
            </div>
            <div class="col-lg-1 mb-lg-3 mt-2">
              <button type="button" class="btn ps-5 pe-5 custom-bg1 shadow-lg">Search</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!--Rooms-->

  <h1 class="mt-5 pt-4 mb-5 text-center fw-bold" style="font-size: 50px; color: #6947BB;" id="rooms">Our Rooms</h1>

  <div class="container-fluid">
    <div class="respo-our-rooms row align-items-center">
      <div class="respo-our-rooms col-lg-3 col-md-6"> <!--Standard Room Info-->
        <div class="card border-0 ms-4 p-3 shadow-lg" style="width: 18rem;">
          <img src="img/1.jpg" class="card-img-top border">
          <div class="card-body">
            <h5 class="card-title text-white">Standard</h5>
            <h6 class="card-title text-white mb-4">PHP 1,240</h6>
            <div class="features mb-4">
              <h6 class="mb-1" style="color: white; font-weight:600; ">Features</h6>
              <span class="badge rounded-pill text-white mb-3 tex-wrap lh-base">
                2 Rooms
              </span>
              <span class="badge rounded-pill text-white mb-3 tex-wrap lh-base">
                1 Bathroom
              </span>
              <span class="badge rounded-pill text-white mb-3 tex-wrap lh-base">
                1 Jacuzzi
              </span>
              <span class="badge rounded-pill text-white mb-3 tex-wrap lh-base">
                2 Sofa
              </span>

              <h6 class="mb-1" style="color: white; font-weight:600; ">Access</h6>
              <span class="badge rounded-pill text-white mb-3 tex-wrap lh-base">
                Wifi
              </span>
              <span class="badge rounded-pill text-white mb-3 tex-wrap lh-base">
                AC
              </span>
              <span class="badge rounded-pill text-white mb-3 tex-wrap lh-base">
                Gym
              </span>
              <span class="badge rounded-pill text-white mb-3 tex-wrap lh-base">
                Free 1 Night Club
              </span>
            </div>
            <div class="rating mb-4">
              <h6 class="mb-1" style="color: white; font-weight:600; ">Ratings</h6>
              <span class="badge rounded-pill" id="rating">
                <box-icon type='solid' name='star' color='#FFFF00' size="sm"></box-icon>
                <box-icon type='solid' name='star' color='#FFFF00' size="sm"></box-icon>
                <box-icon type='solid' name='star' color='#FFFF00' size="sm"></box-icon>
                <box-icon type='solid' name='star' color='#FFFF00' size="sm"></box-icon>
              </span>
            </div>
          </div>
          <div class="d-flex ">
            <button class="btn btn text-light custom-bg mb-4 ms-3" type="submit" onclick="window.location.href='rooms.php';">Book Now</button>
            <button class="btn btn text-light custom-outline mb-4 ms-3" type="submit">Learn More</button>
          </div>
        </div>

      </div>
      <div class="respo-our-rooms col-lg-3 col-md-6"> <!--Deluxe Room Info-->
        <div class="card border-0 ms-4 p-3 shadow-lg" style="width: 18rem;">
          <img src="img/7.jpg" class="card-img-top border">
          <div class="card-body">
            <h5 class="card-title text-white">Deluxe</h5>
            <h6 class="card-title text-white mb-4">PHP 2,799</h6>
            <div class="features mb-4">
              <h6 class="mb-1" style="color: white; font-weight:600; ">Features</h6>
              <span class="badge rounded-pill text-white mb-3 tex-wrap lh-base">
                2 Rooms
              </span>
              <span class="badge rounded-pill text-white mb-3 tex-wrap lh-base">
                2 Bathroom
              </span>
              <span class="badge rounded-pill text-white mb-3 tex-wrap lh-base">
                1 Jacuzzi
              </span>
              <span class="badge rounded-pill text-white mb-3 tex-wrap lh-base">
                3 Sofa
              </span>
              <span class="badge rounded-pill text-white mb-3 tex-wrap lh-base">
                1 Balcony
              </span>

              <h6 class="mb-1" style="color: white; font-weight:600; ">Access</h6>
              <span class="badge rounded-pill text-white mb-3 tex-wrap lh-base">
                Wifi
              </span>
              <span class="badge rounded-pill text-white mb-3 tex-wrap lh-base">
                AC
              </span>
              <span class="badge rounded-pill text-white mb-3 tex-wrap lh-base">
                Gym
              </span>
              <span class="badge rounded-pill text-white mb-3 tex-wrap lh-base">
                Public Pool
              </span>
              <span class="badge rounded-pill text-white mb-3 tex-wrap lh-base">
                Night Club
              </span>
            </div>
            <div class="rating mb-4">
              <h6 class="mb-1" style="color: white; font-weight:600; ">Ratings</h6>
              <span class="badge rounded-pill" id="rating">
                <box-icon type='solid' name='star' color='#FFFF00' size="sm"></box-icon>
                <box-icon type='solid' name='star' color='#FFFF00' size="sm"></box-icon>
                <box-icon type='solid' name='star' color='#FFFF00' size="sm"></box-icon>
                <box-icon type='solid' name='star' color='#FFFF00' size="sm"></box-icon>
              </span>
            </div>
          </div>
          <div class="d-flex">
            <button class="btn btn text-light custom-bg mb-4 ms-3" type="submit" onclick="window.location.href='rooms.php';">Book Now</button>
            <button class="btn btn text-light custom-outline mb-4 ms-3" type="submit">Learn More</button>
          </div>
        </div>
      </div>
      <div class="respo-our-rooms col-lg-3 col-md-6"> <!--Suite Room Info-->
        <div class="card border-0 p-3 ms-4 shadow-lg" style="width: 18rem;">
          <img src="img/5.jpg" class="card-img-top border">
          <div class="card-body">
            <h5 class="card-title text-white">Suite</h5>
            <h6 class="card-title text-white mb-4">PHP 4,500</h6>
            <div class="features mb-4">
              <h6 class="mb-1" style="color: white; font-weight:600; ">Features</h6>
              <span class="badge rounded-pill text-white mb-3 tex-wrap lh-base">
                2 Rooms
              </span>
              <span class="badge rounded-pill text-white mb-3 tex-wrap lh-base">
                2 Bathroom
              </span>
              <span class="badge rounded-pill text-white mb-3 tex-wrap lh-base">
                1 Jacuzzi
              </span>
              <span class="badge rounded-pill text-white mb-3 tex-wrap lh-base">
                4 Sofa
              </span>
              <span class="badge rounded-pill text-white mb-3 tex-wrap lh-base">
                1 Balcony
              </span>

              <h6 class="mb-1" style="color: white; font-weight:600; ">Access</h6>
              <span class="badge rounded-pill text-white mb-3 tex-wrap lh-base">
                Wifi
              </span>
              <span class="badge rounded-pill text-white mb-3 tex-wrap lh-base">
                AC
              </span>
              <span class="badge rounded-pill text-white mb-3 tex-wrap lh-base">
                Gym
              </span>
              <span class="badge rounded-pill text-white mb-3 tex-wrap lh-base">
                Private Pool
              </span>
              <span class="badge rounded-pill text-white mb-3 tex-wrap lh-base">
                VIP Club
              </span>
            </div>
            <div class="rating mb-4">
              <h6 class="mb-1" style="color: white; font-weight:600; ">Ratings</h6>
              <span class="badge rounded-pill" id="rating">
                <box-icon type='solid' name='star' color='#FFFF00' size="sm"></box-icon>
                <box-icon type='solid' name='star' color='#FFFF00' size="sm"></box-icon>
                <box-icon type='solid' name='star' color='#FFFF00' size="sm"></box-icon>
                <box-icon type='solid' name='star' color='#FFFF00' size="sm"></box-icon>
              </span>
            </div>
          </div>
          <div class="d-flex">
            <button class="btn btn text-light custom-bg mb-4 ms-3" type="submit" onclick="window.location.href='rooms.php';">Book Now</button>
            <button class="btn btn text-light custom-outline mb-4 ms-3" type="submit">Learn More</button>
          </div>
        </div>

      </div>
      <div class="respo-our-rooms col-lg-3 col-md-6"> <!--Penthouse Room Info-->
        <div class="card border-0 p-3 ms-4 shadow-lg" style="width: 18rem;">
          <img src="img/5.jpg" class="card-img-top border">
          <div class="card-body">
            <h5 class="card-title text-white">Penthouse</h5>
            <h6 class="card-title text-white mb-4">PHP 8,500</h6>
            <div class="features mb-4">
              <h6 class="mb-1" style="color: white; font-weight:600; ">Features</h6>
              <span class="badge rounded-pill text-white mb-3 tex-wrap lh-base">
                2 Rooms
              </span>
              <span class="badge rounded-pill text-white mb-3 tex-wrap lh-base">
                2 Bathroom
              </span>
              <span class="badge rounded-pill text-white mb-3 tex-wrap lh-base">
                1 Jacuzzi
              </span>
              <span class="badge rounded-pill text-white mb-3 tex-wrap lh-base">
                4 Sofa
              </span>
              <span class="badge rounded-pill text-white mb-3 tex-wrap lh-base">
                1 Balcony
              </span>

              <h6 class="mb-1" style="color: white; font-weight:600; ">Access</h6>
              <span class="badge rounded-pill text-white mb-3 tex-wrap lh-base">
                Wifi
              </span>
              <span class="badge rounded-pill text-white mb-3 tex-wrap lh-base">
                AC
              </span>
              <span class="badge rounded-pill text-white mb-3 tex-wrap lh-base">
                Gym
              </span>
              <span class="badge rounded-pill text-white mb-3 tex-wrap lh-base">
                Private Pool
              </span>
              <span class="badge rounded-pill text-white mb-3 tex-wrap lh-base">
                VIP Club
              </span>
            </div>
            <div class="rating mb-4">
              <h6 class="mb-1" style="color: white; font-weight:600; ">Ratings</h6>
              <span class="badge rounded-pill" id="rating">
                <box-icon type='solid' name='star' color='#FFFF00' size="sm"></box-icon>
                <box-icon type='solid' name='star' color='#FFFF00' size="sm"></box-icon>
                <box-icon type='solid' name='star' color='#FFFF00' size="sm"></box-icon>
                <box-icon type='solid' name='star' color='#FFFF00' size="sm"></box-icon>
              </span>
            </div>
          </div>
          <div class="d-flex">
            <button class="btn btn text-light custom-bg mb-4 ms-3" type="submit" onclick="window.location.href='rooms.php';">Book Now</button>
            <button class="btn btn text-light custom-outline mb-4 ms-3" type="submit">Learn More</button>
          </div>
        </div>

      </div>
      <div class="col-lg-12 text-center mt-5">
        <a href="http://localhost/Hotel%20Reservation/rooms.php" class="btn btn-sm custom-outline1 rounded-0 fw-bold shadow-none">More Rooms</a>
      </div>
    </div>
  </div>

  <!--About Us-->
  <div class="container-fluid mt-5 pt-4 mb-4" id="about_us">
    <h1 style="font-size: 50px; text-align: center; color: #6947BB; font-weight: 600">About Us</h1>

    <!-- About Us Information-->
    <div class="card  pb-5" style="max-width: 100%; background: none;">
      <div class="row g-0">
        <div class="respo-img-aboutus col-md-3 mt-3 ms-4">
          <img src="img/Logo.jpg" class="img-fluid rounded">
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <h2 class="respo-aboutus card-title">Lagoon Hotel</h2>
            <p class="card-text" style="color: black;">At Lagoon Hotel, we extend a heartfelt invitation to immerse yourself in a realm where comfort and luxury intertwine seamlessly. Set amidst a backdrop of awe-inspiring scenery, our hotel stands as a sanctuary of refined elegance and unmatched hospitality. Whether you seek solace in the tranquil embrace of nature or crave adventure amidst the great outdoors, Lagoon Hotel promises an unforgettable retreat that transcends the ordinary.</p>
            <p class="card-text" style="color: black;">Indulge in the epitome of relaxation within our thoughtfully designed accommodations, where every detail is meticulously crafted to cater to your every whim. From sumptuous bedding to panoramic vistas, each room and suite offers a haven of tranquility and serenity. With a wealth of world-class amenities at your fingertips, including a sparkling pool, rejuvenating spa, and exquisite dining options, every moment spent at Lagoon Hotel is a symphony of luxury and indulgence.</p>
          </div>
        </div>
      </div>
    </div>

    <!--Sectioning of Cards (Facilities and Specialties)-->
    <div class="row row-cols-1 row-cols-md-3 g-4" id="set_of_chuchu">
      <div class="col">
        <div class="card h-100" style="background: #381F72;">
          <div class="card-body p-4">
            <h2 class="card-title mb-3 text-white"><box-icon name='book' color='#FFFFFF' size="sm"></box-icon> Our Story</h2>
            <p class="card-text">Lagoon Hotel was born from a vision to redefine the hospitality experience. Situated in the heart of serene landscapes, our journey began with a commitment to providing guests with a haven of tranquility and sophistication.</p>
            <p class="card-text">Over the years, we've perfected the art of hospitality, blending modern amenities with warm, personalized service to create an unforgettable stay for every visitor.</p>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card h-100" style="background: #381F72;">
          <div class="card-body p-4">
            <h2 class="card-title mb-3 text-white"><box-icon name='heart-circle' color='#FFFFFF' size="sm"></box-icon> Our Commitment</h2>
            <p class="card-text">At Lagoon Hotel, we pride ourselves on delivering exceptional service tailored to meet the unique needs of each guest. Whether you're traveling for business or leisure, our dedicated team is here to ensure your stay exceeds every expectation.</p>
            <p class="card-text">From the moment you step through our doors, you'll be greeted with genuine warmth and hospitality, setting the stage for a truly remarkable experience.</p>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card h-100" style="background: #381F72;">
          <div class="card-body p-4">
            <h2 class="card-title mb-3 text-white"><box-icon name='briefcase-alt' color='#FFFFFF' size="sm"></box-icon> Our Service</h2>
            <p class="card-text">Indulge in the ultimate comfort with our luxurious accommodations. Each of our well-appointed rooms and suites is designed to provide a peaceful retreat, featuring plush bedding, modern amenities, and stunning views of the surrounding landscape. Whether you're seeking a romantic getaway or a family vacation, we have the perfect space to suit your needs.</p>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!--Contact Us-->
  <div class="container-fluid mt-5 pt-4 mb-4" id="contact_us">
    <h1 style="font-size: 50px; text-align: center; color: #6947BB; font-weight: 600">Contact Us</h1>
    <div class="container-fluid mt-5 pt-4 mb-4">
      <div class="row row-cols-1 row-cols-md-3 g-4" id="set_of_chuchu">
        <div class="col-lg-6">
          <div class="card bg-transparent h-100 ms-4">
            <div class="card-body p-4 ratio ratio-4x3">
              <iframe class="embed-responsive-item" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3867.9780660147408!2d121.14095087424354!3d14.196062686243737!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd63be6b01be1f%3A0x1b6471363e521f5f!2sHotel%20Marciano!5e0!3m2!1sen!2sph!4v1714713474846!5m2!1sen!2sph" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="card h-100 me-4 bg-transparent">
            <div class="card-body p-4">
              <h2 class="card-title mb-4">Location and Socials</h2>
              <h5 class="card-title1 mb-2">Address</h5>
              <div class="d-flex align-items-center mb-4">
                <box-icon name='current-location' color='#000000'></box-icon>
                <p class="card-text ms-1" style="color: black;"> National Highway First PJM Compound, Real, Calamba, 4027 Laguna</p>
              </div>
              <h5 class="card-title1 mb-2">Facebook</h5>
              <div class="d-flex align-items-center mb-4">
                <box-icon name='facebook-square' type='logo' color='#000000'></box-icon>
                <p class="card-text ms-1" style="color: black;"> Lagoon Hotels</p>
              </div>
              <h5 class="card-title1 mb-2">TikTok</h5>
              <div class="d-flex align-items-center mb-4">
                <box-icon name='tiktok' type='logo' color='#000000'></box-icon>
                <p class="card-text ms-1" style="color: black;"> @lagoon_hotels</p>
              </div>
              <h5 class="card-title1 mb-2">Instagram</h5>
              <div class="d-flex align-items-center mb-4">
                <box-icon name='instagram' type='logo' color='#000000'></box-icon>
                <p class="card-text ms-1" style="color: black;">@lagoon_hotels</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>