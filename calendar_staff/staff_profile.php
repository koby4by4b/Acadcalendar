<?php
// Session Usage
session_start();
// Kick not logged in users
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
$DATABASE_HOST = 'sql311.epizy.com';
$DATABASE_USER = 'epiz_32769631';
$DATABASE_PASS = 'x';
$DATABASE_NAME = 'epiz_32769631_acadcalendar';
//$DATABASE_HOST = 'localhost';
//$DATABASE_USER = 'root';
//$DATABASE_PASS = '';
//$DATABASE_NAME = 'acadcalendar';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// Database gather through sessions
$stmt = $con->prepare('SELECT firstname, lastname, email, phone, course, year FROM acad_list WHERE id = ?');
// Use ID to get info
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($firstname, $lastname, $email, $phone, $course, $year);
$stmt->fetch();
$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Acadcalendar - Staff Profile</title>

    <!-- Favicons -->
    <link href="../assets/img/favicon.png" rel="icon">
    <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="../assets/css/web_style.css" rel="stylesheet">
</head>

<body>
	 <!-- Header -->
      <header id="header" class="header fixed-top">
        <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
       <!-- .navbar -->
          <a href="home.php" class="logo d-flex align-items-center">
            <img src="../assets/img/logo.png" alt="">
            <span>Acadcalendar</span>
          </a>
          <nav id="navbar" class="navbar">
            <ul>
              <li><a class="nav-link scrollto active" href="home.php">Home</a></li>
              <li><a class="nav-link scrollto" href="staff_logout.php">Logout</a></li>
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
                <h3 class="mb-2 pb-2 mb-md-2 px-md-2">Profile Page</h3>
                <hr>
                    <!-- Account Details -->
                    <p>Your account details are below:</p>
                    <table>
                      <tr>
                        <td><i class="fas fa-user"></i> First Name:</td>
                        <td><?=$firstname?></td>
                      </tr>
                      <tr>
                        <td><i class="fas fa-user"></i> Last Name:</td>
                        <td><?=$lastname?></td>
                      </tr>
                      <tr>
                        <td><i class="fas fa-id-card"></i> Username:</td>
                        <td><?=$_SESSION['name']?></td>
                      </tr>
                      <tr>
                        <td><i class="fas fa-school"></i> Status:</td>
                        <td> 
                          <?php
                            if ($course == 5) { 
                            print("School Staff");
                            }    
                            else{
                            echo "<script> alert('Something went wrong with this registration \n
                            Please register again correctly');
                            window.location.href='../index.html';
                            </script>";
                            }   
                          ?> 
                        </td>
                      </tr>
                      <tr>
                        <td><i class="fas fa-graduation-cap"></i> Year Level:</td>
                        <td> 
                          <?php
                            if ($year == 5) { 
                            print("N/A");
                            }  
                            else{
                            echo "<script> alert('Something went wrong with this registration \n
                            Please register again correctly');
                            window.location.href='../index.html';
                            </script>";
                            }   
                          ?> 
                        </td>
                      </tr>
                      <tr>
                        <td><i class="fas fa-envelope"></i> Email:</td>
                        <td><?=$email?></td>
                      </tr>
                      <tr>
                        <td><i class="fas fa-phone"></i> Phone Number:</td>
                        <td><?=$phone?></td>
                      </tr>
                      </table>
                  </div>
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
</html>