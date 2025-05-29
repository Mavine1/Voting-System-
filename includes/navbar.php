<header class="main-header" style="background-color: #1e40af; box-shadow: 0 4px 15px rgba(220, 38, 38, 0.4), inset 0 1px 0 rgba(220, 38, 38, 0.3);">
  <nav class="navbar navbar-static-top" style="background-color: #1e40af;">
    <div class="container" style="background-color: #1e40af;">
      <div class="navbar-header" style="background-color: #1e40af;">
        <a href="#" class="navbar-brand" style="background-color: #1e40af; color: #ffffff; font-size: 22px; font-family: Times; text-decoration: none; text-shadow: 2px 2px 4px rgba(220, 38, 38, 0.6);">
          <b>Text <b>Book</b> Centre</b>
        </a>

      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
        <ul class="nav navbar-nav">
          <?php
            if(isset($_SESSION['student'])){
              echo "
                <li><a href='index.php' style='color: #ffffff; font-family: Times; font-size: 16px; padding: 15px 20px; text-shadow: 1px 1px 3px rgba(220, 38, 38, 0.5);'>HOME</a></li>
                <li><a href='transaction.php' style='color: #ffffff; font-family: Times; font-size: 16px; padding: 15px 20px; text-shadow: 1px 1px 3px rgba(220, 38, 38, 0.5);'>TRANSACTION</a></li>
              ";
            } 
          ?>
        </ul>
      </div>
      <!-- /.navbar-collapse -->
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="user user-menu">
            <a href="" style="color: #ffffff; padding: 10px 15px;">
              <img src="<?php echo (!empty($voter['photo'])) ? 'images/'.$voter['photo'] : 'images/profile.jpg' ?>" class="user-image" alt="User Image" style="border: 2px solid #ffffff; border-radius: 50%; box-shadow: 0 2px 8px rgba(220, 38, 38, 0.4);">
              <span class="hidden-xs" style="color: #ffffff; font-size: 18px; font-family: Times; margin-left: 10px; text-shadow: 1px 1px 3px rgba(220, 38, 38, 0.5);">
                <?php echo $voter['firstname'].' '.$voter['lastname']; ?>
              </span>
            </a>
          </li>
          <li>
            <a href="logout.php" style="color: #ffffff; padding: 15px 20px; text-decoration: none;">
              <i class="fa fa-sign-out" style="color: #ffffff; font-size: 18px; margin-right: 5px; text-shadow: 1px 1px 3px rgba(220, 38, 38, 0.5);"></i>
              <b style="color: #ffffff; font-size: 18px; font-family: Times; text-shadow: 1px 1px 3px rgba(220, 38, 38, 0.5);">LOGOUT</b>
            </a>
          </li>  
        </ul>
      </div>
      <!-- /.navbar-custom-menu -->
    </div>
    <!-- /.container-fluid -->
  </nav>
</header>

<style>
/* Additional CSS for hover effects and better styling with blue background and red shadows */
.navbar-nav > li > a:hover {
    background-color: rgba(220, 38, 38, 0.2) !important;
    color: #ffffff !important;
    box-shadow: 0 2px 8px rgba(220, 38, 38, 0.4);
    transform: translateY(-2px);
    transition: all 0.3s ease;
}

.navbar-brand:hover {
    background-color: rgba(220, 38, 38, 0.15) !important;
    color: #ffffff !important;
    text-shadow: 3px 3px 6px rgba(220, 38, 38, 0.8) !important;
    transform: scale(1.02);
    transition: all 0.3s ease;
}

.user-image {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    margin-right: 10px;
}

.navbar-toggle:hover {
    background-color: rgba(220, 38, 38, 0.2) !important;
    box-shadow: 0 2px 6px rgba(220, 38, 38, 0.3);
}

.user-menu a:hover {
    background-color: rgba(220, 38, 38, 0.15) !important;
    box-shadow: 0 3px 10px rgba(220, 38, 38, 0.4);
    transform: scale(1.02);
    transition: all 0.3s ease;
}

/* Add red glow effect to the entire header */
.main-header::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(90deg, transparent 0%, rgba(220, 38, 38, 0.1) 50%, transparent 100%);
    pointer-events: none;
}

/* Add subtle red border glow */
.main-header {
    border-bottom: 2px solid rgba(220, 38, 38, 0.3);
    position: relative;
}
</style>