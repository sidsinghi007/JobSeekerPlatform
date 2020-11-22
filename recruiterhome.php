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
    if ($stmt = $con->prepare('SELECT * FROM jobstable WHERE remail = ?')) {
        // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
        $stmt->bind_param('s', $_SESSION['email']);
        $stmt->execute();
        // Store the result so we can check if the account exists in the database.
        $stmt->store_result();
    
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($remail,$rname,$jid,$jrole,$jposition,$jdesc,$jeleg,$jpackage);
            //$stmt->fetch();
            $cc=$stmt->num_rows;
            $soso=$cc;
            $i=0;
            $arrayjid=[];
            $arrayjrole=[];
            $arrayjpos=[];
            $arrayjdesc=[];
            $arrayjeleg=[];
            $arrayjpack=[];
            while($cc>0)
            {
                $stmt->fetch();
                $arrayjid[$i]=$jid;
                $arrayjrole[$i]=$jrole;
                $arrayjpos[$i]=$jposition;
                $arrayjdesc[$i]=$jdesc;
                $arrayjeleg[$i]=$jeleg;
                $arrayjpack[$i]=$jpackage;

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
    <link rel="stylesheet" href="mystyle_recruiter_page.css">
</head>
<body>
<div id=recruit>
    <a href="logout.php" class="hhh">Logout</a>
    <a href="AddNewJobsPage.php" class="hero">Add new job</a>
                  
                <br>
                <div2 id=imgg>
                    <?php echo '<img src="data:image/jpeg;base64,'.base64_encode($_SESSION['image'] ).'" height="200" width="200"/>'; ?>
                </div2>
                
                    <p id=welcome>Welcome <?=$_SESSION['name']?>!</p>
                    <p id=contactinfo>Contact info</p>
                    <p id=em>Email id:<?=$_SESSION['email']?></p>
                    <p id=contno>Contact number: <?=$_SESSION['phone']?></p>
                
 
        
    
                    <hr>
                    <div name="divj" id="los">
                
    
    <script>
        window.onload = function exampleFunction() { 
                        
            var sizee= <?php echo $soso ?>;
            var monojid = <?php echo '["' .implode('", "', $arrayjid) . '"]' ?>;
            var monojrole = <?php echo '["' .implode('", "', $arrayjrole) . '"]' ?>;
            var monojpos = <?php echo '["' .implode('", "', $arrayjpos) . '"]' ?>;
            var monojdesc= <?php echo '["' .implode('", "', $arrayjdesc) . '"]' ?>;
            var monojeleg = <?php echo '["' .implode('", "', $arrayjeleg) . '"]' ?>;
            var monojpack = <?php echo '["' .implode('", "', $arrayjpack) . '"]' ?>;
            for(i=0;i<sizee;i++)
                {
                    var div1=document.createElement('div');
                    var pusernameh1=document.createElement('p');
                    var pusernameh2=document.createElement('p');
                    var pusernameh3=document.createElement('p');
                    var pusernameh4=document.createElement('p');
                    var pusernameh5=document.createElement('p');
                    var pusernameh6=document.createElement('p');
                    var hrtag=document.createElement('hr');
                    pusernameh1.textContent="JOB ID=  "+monojid[i]+"    JOB ROLE=  "+monojrole[i]+"    JOB POSITION=  "+monojpos[i];;
                    pusernameh4.textContent="JOB DESCRIPTION="+monojdesc[i];
                    pusernameh5.textContent="JOB ELEGIBILITY="+monojeleg[i];
                    pusernameh6.textContent="JOB PACKAGE="+monojpack[i];
                    div1.appendChild(pusernameh1);
                    div1.appendChild(pusernameh4);
                    div1.appendChild(pusernameh5);
                    div1.appendChild(pusernameh6);
                    div1.appendChild(hrtag);
                    document.getElementById('los').appendChild(div1);
                }
            } 
    </script>
</div>
</body>
</html>