<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: loginpage.html');
	exit;
}
else
{
        $REMAIL=$_SESSION['email'];
}
?>

<!DOCTYPE html>
<html>
<head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <title>Addition of a New Job </title>
        <link rel="stylesheet" type="text/css" href="style2.css">
</head>
    <body>
        <h1>Add a New Job</h1>
        <div class="register">
        <h2> Add Job here</h2>
        <form method="post" id="register" action="">
            
            <label>Job Role</label><br>
            <select name="Jobrole" id="jrole" required>
                        <option value="choose" selected disabled>Choose one</option>
                        <option value="FullTime">Full-Time</option>
                        <option value="Internship">Internship</option>
                        <option value="PartTime">Part-Time</option>
                    </select>
                    <br><br>
                    
            <label>Position</label><br>
                    <input type="text" name="JobPosition" id="jposition"
                    placeholder="Enter Job position" required><br><br>

            <label>Job Description</label><br>
                    <textarea name="JobDescription" id="jdescription" rows="4" cols="50"
                    placeholder="Enter Job Description" required></textarea><br><br>

            <label>Eligibility</label><br>
                    <input type="text" name="JobEligibility" id="jeligibility"
                    placeholder="Enter Job Eligibility" required><br><br>

            <label>Job Id</label><br><sub>(Enter 6 alphanumeric characters)</sub>
                    <input type="text" size="6" onBlur="checkAvail()" maxlength="6" minlength="6" name="JobId" id="jid"
                    placeholder="Enter Job Id(Ex:A12345)" required><br><br>

            <label>Package</label><br>
                    <input type="text" name="JobPackage" id="jpackage"
                    placeholder="Enter Job package" required><br><br>
            
            
                <input type="submit" name="Submit" id="jsub">                 
            <?php
            if(isset($_POST['Submit']))
            {
                $dbHost     = 'localhost';
                $dbUsername = 'root';
                $dbPassword = '';
                $dbName     = 'iwtprojectdb';
            
                $con = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);
                if ( mysqli_connect_errno() ) {
                        // If there is an error with the connection, stop the script and display the error.
                        exit('Failed to connect to MySQL: ' . mysqli_connect_error());
                }
                $REMAIL=$_SESSION['email'];
                $JOBROLE=$_POST['Jobrole'];
                $POSITION=$_POST['JobPosition'];
                $DESCRIPTION=$_POST['JobDescription'];
                $ELIGIBILITY=$_POST['JobEligibility'];
                $JOBID = $_POST['JobId'];
                $PACKAGE=$_POST['JobPackage'];

                $insert = $con->query("INSERT into jobstable (remail, jid, jrole, jposition, jdesc, jeleg, jpackage ) VALUES ('$REMAIL', '$JOBID', '$JOBROLE', '$POSITION', '$DESCRIPTION', '$ELIGIBILITY', '$PACKAGE')");
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

        </form>
         </div>

         <script>


                function checkAvail()
                {
                        var username=$('#jid').val();
                        
                        jQuery.ajax({
                        url: "checkjob.php",
                        data: {username:username},//'username='+$("#Iemail").val(),
                        type: "POST",
                        success:function(data)
                        {
                                
                                if(data=="Already Exists")
                                {
                                        alert(data+" choose another id");
                                        $("#jid").val("");
                                }
                        },error:function(){}
                        });
                
                }
         </script>

    </body>
</html>
