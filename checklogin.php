<?php

    include("connection.php");
	$tbl_name="teacher";
	// username and password sent from form 
	$myusername=$_POST['myusername']; 
	$mypassword=$_POST['mypassword']; 

	// To protect MySQL injection (more detail about MySQL injection)
	$myusername = stripslashes($myusername);
	$mypassword = stripslashes($mypassword);

	$myusername = mysqli_real_escape_string($conn, $myusername);
	$mypassword = mysqli_real_escape_string($conn, $mypassword);

    $my_password_hash = hash('sha512', $mypassword);

	$sql="SELECT * FROM $tbl_name WHERE BINARY username='$myusername' and password='$my_password_hash'";

	$result=mysqli_query($conn, $sql);
	// Mysql_num_row is counting table row
	$count=mysqli_num_rows($result);
	
	
	if($count==1){
        $row = mysqli_fetch_assoc($result);

        session_start();
        $_SESSION['myusername'] = $myusername;
        $_SESSION['mypassword'] = $my_password_hash;
        $_SESSION['fullName'] = $row['full_name'];
        $_SESSION['teacherId'] = $row['teacherId'];
        
        header("location: teacherprofile.php");
	}
	else {
        echo '<script>
                alert("Wrong User Name and Password !!");
                window.location.href="login.html";
                </script>';
	}
?>

