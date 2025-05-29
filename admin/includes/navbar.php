<header class="main-header" style="background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #ef4444 100%);">
  <!-- Logo -->
  <a href="#" class="logo" style="background: linear-gradient(135deg, #1e40af 0%, #2563eb 100%);">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini" style="background: linear-gradient(135deg, #1e40af 0%, #2563eb 100%);"><b>O</b>VS</span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg" style="background: linear-gradient(135deg, #1e40af 0%, #2563eb 100%); color: #ffffff; font-size: 22px; font-family: Times;">
      <marquee behavior="scroll" direction="left">Text Book Centre</marquee>
    </span>
  </a>

  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top" style="background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #ef4444 100%);">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>

    <div class="navbar-custom-menu" style="color: #ffffff; font-size: 17px; font-family: Times;">
      <ul class="nav navbar-nav" style="background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #ef4444 100%); color: #ffffff; font-size: 17px; font-family: Times;">
        <!-- User Account: style can be found in dropdown.less -->
        <li class="dropdown user user-menu" style="color: #ffffff;">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="background: linear-gradient(135deg, #1e40af 0%, #2563eb 100%); color: #ffffff; font-size: 17px; font-family: Times;">
            <img src="<?php echo (!empty($user['photo'])) ? '../images/' . $user['photo'] : '../images/profile.jpg'; ?>" class="user-image" alt="User Image">
            <span class="hidden-xs"><?php echo $user['firstname'] . ' ' . $user['lastname']; ?></span>
          </a>

          <ul class="dropdown-menu" style="background: linear-gradient(135deg, #1e40af 0%, #ef4444 100%); color: #ffffff; font-size: 17px; font-family: Times;">
            <!-- User image -->
            <li class="user-header" style="background: linear-gradient(135deg, #1e40af 0%, #ef4444 100%); color: #ffffff; font-size: 17px; font-family: Times;">
              <img src="<?php echo (!empty($user['photo'])) ? '../images/' . $user['photo'] : '../images/profile.jpg'; ?>" class="img-circle" alt="User Image">
              <p>
                <?php echo $user['firstname'] . ' ' . $user['lastname']; ?>
                <small>Member since <?php echo date('Y'); ?></small>
              </p>
            </li>

            <li class="user-footer" style="background: linear-gradient(135deg, #2563eb 0%, #dc2626 100%); color: #ffffff; font-size: 17px; font-family: Times;">
              <div class="pull-left" style="background: transparent; color: #ffffff; font-size: 17px; font-family: Times;">
                <a href="#profile" data-toggle="modal" class="btn btn-default btn-curve" style="background-color: #ffffff; color: #1e40af; border: 2px solid #1e40af;" id="admin_profile">Update</a>
              </div>

              <div class="pull-right" style="background: transparent; color: #ffffff; font-size: 17px; font-family: Times;">
                <a href="logout.php" class="btn btn-default btn-curve" style="background-color: #ffffff; color: #ef4444; border: 2px solid #ef4444;">Sign out</a>
              </div>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>

<?php include 'includes/profile_modal.php'; ?>