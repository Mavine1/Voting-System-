<header class="main-header" style="background-color: #1e40af;">
  <nav class="navbar navbar-static-top" style="background-color: #1e40af;">
    <div class="container" style="background-color: #1e40af;">
      <div class="navbar-header" style="background-color: #1e40af;">
        <a href="#" class="navbar-brand" style="background-color: #1e40af; color: #ffffff; font-size: 22px; font-family: Times; text-decoration: none;">
          <b>ONLINE <b>VOTING</b> SYSTEM</b>
        </a>
        <button type="button" class="navbar-toggle collapsed" style="background-color: #1e40af; border: 2px solid #ffffff;" data-toggle="collapse" data-target="#navbar-collapse">
          <i class="fa fa-bars" style="color: #ffffff;"></i>
        </button>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
        <ul class="nav navbar-nav">
          <?php
            if(isset($_SESSION['student'])){
              echo "
                <li><a href='index.php' style='color: #ffffff; font-family: Times; font-size: 16px; padding: 15px 20px;'>HOME</a></li>
                <li><a href='transaction.php' style='color: #ffffff; font-family: Times; font-size: 16px; padding: 15px 20px;'>TRANSACTION</a></li>
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
              <img src="<?php echo (!empty($voter['photo'])) ? 'images/'.$voter['photo'] : 'images/profile.jpg' ?>" class="user-image" alt="User Image" style="border: 2px solid #ffffff; border-radius: 50%;">
              <span class="hidden-xs" style="color: #ffffff; font-size: 18px; font-family: Times; margin-left: 10px;">
                <?php echo $voter['firstname'].' '.$voter['lastname']; ?>
              </span>
            </a>
          </li>
          <li>
            <a href="logout.php" style="color: #ffffff; padding: 15px 20px; text-decoration: none;">
              <i class="fa fa-sign-out" style="color: #ffffff; font-size: 18px; margin-right: 5px;"></i>
              <b style="color: #ffffff; font-size: 18px; font-family: Times;">LOGOUT</b>
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
/* Additional CSS for hover effects and better styling */
.navbar-nav > li > a:hover {
    background-color: rgba(255, 255, 255, 0.1) !important;
    color: #ffffff !important;
}

.navbar-brand:hover {
    background-color: rgba(255, 255, 255, 0.1) !important;
    color: #ffffff !important;
}

.user-image {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    margin-right: 10px;
}

.navbar-toggle:hover {
    background-color: rgba(255, 255, 255, 0.1) !important;
}
</style>