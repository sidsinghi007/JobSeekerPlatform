<?php
    $dbHost     = 'localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName     = 'iwtprojectdb';

    $con = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);
    if ( mysqli_connect_errno() ) {
	    // If there is an error with the connection, stop the script and display the error.
	    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    }
    else {
        echo"connected";
    }

    if($_POST['opt']=="applicant")
    {
        $CEMAIL=$_POST['EMAIL'];
        $CPASSWORD=password_hash($_POST['PASSWORD'],PASSWORD_DEFAULT);
        $CPHONE=$_POST['CONTACT'];
        $CNAME=$_POST['USERNAME'];
        $image = $_FILES['IMAGES']['tmp_name'];
		$imgContent = addslashes(file_get_contents($image));
        $insert = $con->query("INSERT into customertab (cemail, cpassword, cname, cphone, cimage) VALUES ('$CEMAIL', '$CPASSWORD', '$CNAME', '$CPHONE', '$imgContent')");
        if($insert)
		{
			echo "File uploaded successfully.";
        }
		else
		{
			echo "File upload failed, please try again.";
        } 
        $con->close();
    }
    else if($_POST['opt']=="recruiter")
    {
        $CEMAIL=$_POST['EMAIL'];
        $CPASSWORD=password_hash($_POST['PASSWORD'],PASSWORD_DEFAULT);
        $CPHONE=$_POST['CONTACT'];
        $CNAME=$_POST['USERNAME'];
        $image = $_FILES['IMAGES']['tmp_name'];
		$imgContent = addslashes(file_get_contents($image));
        $insert = $con->query("INSERT into recruitertab (remail, rpassword, rname, rphone, rlogo) VALUES ('$CEMAIL', '$CPASSWORD', '$CNAME', '$CPHONE', '$imgContent')");
        if($insert)
		{
			echo "File uploaded successfully.";
        }
		else
		{
			echo "File upload failed, please try again.";
        } 
        $con->close();
    }
?>