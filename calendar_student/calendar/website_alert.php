<?php
// Connection 1
// Database Info
$DATABASE_HOST = 'sql311.epizy.com';
$DATABASE_USER = 'epiz_32769631';
$DATABASE_PASS = 'x';
$DATABASE_NAME = 'epiz_32769631_acadcalendar';
// Try connection
$conn1 = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	// Error catch
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// Database gather through sessions
$stmt1 = $conn1->prepare('SELECT title, description, start_datetime, end_datetime, event_method FROM acad_student_events WHERE id = ?');
// Use ID to get info
$stmt1->bind_param('i', $_SESSION['id']);
$stmt1->execute();
$stmt1->bind_result($title, $description, $start_datetime, $end_datetime, $event_method1);
$stmt1->fetch();
$stmt1->close();

// Connection 2
// Try connection
$conn2 = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	// Error catch
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// Database gather through sessions
$stmt2 = $conn2->prepare('SELECT title, course, year, description, start_datetime, end_datetime, event_method FROM acad_staff_events WHERE id = ?');
// Use ID to get info
$stmt2->bind_param('i', $_SESSION['id']);
$stmt2->execute();
$stmt2->bind_result($title, $course, $year, $description, $start_datetime, $end_datetime, $event_method2);
$stmt2->fetch();
$stmt2->close();

// Connection 3
// Try connection
$conn3 = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	// Error catch
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// Database gather through sessions
$stmt3 = $conn3->prepare('SELECT title, course, year, description, start_datetime, end_datetime, event_method FROM acad_admin_events WHERE id = ?');
// Use ID to get info
$stmt3->bind_param('i', $_SESSION['id']);
$stmt3->execute();
$stmt3->bind_result($title, $course, $year, $description, $start_datetime, $end_datetime, $event_method3);
$stmt3->fetch();
$stmt3->close();

// Null Check
$nullCheck1 = mysqli_query($conn1,"SELECT * FROM acad_student_events");
$nullCheck2 = mysqli_query($conn2,"SELECT * FROM acad_staff_events");
$nullCheck3 = mysqli_query($conn3,"SELECT * FROM acad_admin_events");
$row1 = mysqli_fetch_assoc($nullCheck1);
$row2 = mysqli_fetch_assoc($nullCheck2);
$row3 = mysqli_fetch_assoc($nullCheck3);
if (empty($row1) || empty($row2) || empty($row3)){
    echo'<script type="text/javascript">';
    echo 'alert(\''.'Welcome to the Calendar - Student!'.'\');';
    echo '</script>';
}
else{
    // Check
    $checkStudent = mysqli_query($conn1,"SELECT event_method FROM acad_student_events");
    $checkStaff = mysqli_query($conn2,"SELECT event_method FROM acad_staff_events");
    $checkAdmin = mysqli_query($conn3,"SELECT event_method FROM acad_admin_events");
    $rowStudent = mysqli_fetch_assoc($checkStudent);
    $rowAdmin = mysqli_fetch_assoc($checkStaff);
    $rowStaff = mysqli_fetch_assoc($checkAdmin);
    // Event Method Check
    if($rowStudent['event_method'] == 1 || $rowStaff['event_method'] == 1 || $rowAdmin['event_method'] == 1){
        // Warning
        $warningStudent = mysqli_query($conn1,"SELECT * FROM acad_student_events WHERE start_datetime >= NOW() - INTERVAL 1 DAY ORDER BY id DESC LIMIT 1");
        if($row = mysqli_fetch_array($warningStudent)){
            echo'<script type="text/javascript">';
            echo 'alert(\''.'Warning!\n'
            . 'Event Title: '. $row['title'] . '\n' 
            . 'Event Description: '. $row['description']. '\n'
            . 'Event is near completion in: '. $row['end_datetime'] .
            '\');';
            echo '</script>';
        }
        $warningStaff = mysqli_query($conn2,"SELECT * FROM acad_staff_events WHERE start_datetime >= NOW() - INTERVAL 1 DAY ORDER BY id DESC LIMIT 1");
        if($row = mysqli_fetch_array($warningStaff)){
            echo'<script type="text/javascript">';
            echo 'alert(\''.'Warning!\n'
            . 'Event Title: '. $row['title'] . '\n' 
            . 'Event Description: '. $row['description']. '\n'
            . 'Event is near completion in: '. $row['end_datetime'] .
            '\');';
            echo '</script>';
        }
        $warningAdmin = mysqli_query($conn3,"SELECT * FROM acad_admin_events WHERE start_datetime >= NOW() - INTERVAL 1 DAY ORDER BY id DESC LIMIT 1");
        if($row = mysqli_fetch_array($warningAdmin)){
            echo'<script type="text/javascript">';
            echo 'alert(\''.'Warning!\n'
            . 'Event Title: '. $row['title'] . '\n' 
            . 'Event Description: '. $row['description']. '\n'
            . 'Event is near completion in: '. $row['end_datetime'] .
            '\');';
            echo '</script>';
        }
        // Alert
        $alertStudent = mysqli_query($conn1,"SELECT * FROM acad_student_events WHERE end_datetime <= NOW() ORDER BY id DESC LIMIT 1");
        if ($row = mysqli_fetch_array($alertStudent)) {

            echo '<script type="text/javascript">';
            echo 'alert(\''.'Alert!\n'
            . 'Event Title: '. $row['title'] . '\n' 
            . 'Event Description: '. $row['description']. '\n'
            . 'Event Has Ended in: '. $row['end_datetime'] .
            '\');';
            echo '</script>';
        }
        $alertStaff = mysqli_query($conn2,"SELECT * FROM acad_staff_events WHERE end_datetime <= NOW() ORDER BY id DESC LIMIT 1");
        if ($row = mysqli_fetch_array($alertStaff)) {

            echo '<script type="text/javascript">';
            echo 'alert(\''.'Alert!\n'
            . 'Event Title: '. $row['title'] . '\n' 
            . 'Event Description: '. $row['description']. '\n'
            . 'Event Has Ended in: '. $row['end_datetime'] .
            '\');';
            echo '</script>';
        }
        $alertAdmin = mysqli_query($conn3,"SELECT * FROM acad_admin_events WHERE end_datetime <= NOW() ORDER BY id DESC LIMIT 1");
        if ($row = mysqli_fetch_array($alertAdmin)) {

            echo '<script type="text/javascript">';
            echo 'alert(\''.'Alert!\n'
            . 'Event Title: '. $row['title'] . '\n' 
            . 'Event Description: '. $row['description']. '\n'
            . 'Event Has Ended in: '. $row['end_datetime'] .
            '\');';
            echo '</script>';
        }
    }
}


?>