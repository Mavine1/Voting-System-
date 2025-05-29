<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Voting System Header</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        @keyframes floatBooks {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            25% { transform: translateY(-10px) rotate(2deg); }
            50% { transform: translateY(-5px) rotate(-1deg); }
            75% { transform: translateY(-15px) rotate(1deg); }
        }

        @keyframes floatTrophy {
            0%, 100% { transform: translateY(0px) rotate(0deg) scale(1); }
            33% { transform: translateY(-8px) rotate(-2deg) scale(1.05); }
            66% { transform: translateY(-12px) rotate(2deg) scale(0.95); }
        }

        @keyframes shimmer {
            0% { opacity: 0.3; }
            50% { opacity: 0.8; }
            100% { opacity: 0.3; }
        }

        .main-header {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 25%, #e2e8f0 50%, #cbd5e1 75%, #1e40af 100%);
            position: relative;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(30, 64, 175, 0.2);
        }

        .main-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%231e40af" opacity="0.1"><path d="M6 2h12a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2zm6 2a1 1 0 0 0-1 1v14a1 1 0 0 0 2 0V5a1 1 0 0 0-1-1z"/></svg>') 50px 20px,
                url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%23ef4444" opacity="0.15"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>') 200px 30px,
                url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%231e40af" opacity="0.08"><path d="M19 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/></svg>') 350px 25px,
                url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%23ffffff" opacity="0.12"><path d="M7 2v2h10V2h2v2h3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h3V2h2z"/></svg>') 500px 15px;
            background-size: 30px 30px, 25px 25px, 35px 35px, 28px 28px;
            background-repeat: no-repeat;
            animation: floatBooks 6s ease-in-out infinite;
            z-index: 1;
        }

        .floating-trophy {
            position: absolute;
            right: 100px;
            top: 10px;
            font-size: 28px;
            color: #ef4444;
            animation: floatTrophy 4s ease-in-out infinite;
            z-index: 2;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }

        .floating-book-1 {
            position: absolute;
            left: 80px;
            top: 15px;
            font-size: 24px;
            color: #1e40af;
            animation: floatBooks 7s ease-in-out infinite 0.5s;
            z-index: 2;
        }

        .floating-book-2 {
            position: absolute;
            right: 300px;
            top: 8px;
            font-size: 20px;
            color: #ffffff;
            animation: floatBooks 5s ease-in-out infinite 1s;
            z-index: 2;
        }

        .floating-graduation {
            position: absolute;
            left: 250px;
            top: 12px;
            font-size: 22px;
            color: #ef4444;
            animation: shimmer 3s ease-in-out infinite;
            z-index: 2;
        }

        .logo {
            background: linear-gradient(135deg, #ffffff, #e2e8f0) !important;
            position: relative;
            z-index: 3;
            border-radius: 6px;
            margin: 4px;
            box-shadow: 0 2px 4px rgba(30, 64, 175, 0.1);
        }

        .logo-mini, .logo-lg {
            background: transparent !important;
            color: #1e40af !important;
            font-weight: 600;
        }

        .navbar {
            background: linear-gradient(135deg, #ffffff, #f8fafc) !important;
            position: relative;
            z-index: 3;
        }

        .dropdown-toggle {
            background: rgba(255, 255, 255, 0.9) !important;
            color: #1e40af !important;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .dropdown-toggle:hover {
            background: rgba(248, 250, 252, 0.9) !important;
            transform: translateY(-1px);
        }

        .dropdown-menu {
            background: linear-gradient(135deg, #ffffff, #f8fafc) !important;
            border: 1px solid #1e40af;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(30, 64, 175, 0.2);
        }

        .user-header {
            background: linear-gradient(135deg, #ffffff, #f8fafc) !important;
            color: #1e40af !important;
            border-radius: 8px 8px 0 0;
        }

        .user-footer {
            background: linear-gradient(135deg, #ffffff, #f8fafc) !important;
            color: #1e40af !important;
            border-radius: 0 0 8px 8px;
        }

        .btn-update {
            background: linear-gradient(135deg, #1e40af, #1d4ed8) !important;
            color: white !important;
            border: none;
            border-radius: 6px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(30, 64, 175, 0.3);
        }

        .btn-update:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(30, 64, 175, 0.4);
        }

        .btn-signout {
            background: linear-gradient(135deg, #ef4444, #dc2626) !important;
            color: white !important;
            border: none;
            border-radius: 6px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(239, 68, 68, 0.3);
        }

        .btn-signout:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(239, 68, 68, 0.4);
        }

        .marquee-text {
            color: #1e40af !important;
            font-weight: 600;
            text-shadow: 1px 1px 2px rgba(255,255,255,0.7);
        }
    </style>
</head>
<body>

<header class="main-header">
    <!-- Floating decorative elements -->
    <i class="fas fa-trophy floating-trophy"></i>
    <i class="fas fa-book floating-book-1"></i>
    <i class="fas fa-book-open floating-book-2"></i>
    <i class="fas fa-graduation-cap floating-graduation"></i>
    
    <!-- Logo -->
    <a href="#" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>O</b>VS</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg marquee-text" style="font-size: 22px; font-family:Times">
            <marquee behavior="scroll" direction="left">Online Voting System</marquee>
        </span>
    </a>
    
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu" style="color:#1e40af; font-size: 17px; font-family:Times">
            <ul class="nav navbar-nav">
                <!-- User Account -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="font-size: 17px; font-family:Times">
                        <img src="<?php echo (!empty($user['photo'])) ? '../images/'.$user['photo'] : '../images/profile.jpg'; ?>" class="user-image" alt="User Image">
                        <span class="hidden-xs"><?php echo $user['firstname'].' '.$user['lastname']; ?></span>
                    </a>
                    <ul class="dropdown-menu" style="font-size: 17px; font-family:Times">
                        <!-- User image -->
                        <li class="user-header" style="font-size: 17px; font-family:Times">
                            <img src="<?php echo (!empty($user['photo'])) ? '../images/'.$user['photo'] : '../images/profile.jpg'; ?>" class="img-circle" alt="User Image">
                            <p>
                                <?php echo $user['firstname'].' '.$user['lastname']; ?>
                                <small>Member since <?php echo date('M. Y', strtotime($user['created_on'])); ?></small>
                            </p>
                        </li>
                        <li class="user-footer" style="font-size: 17px; font-family:Times">
                            <div class="pull-left">
                                <a href="#profile" data-toggle="modal" class="btn btn-default btn-curve btn-update" id="admin_profile">
                                    <i class="fas fa-user-edit"></i> Update
                                </a>
                            </div>
                            <div class="pull-right">
                                <a href="logout.php" class="btn btn-default btn-curve btn-signout">
                                    <i class="fas fa-sign-out-alt"></i> Sign out
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>

<?php include 'includes/profile_modal.php'; ?>

</body>
</html>