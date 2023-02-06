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

if(!isset($_GET['id'])){
    echo "<script> alert('Undefined Schedule ID.'); location.replace('./event_calendar') </script>";
    $conn->close();
    exit;
}

$delete = $conn->query("DELETE FROM `acad_staff_events` where id = '{$_GET['id']}'");
if($delete){
    echo "<script> alert('Event has deleted successfully.'); location.replace('./event_calendar') </script>";
}else{
    echo "<pre>";
    echo "An Error occured.<br>";
    echo "Error: ".$conn->error."<br>";
    echo "SQL: ".$sql."<br>";
    echo "</pre>";
}
$conn->close();

?>