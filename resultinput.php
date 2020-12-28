<?php
    session_start();

	if(!isset($_SESSION['myusername']) && !isset($_SESSION['mypassword'])){
        header("location: login.html");
        exit;
    } 
    include("connection.php");
    $roll = $_GET['roll'];
    $teacherId = $_SESSION['teacherId'];
    $sql = "select * from result where studentroll=".$roll." and teacherId=".$teacherId;
    $result = mysqli_query($conn, $sql);
    $count=mysqli_num_rows($result);

	$course1code = "";
    $course2code = "";
    $course3code = "";

    $course1classtest = "";
    $course2classtest = "";
    $course3classtest = "";

    $course1Final = "";
    $course2Final = "";
    $course3Final = "";

	if($count==1){
        $row = mysqli_fetch_assoc($result);

        $course1code = $row['course1code'];
        $course2code = $row['course2code'];
        $course3code = $row['course3code'];

        $course1classtest = $row['course1classtest'];
        $course2classtest = $row['course2classtest'];
        $course3classtest = $row['course3classtest'];

        $course1Final = $row['course1final'];
        $course2Final = $row['course2final'];
        $course3Final = $row['course3final'];
    }
?>
<head>
    <title>Teacher Profile</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS only -->
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
        </style>
</head>

    <body>
        <div class="container" style="margin-top: 20px;">
        <div style="float: right; margin-bottom: 5px;">
            welcome, <?php echo htmlspecialchars($_SESSION['fullName'])." ";?>
            <a href="logout.php"><input type="submit" class="btn btn-primary" value="Logout" /></a>
            </div>
            <h2> Enter Mark For Student </h2>
            <form name="marksForm" action="actionresult.php" method="post">
            <div class="form-group row">
                <label class="col-sm-1 col-form-label">Name</label>
                <div class="col-sm-11">
                <input type="hidden" name="name" value="<?php echo $_GET['name']; ?>">
                <label class="col-sm-3 col-form-label"><?php echo $_GET['name']?></label> </div>
        </div>
        <div class="form-group row">
                <label class="col-sm-1 col-form-label">Roll</label>
                <div class="col-sm-11">
                <input type="hidden" name="roll" value="<?php echo $_GET['roll']; ?>">
                <label class="col-sm-3 col-form-label"><?php echo $_GET['roll']?></label> </div>
        </div>
                <div class="input-group">
                    <span class="input-group-text">Course Code and Marks</span>
                    <input type="text" aria-label="Course Code" value="<?php echo $course1code?>" placeholder="Course Code" name="course1code"
                        class="form-control">
                    <input type="number" aria-label="ClassTest" placeholder="Class Test" value="<?php echo $course1classtest?>" name="course1classtest" class="form-control"
                        min="0" max="40">
                        <input type="number" aria-label="Final" placeholder="Final" value="<?php echo $course1Final?>" name="course1Final" class="form-control"
                        min="0" max="60">
                </div>
                <br>
                <div class="input-group">
                    <span class="input-group-text">Course Code and Marks</span>
                    <input type="text" aria-label="Course Code" value="<?php echo $course2code?>" placeholder="Course Code" name="course2code"
                        class="form-control">
                        <input type="number" aria-label="ClassTest" placeholder="Class Test" value="<?php echo $course2classtest?>" name="course2classtest" class="form-control"
                        min="0" max="40">
                        <input type="number" aria-label="Final" placeholder="Final" value="<?php echo $course2Final?>" name="course2Final" class="form-control"
                        min="0" max="60">
                </div>
                <br>
                <div class="input-group">
                    <span class="input-group-text">Course Code and Marks</span>
                    <input type="text" aria-label="Course Code"  placeholder="Course Code" value="<?php echo $course3code?>" name="course3code"
                        class="form-control">
                        <input type="number" aria-label="ClassTest" placeholder="Class Test" value="<?php echo $course3classtest?>" name="course3classtest" class="form-control"
                        min="0" max="40">
                        <input type="number" aria-label="Final" placeholder="Final" value="<?php echo $course3Final?>" name="course3Final" class="form-control"
                        min="0" max="60">
                </div>
                <br>
                <input type="submit" class="btn btn-success" value="Submit" onclick="return checkMarks()" />
            </form>
        </div>

    </body>

    <script>
        function checkMarks() {
            debugger;
            var course1code = document.forms["marksForm"]["course1code"].value;
            var course2code = document.forms["marksForm"]["course2code"].value;
            var course3code = document.forms["marksForm"]["course3code"].value;

            var course1classtest = parseFloat(document.forms["marksForm"]["course1classtest"].value);
            var course2classtest = parseFloat(document.forms["marksForm"]["course2classtest"].value);
            var course3classtest = parseFloat(document.forms["marksForm"]["course3classtest"].value);

            var course1Final = parseFloat(document.forms["marksForm"]["course1Final"].value);
            var course2Final = parseFloat(document.forms["marksForm"]["course2Final"].value);
            var course3Final = parseFloat(document.forms["marksForm"]["course3Final"].value);

            var alertMessage = "";
            var confirm = true;

            if (course1code == "" || course2code == "" || course3code == "" || isNaN(course1classtest) ||
            isNaN(course2classtest) || isNaN(course3classtest) || isNaN(course1Final)  || isNaN(course2Final) || isNaN(course3Final)) {
                alertMessage = "Please Enter All The Course Code and Marks.";
                alert(alertMessage);
                confirm = false;
            }
            return confirm;
        }
    </script>

</html>