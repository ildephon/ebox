<?php
session_start();
if(!isset($_SESSION['user'])) {
  header('Location: ../index.php');
  exit;
}
?>
<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <link rel="shortcut icon" href="../images/favicon.png" type="">
 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <title> OSBS - Online Suggestion Box System </title>

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.css" />

  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

  <!--owl slider stylesheet -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

  <!-- font awesome style -->
  <link href="../css/font-awesome.min.css" rel="stylesheet" />

  <!-- Custom styles for this template -->
  <link href="../css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="../css/responsive.css" rel="stylesheet" />

  <style>
    /* Basic button styling */
.add-staff-btn {
    display: inline-block;
    background-color: #28a745; /* Green background */
    color: white; /* Text color */
    padding: 10px 20px;
    border-radius: 50px; /* Rounded corners */
    font-size: 18px;
    font-weight: bold;
    text-transform: uppercase;
    text-decoration: none;
    transition: all 0.4s ease; /* Smooth transition */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Subtle shadow */
}

.add-staff-btn i {
    margin-right: 10px;
    transition: transform 0.4s ease; /* Smooth rotation for the icon */
}

/* Hover effect */
.add-staff-btn:hover {
    background-color: #218838; /* Darker green on hover */
    color: #fff; /* Ensure text remains white */
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3); /* Deeper shadow on hover */
}

.add-staff-btn:hover i {
    transform: rotate(360deg); /* Full rotation on hover */
}

/* Optional focus effect for accessibility */
.add-staff-btn:focus {
    outline: none;
    box-shadow: 0 0 5px 2px rgba(40, 167, 69, 0.8);
}

.add-staff-btn {
    padding: 10px 20px;
    font-size: 16px;
    background-color: #007bff;
    color: white;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.add-staff-btn i {
    margin-right: 5px;
}

.add-staff-btn:hover {
    background-color: #0056b3;
    color: white;
}

  </style>
</head>

<body class="sub_page">

  <div class="hero_area">

    <div class="hero_bg_box">
      <div class="bg_img_box">
        <!-- <img src="images/hero-bg.png" alt=""> -->
      </div>
    </div>

    
<header class="header_section">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
          <a class="navbar-brand" href="index.php">
            <span>
              OSBS - Online Suggestion Box System
            </span>
          </a>

          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class=""> </span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav  ">
              <li class="nav-item active">
                <a class="nav-link" href="home.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="pin.php"> Pinned</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="Focus.php"> Focused</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="profile.php"> Profile</a>
              </li>
              <!-- <li class="nav-item">
                <a class="nav-link" href="service.php">Services</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="why.php">Why Us</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="team.html">Team</a>
              </li> -->
              <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout<span class="sr-only">(current)</span> </a>
              </li>
              
            </ul>
          </div>
        </nav>
      </div>
    </header>
    </div>