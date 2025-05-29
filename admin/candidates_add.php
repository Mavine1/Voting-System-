<?php
include 'includes/session.php';

if (isset($_POST['add'])) {
    // Add single candidate
    $firstname = $conn->real_escape_string($_POST['firstname']);
    $lastname = $conn->real_escape_string($_POST['lastname']);
    $position = intval($_POST['position']);
    $platform = $conn->real_escape_string($_POST['platform']);

    $filename = '';
    if (!empty($_FILES['photo']['name'])) {
        $filename = basename($_FILES['photo']['name']);
        $target_dir = '../images/';
        $target_file = $target_dir . $filename;

        // Optional: validate file type and size here

        if (!move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
            $_SESSION['error'] = "Failed to upload photo.";
            header('location: candidates.php');
            exit;
        }
    }

    $sql = "INSERT INTO candidates (position_id, firstname, lastname, photo, platform) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        $_SESSION['error'] = "Prepare failed: " . $conn->error;
        header('location: candidates.php');
        exit;
    }
    $stmt->bind_param('issss', $position, $firstname, $lastname, $filename, $platform);
    if ($stmt->execute()) {
        $_SESSION['success'] = 'Candidate added successfully';
    } else {
        $_SESSION['error'] = $stmt->error;
    }
    $stmt->close();

} elseif (isset($_POST['convert_all']) || isset($_POST['voters'])) {
    // Convert voters to candidates
    $position_id = intval($_POST['position']);
    $platform = $conn->real_escape_string($_POST['platform']);
    $add_all = (isset($_POST['convert_all']) && $_POST['convert_all'] == '1');
    $selected_voters = isset($_POST['voters']) ? $_POST['voters'] : '';

    if (!$position_id) {
        $_SESSION['error'] = 'Please select a position.';
        header('location: candidates.php');
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO candidates (position_id, firstname, lastname, photo, platform) 
                            VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        $_SESSION['error'] = "Prepare failed: " . $conn->error;
        header('location: candidates.php');
        exit;
    }

    if ($add_all) {
        $voters = $conn->query("SELECT firstname, lastname, photo FROM voters");
    } else {
        if (empty($selected_voters)) {
            $_SESSION['error'] = 'No voters selected for conversion.';
            header('location: candidates.php');
            exit;
        }
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
