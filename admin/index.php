<?php
session_start();
if (isset($_SESSION['admin'])) {
	header('location:home.php');
}
?>
<?php include 'includes/header.php'; ?>

<style>
	/* Animated background with books and awards */
	.animated-bg {
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background: linear-gradient(135deg, #ffffff 0%, #e0f2fe 50%, #bbdefb 100%);
		overflow: hidden;
		z-index: -1;
	}

	.floating-item {
		position: absolute;
		animation: float 6s ease-in-out infinite;
		opacity: 0.1;
	}

	.book {
		width: 40px;
		height: 50px;
		background: linear-gradient(45deg, #1e40af, #3b82f6);
		border-radius: 3px;
		box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
	}

	.book::before {
		content: '';
		position: absolute;
		left: 5px;
		top: 5px;
		right: 5px;
		bottom: 5px;
		background: rgba(255, 255, 255, 0.3);
		border-radius: 2px;
	}

	.award {
		width: 35px;
		height: 35px;
		background: linear-gradient(45deg, #ffd700, #ffed4e);
		border-radius: 50%;
		position: relative;
		box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
	}

	.award::before {
		content: '★';
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		color: #1e40af;
		font-size: 18px;
		font-weight: bold;
	}

	@keyframes float {

		0%,
		100% {
			transform: translateY(0px) rotate(0deg);
		}

		25% {
			transform: translateY(-20px) rotate(5deg);
		}

		50% {
			transform: translateY(-10px) rotate(-3deg);
		}

		75% {
			transform: translateY(-15px) rotate(3deg);
		}
	}

	.password-toggle {
		position: absolute;
		right: 10px;
		top: 50%;
		transform: translateY(-50%);
		cursor: pointer;
		color: #1e40af;
		z-index: 10;
	}

	.form-control {
		padding-right: 40px;
	}
</style>

<body class="hold-transition login-page">
	<!-- Animated Background -->
	<div class="animated-bg">
		<!-- Books -->
		<div class="floating-item book" style="top: 10%; left: 5%; animation-delay: 0s;"></div>
		<div class="floating-item book" style="top: 20%; right: 10%; animation-delay: 1s;"></div>
		<div class="floating-item book" style="top: 60%; left: 15%; animation-delay: 2s;"></div>
		<div class="floating-item book" style="top: 80%; right: 20%; animation-delay: 3s;"></div>
		<div class="floating-item book" style="top: 40%; left: 80%; animation-delay: 4s;"></div>

		<!-- Awards -->
		<div class="floating-item award" style="top: 15%; left: 25%; animation-delay: 0.5s;"></div>
		<div class="floating-item award" style="top: 35%; right: 15%; animation-delay: 1.5s;"></div>
		<div class="floating-item award" style="top: 70%; left: 10%; animation-delay: 2.5s;"></div>
		<div class="floating-item award" style="top: 50%; right: 5%; animation-delay: 3.5s;"></div>
		<div class="floating-item award" style="top: 25%; left: 70%; animation-delay: 4.5s;"></div>

		<!-- More Books -->
		<div class="floating-item book" style="top: 5%; left: 40%; animation-delay: 1.2s;"></div>
		<div class="floating-item book" style="top: 85%; left: 60%; animation-delay: 2.8s;"></div>
		<div class="floating-item book" style="top: 45%; left: 5%; animation-delay: 4.2s;"></div>

		<!-- More Awards -->
		<div class="floating-item award" style="top: 65%; left: 85%; animation-delay: 0.8s;"></div>
		<div class="floating-item award" style="top: 10%; left: 60%; animation-delay: 3.2s;"></div>
	</div>

	<div class="login-box" style="background-color: rgba(255,255,255,0.95); color: #1e40af; font-size: 22px; font-family: Times; border-radius: 10px; box-shadow: 0 8px 32px rgba(30, 64, 175, 0.3);">
		<div class="login-logo" style="background-color: rgba(255,255,255,0.95); color: #1e40af; font-size: 22px; font-family: Times; border-radius: 10px 10px 0 0; padding: 20px;">
			<b>Text Book Center Awards</b>
		</div>

		<div class="login-box-body" style="background-color: rgba(255,255,255,0.95); color: #1e40af; font-size: 22px; font-family: Times; border-radius: 0 0 10px 10px; padding: 20px;">
			<p class="login-box-msg" style="color: #1e40af; font-size: 16px; font-family: Times;">Sign in to start your admin session</p>

			<form action="login.php" method="POST">
				<div class="form-group has-feedback">
					<input type="text" class="form-control" name="username" placeholder="Username" required style="border: 2px solid #1e40af; border-radius: 5px; color: #1e40af;">
					<span class="glyphicon glyphicon-user form-control-feedback" style="color: #1e40af;"></span>
				</div>

				<div class="form-group has-feedback" style="position: relative;">
					<input type="password" class="form-control" name="password" id="password" placeholder="Password" required style="border: 2px solid #1e40af; border-radius: 5px; color: #1e40af;">
					<span style="color: #1e40af;"></span>
					<span class="password-toggle" onclick="togglePassword()">
						<i class="fa fa-eye" id="eye-icon"></i>
					</span>
				</div>

				<div class="row">
					<div class="col-xs-4">
						<button type="submit" class="btn btn-primary btn-block btn-curve" style="background-color: #1e40af; color: #ffffff; font-size: 12px; font-family: Times; border: none; border-radius: 5px; padding: 10px;" name="login">
							<i class="fa fa-sign-in"></i> Sign In
						</button>
					</div>
				</div>
			</form>
		</div>

		<?php
		if (isset($_SESSION['error'])) {
			echo "
            <div class='callout callout-danger text-center mt20' style='background-color: #ef4444; color: #ffffff; border-radius: 5px; margin: 10px; padding: 10px;'>
                <p>" . $_SESSION['error'] . "</p>
            </div>
        ";
			unset($_SESSION['error']);
		}
		?>
	</div>

	<script>
		function togglePassword() {
			const passwordField = document.getElementById('password');
			const eyeIcon = document.getElementById('eye-icon');

			if (passwordField.type === 'password') {
				passwordField.type = 'text';
				eyeIcon.className = 'fa fa-eye-slash';
			} else {
				passwordField.type = 'password';
				eyeIcon.className = 'fa fa-eye';
			}
		}
	</script>

	<?php include 'includes/scripts.php' ?>
</body>

</html>