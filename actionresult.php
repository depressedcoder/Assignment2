<?php
    session_start();

    if(!isset($_SESSION['myusername']) && !isset($_SESSION['mypassword'])){
        header("location: login.html");
        exit;
    }      
    function dataReceive(){

        $roll = $_POST["roll"];
        $teacherId = $_SESSION['teacherId'];

        $course1code = $_POST["course1code"];
        $course2code = $_POST["course2code"];
        $course3code = $_POST["course3code"];
        
        $course1classtest = (double)$_POST["course1classtest"];
        $course2classtest = (double)$_POST["course2classtest"];    
        $course3classtest = (double)$_POST["course3classtest"];

        $course1Final = (double)$_POST["course1Final"];
        $course2Final = (double)$_POST["course1Final"];    
        $course3Final = (double)$_POST["course1Final"];
        
        $student_info_with_marks = array($roll,
                     $teacherId, 
                    $course1code, 
                    $course2code, 
                    $course3code,
                    $course1classtest,
                     $course2classtest,
                      $course3classtest,
                    $course1Final, 
                    $course2Final, 
                    $course3Final);
        
        return $student_info_with_marks;
    }

    function databaseConnection(){
        
        include("connection.php");
        
        return $conn;
    }

    function dataEntry($conn, $marks){
        $roll = $marks[0];
        $teacherId = $_SESSION['teacherId'];
        $sqlq = "select * from result where studentroll=".$roll." and teacherId=".$teacherId;
        $result = mysqli_query($conn, $sqlq);
        $count=mysqli_num_rows($result);
        if($count>0)
        {
            $updateSql = "UPDATE `result` SET 
            `course1code`='$marks[2]',
            `course1classtest`='$marks[5]',
            `course1final`='$marks[8]',
            `course2code`='$marks[3]',
            `course2classtest`='$marks[6]',
            `course2final`='$marks[9]',
            `course3code`='$marks[4]',
            `course3classtest`='$marks[7]',
            `course3final`='$marks[10]' where studentroll = '$roll' and teacherId = '$teacherId'"; 

            $data = mysqli_query($conn, $updateSql);

            if($data)
            {
                echo '<script>alert("Student Result Updated");
                    window.location.href="teacherprofile.php";
                    </script>';
            }
            else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }
        else{
            $sql = "INSERT INTO `result`(`studentroll`, `teacherId`,
            `course1code`, `course1classtest`, `course1final`, `course2code`,
            `course2classtest`, `course2final`, `course3code`, `course3classtest`,
            `course3final`)
                VALUES ('$marks[0]','$marks[1]',
                '$marks[2]','$marks[5]','$marks[8]','$marks[3]'
                ,'$marks[6]','$marks[9]','$marks[4]','$marks[7]','$marks[10]')";
    
            $newsql = "update student set resultsubmissioncount = resultsubmissioncount+1 where roll = ".$marks[0];
    
            if (mysqli_query($conn, $sql) && mysqli_query($conn, $newsql)) {
                //echo "New record created successfully";
                echo '<script>alert("Submitted Student Result");
                    window.location.href="teacherprofile.php";
                    </script>';
            } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }
    }
    $student_info_with_marks = dataReceive();
    if($student_info_with_marks[0] != "" && $student_info_with_marks[1]!="")
    {
        $conn = databaseConnection();
        dataEntry($conn, $student_info_with_marks);
    
        if ($conn != null)
            mysqli_close($conn);
    }
        
    
?>