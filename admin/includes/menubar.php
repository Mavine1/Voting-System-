<aside class="main-sidebar" style="background: linear-gradient(180deg, #1e3a8a 0%, #1e40af 100%); box-shadow: 2px 0 10px rgba(0,0,0,0.1);">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar" style="background: transparent;">
    <!-- Sidebar user panel -->
    <div class="user-panel" style="height: 80px; padding: 15px; border-bottom: 2px solid rgba(255,255,255,0.1); margin-bottom: 20px;">
      <div class="pull-left image">
        <img src="<?php echo (!empty($user['photo'])) ? '../images/'.$user['photo'] : '../images/profile.jpg'; ?>" 
             class="img-square" 
             alt="User Image" 
             style="width: 50px; height: 50px; border-radius: 50%; border: 3px solid #dc2626; object-fit: cover;">
      </div>
      <div class="pull-left info" style="margin-left: 15px; padding-top: 5px;">
        <p style="color: white; font-size: 16px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-weight: 600; margin-bottom: 5px;">
          <?php echo $user['firstname'].' '.$user['lastname']; ?>
        </p>
        <a style="text-decoration: none;">
          <i class="fa fa-circle" style="color: #10b981; font-size: 8px;"></i>  
          <b style="color: #e5e7eb; font-size: 13px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin-left: 5px;">Online</b>
        </a>
      </div>
    </div>
    
    <!-- sidebar menu -->
    <ul class="sidebar-menu" data-widget="tree" style="background: transparent; list-style: none; padding: 0; margin: 0;">
      
      <!-- REPORTS Section -->
      <li class="header" style="background: linear-gradient(90deg, #dc2626, #b91c1c); color: white; font-size: 11px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-weight: 700; padding: 10px 20px; margin: 0 0 5px 0; text-transform: uppercase; letter-spacing: 1px;">
        REPORTS
      </li>
      <li style="margin-bottom: 2px;">
        <a href="home.php" style="display: block; padding: 12px 20px; color: white; text-decoration: none; transition: all 0.3s ease; border-left: 3px solid transparent;">
          <i class="fa fa-dashboard" style="color: #60a5fa; margin-right: 10px; width: 16px;"></i> 
          <span style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px;">Dashboard</span>
        </a>
      </li>
      <li style="margin-bottom: 2px;">
        <a href="votes.php" style="display: block; padding: 12px 20px; color: white; text-decoration: none; transition: all 0.3s ease; border-left: 3px solid transparent;">
          <span class="glyphicon glyphicon-lock" style="color: #60a5fa; margin-right: 10px; width: 16px;"></span> 
          <span style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px;">Total votes</span>
        </a>
      </li>
      
      <!-- MANAGE Section -->
      <li class="header" style="background: linear-gradient(90deg, #dc2626, #b91c1c); color: white; font-size: 11px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-weight: 700; padding: 10px 20px; margin: 15px 0 5px 0; text-transform: uppercase; letter-spacing: 1px;">
        MANAGE
      </li>
      <li style="margin-bottom: 2px;">
        <a href="voters.php" style="display: block; padding: 12px 20px; color: white; text-decoration: none; transition: all 0.3s ease; border-left: 3px solid transparent;">
          <i class="fa fa-users" style="color: #60a5fa; margin-right: 10px; width: 16px;"></i> 
          <span style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px;">Voters</span>
        </a>
      </li>
      <li style="margin-bottom: 2px;">
        <a href="positions.php" style="display: block; padding: 12px 20px; color: white; text-decoration: none; transition: all 0.3s ease; border-left: 3px solid transparent;">
          <i class="fa fa-tasks" style="color: #60a5fa; margin-right: 10px; width: 16px;"></i> 
          <span style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px;">Positions</span>
        </a>
      </li>
      <li style="margin-bottom: 2px;">
        <a href="candidates.php" style="display: block; padding: 12px 20px; color: white; text-decoration: none; transition: all 0.3s ease; border-left: 3px solid transparent;">
          <i class="fa fa-black-tie" style="color: #60a5fa; margin-right: 10px; width: 16px;"></i> 
          <span style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px;">Candidates</span>
        </a>
      </li>
      
      <!-- SETTINGS Section -->
      <li class="header" style="background: linear-gradient(90deg, #dc2626, #b91c1c); color: white; font-size: 11px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-weight: 700; padding: 10px 20px; margin: 15px 0 5px 0; text-transform: uppercase; letter-spacing: 1px;">
        SETTINGS
      </li>
      <li style="margin-bottom: 2px;">
        <a href="#config" data-toggle="modal" style="display: block; padding: 12px 20px; color: white; text-decoration: none; transition: all 0.3s ease; border-left: 3px solid transparent;">
          <i class="fa fa-cogs" style="color: #60a5fa; margin-right: 10px; width: 16px;"></i> 
          <span style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px;">Election Title</span>
        </a>
      </li>
    </ul>
  </section>
  <!-- /.sidebar -->
  
  <style>
    /* Hover effects for menu items */
    .sidebar-menu li a:hover {
      background: rgba(255, 255, 255, 0.1) !important;
      border-left: 3px solid #dc2626 !important;
      transform: translateX(5px);
    }
    
    /* Active state styling */
    .sidebar-menu li.active a {
      background: rgba(220, 38, 38, 0.2) !important;
      border-left: 3px solid #dc2626 !important;
    }
    
    /* Smooth transitions */
    .sidebar-menu li a {
      transition: all 0.3s ease !important;
    }
    
    /* User panel hover effect */
    .user-panel:hover {
      background: rgba(255, 255, 255, 0.05);
      border-radius: 8px;
      transition: all 0.3s ease;
    }
  </style>
</aside>
<?php include 'config_modal.php'; ?>