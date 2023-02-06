<?php
    session_start();
    // Database Info
    $DATABASE_HOST = 'sql311.epizy.com';
    $DATABASE_USER = 'epiz_32769631';
    $DATABASE_PASS = 'x';
    $DATABASE_NAME = 'epiz_32769631_acadcalendar';
    //$DATABASE_HOST = 'localhost';
    //$DATABASE_USER = 'root';
    //$DATABASE_PASS = '';
    //$DATABASE_NAME = 'acadcalendar';
    // Try connection
    $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
    if ( mysqli_connect_errno() ) {
        // Error catch
        exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    }

    // Data check through isset
    if ( !isset($_POST['username'], $_POST['password']) ) {
        // Null data catch
        echo "<script> alert('Please fill both the username and password fields!');
        window.location.href='login.html';
        </script>";
    }

    // SQL Preparation
    if ($stmt = $con->prepare('SELECT id, password, course, year FROM acad_list WHERE username = ?')) {
        // Bind parameters 
        $stmt->bind_param('s', $_POST['username']);
        $stmt->execute();
        // Store the result 
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $password, $course, $year);
            $stmt->fetch();
            // Account check pass, verify password
            if (password_verify($_POST['password'], $password)){
                // Session creation
                session_regenerate_id();
                $_SESSION['loggedin'] = TRUE;
                $_SESSION['name'] = $_POST['username'];
                $_SESSION['id'] = $id;
                //header('Location: home.php');      
            } else {
                // Incorrect password
                echo "<script> alert('Incorrect username and/or password!');
                window.location.href='login.html';
                </script>";
            }
        } else {
            // Incorrect username
            echo "<script> alert('Incorrect username and/or password!');
                window.location.href='login.html';
                </script>";
        }
        $stmt->close();
    }
    // Member check if staff or student
    //student
    if ($course == 1 || $course == 2 || $course == 3 || $course == 4 && $year == 1 || $year == 2 || $year == 3 || $year == 4) {
        header('location: ../calendar_student/home.php'); 
    }
    //staff
    elseif ($course == 5 && $year == 5) { 
        header ('Location: ../calendar_staff/home.php');
    }    
    //admin
    elseif($course == 6 && $year == 6){
        header('location: ../calendar_admin/home.php');
    }  
    
?>