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

if($_SERVER['REQUEST_METHOD'] !='POST'){
    echo "<script> alert('Error: No data to save.'); location.replace('./event_calendar.php') </script>";
    $conn->close();
    exit;
}
extract($_POST);
$allday = isset($allday);

// Window Alert
if(isset($_POST['alert_w'])){
    if(empty($id)){
        $sql = "INSERT INTO `acad_admin_events` (`title`,`description`,`course`,`year`,`start_datetime`,`end_datetime`, `event_method`, `permission`) VALUES ('$title','$description','$course','$year','$start_datetime','$end_datetime','1', '1')";
        if(preg_match('/^[5-5][0-9]{0,1}+$/', $course) == 0) {
            exit('Course is not valid!');
        }
        if(preg_match('/^[5-5][0-9]{0,1}+$/', $year) == 0) {
            exit('Year Level is not valid!');
        }
    }  
    else{
        $sql = "UPDATE `acad_admin_events` set `title` = '{$title}', `description` = '{$description}',`course` ='{$course}', `year` ='{$year}', `start_datetime` = '{$start_datetime}', `end_datetime` = '{$end_datetime}' where `id` = '{$id}'";
    }

    $save = $conn->query($sql);
    if($save){
        echo "<script> alert('Event Successfully Saved.'); location.replace('./event_calendar.php') </script>";
    }else{
        echo "<pre>";
        echo "An Error occured.<br>";
        echo "Error: ".$conn->error."<br>";
        echo "SQL: ".$sql."<br>";
        echo "</pre>";
    }
}
// Email Alert
else if(isset($_POST['alert_e'])){
    if(empty($id)){
        $sql = "INSERT INTO `acad_admin_events` (`title`,`description`,`course`,`year`,`start_datetime`,`end_datetime`, `event_method`, `permission`) VALUES ('$title','$description','$course','$year','$start_datetime','$end_datetime','2', '1')";
        if(preg_match('/^[1-5][0-9]{0,1}+$/', $course) == 0) {
            exit('Course is not valid!');
        }
        if(preg_match('/^[1-5][0-9]{0,1}+$/', $year) == 0) {
            exit('Year Level is not valid!');
        }
    }  
    else{
        $sql = "UPDATE `acad_admin_events` set `title` = '{$title}', `description` = '{$description}',`course` ='{$course}', `year` ='{$year}', `start_datetime` = '{$start_datetime}', `end_datetime` = '{$end_datetime}' where `id` = '{$id}'";
    }

    $save = $conn->query($sql);
    if($save){
        echo "<script> alert('Event Successfully Saved.'); location.replace('./email_setup.php') </script>";
    }else{
        echo "<pre>";
        echo "An Error occured.<br>";
        echo "Error: ".$conn->error."<br>";
        echo "SQL: ".$sql."<br>";
        echo "</pre>";
    }
}
// SMS Alert
else if(isset($_POST['alert_s'])){
    if(empty($id)){
        $sql = "INSERT INTO `acad_admin_events` (`title`,`description`,`course`,`year`,`start_datetime`,`end_datetime`, `event_method`, `permission`) VALUES ('$title','$description','$course','$year','$start_datetime','$end_datetime','3', '1')";
        if(preg_match('/^[1-5][0-9]{0,1}+$/', $course) == 0) {
            exit('Course is not valid!');
        }
        if(preg_match('/^[1-5][0-9]{0,1}+$/', $year) == 0) {
            exit('Year Level is not valid!');
        }
    }  
    else{
        $sql = "UPDATE `acad_admin_events` set `title` = '{$title}', `description` = '{$description}',`course` ='{$course}', `year` ='{$year}', `start_datetime` = '{$start_datetime}', `end_datetime` = '{$end_datetime}' where `id` = '{$id}'";
    }

    $save = $conn->query($sql);
    if($save){
        echo "<script> alert('Event Successfully Saved.'); location.replace('http://acadcalendar.42web.io/sms_setup_admin.php') </script>";
    }else{
        echo "<pre>";
        echo "An Error occured.<br>";
        echo "Error: ".$conn->error."<br>";
        echo "SQL: ".$sql."<br>";
        echo "</pre>";
    }
}
$conn->close();
?>