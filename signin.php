<?php
session_start();
if (isset($_SESSION['admin'])) {
    header('location: admin/home.php');
}

if (isset($_SESSION['voter'])) {
    header('location: home.php');
}
?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition login-page" style="background-color:#FFFFFF;"> <!-- Set background color to white -->
<div class="login-box" style="background-color:#FFFFFF; color:black; font-size: 22px; font-family:Times;"> <!-- Set background color of login box to white -->
    <div class="login-logo" style="background-color:#FFFFFF; color:black; font-size: 22px; font-family:Times;">
        <b> TBC@60 Awards</b>
    </div>

    <div class="login-box-body" style="background-color:#FFFFFF; color:black; font-size: 22px; font-family:Times;"> <!-- Set background color of login box body to white -->
        <p class="login-box-msg" style="color:black; font-size: 16px; font-family:Times;">Sign in to start your voting session</p>

        <form action="login.php" method="POST">
            <div class="form-group has-feedback">
                <input type="text" class="form-control" name="voter" placeholder="Email or Username" required>  <!-- Change name to 'voter' -->
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-curve" style="background-color: #4682B4; color:white; font-size: 12px; font-family:Times" name="login"><i class="fa fa-sign-in"></i> Sign In</button>
                </div>
            </div>
        </form>

        <!-- Forgot password and Sign up links -->
        <div class="row" style="margin-top: 10px;">
            <div class="col-xs-12" style="text-align: center;">
                <a href="signup.php" style="color: #4682B4; font-size: 14px;">Don't have an account? Sign up</a><br>
                <a href="forgot_password.php" style="color: #4682B4; font-size: 14px;">Forgot password?</a>
            </div>
        </div>
    </div>
    <?php
        if (isset($_SESSION['error'])) {
            echo "
                <div class='callout callout-danger text-center mt20'>
                    <p>".$_SESSION['error']."</p> 
                </div>
            ";
            unset($_SESSION['error']);
        }
    ?>
</div>

<?php include 'includes/scripts.php' ?>
</body>
</html>
