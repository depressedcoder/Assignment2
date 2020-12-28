<?php
    session_start();

    if(!isset($_SESSION['myusername']) && !isset($_SESSION['mypassword'])){
        header("location: login.html");
        exit;
    }  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
        crossorigin="anonymous"></script>
        <style>
                .container {
    padding: 2rem 0rem;
    }

    h4 {
    margin: 2rem 0rem 1rem;
    }

    .table-image {
    td, th {
        vertical-align: middle;
    }
    }
    a {
        text-decoration: none !important;
    }
        </style>
</head>
<body>
<body>
        <div class="container" style="margin-top: 20px;">
        <div style="float: right; margin-bottom: 5px;">
            welcome, <?php echo htmlspecialchars($_SESSION['fullName'])." ";?>
            <a href="logout.php"><input type="submit" class="btn btn-primary" value="Logout" /></a>
            </div>
            <h2> <?php echo $_GET['name'] ?>'s Mark </h2>
            <div class="row">
                <div class="col-12">
                <table class="table table-bordered" style="text-align:center;">
                    <thead>
                    <tr>
                        <th scope="col">Roll Number</th>
                        <th scope="col">Student Name</th>
                        <th scope="col">Teacher Name</th>
                        <th scope="col">Course 1 Code</th>
                        <th scope="col">Course 1 Class Test Mark</th>
                        <th scope="col">Course 1 Final Mark</th>
                        <th scope="col">Course 2 Code</th>
                        <th scope="col">Course 2 Class Test Mark</th>
                        <th scope="col">Course 2 Final Mark</th>
                        <th scope="col">Course 3 Code</th>
                        <th scope="col">Course 3 Class Test Mark</th>
                        <th scope="col">Course 3 Final Mark</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                            include("connection.php");
                            $tbl_name="result";

                            $sql="SELECT * FROM $tbl_name where studentroll = ".$_GET['roll'];
                            
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        $teacherSql = "select full_name from teacher where teacherId=".$row['teacherId'];
                                        $teacherResult = mysqli_query($conn, $teacherSql);
                                        $teacherInfo = mysqli_fetch_assoc($teacherResult);
                                        
                                        echo"<tr>";
                                        echo "<th scope='row'>" . $row['studentroll'] . "</th>";
                                        echo "<td>" . $_GET['name'] . "</td>";
                                        echo "<td>" . $teacherInfo['full_name']. "</td>";
                                        echo "<td>" . $row['course1code'] . "</td>";
                                        echo "<td>" . $row['course1classtest'] . "</td>";
                                        echo "<td>" . $row['course1final'] . "</td>";
                                        echo "<td>" . $row['course2code'] . "</td>";
                                        echo "<td>" . $row['course2classtest'] . "</td>";
                                        echo "<td>" . $row['course2final'] . "</td>";
                                        echo "<td>" . $row['course3code'] . "</td>";
                                        echo "<td>" . $row['course3classtest'] . "</td>";
                                        echo "<td>" . $row['course3final'] . "</td>";
                                        echo "</tr>";
                                    } 
                                }
                        ?>
                    </tbody>
                </table>
                </div>
            </div>
            <h2> <?php echo $_GET['name'] ?>'s Result </h2>
            <div class="row">
                <div class="col-12">
                <table class="table table-bordered" style="text-align:center;">
                    <thead>
                    <tr>
                        <th scope="col">Course 1 Total Mark(Avg)</th>
                        <th scope="col">Course 1 Grade Point</th>
                        <th scope="col">Course 1 Grade</th>
                        <th scope="col">Course 2 Total Mark(Avg)</th>
                        <th scope="col">Course 2 Grade Point</th>
                        <th scope="col">Course 2 Grade</th>
                        <th scope="col">Course 3 Total Mark(Avg)</th>
                        <th scope="col">Course 3 Grade Point</th>
                        <th scope="col">Course 3 Grade</th>
                        <th scope="col">Final Grade point</th>
                        <th scope="col">Final Grade</th>
                        <th scope="col">Status</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                            include("connection.php");
                            $tbl_name="result";
                            function getPointAndGrade($courseMark)
                            {
                                $point = 0.0;
                                $grade = "F";

                                if($courseMark >= 80 && $courseMark <= 100)
                                {
                                    $point = 4.0;
                                    $grade = "A+";
                                }
                                else if($courseMark >= 70 && $courseMark < 80)
                                {
                                    $point = 3.5;
                                    $grade = "A";
                                }
                                else if($courseMark >= 60 && $courseMark < 70)
                                {
                                    $point = 3.0;
                                    $grade = "A-";
                                }
                                else if($courseMark >= 50 && $courseMark < 60)
                                {
                                    $point = 2.5;
                                    $grade = "B";
                                }

                                return array($point, $grade);
                            }      

                            $course1totalMark = 0;
                            $course2totalMark = 0;
                            $course3totalMark = 0;

                            $course1GradePoint = 0;
                            $course2GradePoint = 0;
                            $course3GradePoint = 0;

                            $course1Grade = "";
                            $course2Grade = "";
                            $course3Grade = "";
                            
                            $sql="SELECT * FROM $tbl_name where studentroll = ".$_GET['roll'];
                            
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        $course1totalMark += (double)$row['course1classtest']+(double)$row['course1final'];
                                        $course2totalMark += (double)$row['course2classtest']+(double)$row['course2final'];
                                        $course3totalMark += (double)$row['course3classtest']+(double)$row['course3final'];
                                    } 
                                }
                                $studentSql="SELECT resultsubmissioncount FROM student where roll = ".$_GET['roll'];
                                $sResult = mysqli_query($conn, $studentSql);
                                $studentinfo = mysqli_fetch_assoc($sResult);
                                $resultSubmissionCount = (int)($studentinfo['resultsubmissioncount']);
                                if($resultSubmissionCount>0)
                                {
                                    $status = "NOT PASSED";

                                    $CGPA = getPointAndGrade(($course1totalMark/$resultSubmissionCount+$course2totalMark/$resultSubmissionCount+$course3totalMark/$resultSubmissionCount)/3)[0];
                                    if($CGPA >= 2.5 && 
                                    getPointAndGrade($course1totalMark/$resultSubmissionCount)[0]>= 2.5 &&
                                    getPointAndGrade($course2totalMark/$resultSubmissionCount)[0]>= 2.5 &&
                                    getPointAndGrade($course1totalMark/$resultSubmissionCount)[0]>= 2.5)
                                    {
                                        $status = "PASSED";
                                    }
    
                                    echo"<tr>";
                                    echo "<th>" . $course1totalMark/$resultSubmissionCount . "</th>";
                                    echo "<td>" . getPointAndGrade($course1totalMark/$resultSubmissionCount)[0] . "</td>";
                                    echo "<td>" . getPointAndGrade($course1totalMark/$resultSubmissionCount)[1]. "</td>";
                                    echo "<th>" . $course2totalMark/$resultSubmissionCount . "</th>";
                                    echo "<td>" . getPointAndGrade($course2totalMark/$resultSubmissionCount)[0] . "</td>";
                                    echo "<td>" . getPointAndGrade($course2totalMark/$resultSubmissionCount)[1]. "</td>";
                                    echo "<th>" . $course3totalMark/$resultSubmissionCount . "</th>";
                                    echo "<td>" . getPointAndGrade($course3totalMark/$resultSubmissionCount)[0] . "</td>";
                                    echo "<td>" . getPointAndGrade($course3totalMark/$resultSubmissionCount)[1]. "</td>";
                                    echo "<td>" . $CGPA . "</td>";
                                    echo "<td>" . getPointAndGrade(($course1totalMark/$resultSubmissionCount+$course2totalMark/$resultSubmissionCount+$course3totalMark/$resultSubmissionCount)/3)[1] . "</td>";
                                    echo "<th>" . $status . "</th>";
                                    echo "</tr>";
                                }

                        ?>
                    </tbody>
                </table>
                </div>
            </div>
        </div>

    </body>
</body>
</html>