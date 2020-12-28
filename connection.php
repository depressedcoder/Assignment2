<?php 
$servername = "localhost";
$username = "root";
$password = "mobinur1996";
$dbname = "CourseResult";

$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    echo '<script>alert("Database Connection Error ! :(");
    window.location.href="login.html";
    </script>'; 
    
}
?>