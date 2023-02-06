<?php
// Session Usage
session_start();
// Kick not logged in users
if (!isset($_SESSION['loggedin'])) {
	header('Location: ../index.html');
	exit;
}
// Welcome to acadcalendar
echo "<script> alert('Loading, Please Wait');</script>";
sleep(15);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Acadcalendar - Admin</title>

    <!-- Favicons -->
    <link href="../assets/img/favicon.png" rel="icon">
    <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="../assets/css/web_style.css" rel="stylesheet">

    <script src="../assets/js/jquery-3.6.0.min.js"></script>
</head>

<body>
    <!-- Header -->
         <header id="header" class="header fixed-top">
        <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
       <!-- .navbar -->
          <a href="#" class="logo d-flex align-items-center">
            <img src="../assets/img/logo.png" alt="">
            <span>Acadcalendar</span>
          </a>
          <nav id="navbar" class="navbar">
            <ul>
              <li><a class="nav-link scrollto active" href="admin_profile.php">Profile</a></li>
              <li><a class="nav-link scrollto" href="admin_logout.php">Logout</a></li>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
          </nav>
        </div>
      </header>
    <!-- End Header -->

    <section class="d-flex align-items-center" style="background-image: url('../assets/img/hero-bg.png'); height: 100vh;">
        <div class="container">
          <div class="row">
            <div class="card rounded-2">
              <div class="card-body p-4 p-md-5">
                    <h3 class="mb-2 pb-2 mb-md-2 px-md-2">Landing Page</h3>
                    <hr>
                    <p>Welcome back, <a href="#"><?=$_SESSION['name']?>!</a></p>
                    <p> Click Here to Access your <a href="./calendar/event_calendar.php">Event Calendar</a></p>
                </div>
              </div>
          </div>
        </div>
    </section>

</body>
    <!-- Vendor JS Files -->
    <script src="../assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="../assets/vendor/aos/aos.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="../assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>

    <!-- Main JS File -->
    <script src="../assets/js/web_main.js"></script>

    <!-- Welcome Once -->
    <script>
    var init = function() {
          var alertedAdmin = localStorage.getItem('alertedAdmin') || '';
          if (alertedAdmin != 'yes') {
              alert("Welcome to Acadcalendar - Admin!");
              localStorage.setItem('alertedAdmin','yes');
          }
          else{
             //Welcome Again
            alert("Welcome Back - Admin!");
          }
      }
    setTimeout(function(){
      $(document).ready(init);
    }, 2500);
    </script>
</html>