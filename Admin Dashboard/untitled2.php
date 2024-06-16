<?php
    // connect the php file to database alumni_management_system
    $serername="localhost";
    $db_username="root";
    $db_password="";
    $db_name="alumni_management_system";
    $conn=mysqli_connect($serername, $db_username, $db_password, $db_name);

    // check for error
    if(mysqli_connect_errno()){
        die("". mysqli_connect_error());
    }else{
        // display if no error in connection
        echo"Successfully Connected!";
    }
        
        //query for alumni count
        $sql = "SELECT COUNT(student_id) AS alumni_count FROM alumni";

        // connect in databse then run the query $sql
        $result = $conn->query($sql);
        // retrieve the data from database
        $row = $result->fetch_assoc();

        // get the exact query or in short COUNT(student_id) from table alumni,  COUNT(student_id) rename as alumni_count
        $count = $row['alumni_count'];

        //query for coordinators count
        $sql_coordinator = "SELECT COUNT(coor_id) AS coordinators_count FROM coordinator";

        // connect in databse then run the query $sql
        $result_coordinator = $conn->query($sql_coordinator);
         // retrieve the data from database
        $row_coordinator = $result_coordinator->fetch_assoc();
        // get the exact query or in short COUNT(coor_id) from table coordinator,  COUNT(coordinator_id) rename as coordinators_count
        $coordinator_count = $row_coordinator['coordinators_count'];

        //query for events count
        $sql_event = "SELECT COUNT(event_id) AS events_count FROM event";

        // connect in databse then run the query $sql
        $result_event = $conn->query($sql_event);
         // retrieve the data from database
        $row_event = $result_event->fetch_assoc();
        // get the exact query or in short COUNT(event_id) from table event,  COUNT(event_id) rename as events_count
        $event_count = $row_event['events_count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Modern Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <input type="checkbox" id="menu-toggle">
    <div class="sidebar">
        <div class="side-header">
            <h3><img src="https://cvsu-imus.edu.ph/student-portal/assets/images/logo-mobile.png"></img><span>CVSU</span></h3>
        </div>
        
        <div class="side-content">
            <div class="profile">
                <div class="profile-img bg-img" style="background-image: url(img/3.jpeg)"></div>
                <h4>ADMIN</h4>
                <small style="color: white;">admin@email.com</small>
            </div>

            <div class="side-menu">
                <ul>
                    <li>
                        <a href="dashboard.html" class="active">
                            <span class="las la-home" style="color:#fff"></span>
                            <small>Dashboard</small>
                        </a>
                    </li>
                    <li>
                        <a href="profile.html">
                            <span class="las la-user-alt" style="color:#fff"></span>
                            <small>Profile</small>
                        </a>
                    </li>
                    <li>
                        <a href="alumni-list.html">
                            <span class="las la-th-list" style="color:#fff"></span>
                            <small>ALUMNI LIST</small>
                        </a>
                    </li>
                    <li>
                        <a href="coordinator.html">
                            <span class="las la-user-cog" style="color:#fff"></span>
                            <small>COORDINATOR</small>
                        </a>
                    </li>
                    <li>
                        <a href="event.html">
                            <span class="las la-calendar" style="color:#fff"></span>
                            <small>EVENT</small>
                        </a>
                    </li>
                    <li>
                        <a href="page.html">
                            <span class="las la-map" style="color:#fff"></span>
                            <small>PAGE</small>
                        </a>
                    </li>
                    <li>
                        <a href="report.html">
                            <span class="las la-clipboard-check" style="color:#fff"></span>
                            <small>REPORT</small>
                        </a>
                    </li>
                    <li>
                        <a href="archive.html">
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
                        
                        
                        <a href="">
                        <span class="las la-power-off" style="font-size: 30px; border-left: 1px solid #fff; padding-left:10px; color:#fff"></span>
                        </a>

                    </div>
                </div>
            </div>
        </header>
        
        
        <main>
            
            <div class="page-header">
                <h1>Dashboard</h1>
            </div>
            
            <div class="page-content">
                <!-- Dashboard Items Start -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <i class="las la-user-graduate fa-3x"></i>
                                        <div class="ml-4">
                                            <div class="row mb-3">
                                                <!-- display Alumni Total Count -->
                                                <label style="font-size: 20px;">Alumni Total Count:</label>
                                                <!-- display alumni count in database -->
                                                <label class="col-sm-3 col-form-label" style="font-size: 30px;"><?php echo $count; ?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="http://localhost/nicol/adminpage/alumni.php" class="card-footer d-flex justify-content-between text-white">
                                    <span>View Details</span>
                                    <i class="las la-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <i class="las la-user-plus fa-3x"></i>
                                        <div class="ml-4">
                                            <div class="row mb-3">
                                                 <!-- Display Student Total Count -->
                                                <label style="font-size: 20px;">Coordinators Total Count:</label>
                                                <label class="col-sm-3 col-form-label" style="font-size: 30px;"><?php echo $coordinator_count; ?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="http://localhost/nicol/adminpage/coordinator.php" class="card-footer d-flex justify-content-between text-white">
                                    <span>View Details</span>
                                    <i class="las la-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-warning text-white mb-4">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <i class="las la-calendar-alt fa-3x"></i>
                                        <div class="ml-4">
                                        <div class="row mb-3">
                                                 <!-- Display Student Total Count -->
                                                <label style="font-size: 20px;">Events Total Count:</label>
                                                <label class="col-sm-3 col-form-label" style="font-size: 30px;"><?php echo $event_count; ?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="http://localhost/nicol/adminpage/event.php" class="card-footer d-flex justify-content-between text-white">
                                    <span>View Details</span>
                                    <i class="las la-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-danger text-white mb-4">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <i class="las la-users fa-3x"></i>
                                        <div class="ml-4">
                                            <h5>Total Visits</h5>
                                            <h2>10,000</h2>
                                        </div>
                                    </div>
                                </div>
                                <a href="report.html" class="card-footer d-flex justify-content-between text-white">
                                    <span>View Details</span>
                                    <i class="las la-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Dashboard Items End -->
            </div>
        
        </main>
    </div>
</body>
</html>