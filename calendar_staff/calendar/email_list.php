<?php
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
    <title>Acadcalendar - Contact List</title>

    <!-- Favicons -->
    <link href="http://acadcalendar.42web.io/assets/img/favicon.png" rel="icon">
    <link href="http://acadcalendar.42web.io/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="http://acadcalendar.42web.io/assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="http://acadcalendar.42web.io/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://acadcalendar.42web.io/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="http://acadcalendar.42web.io/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="http://acadcalendar.42web.io/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="http://acadcalendar.42web.io/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="http://acadcalendar.42web.io/assets/css/web_style.css" rel="stylesheet">
    
</head>

<body>
    <!-- Header -->
	 <header id="header" class="header fixed-top">
      <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
      <!-- .navbar -->
        <a href="#" class="logo d-flex align-items-center">
          <img src="http://acadcalendar.42web.io/assets/img/logo.png" alt="">
          <span>Acadcalendar</span>
        </a>
        <nav id="navbar" class="navbar">
          <ul>
          </ul>
          <i class="bi bi-list mobile-nav-toggle"></i>
        </nav>
      </div>
    </header>
  <!-- End Header -->

    <?php 
      $selectQuery = "SELECT firstname, lastname, email, course, year FROM `acad_list` ORDER BY `id` ASC";
      $result = mysqli_query($con ,$selectQuery);
      if(mysqli_num_rows($result) > 0){
      }else{
          $msg = "No Record found";
      }
    ?>

<section class="d-flex" style="background-image: url('http://acadcalendar.42web.io/assets/img/hero-bg.png'); height: 100vh;">
    <div class="container py-5 overflow-auto" id="page-container">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="card rounded-2">
                <div class="card-body p-4 p-md-5">
                    <h3 class="mb-2 pb-2 mb-md-2 px-md-2">Email Contact List</h3>
                    <table border="1px" style="width:600px; line-height:40px;">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Course</th>
                                <th>Year</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                while($row = mysqli_fetch_assoc($result)){?>
                                <tr>
                                    <td><?php echo $row['firstname']. " " .$row['lastname']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php 
                                    if($row['course'] == 1){
                                        echo "BSIT";
                                    }
                                    else if ($row['course'] == 2){
                                        echo "BSHM";
                                    }
                                    else if ($row['course'] == 3){
                                        echo "BSBA";
                                    }
                                    else if ($row['course'] == 4){
                                        echo "BSTM";
                                    }
                                    else if ($row['course'] == 5){
                                        echo "Staff";
                                    }
                                    else if ($row['course'] == 6){
                                        echo "Admin";
                                    }
                                    else{
                                        echo "Not active";
                                    } 
                                    ?></td>
                                    <td><?php 
                                    if($row['year'] == 1){
                                        echo "1st Year";
                                    }
                                    else if ($row['year'] == 2){
                                        echo "2nd Year";
                                    }
                                    else if ($row['year'] == 3){
                                        echo "3rd Year";
                                    }
                                    else if ($row['year'] == 4){
                                        echo "4th Year";
                                    }
                                    else if ($row['year'] == 5){
                                        echo "Staff";
                                    }
                                    else if ($row['year'] == 6){
                                        echo "Admin";
                                    }
                                    else{
                                        echo "Not active";
                                    } 
                                    ?></td>
                                <tr>
                            <?php }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

</body>

	<!-- Vendor JS Files -->
	<script src="http://acadcalendar.42web.io/assets/vendor/purecounter/purecounter_vanilla.js"></script>
	<script src="http://acadcalendar.42web.io/assets/vendor/aos/aos.js"></script>
	<script src="http://acadcalendar.42web.io/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="http://acadcalendar.42web.io/assets/vendor/glightbox/js/glightbox.min.js"></script>
	<script src="http://acadcalendar.42web.io/assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
	<script src="http://acadcalendar.42web.io/assets/vendor/swiper/swiper-bundle.min.js"></script>

	<!-- Main JS File -->
	<script src="http://acadcalendar.42web.io/assets/js/web_main.js"></script>
</html>