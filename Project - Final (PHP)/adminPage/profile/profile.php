<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Admin Profile</title>
    <link rel="shortcut icon" href="../../assets/cvsu.png" type="image/svg+xml">
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    
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
                       <a href="../dashboard_admin.php" >
                            <span class="las la-home" style="color:#fff"></span>
                            <small>DASHBOARD</small>
                        </a>
                    </li>
                    <li>
                       <a href="./profile.php"class="active">
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
                            <span class="las la-map" style="color:#fff"></span>
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
                            <span class="las la-clipboard-check" style="color:#fff"></span>
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
                <h1>Profile</h1> 
            </div>
            
    <div class="page-content">
        <div class="row">
            <div class="container-fluid">
                <div class="content-header">
                    <img src="user-circle-regular-168.png" id="profile-pic">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="container-fluid">
                <div class="information">
                    <form>
                        <fieldset disabled>                          
                          <div class="mb-3">
                            <label for="disabledTextInput" class="form-label">ADMIN FULL NAME</label>
                            <input type="text" id="disabledTextInput" class="form-control" placeholder="Admin">
                          </div>                          
                          <div class="mb-3">
                            <label for="disabledTextInput" class="form-label">USERNAME</label>
                            <input type="text" id="disabledTextInput" class="form-control" placeholder="Admin123">
                          </div>                          
                          <div class="mb-3">
                            <label for="disabledTextInput" class="form-label">CONTACT NUMBER</label>
                            <input type="number" id="disabledTextInput" class="form-control" placeholder="09123456789">
                          </div>                          
                          <div class="mb-3">
                            <label for="disabledTextInput" class="form-label">EMAIL ADDRESS</label>
                            <input type="text" id="disabledTextInput" class="form-control" placeholder="admin@email.com">
                          </div>                          
                          <div class="mb-3">
                            <label for="disabledTextInput" class="form-label">PASSWORD</label>
                            <input type="text" id="disabledTextInput" class="form-control" placeholder="admin123">
                          </div>                          
                      </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="container-fluid">
                <div class="buttons">
                    <a href="./update.php"><button type="button" class="btn" id="button1">UPDATE INFO</button></a>
                    <a href="./change_pass.php"><button type="button" class="btn" id="button2">CHANGE PASSWORD</button></a>
                </div>
            </div>
        </div>
    </div>
</div>
           
</body>
</html>
