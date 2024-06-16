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
    <title>Coordinator List</title>
</head>

<body style="margin: 100px;">
    <div style="margin-left: 7%; margin-right: 7%;" >
        <H3>Coordinator List</H3>
        <hr>
        <!-- add new alumni -->
        <a class="btn btn-primary btn-sm" href="coordinatorCrud/add_coor.php">Add new</a>
        <br>
        <!-- table -->
        <table id="myTable" class="table">
            <thead>
                <tr>
                    <th>Coordinator ID</th>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>username</th>
                    <th>Creation Date</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <?php
                        // to retrieve data in table
                        $query = "SELECT * FROM coordinator";
                        $result = mysqli_query($conn, $query);

                        while ($row = mysqli_fetch_assoc($result)) {
                            $fullname = $row["fname"] . " " . $row["mname"] . " " . $row["lname"];


                    echo "
                    <td>$row[coor_id]</td>
                    ";?>
                    <td><?php echo htmlspecialchars($fullname)?></td>
                    <?php echo "
                    <td>$row[contact]</td>
                    <td>$row[email]</td>
                    <td>$row[username]</td>
                    <td>$row[date_created]</td>
                    <td>
                        <!-- update and delete button -->
                        <a class='btn btn-primary btn-sm' href='coordinatorCrud/update_coor.php?id=$row[coor_id]'>Update</a>
                        <a class='btn btn-danger btn-sm' href='coordinatorCrud/del_coor.php?id=$row[coor_id]'>Archive</a>
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