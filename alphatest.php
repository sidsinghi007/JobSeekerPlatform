<?php
    $_testing=password_hash("beta00000",PASSWORD_DEFAULT);
    echo($_testing);
    if(password_verify("beta00000",$_testing))
    {
        echo("best");
    }
    else{
        echo("no");
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="IMAGES" id="img">
        <input type="submit" name="sub">
        <?php
            if(isset($_POST['sub']))
            {
                if(array_key_exists('IMAGES',$_POST)){
                $file_type=$_FILES['IMAGES'];
                $file_type=$_FILES['IMAGES']['type'];
                $image = $_FILES['IMAGES']['tmp_name'];
                $imgContent = addslashes(file_get_contents($image));}
                else{
                    echo "no";
                }
            }
        ?>
    </form>
</body>
</html>