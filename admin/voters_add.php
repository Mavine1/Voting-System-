<?php
include 'includes/session.php';

if (isset($_POST['add'])) {
    // Capture form data
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $email = trim($_POST['email']);  // Email field
    $username = trim($_POST['username']);  // Username field
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT); // Password hashing
    $filename = $_FILES['photo']['name'];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Invalid email format';
        header('Location: voters.php');
        exit();
    }

    // Check if email or username already exists in the database
    $sql = "SELECT * FROM voters WHERE email = ? OR username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error'] = 'Email or Username already taken';
        header('Location: voters.php');
        exit();
    }

    // Handle file upload for photo
    if (!empty($filename)) {
        $target_dir = '../images/';
        $target_file = $target_dir . basename($filename);

        // Ensure the file is uploaded successfully
        if (!move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
            $_SESSION['error'] = 'Failed to upload photo';
            header('Location: voters.php');
            exit();
        }
    } else {
        // If no photo is uploaded, set a default
        $filename = 'default.jpg';
    }

    // Insert the new voter into the database using prepared statements
    $sql = "INSERT INTO voters (username, email, password, firstname, lastname, photo) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $username, $email, $password, $firstname, $lastname, $filename);

    // Execute the query and check if it was successful
    if ($stmt->execute()) {
        $_SESSION['success'] = 'Voter added successfully';
    } else {
        $_SESSION['error'] = 'Error: ' . $stmt->error;
    }

    $stmt->close();
} else {
    $_SESSION['error'] = 'Please fill out the form first';
}

// Redirect back to voters page
header('Location: voters.php');
exit();
?>
