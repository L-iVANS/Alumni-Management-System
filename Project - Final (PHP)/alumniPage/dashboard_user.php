<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Alumni Dasboard</title>
    <link rel="shortcut icon" href="../assets/cvsu.png" type="image/svg+xml">
    <link rel="stylesheet" href="dashboard_user.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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
                <h4>ALUMNI</h4>
                <small style="color: white;">user@email.com</small>
            </div>

            <div class="side-menu">
                <ul>
                    <li>
                       <a href="./dashboard_user.php" class="active">
                            <span class="las la-home" style="color:#fff"></span>
                            <small>DASHBOARD</small>
                        </a>
                    </li>
                    <li>
                       <a href="./profile/profile.php" >
                            <span class="las la-user-alt" style="color:#fff"></span>
                            <small>PROFILE</small>
                        </a>
                    </li>
                    <li>
                       <a href="./event/event.php">
                            <span class="las la-calendar" style="color:#fff"></span>
                            <small>EVENT</small>
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
                    <span class="las la-bars"></span>
                </label>
                <!-- <span class="header-title">ALUMNI MANAGEMENT SYSTEM</span>  -->
                <div class="header-menu">
                    <label for="">
                    </label>
                    
                    <div class="notify-icon">
                    </div>
                    
                    <div class="notify-icon">   
                    </div>
                    
                    <div class="user">
                        <div class="bg-img" style="background-image: url(img/1.jpeg)"></div>
                        
                        <a href="./logout.php">
                        <span class="las la-power-off"></span>
                        </a>

                    </div>
                </div>
            </div>
        </header>
        
        
        <main>
            
            <div class="page-header">
                <h1><Strong>Dashboard</Strong></h1>
            </div>
        </main>
            <div class="page-content">
                <!--  -->
            </div>
    </div>
</body>
</html>
