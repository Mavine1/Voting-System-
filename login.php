<?php
session_start();
include 'includes/conn.php';

if (isset($_POST['login'])) {
    $voter = $_POST['voter']; // Email or Username
    $password = $_POST['password'];

    // Check if the input is an email or username
    if (filter_var($voter, FILTER_VALIDATE_EMAIL)) {
        // If the input is an email, search for email in the database
        $sql = "SELECT * FROM voters WHERE email = '$voter'";
    } else {
        // If the input is a username, search for username in the database
        $sql = "SELECT * FROM voters WHERE username = '$voter'";
    }

    $query = $conn->query($sql);

    if ($query->num_rows < 1) {
        $_SESSION['error'] = 'Cannot find voter with the provided email/username';
    } else {
        $row = $query->fetch_assoc();

        // Verify the password
        if (password_verify($password, $row['password'])) {
            $_SESSION['voter'] = $row['id'];  // Store the voter ID in session
            header('Location: home.php'); // Redirect to home page after successful login
            exit();
        } else {
            $_SESSION['error'] = 'Incorrect password';
        }
    }
} else {
    $_SESSION['error'] = 'Input voter credentials first';
}

// Redirect back to the login page if there was an error
header('Location: index.php');
exit();
?>
