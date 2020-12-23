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
    

            if(isset($_POST['searchsub']))
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
                $param="%{$_POST['searchbox']}%";
                if ($stmt = $con->prepare('SELECT * FROM jobstable WHERE jposition = ? OR cskills LIKE ?')) {
                    // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
                    $stmt->bind_param('ss', $_POST['searchbox'],$param);
                    $stmt->execute();
                    // Store the result so we can check if the account exists in the database.
                    $stmt->store_result();
                
                    if ($stmt->num_rows > 0) {
                        $stmt->bind_result($remail,$rname,$jid,$jrole,$jposition,$jdesc,$jeleg,$jpackage,$cskills);
                        //$stmt->fetch();
                        $cc=$stmt->num_rows;
                        $soso=$cc;
                        $i=0;
                        $arrayremail=[];
                        $arrayrname=[];
                        $arrayjid=[];
                        $arrayjrole=[];
                        $arrayjpos=[];
                        $arrayjdesc=[];
                        $arrayjeleg=[];
                        $arrayjpack=[];
                        $arrayckills=[];
                    
                        while($cc>0)
                        {
                            $stmt->fetch();
                            $arrayremail[$i]=$remail;
                            $arrayrname[$i]=$rname;
                            $arrayjid[$i]=$jid;
                            $arrayjrole[$i]=$jrole;
                            $arrayjpos[$i]=$jposition;
                            $arrayjdesc[$i]=$jdesc;
                            $arrayjeleg[$i]=$jeleg;
                            $arrayjpack[$i]=$jpackage;
                            $arrayckills[$i]=$cskills;
            
                            $cc=$cc-1;
                            $i=$i+1;
                        }
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
    <link rel="stylesheet" href="mystyle_jobsearch.css">
</head>
<body id=mainbdy>
    <div id=bigone>
        <div id=twobuttons>
    <form method="POST" action="">
        <input type="text" name="searchbox" id="searchb" placeholder="Search for Job Position (Ex:SDE)">
        <input type="submit" name="searchsub" id="searchi">
    </form>
</div>
<div id=display>
    <div id="los"></div>
    <script>
        window.onload = function jojo()
        {
            if(<?php echo $soso ?> >0){
            var sizee= <?php echo $soso ?>;
            var monoremail= <?php echo '["' .implode('", "', $arrayremail) . '"]' ?>; 
            var monorname= <?php echo '["' .implode('", "', $arrayrname) . '"]' ?>;
            var monojid = <?php echo '["' .implode('", "', $arrayjid) . '"]' ?>;
            var monojrole = <?php echo '["' .implode('", "', $arrayjrole) . '"]' ?>;
            var monojpos = <?php echo '["' .implode('", "', $arrayjpos) . '"]' ?>;
            var monojdesc= <?php echo '["' .implode('", "', $arrayjdesc) . '"]' ?>;
            var monojeleg = <?php echo '["' .implode('", "', $arrayjeleg) . '"]' ?>;
            var monojpack = <?php echo '["' .implode('", "', $arrayjpack) . '"]' ?>;
            for(i=0;i<sizee;i++)
                {
                    var div1=document.createElement('div1');
                    var pusernameh1=document.createElement('p');
                    var pusernameh2=document.createElement('p');
                    var pusernameh3=document.createElement('p');
                    var pusernameh4=document.createElement('p');
                    var pusernameh5=document.createElement('p');
                    var pusernameh6=document.createElement('p');
                    var hrtag=document.createElement('hr');
                    pusernameh1.textContent="JOB ID=  "+monojid[i]+"  JOB ROLE=  "+monojrole[i]+"   JOB POSITION=  "+monojpos[i];;
                    pusernameh4.textContent="JOB DESCRIPTION="+monojdesc[i];
                    pusernameh5.textContent="JOB ELEGIBILITY="+monojeleg[i];
                    pusernameh6.textContent="JOB PACKAGE="+monojpack[i];
                    pusernameh2.textContent="Company Name="+monorname[i];
                    pusernameh3.textContent="Company email="+monoremail[i];
                    div1.appendChild(pusernameh2);
                    div1.appendChild(pusernameh3);
                    div1.appendChild(pusernameh1);
                    div1.appendChild(pusernameh4);
                    div1.appendChild(pusernameh5);
                    div1.appendChild(pusernameh6);
                    div1.appendChild(hrtag);
                    document.getElementById('los').appendChild(div1);
                }
                monojid.splice(0,monojid.length);
                
            }
        }
    </script>
    </div>
    </div>
</body>
</html>