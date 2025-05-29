<?php
session_start();
include 'includes/conn.php'; // Make sure the database connection file is included

if (isset($_POST['signup'])) {
    // Capture the form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];

    // Handle file upload for photo
    $photo = $_FILES['photo']['name'];
    $photo_tmp = $_FILES['photo']['tmp_name'];

    // Check if uploads directory exists, if not, create it
    $photo_folder = "uploads/" . $photo;
    if (!is_dir("uploads")) {
        mkdir("uploads", 0777, true); // Create the uploads directory if it does not exist
    }

    // Move the uploaded photo to the desired folder
    if (move_uploaded_file($photo_tmp, $photo_folder)) {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert user data into the database
        $sql = "INSERT INTO voters (username,email, password, firstname, lastname, photo) 
                VALUES ('$username', '$email', '$hashed_password', '$firstname', '$lastname', '$photo')";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['success'] = "Account created successfully! You can now log in.";
            header("Location: login.php"); // Redirect to login page after successful sign up
        } else {
            $_SESSION['error'] = "Error: " . $conn->error;
        }
    } else {
        $_SESSION['error'] = "Failed to upload photo.";
    }
}
?>

<?php include 'includes/header.php'; ?>
<body style="background-color: #ffffff; font-family: 'Arial', sans-serif;"> <!-- Set background color to white -->

<!-- Main Sign Up Box -->
<div class="signup-box" style="width: 100%; max-width: 400px; margin: 100px auto; padding: 20px; border-radius: 8px; background-color: #ffffff; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
    <div class="signup-logo" style="text-align: center; margin-bottom: 20px;">
      
        <h3 style="font-size: 26px; font-weight: bold; color: #1E3A8A;">Create an Account</h3> <!-- Blue color -->
    </div>

    <div class="signup-box-body" style="text-align: center;">
        <p style="font-size: 18px; font-weight: bold; color: #1E3A8A;">Welcome! Please fill in the details to create an account</p> <!-- Blue color -->

        <!-- Sign Up Form -->
        <form action="signup.php" method="POST" enctype="multipart/form-data">
            <div class="form-group" style="margin-bottom: 20px;">
                <input type="text" class="form-control" name="username" placeholder="Username" required style="padding: 15px; font-size: 14px; border-radius: 5px; border: 1px solid #ccc;">
            </div>
            <div class="form-group" style="margin-bottom: 20px;">
                <input type="email" class="form-control" name="email" placeholder="Your email" required style="padding: 15px; font-size: 14px; border-radius: 5px; border: 1px solid #ccc;">
            </div>
            <div class="form-group" style="margin-bottom: 20px;">
                <input type="password" class="form-control" name="password" placeholder="Create password" required style="padding: 15px; font-size: 14px; border-radius: 5px; border: 1px solid #ccc;">
            </div>
            <div class="form-group" style="margin-bottom: 20px;">
                <input type="text" class="form-control" name="firstname" placeholder="First Name" required style="padding: 15px; font-size: 14px; border-radius: 5px; border: 1px solid #ccc;">
            </div>
            <div class="form-group" style="margin-bottom: 20px;">
                <input type="text" class="form-control" name="lastname" placeholder="Last Name" required style="padding: 15px; font-size: 14px; border-radius: 5px; border: 1px solid #ccc;">
            </div>
            <div class="form-group" style="margin-bottom: 20px;">
                <input type="file" class="form-control" name="photo" required style="padding: 15px; font-size: 14px; border-radius: 5px; border: 1px solid #ccc;">
            </div>

            <!-- Submit Button -->
            <div class="row" style="text-align: center;">
                <div class="col-xs-12">
                    <button type="submit" class="btn btn-block" style="background-color: #1E3A8A; color: white; font-size: 14px; padding: 15px; border-radius: 5px; border: none; width: 100%;" name="signup">Sign Up</button> <!-- Blue color -->
                </div>
            </div>

            <!-- Sign Up Links -->
            <div style="margin-top: 15px; text-align: center;">
                <a href="login.php" style="color: #1E3A8A; font-size: 14px;">Already have an account? Log in</a> <!-- Blue color -->
            </div>
        </form>
    </div>
</div>

<?php include 'includes/scripts.php' ?>
</body>
</html>
