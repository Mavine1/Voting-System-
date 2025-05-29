<?php
include 'includes/session.php';

if (isset($_POST['add'])) {
    // Single candidate add with uploaded photo
    $firstname = $conn->real_escape_string($_POST['firstname']);
    $lastname = $conn->real_escape_string($_POST['lastname']);
    $position = intval($_POST['position']);
    $platform = $conn->real_escape_string($_POST['platform']);
    $filename = $_FILES['photo']['name'];

    if (!empty($filename)) {
        move_uploaded_file($_FILES['photo']['tmp_name'], '../images/' . $filename);
    }

    $sql = "INSERT INTO candidates (position_id, firstname, lastname, photo, platform) VALUES ('$position', '$firstname', '$lastname', '$filename', '$platform')";
    if ($conn->query($sql)) {
        $_SESSION['success'] = 'Candidate added successfully';
    } else {
        $_SESSION['error'] = $conn->error;
    }

} elseif (isset($_POST['convert'])) {
    // Convert voters to candidates
    $position_id = intval($_POST['position']);
    $platform = $conn->real_escape_string($_POST['platform']);
    $add_all = isset($_POST['add_all_voters']);
    $selected_voters = isset($_POST['selected_voters']) ? $_POST['selected_voters'] : '';

    if (!$position_id) {
        $_SESSION['error'] = 'Please select a position.';
        header('location: candidates.php');
        exit;
    }

    // Prepare insert statement
    $stmt = $conn->prepare("INSERT INTO candidates (position_id, firstname, lastname, photo, platform) VALUES (?, ?, ?, ?, ?)");

    if ($add_all) {
        $voters = $conn->query("SELECT firstname, lastname, photo FROM voters");
    } else {
        if (empty($selected_voters)) {
            $_SESSION['error'] = 'No voters selected for conversion.';
            header('location: candidates.php');
            exit;
        }
        // Convert comma-separated string to array of ints
        $ids = array_map('intval', explode(',', $selected_voters));
        $ids_list = implode(',', $ids);
        $voters = $conn->query("SELECT firstname, lastname, photo FROM voters WHERE id IN ($ids_list)");
    }

    $added = 0;
    if ($voters) {
        while ($voter = $voters->fetch_assoc()) {
            $photo = !empty($voter['photo']) ? $voter['photo'] : '';
            $stmt->bind_param('issss', $position_id, $voter['firstname'], $voter['lastname'], $photo, $platform);
            if ($stmt->execute()) {
                $added++;
            }
        }
    }
    $stmt->close();

    if ($added > 0) {
        $_SESSION['success'] = "$added voter(s) converted to candidate(s) successfully.";
    } else {
        $_SESSION['error'] = "No candidates were added.";
    }

} else {
    $_SESSION['error'] = 'Fill up add form first';
}

header('location: candidates.php');
exit;
?>
