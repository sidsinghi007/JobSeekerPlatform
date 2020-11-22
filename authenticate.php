<?php
session_start();
// Change this to your connection info.
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'iwtprojectdb';
// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	// If there is an error with the connection, stop the script and display the error.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if ( !isset($_POST['EMAIL'], $_POST['PASSWORD']) ) {
	// Could not get the data that should have been sent.
	exit('Please fill both the username and password fields!');
}

// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
if($_POST['opt']=="applicant"){
if ($stmt = $con->prepare('SELECT * FROM customertab WHERE cemail = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
	$stmt->bind_param('s', $_POST['EMAIL']);
	$stmt->execute();
	// Store the result so we can check if the account exists in the database.
	$stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($cemail, $cpassword, $cname, $cphone, $cimage);
        $stmt->fetch();
        // Account exists, now we verify the password.
        // Note: remember to use password_hash in your registration file to store the hashed passwords.
        if (password_verify($_POST['PASSWORD'], $cpassword)) {
            // Verification success! User has loggedin!
            // Create sessions so we know the user is logged in, they basically act like cookies but remember the data on the server.
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $cname;
            $_SESSION['id'] = $cemail;
            $_SESSION['email']=$_POST['EMAIL'];
            $_SESSION['image']=$cimage;
            $_SESSION['phone']=$cphone;
            
            header('Location: customerhome.php');
        } else {
            // Incorrect password
            echo 'Incorrect username and/or password!1';
        }
    } else {
        // Incorrect username
        echo 'Incorrect username and/or password!2';
    }

	$stmt->close();
}
}


else if($_POST['opt']=="recruiter"){
    echo "0";
    if ($stmt = $con->prepare('SELECT * FROM recruitertab WHERE remail = ?')) {
        // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
        echo "1";
        $stmt->bind_param('s', $_POST['EMAIL']);
        $stmt->execute();
        // Store the result so we can check if the account exists in the database.
        $stmt->store_result();
    
        if ($stmt->num_rows > 0) {
            echo "3";
            $stmt->bind_result($remail, $rpassword, $rname, $rphone, $rlogo);
            $stmt->fetch();
            // Account exists, now we verify the password.
            // Note: remember to use password_hash in your registration file to store the hashed passwords.
            if (password_verify($_POST['PASSWORD'], $rpassword)) {
                // Verification success! User has loggedin!
                // Create sessions so we know the user is logged in, they basically act like cookies but remember the data on the server.
                echo "4";
                session_regenerate_id();
                $_SESSION['loggedin'] = TRUE;
                $_SESSION['name'] = $rname;
                $_SESSION['id'] = $remail;
                $_SESSION['email']=$_POST['EMAIL'];
                $_SESSION['image']=$rlogo;
                $_SESSION['phone']=$rphone;
                
                header('Location: recruiterhome.php');
            } else {
                // Incorrect password
                echo 'Incorrect username and/or password!1';
            }
        } else {
            // Incorrect username
            echo 'Incorrect username and/or password!2';
        }
    
        $stmt->close();
    }
    }

?>