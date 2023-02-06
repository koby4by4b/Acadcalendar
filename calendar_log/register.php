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

    // Data submission check
    if (!isset($_POST['firstname'], $_POST['lastname'], $_POST['username'], $_POST['password'], $_POST['email'], $_POST['phone'], $_POST['course'], $_POST['year'])) {
        // No data found
        echo "<script> alert('Please complete the registration form!');
        window.location.href='register.html';
        </script>";
    }

    // Empty space check
    if ( empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['course']) || empty($_POST['year'])) {
        // One or more values empty
        echo "<script> alert('Please complete the registration form!');
        window.location.href='register.html';
        </script>";
    }
    // Account Check
    if ($stmt = $con->prepare('SELECT id, password FROM acad_list WHERE username = ?')) {
        // Email Check
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            echo "<script> alert('Email is not valid!');
            window.location.href='register.html';
            </script>";
        }
        // Phone Check
        if (preg_match('/^[0-9][0-9]{10,12}+$/', $_POST['phone']) == 0) {
            echo "<script> alert('Phone Number is not valid!');
            window.location.href='register.html';
            </script>";
        }
        // Name match
        if (preg_match('/^[a-zA-Z_\-\s]+$/', $_POST['firstname']) == 0) {
            echo "<script> alert('First name is not valid!');
            window.location.href='register.html';
            </script>";
        }
        if (preg_match('/^[a-zA-Z_\-\s]+$/', $_POST['lastname']) == 0) {
            echo "<script> alert('Last name is not valid!');
            window.location.href='register.html';
            </script>";
        }
        if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
            echo "<script> alert('Password must be between 5 and 20 characters long!');
            window.location.href='register.html';
            </script>";
        }
        // Code match
        if(preg_match('/^[1-6][0-9]{0,1}+$/', $_POST['course']) == 0) {
            echo "<script> alert('Course is not valid!');
            window.location.href='register.html';
            </script>";
        }
        if(preg_match('/^[1-6][0-9]{0,1}+$/', $_POST['year']) == 0) {
            echo "<script> alert('Year Level is not valid!');
            window.location.href='register.html';
            </script>";
        }
        // Bind parameters
        $stmt->bind_param('s', $_POST['username']);
        $stmt->execute();
        $stmt->store_result();
        // Existing account check
	    if ($stmt->num_rows > 0) {
		    // Username exists
		    echo "<script> alert('Username exists, please choose another!');
            window.location.href='register.html';
            </script>";
        }
        else{
            // Insert new account
            if ($stmt = $con->prepare('INSERT INTO acad_list (firstname, lastname, username, password, email, phone, course, year) VALUES (?, ?, ?, ?, ?, ?, ?, ?)')) {
                // Password check
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $stmt->bind_param('ssssssss', $_POST['firstname'], $_POST['lastname'], $_POST['username'], $password, $_POST['email'], $_POST['phone'], $_POST['course'], $_POST['year']);
                $stmt->execute();
                echo "<script> alert('You have successfully registered, you can now login!');
                window.location.href='login.html';
                </script>";
            } 
            else {
                // SQL error catch
                echo "<script> alert('Could not prepare statement!');
                window.location.href='register.html';
                </script>";
            }
        }
        $stmt->close();
    }
    else {
        // SQL error catch
        echo "<script> alert('Could not prepare statement!');
        window.location.href='register.html';
        </script>";
        exit();
    }

?>