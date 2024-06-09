<?php include "database1.php" ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>
    <title>Profile</title>
</head>

<body style="margin: 100px;">
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->
    

    <H3>Alumni List</H3>
    <table id="myTable" class="table">
            <thead>
            <th>Student ID</th>
            <th>Name</th>
            <th>Course</th>
            <th>Batch</th>
            <th>Currently Connected To</th>
            <th>Contact</th>
            <th>Email</th>
            <th>Username</th>
            <th>Date Created</th>
            <th>Action</th>
            </thead>

            <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <td><?php echo $row['student_id']; ?></td>
                <td><?php echo $row['alumni_name']; ?></td>
                <td><?php echo $row['course']; ?></td>
                <td><?php echo $row['batch']; ?></td>
                <td><?php echo $row['connected_to']; ?></td>
                <td><?php echo $row['contact']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['date_created']; ?></td>
                <td>
                    <a class="btn btn-success btn-sm" href="view ">Update</a>
                    <a class="btn btn-primary btn-sm" href="Update ">Update</a>
                    <a class="btn btn-danger btn-sm" href="archive ">Archive</a>
                </td>
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
    <script>
        let table = new DataTable('#myTable');
        // $(document).ready( function () {
        //     $('#myTable').DataTable();
        // });
    </script>
</body>

</html>