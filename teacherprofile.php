<?php
    session_start();

	if(!isset($_SESSION['myusername']) && !isset($_SESSION['mypassword'])){
        header("location: login.html");
        exit;
    } 
?>
<html>
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
    a {
        text-decoration: none !important;
    }
        </style>
</head>


    <body>
        <div class="container" style="margin-top: 20px;">
        <div style="float: right; margin-bottom: 5px;">
            welcome, <?php echo htmlspecialchars($_SESSION['fullName'])." ";?>
            <a href="logout.php"><input type="submit" class="btn btn-primary" value="Logout" /></a>
            </div>
            <h2> IIT Student List </h2>
            <div class="row">
                <div class="col-12">
                <table class="table table-bordered" style="text-align:center;">
                    <thead>
                    <tr>
                        <th scope="col">Roll Number</th>
                        <th scope="col">Student Name</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                            include("connection.php");
                            $tbl_name="student";

                            $sql="SELECT * FROM $tbl_name";

                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        echo"<tr>";
                                        echo "<th scope='row'>" . $row['roll'] . "</th>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo"<td>
                                        <a href = 'resultinput.php?roll=$row[roll]&name=$row[name]'><button type='button' class='btn btn-warning'> Enter Marks </button>
                                        <a href = 'resultdetails.php?roll=$row[roll]&name=$row[name]'><button type='button' class='btn btn-info'> Result </button>
                                        </td>";
                                        echo "</tr>";
                                    } 
                                }
                        ?>
                    </tbody>
                </table>
                </div>
            </div>
        </div>

    </body>
</html>