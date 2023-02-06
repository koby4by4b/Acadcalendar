<?php
// Session Usage
session_start();
// Kick not logged in users
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
// Course Check Database
$DATABASE_HOST = 'sql311.epizy.com';
$DATABASE_USER = 'epiz_32769631';
$DATABASE_PASS = 'x';
$DATABASE_NAME = 'epiz_32769631_acadcalendar';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
$stmt = $con->prepare('SELECT firstname, lastname, email, course, year FROM acad_list WHERE id = ?');
// Use ID to get info
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($firstname, $lastname, $email, $course, $year);
$stmt->fetch();
$stmt->close();

// Connection 1
// Try connection
$conn1 = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	// Error catch
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// Connection 2
// Try connection
$conn2 = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	// Error catch
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

//s1
// Database gather through sessions
$stmt1 = $conn1->prepare('SELECT title, course, year, description, start_datetime, end_datetime FROM acad_staff_events WHERE id = ?');
// Use ID to get info
$stmt1->bind_param('i', $_SESSION['id']);
$stmt1->execute();
$stmt1->bind_result($title, $course, $year, $description, $start_datetime, $end_datetime);
$stmt1->fetch();
$stmt1->close();
//s2
// Database gather through sessions
$stmt2 = $conn2->prepare('SELECT title, course, year, description, start_datetime, end_datetime FROM acad_admin_events WHERE id = ?');
// Use ID to get info
$stmt2->bind_param('i', $_SESSION['id']);
$stmt2->execute();
$stmt2->bind_result($title, $course, $year, $description, $start_datetime, $end_datetime);
$stmt2->fetch();
$stmt2->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Acadcalendar - Staff Calendar</title>

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
    <link href="http://acadcalendar.42web.io//assets/fullcalendar/lib/main.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="http://acadcalendar.42web.io/assets/css/web_style.css" rel="stylesheet">

    <!-- Fullcalendar -->
    <link href="http://acadcalendar.42web.io/assets/css/calendar_style.css" rel="stylesheet">
    <script src="http://acadcalendar.42web.io/assets/js/jquery-3.6.0.min.js"></script>
    <script src="http://acadcalendar.42web.io/assets/fullcalendar/lib/main.min.js"></script>
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
              <li><a class="nav-link scrollto active" href="../staff_profile.php">Profile</a></li>
              <li><a class="nav-link scrollto" href="../staff_logout.php">Logout</a></li>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
          </nav>
        </div>
    </header>
    <!-- End Header -->

    <section class="d-flex" style="background-image: url('http://acadcalendar.42web.io/assets/img/hero-bg.png'); height: 100vh;">
            <div class="container py-5 overflow-auto" id="page-container">
                <div class="row">
                    <div class="col-md-8" id="calendar-form">
                        <!-- Calendar -->
                        <div id="calendar"></div>
                    </div>
                    <div class="col-md-3 g-0">
                        <div class="cardt shadow" id="sched-form">
                            <div class="card-header bg-gradient bg-primary text-light rounded-top">
                                <!-- Schedule Add Form -->
                                <h5 class="card-title">Event Creation Form</h5>
                            </div>
                            <div class="card-body">
                                <div class="container-fluid">
                                    <form action="save_event.php" method="post" id="schedule-form">
                                        <input type="hidden" name="id" value="">
                                        <div class="form-group mb-2">
                                            <label for="title" class="control-label">Title</label>
                                            <input type="text" class="form-control form-control-sm rounded-0" name="title" id="title" required>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="description" class="control-label">Description</label>
                                            <textarea rows="3" class="form-control form-control-sm rounded-0" name="description" id="description" required></textarea>
                                        </div>
                                            <div class="form-group mb-2">
                                            <label for="course" class="control-label">Course Code</label>
                                            <input type="text" class="form-control form-control-sm rounded-0" name="course" id="course" placeholder="1-BSIT/2-BSHM/3-BSBA/4-BSTM/5-All" required>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="year" class="control-label">Year Code</label>
                                            <input type="text" class="form-control form-control-sm rounded-0" name="year" id="year" placeholder="1-BSIT/2-BSHM/3-BSBA/4-BSTM/5-All" required>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="start_datetime" class="control-label">Start</label>
                                            <input type="datetime-local" class="form-control form-control-sm rounded-0" name="start_datetime" id="start_datetime" required>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="end_datetime" class="control-label">End</label>
                                            <input type="datetime-local" class="form-control form-control-sm rounded-0" name="end_datetime" id="end_datetime" required>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-center">
                                    <button class="btn btn-primary btn-sm rounded-0" data-bs-toggle="modal" data-bs-target="#eventModal"><i class="fa fa-save"></i> Save</button>
                                        <!-- Event Modal -->
                                        <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="eventModalLabel">Event Modal</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Please choose the method of receiving the event
                                                </div>
                                                <div class="modal-footer">
                                                    <!-- Event Modal Choices -->
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button class="btn btn-primary" type="submit" form="schedule-form" name="alert_w"> Website Alert</button>
                                                    <button class="btn btn-primary" type="submit" form="schedule-form" name="alert_e"> Email </button>
                                                    <button class="btn btn-primary" type="submit" form="schedule-form" name="alert_s"> SMS Message</button>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    <button class="btn btn-default border btn-sm rounded-0 mb-2" type="reset" form="schedule-form"><i class="fa fa-reset"></i> Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Event Details Modal on Calendar Click -->
            <div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="event-details-modal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-0">
                        <div class="modal-header rounded-0">
                            <h5 class="modal-title">Event Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body rounded-0">
                            <div class="container-fluid">
                                <dl>
                                    <dt class="text-muted">Title</dt>
                                    <dd id="title" class="fw-bold fs-4"></dd>
                                    <dt class="text-muted">Description</dt>
                                    <dd id="description" class=""></dd>
                                    <dt class="text-muted">Course Code</dt>
                                    <dd id="course" class="" data-toggle="tooltip" data-placement="bottom" title="1-BSIT / 2-BSHM / 3-BSBA / 4-BSTM / 5-Announcement" ></dd>
                                    <dt class="text-muted">Year Code</dt>
                                    <dd id="year" class="" data-toggle="tooltip" data-placement="bottom" title="1-1st / 2-2nd / 3-3rd / 4-4th / 5-Everyone"> </dd>
                                    <dt class="text-muted">Start</dt>
                                    <dd id="start" class=""></dd>
                                    <dt class="text-muted">End</dt>
                                    <dd id="end" class=""></dd>
                                </dl>
                            </div>
                        </div>
                        <div class="modal-footer rounded-0">
                            <div class="text-end">
                                <button type='button' class='btn btn-primary btn-sm rounded-0' id='edit'> Edit </button> 
                                <button type='button' class='btn btn-danger btn-sm rounded-0' id="delete">Delete</button>
                                <button type="button" class="btn btn-secondary btn-sm rounded-0" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <div id="Alert">
    </div>
</body>
    <!-- Display Events -->
    <?php 
        $schedules1 = $conn1->query("SELECT * FROM `acad_staff_events`");
        $schedules2 = $conn2->query("SELECT * FROM `acad_admin_events`");
        $sched_res = [];
        foreach($schedules1->fetch_all(MYSQLI_ASSOC) as $row){
            $row['sdate'] = date("F d, Y h:i A",strtotime($row['start_datetime']));
            $row['edate'] = date("F d, Y h:i A",strtotime($row['end_datetime']));
            $sched_res[$row['id']] = $row;
        }
        foreach($schedules2->fetch_all(MYSQLI_ASSOC) as $row){
            $row['sdate'] = date("F d, Y h:i A",strtotime($row['start_datetime']));
            $row['edate'] = date("F d, Y h:i A",strtotime($row['end_datetime']));
            $sched_res[$row['id']] = $row;
        }
    ?>
    <?php 
        if(isset($conn1)) $conn1->close();
        if(isset($conn2)) $conn2->close();
    ?>
    <script>
        var scheds = $.parseJSON('<?= json_encode($sched_res) ?>')
    </script>

	<!-- Vendor JS Files -->
	<script src="http://acadcalendar.42web.io/assets/vendor/purecounter/purecounter_vanilla.js"></script>
	<script src="http://acadcalendar.42web.io/assets/vendor/aos/aos.js"></script>
	<script src="http://acadcalendar.42web.io/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="http://acadcalendar.42web.io/assets/vendor/glightbox/js/glightbox.min.js"></script>
	<script src="http://acadcalendar.42web.io/assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
	<script src="http://acadcalendar.42web.io/assets/vendor/swiper/swiper-bundle.min.js"></script>

	<!-- Main JS File -->
	<script src="http://acadcalendar.42web.io/assets/js/web_main.js"></script>
    <script src="http://acadcalendar.42web.io/assets/js/staff_calendar.js"></script>
   
</html>