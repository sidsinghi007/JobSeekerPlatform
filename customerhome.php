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
    if ($stmt = $con->prepare('SELECT skill FROM skilltab WHERE cemail = ?')) {
        // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
        $stmt->bind_param('s', $_SESSION['email']);
        $stmt->execute();
        // Store the result so we can check if the account exists in the database.
        $stmt->store_result();
    
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($skill);
            //$stmt->fetch();
            $cc=$stmt->num_rows;
            $soso=$cc;
            $i=0;
            $array=[];
            while($cc>0)
            {
                $stmt->fetch();
                $array[$i]=$skill;
                $cc=$cc-1;
                $i=$i+1;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="mystyle_customer.css">
</head>
<body>
    <table>
        <tr>
            <td>
                <?php echo '<img src="data:image/jpeg;base64,'.base64_encode($_SESSION['image'] ).'" height="200" width="200"/>'; ?>
            </td> 
            <td>
                <p>Welcome <?=$_SESSION['name']?>!</p>
                <p><?=$_SESSION['email']?></p>
                <p><?=$_SESSION['phone']?></p>
            </td>
        </tr>
        <tr>
            <td>
                <form method="POST" action="">
                    <label id="LEDIT">ADD SKILL</label>
                    <input type="text" name="EDIT" id="Iedit">
                    <input type="submit" name="subskill" id="SUBSKILL">
                    <?php
                    if(isset($_POST['subskill']))
                    {
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
                        $CEDIT=$_POST['EDIT'];
                        $EMAIL=$_SESSION['email'];
                        $insert = $con->query("INSERT into skilltab (cemail, skill) VALUES ('$EMAIL', '$CEDIT')");
                        if($insert)
		                {
			                echo "File uploaded successfully.";
                        }
		                // else
		                // {
			            //     echo "File upload failed, please try again.";
                        // } 
                        $con->close();
                    }
                    ?>
                </form>
                <p>Skills
                    <div id="los"></div>
                <script> 
                     window.onload = function exampleFunction() { 
                        
                        var sizee= <?php echo $soso ?>;
                        var mono = <?php echo '["' .implode('", "', $array) . '"]' ?>;
                        for(i=0;i<sizee;i++)
                        {
                            var pusernameh=document.createElement('p');
                            pusernameh.textContent=mono[i];
                            document.getElementById('los').appendChild(pusernameh);
                        }
                    } 
                </script> 
                </p>
            </td>
        </tr>
    </table>
    <a href="logout.php" class="hhh">logout</a>
    <a href="jobsearch7.php" class="hhh">Search for jobs</a>
</body>
</html>