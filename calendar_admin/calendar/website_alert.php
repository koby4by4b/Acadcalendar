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
$stmt1 = $conn->prepare('SELECT title, course, year, description, start_datetime, end_datetime, event_method FROM acad_admin_events WHERE id = ?');
// Use ID to get info
$stmt1->bind_param('i', $_SESSION['id']);
$stmt1->execute();
$stmt1->bind_result($title, $course, $year, $description, $start_datetime, $end_datetime, $event_method);
$stmt1->fetch();
$stmt1->close();

// Null Check
$nullCheck = mysqli_query($conn,"SELECT * FROM acad_admin_events");
$row1 = mysqli_fetch_assoc($nullCheck);
if (empty($row1)){
    echo'<script type="text/javascript">';
    echo 'alert(\''.'Welcome to the Calendar - Admin!'.'\');';
    echo '</script>';
}
else{
    // Check
    $check = mysqli_query($conn,"SELECT event_method FROM acad_admin_events");
    $row2 = mysqli_fetch_assoc($check);
    // Event Method Check
    if($row2['event_method'] == 1){
        // Warning
        $warning = mysqli_query($conn,"SELECT * FROM acad_admin_events WHERE start_datetime >= NOW() - INTERVAL 1 DAY ORDER BY id DESC LIMIT 1");
        if($row = mysqli_fetch_array($warning)){
            echo'<script type="text/javascript">';
            echo 'alert(\''.'Warning!\n'
            . 'Event Title: '. $row['title'] . '\n' 
            . 'Event Description: '. $row['description']. '\n'
            . 'Event is near completion in: '. $row['end_datetime'] .
            '\');';
            echo '</script>';
        }
        // Alert
        $alert = mysqli_query($conn,"SELECT * FROM acad_admin_events WHERE end_datetime <= NOW() ORDER BY id DESC LIMIT 1");
        if ($row2 = mysqli_fetch_array($alert)) {

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