<?php 
    include_Once('database.php');
    // get page number
    if(isset($_GET['page_no']) && $_GET['page_no'] !== ""){
        $page_no = $_GET['page_no'];
    }else{
        $page_no = 1;
    }

    $total_records_per_page = 5;
    $offset = ($page_no -1) * $total_records_per_page;
    $previous_page = $page_no - 1;
    $next_page = $page_no + 1;

    $result_count = mysqli_query($conn, "SELECT COUNT(*) as total_records FROM alumni") or die(mysqli_error($conn));
    $records = mysqli_fetch_array($result_count);
    $total_records = $records['total_records'];
    $total_no_of_pages = ceil($total_records / $total_records_per_page);

    $sql = "SELECT *FROM alumni LIMIT $offset, $total_records_per_page";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Profile</title>
</head>
<body style="margin: 100px;">
    <br>
    <form action="" method="GET">
        <div class="input-group mb-3" style="width: 30%;">
            <input type="text" name="search" value="<?php if(isset($_GET['search'])){echo $_GET['search'];} ?>" class="form-control" placeholder="Search data">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>
    <br>
    <hr>
    <br>
    <H3>Alumni List</H3>
    <table class="table">
        <tr>
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
        </tr>
        <tr>
        <?php
            if(isset($_GET['search'])){
                $filtervalues = $_GET['serach'];
                $query = "SELECT * FROM alumni WHERE CONCAT(student_id, alumni_name, course, batch, email) LIKE '%$filtervalues%' ";
                $query_run = mysqli_query($conn, $query);
                
                if(mysqli_num_rows($query_run) > 0){
                    foreach($query_run as $items){
                       ?>
                        <td><?php $item['student_id']; ?></td>
                        <td><?php $item['alumni_name']; ?></td>
                        <td><?php $item['course']; ?></td>
                        <td><?php $item['batch']; ?></td>
                        <td><?php $item['connected_to']; ?></td>
                        <td><?php $item['contact']; ?></td>
                        <td><?php $item['email']; ?></td>
                        <td><?php $item['username']; ?></td>
                        <td><?php $item['date_created']; ?></td>
                       <?php
                    }
                }else{
                    ?>
                    <td><?php echo $row['student_id']; ?></td>
                    <?php 
                }
            }



            while($row = mysqli_fetch_assoc($result))
            {
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
            <td><a class="btn btn-success btn-sm" href="view ">Update</a></td>
            <td><a class="btn btn-primary btn-sm" href="Update ">Update</a></td>
            <td><a class="btn btn-danger btn-sm" href="archive ">Archive</a></td>
            </tr>
            <?php
                }
                mysqli_close($conn);
            ?>
    </table>
    <br>
    <nav aria-label="Page navigation example">
        <ul class="pagination">
        <li class="page-item"><a class="page-link" <?= ($page_no <= 1) ? 'disabled' : ''; ?> " <?= ($page_no > 1) ? 'href=?page_no=' . $previous_page : ''; ?>>First</a></li>
            <li class="page-item"><a class="page-link" <?= ($page_no <= 1) ? 'disabled' : ''; ?> " <?= ($page_no > 1) ? 'href=?page_no=' . $previous_page : ''; ?>>Prev</a></li>
            <li class="page-item"><a class="page-link" <?= ($page_no >= $total_no_of_pages) ? 'disabled' : ''; ?> " <?= ($page_no < $total_no_of_pages) ? 'href=?page_no=' . $next_page : ''; ?>>Next</a></li>
            <li class="page-item"><a class="page-link" <?= ($page_no <= 1) ? 'disabled' : ''; ?> " <?= ($page_no > 1) ? 'href=?page_no=' . $previous_page : ''; ?>>Last</a></li>
        </ul>
    </nav>
    <div class="p-10" ></div>
        <strong>Page <?= $page_no; ?> of <?= $total_no_of_pages?></strong>
    <br>
    <hr>
    <br>

</body>

</html>