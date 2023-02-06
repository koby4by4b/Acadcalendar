<?php
// Database Info
$DATABASE_HOST = 'sql311.epizy.com';
$DATABASE_USER = 'epiz_32769631';
$DATABASE_PASS = 'x';
$DATABASE_NAME = 'epiz_32769631_acadcalendar';
// Try connection
$conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	// Error catch
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// Database gather through sessions
$stmt1 = $conn->prepare('SELECT title, course, year, description, start_datetime, end_datetime FROM acad_staff_events WHERE id = ?');
// Use ID to get info
$stmt1->bind_param('i', $_SESSION['id']);
$stmt1->execute();
$stmt1->bind_result($title, $course, $year, $description, $start_datetime, $end_datetime);
$stmt1->fetch();
$stmt1->close();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Acadcalendar - Email Setup</title>

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
    <link href="http://acadcalendar.42web.io/assets/css/event_sender_style.css" rel="stylesheet">

    <script src="http://acadcalendar.42web.io/assets/js/jquery-3.6.0.min.js"></script>
    <script src="https://smtpjs.com/v3/smtp.js"></script>

</head>

<body>
      <!-- Header -->
      <header id="header" class="header fixed-top">
        <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
          <!-- .navbar -->
          <a href="../home.php" class="logo d-flex align-items-center">
            <img src="http://acadcalendar.42web.io/assets/img/logo.png" alt="">
            <span>Acadcalendar</span>
          </a>
          <nav id="navbar" class="navbar">
            <ul>
              <li><a class="nav-link scrollto active" href="./event_calendar.php">Calendar</a></li>
              <li><a class="nav-link scrollto" href="../staff_logout.php">Logout</a></li>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
          </nav>
        </div>
    </header>
    <!-- End Header -->

    <section class="d-flex align-items-center" style="background-image: url('http://acadcalendar.42web.io/assets/img/hero-bg.png'); height: 100vh;">
        <div class="container">
          <div class="row">
          <div class="col-md-5 mx-auto bg-white shadow border p-4 rounded">
                <h2 class="text-center fw-bold mb-3">Email Sender</h2>
                <form action="#" id="submit">
                    <div class="form-group mb-3">
                        <label for="receiver" class="form-label">Receiver Email</label>
                        <input type="text" class="form-control" placeholder="Gmail preferred" required name="receiver" id="receiver">
                    </div>
                    <div class="form-group mb-3">
                        <label for="subject" class="form-label">Subject</label>
                        <input type="text" class="form-control" placeholder="Enter subject" required name="subject" id="subject" value="Acadcalendar Email Notification">
                    </div>
                    <div class="form-group mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea rows="5" class="form-control" placeholder="Enter message" required name="message" id="message">
                            <?php
                                $check = mysqli_query($conn,"SELECT title, description, start_datetime, end_datetime FROM acad_staff_events ORDER BY id DESC LIMIT 1");
                                $row = mysqli_fetch_assoc($check);
                                echo "Event Title:" . "\n";
                                echo $row['title'] . "\n";
                                echo "Event Details:" . "\n";
                                echo $row['description'] . "\n";
                                echo "Start of Event:" . "\n";
                                echo $row['start_datetime'] . "\n";
                                echo "End of Event:" . "\n";
                                echo $row['end_datetime'] . "\n";
                            ?>
                        </textarea>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary" name="submit">Send Email</button>
                        <button type="reset" class="btn btn-danger">Reset form</button>
                        <a class="btn btn-secondary" role="button" onclick="openWin()">Email List</a>
                    </div>
                </form>
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
    <script src="http://acadcalendar.42web.io/assets/js/send_email.js"></script>

    <!-- Email list -->
    <script>
    function openWin() {
        list_email = window.open("http://acadcalendar.42web.io/calendar_staff/calendar/email_list.php");
    }
    </script>
</html>