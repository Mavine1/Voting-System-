<?php
session_start();
include 'includes/conn.php';

if (isset($_POST['login'])) {
    $password = $_POST['password'];

    // Check password against all voters in database
    $sql = "SELECT * FROM voters WHERE password IS NOT NULL";
    $query = $conn->query($sql);

    $login_successful = false;
    $voter_id = null;

    if ($query->num_rows > 0) {
        while ($row = $query->fetch_assoc()) {
            // Verify the password against each voter's password
            if (password_verify($password, $row['password'])) {
                $login_successful = true;
                $voter_id = $row['id'];
                break; // Stop checking once we find a match
            }
        }
    }

    if ($login_successful) {
        $_SESSION['voter'] = $voter_id;  // Store the voter ID in session
        header('Location: home.php'); // Redirect to home page after successful login
        exit();
    } else {
        $_SESSION['error'] = 'Incorrect password';
    }
} else {
    $_SESSION['error'] = 'Please enter a password';
}

// Redirect back to the login page if there was an error
header('Location: index.php');
exit();
?>