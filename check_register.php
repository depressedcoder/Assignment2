<?php

    include("connection.php");
	$tbl_name="teacher"; // Table name 

    // username and password sent from form 
    $teacherId = $_POST['teacherId']; 
	$myusername = $_POST['myusername']; 
	$mypassword = $_POST['mypassword']; 
    $my_fullname = $_POST['my_fullname']; 

    // To protect MySQL injection (more detail about MySQL injection)
    $teacherId = stripslashes($teacherId);
	$mypassword = stripslashes($mypassword);
	$myusername = stripslashes($myusername);
	$mypassword = stripslashes($mypassword);
    $my_fullname = stripslashes($my_fullname);


	$teacherId = mysqli_real_escape_string($conn, $teacherId);
	$myusername = mysqli_real_escape_string($conn, $myusername);
	$mypassword = mysqli_real_escape_string($conn, $mypassword);
	$my_fullname = mysqli_real_escape_string($conn, $my_fullname);

    $my_password_hash = hash('sha512', $mypassword);

    $existingUserNameCheckSQL = "SELECT * FROM $tbl_name WHERE BINARY username='$myusername'";

    $result=mysqli_query($conn, $existingUserNameCheckSQL);
	// Mysql_num_row is counting table row
    $count=mysqli_num_rows($result);
    
    if($count>0)
    {
        echo '<script>
            alert("Already has an user with this User Name! :(");
            window.location.href="login.html";
        </script>';
        
    }else{
        if($teacherId != "" && $myusername != "" && $my_fullname != "" && $mypassword != "")
        {
            $sql="SELECT * FROM $tbl_name WHERE BINARY username='$myusername' and password='$my_password_hash'";

            $sql = 
                "INSERT INTO $tbl_name (teacherId,username, password, full_name)
               VALUES 
            ('$teacherId','$myusername', '$my_password_hash', '$my_fullname')";
            if (mysqli_query($conn, $sql)) {
                echo '<script>
                alert("Registration Successfully done.");
                window.location.href="login.html";
                </script>';
               
            } else {
                echo '<script>alert("Registration not done :( \n Error: '.$sql.'\n'.mysqli_error($conn).'")</script>';
            }
        }
    }

?>

