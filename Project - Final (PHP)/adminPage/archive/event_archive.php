<?php
session_start();

$serername = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "alumni_management_system";
$conn = mysqli_connect($serername, $db_username, $db_password, $db_name);

// USER ACCOUNT DATA
if (isset($_SESSION['user_id'])) {
    $account = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT * FROM admin WHERE admin_id = ?");
    $stmt->bind_param("s", $account); // "s" indicates the type is string
    $stmt->execute();
    $user_result = $stmt->get_result();

    if ($user_result->num_rows > 0) {
        $user = $user_result->fetch_assoc();
    } else {
        // No user found with the given admin_id
    }

    $stmt->close();
} else {
    echo "User not logged in.";
}

// Close the database connection if needed
// $conn->close();


// Pagination configuration
$records_per_page = 5; // Number of records to display per page
$current_page = isset($_GET['page']) ? $_GET['page'] : 1; // Get current page number, default to 1

// Calculate the limit clause for SQL query
$start_from = ($current_page - 1) * $records_per_page;

// Initialize variables
$sql = "SELECT * FROM alumni_archive ";

// Check if search query is provided
if (isset($_GET['query']) && !empty($_GET['query'])) {
    $search_query = $_GET['query'];
    // Modify SQL query to include search filter
    $sql .= "WHERE alumni_id like '%$search_query%' or student_id like '%$search_query%' or fname LIKE '%$search_query%' or mname LIKE '%$search_query%' or lname LIKE '%$search_query' or address LIKE '%$search_query%' or email LIKE '%$search_query%' or (gender LIKE '%$search_query%' and gender != 'fe') ";
}

$sql .= "LIMIT $start_from, $records_per_page";

$result = $conn->query($sql);

// Count total number of records
$total_records = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM alumni_archive"));
$total_pages = ceil($total_records / $records_per_page);


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Alumni List</title>
    <link rel="stylesheet" href="./css/alumni.css">
    <link rel="shortcut icon" href="../../assets/cvsu.png" type="image/svg+xml">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script>
        "https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    </script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- FOR PAGINATION -->
    <style>
        /*  DESIGN FOR SEARCH BAR AND PAGINATION */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #368DB8;

        }

        .pagination {
            margin-top: 20px;
            text-align: center;

        }

        .pagination a {
            display: inline-block;
            padding: 8px 16px;
            text-decoration: none;
            background-color: #f1f1f1;
            color: black;
            border: 1px solid #ccc;
            margin-right: 5px;
            /* Added margin to separate buttons */
        }

        .pagination a.active {
            background-color: #4CAF50;
            color: white;
            border: 1px solid #4CAF50;
        }

        .pagination a:hover:not(.active) {
            background-color: #ddd;
        }

        .pagination .prev :hover {
            float: left;

            /* Float left for "Previous" link */
        }


        .pagination .next {
            float: right;
            /* Float right for "Next" link */
        }
    </style>

</head>

<body>
    <input type="checkbox" id="menu-toggle">
    <div class="sidebar">
        <div class="side-header">
            <h3><img src="https://cvsu-imus.edu.ph/student-portal/assets/images/logo-mobile.png"></img><span>CVSU</span></h3>
        </div>

        <div class="side-content">
            <div class="profile">
                <i class='bx bx-user bx-flip-horizontal'></i>
                <h4><?php echo $user['fname']; ?></h4>
                <small style="color: white;"><?php echo $user['email']; ?></small>
                <!-- <h4>ADMIN</h4>
                <small style="color: white;">admin@email.com</small> -->
            </div>

            <div class="side-menu">
                <ul>
                    <li>
                        <a href="../dashboard_admin.php">
                            <span class="las la-home" style="color:#fff"></span>
                            <small>DASHBOARD</small>
                        </a>
                    </li>
                    <li>
                        <a href="../profile/profile.php">
                            <span class="las la-user-alt" style="color:#fff"></span>
                            <small>PROFILE</small>
                        </a>
                    </li>
                    <li>
                        <a href="../alumni/alumni.php">
                            <span class="las la-th-list" style="color:#fff"></span>
                            <small>ALUMNI</small>
                        </a>
                    </li>
                    <li>
                        <a href="../coordinator/coordinator.php">
                            <span class="las la-user-cog" style="color:#fff"></span>
                            <small>COORDINATOR</small>
                        </a>
                    </li>
                    <li>
                        <a href="../event/event.php">
                            <span class="las la-calendar" style="color:#fff"></span>
                            <small>EVENT</small>
                        </a>
                    </li>
                    <li>
                        <a href="../settings/about.php">
                            <span class="las la-cog" style="color:#fff"></span>
                            <small>SETTINGS</small>
                        </a>
                    </li>
                    <li>
                        <a href="../report/report.php">
                            <span class="las la-clipboard-check" style="color:#fff"></span>
                            <small>REPORT</small>
                        </a>
                    </li>
                    <li>
                        <a href="./event_archive.php" class="active">
                            <span class="las la-archive" style="color:#fff"></span>
                            <small>ARCHIVE</small>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </div>

    <div class="main-content">

        <header>
            <div class="header-content">
                <label for="menu-toggle">
                    <span class="las la-bars bars" style="color: white;"></span>
                </label>

                <div class="header-menu">
                    <label for="">
                    </label>

                    <div class="user">


                        <a href="../logout.php">
                            <span class="las la-power-off" style="font-size: 30px; border-left: 1px solid #fff; padding-left:10px; color:#fff"></span>
                        </a>

                    </div>
                </div>
            </div>
        </header>


        <main>
            <div class="page-header">
                <h1><strong>Archive</strong></h1>
            </div>

            <div class="container-fluid" id="main-container">
                <div class="container-fluid" id="content-container">
                    <div class="container-title">
                        <span>Records</span>
                    </div>
                    <!-- <br>
                    <div class="container-title">
                        <a class='btn btn-secondary border border-dark' href='./alumni_archive.php' style="padding-left: 70px; padding-right: 70px; margin-right: 1%;">Alumni</a>
                        <a class='btn btn-light border border-dark' href='./coor_archive.php' style="padding-left: 70px; padding-right: 70px; margin-right: 1%;">Coordinator</a>
                        <a class='btn btn-light border border-dark' href='./event_archive.php' style="padding-left: 70px; padding-right: 70px;">Event</a>
                    </div> -->
                    <div class="congainer-fluid" id="column-header">
                        <div class="row">
                            <div class="col">
                                <div class="search">

                                    <form class="d-flex" role="search">
                                        <div class="container-fluid" id="search">
                                            <input class="form-control me-2" type="search" name="query" placeholder="Search Records..." aria-label="Search" value="<?php echo isset($_GET['query']) ? $_GET['query'] : ''; ?>">
                                            <button class="btn btn-outline-success" type="submit" style="padding-left: 30px; padding-right: 39px;">Search</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                            <div class="col">
                                <div class="add-button" style="margin-left: 20%; margin-right: 0;">
                                        <a class='btn btn-light border border-dark' href='./alumni_archive.php' style="padding-left: 55px; padding-right: 55px; margin-right: 1%;">Alumni</a>
                                        <a class='btn btn-light border border-dark' href='./coor_archive.php' style="padding-left: 37.7px; padding-right: 37.7px; margin-right: 1%;">Coordinator</a>
                                        <a class='btn btn-secondary border border-dark' href='./event_archive.php' style="padding-left: 59px; padding-right: 59px;">Event</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-content">
                        <table id="example" class="table-responsive table table-striped table-hover ">
                            <thead>

                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">STUDENT ID</th>
                                    <th scope="col">NAME</th>
                                    <th scope="col">GENDER</th>
                                    <th scope="col">COURSE</th>
                                    <th scope="col">BATCH</th>
                                    <th scope="col">CONNECTED TO</th>
                                    <th scope="col">CONTACT</th>
                                    <th scope="col">ADDRESS</th>
                                    <th scope="col">EMAIL</th>
                                    <th scope="col">USERNAME</th>
                                    <th scope="col">DATE CREATION</th>
                                    <th scope="col">DATE ARCHIVED</th>
                                    <th scope="col">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $fullname = $row["fname"] . " " . $row["mname"] . " " . $row["lname"];
                                        $batch = $row["batch_startYear"] . " - " . $row["batch_endYear"];
                                ?>
                                        <tr>
                                            <td><?php echo $row['alumni_id'] ?></td>
                                            <td><?php echo $row['student_id'] ?></td>
                                            <td><?php echo htmlspecialchars($fullname) ?></td>
                                            <td><?php echo $row['gender'] ?></td>
                                            <td><?php echo $row['course'] ?></td>
                                            <td><?php echo htmlspecialchars($batch) ?></td>
                                            <td><?php echo $row['connected_to'] ?></td>
                                            <td><?php echo $row['contact'] ?></td>
                                            <td><?php echo $row['address'] ?></td>
                                            <td><?php echo $row['email'] ?></td>
                                            <td><?php echo $row['username'] ?></td>
                                            <td><?php echo $row['date_created'] ?></td>
                                            <td><?php echo $row['date_archived'] ?></td>
                                            <?php
                                            echo "
                                                <td>
                                                    <div class='button'>
                                                        <a class='btn btn-success' href='./restore_event.php?id=$row[alumni_id]'>Restore</a>
                                                    </div>
                                                </td>
                                            "; ?>
                                        </tr>
                                <?php
                                    }
                                } else {
                                    echo '<tr><td colspan="12">No records found</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="container-fluid" id="main-container">
                <div class="container-fluid" id="content-container">
                    <div style="float:right; margin-right:5%;background-color:white; width:85%;border-radius:4px;">
                        <!-- Pagination links -->
                        <div class="pagination" style="float:right; margin-right:1.5%">
                            <!-- next and previous -->
                            <?php
                            if ($current_page > 1) : ?>
                                <a href="?page=<?= ($current_page - 1); ?>&query=<?php echo isset($_GET['query']) ? $_GET['query'] : ''; ?>" class="prev" style="border-radius:4px;background-color:#368DB8;color:white;margin-bottom:13px;">&laquo; Previous</a>
                            <?php endif; ?>

                            <?php if ($current_page < $total_pages) : ?>
                                <a href="?page=<?= ($current_page + 1); ?>&query=<?php echo isset($_GET['query']) ? $_GET['query'] : ''; ?>" class="next" style="border-radius:4px;background-color:#368DB8;color:white;margin-bottom:13px;">Next &raquo;</a>
                            <?php endif; ?>
                        </div>
                        <p style="margin-left:2%;margin-top:2.3%;">Page <?= $current_page ?> out of <?= $total_pages ?></p>
                    </div>
                </div>
            </div>
        </main>
</body>

</html>