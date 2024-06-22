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

// Pagination configuration
$records_per_page = 6; // Number of records to display per page
$current_page = isset($_GET['page']) ? $_GET['page'] : 1; // Get current page number, default to 1

// Calculate the limit clause for SQL query
$start_from = ($current_page - 1) * $records_per_page;

// Initialize variables
$sql = "SELECT * FROM event ";

// Check if search query is provided
if (isset($_GET['query']) && !empty($_GET['query'])) {
    $search_query = $_GET['query'];
    // Modify SQL query to include search filter
    $sql .= "WHERE event_id LIKE '%$search_query%' 
            OR title LIKE '%$search_query%' 
            OR sched_date LIKE '%$search_query%' 
            OR sched_time LIKE '%$search_query%'
            OR description LIKE '%$search_query%'";
}

$sql .= "LIMIT $start_from, $records_per_page";

$result = $conn->query($sql);

// Count total number of records
$total_records_query = "SELECT COUNT(*) FROM event";
if (isset($_GET['query']) && !empty($_GET['query'])) {
    $total_records_query .= " WHERE event_id LIKE '%$search_query%' 
                              OR title LIKE '%$search_query%' 
                              OR sched_date LIKE '%$search_query%' 
                              OR sched_time LIKE '%$search_query%'
                              OR description LIKE '%$search_query%'";
}
$total_records_result = mysqli_query($conn, $total_records_query);
$total_records_row = mysqli_fetch_array($total_records_result);
$total_records = $total_records_row[0];

$total_pages = ceil($total_records / $records_per_page);


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Event List</title>
    <link rel="stylesheet" href="./css/alumni.css">
    <link rel="shortcut icon" href="../../assets/cvsu.png" type="image/svg+xml">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script>
        "https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    </script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- FOR PAGINATION -->
    <style>
        /*  DESIGN FOR SEARCH BAR AND PAGINATION */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            text-align: left;
        }

        .inline {
            border: 1px solid #dddddd;
            padding: 8px;
            font-size: 12px;
            white-space: nowrap;
            /* Prevent text from wrapping */
            overflow: hidden;
            /* Hide overflowing content */
            text-overflow: ellipsis;
            /* Display ellipsis for truncated text */
            max-width: 130px;
            /* Set a max-width to control truncation */

        }

        .act {
            max-width: 235px;
            text-align: center;
            /* Set a max-width to control truncation */
        }

        th {
            background-color: #368DB8;
            font-weight: bold;
            text-align: center;
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
            <i class="bi bi-person-circle"></i>
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
                        <a href="./event.php" class="active">
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
                        <a href="../archive/alumni_archive.php">
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
                <h1><strong>Event</strong></h1>
            </div>

            <div class="container-fluid" id="main-container">
                <div class="container-fluid" id="content-container">
                    <div class="container-title">
                        <span>Records</span>
                    </div>
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
                            <div class="col" id="add-btn">
                                <div class="add-button">
                                    <div class="span">
                                        <a href='./add_event.php'>
                                            <button id="add-new-btn">Add New +</button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-content">
                        <table id="example" class="table-responsive table table-striped table-hover ">
                            <thead>

                                <tr>
                                    <th scope="col" class="inline">ID</th>
                                    <th scope="col" class="inline">TITLE</th>
                                    <th scope="col" class="inline">SCHEDULE</th>
                                    <th scope="col" class="inline">DESCRIPTION</th>
                                    <th scope="col" class="inline">GOING</th>
                                    <th scope="col" class="inline">INTERESTED</th>
                                    <th scope="col" class="inline">NOT INTERESTED</th>
                                    <th scope="col" class="inline">DATE CREATED</th>
                                    <th scope="col" class="inline">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $schedule = $row["sched_date"] . "  " . $row["sched_time"];
                                        
                                ?>
                                        <tr>
                                            <td class="inline"><?php echo $row['event_id'] ?></td>
                                            <td class="inline"><?php echo $row['title'] ?></td>
                                            <td class="inline"><?php echo htmlspecialchars($schedule) ?></td>
                                            <td class="inline"><?php echo $row['description'] ?></td>
                                            <td class="inline"><?php echo $row['going'] ?></td>
                                            <td class="inline"><?php echo $row['interested'] ?></td>
                                            <td class="inline"><?php echo $row['not_interested'] ?></td>
                                            <td class="inline"><?php echo $row['date_created'] ?></td>
                                            <?php
                                            echo "
                                                <td class='inline act'>
                                                    <div class='button'>
                                                        <a class='btn btn-warning btn-sm' href='./update_event.php?id=$row[event_id]' style='font-size: 11.8px;'>Update</a>
                                                        <a class='btn btn-danger btn-sm' href='./del_event.php?id=$row[event_id]' style='font-size: 11.8px;'>Archive</a>
                                                    </div>
                                                </td>
                                            "; ?>
                                        </tr>
                                <?php
                                    }
                                } else {
                                    $current_page = 0;
                                    echo '<tr><td colspan="12" style="text-align: center;">No records found</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>

                    </div>

                    <div>
                        <!-- Pagination links -->
                        <div class="pagination" id="content" style="float:right; margin-right:1.5%">
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
            <!-- <div class="container-fluid" id="main-container">
                <div class="container-fluid" id="content-container">
                    
                </div>
            </div> -->
        </main>
        <script>
            document.addEventListener('DOMContentLoaded', (event) => {
                let currentPage = 1;

                function loadPage(page) {
                    // Simulate an AJAX request to get page content
                    const contentDiv = document.getElementById('content');
                    contentDiv.innerHTML = `Content for page ${page}`; // Replace with actual AJAX call
                    currentPage = page;
                }

                document.getElementById('prevPage').addEventListener('click', (event) => {
                    event.preventDefault();
                    if (currentPage > 1) {
                        loadPage(currentPage - 1);
                    }
                });

                document.getElementById('nextPage').addEventListener('click', (event) => {
                    event.preventDefault();
                    loadPage(currentPage + 1);
                });

                // Initial load
                loadPage(currentPage);
            });
        </script>
</body>

</html>