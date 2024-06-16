<?php
    $serername="localhost";
    $db_username="root";
    $db_password="";
    $db_name="alumni_management_system";
    $conn=mysqli_connect($serername, $db_username, $db_password, $db_name);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrap link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
    
    <!-- link for datatable design -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    
    <!-- link for datatable scrip -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>
    <title>Alumni Archive List</title>
</head>

<body style="margin: 100px;">
    <div style="margin-left: 7%; margin-right: 7%;" >
        <H3>Alumni Archive List</H3>
        <hr>
        <div class="col-sm-3 d-grid">
            <a class="btn btn-outline-primary" href="alumni.php">Alumni List</a>
        </div>
        <br>
        <!-- table -->
        <table id="myTable" class="table">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Course</th>
                    <th>Batch</th>
                    <th>Currently Connected To</th>
                    <th>Contact</th>
                    <th>Address</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Date Created</th>
                    <th>Date Archived</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <?php
                        // to retrieve data in table
                        $query = "SELECT * FROM alumni_archive";
                        $result = mysqli_query($conn, $query);

                        while ($row = mysqli_fetch_assoc($result)) {
                            $fullname = $row["fname"] . " " . $row["mname"] . " " . $row["lname"];

                    echo "
                    <td>$row[student_id]</td>
                    ";?>
                    <td><?php echo htmlspecialchars($fullname)?></td>
                    <?php echo "
                    <td>$row[course]</td>
                    <td>$row[batch]</td>
                    <td>$row[connected_to]</td>
                    <td>$row[contact]</td>
                    <td>$row[address]</td>
                    <td>$row[email]</td>
                    <td>$row[username]</td>
                    <td>$row[date_created]</td>
                    <td>$row[date_archived]</td>
                    <td>
                        <!-- update and delete button -->
                        <a class='btn btn-success btn-sm' href='alumniCrud/restore_alumni.php?id=$row[student_id]'>Restore</a>
                    </td>";
                    ?>
                </tr>
            <?php
                }
            ?>
            </tbody>
        </table>
        <br>
        <br>
        <hr>
        <br>
        <!-- script for table to access datatables -->
        <script>
            let table = new DataTable('#myTable');
        </script>
    </div>
</body>

</html>
