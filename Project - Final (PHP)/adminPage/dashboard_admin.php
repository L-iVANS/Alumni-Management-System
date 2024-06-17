<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Admin Dashboard</title>
    <link rel="shortcut icon" href="../assets/cvsu.png" type="image/svg+xml">
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
                        <a href="./dashboard_admin.php" class="active">
                            <span class="las la-home" style="color:#fff"></span>
                            <small>DASHBOARD</small>
                        </a>
                    </li>
                    <li>
                        <a href="./profile/profile.php">
                            <span class="las la-user-alt" style="color:#fff"></span>
                            <small>PROFILE</small>
                        </a>
                    </li>
                    <li>
                        <a href="./alumni/alumni.php">
                            <span class="las la-th-list" style="color:#fff"></span>
                            <small>ALUMNI</small>
                        </a>
                    </li>
                    <li>
                        <a href="./coordinator/coordinator.php">
                            <span class="las la-user-cog" style="color:#fff"></span>
                            <small>COORDINATOR</small>
                        </a>
                    </li>
                    <li>
                        <a href="./event/event.php">
                            <span class="las la-calendar" style="color:#fff"></span>
                            <small>EVENT</small>
                        </a>
                    </li>
                    <li>
                        <a href="./settings/about.php">
                            <span class="las la-cog" style="color:#fff"></span>
                            <small>SETTINGS</small>
                        </a>
                    </li>
                    <li>
                        <a href="./report/report.php">
                            <span class="las la-clipboard-check" style="color:#fff"></span>
                            <small>REPORT</small>
                        </a>
                    </li>
                    <li>
                        <a href="./archive/alumni_archive.php">
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
                        
                        
                        <a href="./logout.php">
                        <span class="las la-power-off" style="font-size: 30px; border-left: 1px solid #fff; padding-left:10px; color:#fff"></span>
                        </a>

                    </div>
                </div>
            </div>
        </header>
        
        
        <main>
            
            <div class="page-header">
                <h1><strong>Dashboard</strong></h1>
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
                                            <h5>Alumni</h5>
                                            <h2>1000</h2>
                                        </div>
                                    </div>
                                </div>
                                <a href="alumni/alumni.php" class="card-footer d-flex justify-content-between text-white">
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
                                            <h5>Coordinators</h5>
                                            <h2>7</h2>
                                        </div>
                                    </div>
                                </div>
                                <a href="coordinator/coordinator.php" class="card-footer d-flex justify-content-between text-white">
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
                                            <h5>Events</h5>
                                            <h2>5</h2>
                                        </div>
                                    </div>
                                </div>
                                <a href="event/event.php" class="card-footer d-flex justify-content-between text-white">
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
                                <a href="report/report.php" class="card-footer d-flex justify-content-between text-white">
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