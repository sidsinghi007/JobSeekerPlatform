<?php
    
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
    
    
        if ($stmt = $con->prepare('SELECT * FROM jobstable WHERE jid = ?')) {
            // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
            $stmt->bind_param('s', $_POST['username']);
            $stmt->execute();
            // Store the result so we can check if the account exists in the database.
            $stmt->store_result();
        
            if ($stmt->num_rows > 0) {
                echo "Already Exists";

                } else {
                    // Incorrect password
                    //echo 'Incorrect username and/or password!1';
                }
            } else {
                // Incorrect username
                //echo 'Incorrect username and/or password!2';
            }
        
            //$stmt->close();
        
            
?>