<?php 
include 'includes/session.php';

if (isset($_POST['add'])) {
    // Add single candidate
    if (empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['position'])) {
        $_SESSION['error'] = 'Please fill in all required fields.';
        header('location: candidates.php');
        exit;
    }

    $firstname = $conn->real_escape_string(trim($_POST['firstname']));
    $lastname = $conn->real_escape_string(trim($_POST['lastname']));
    $position = intval($_POST['position']);
    $platform = $conn->real_escape_string(trim($_POST['platform']));
    
    $filename = '';
    
    // Handle photo upload if provided
    if (!empty($_FILES['photo']['name'])) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
        $max_size = 2 * 1024 * 1024; // 2MB
        
        if (!in_array($_FILES['photo']['type'], $allowed_types)) {
            $_SESSION['error'] = "Invalid file type. Please upload JPG, PNG, or GIF images only.";
            header('location: candidates.php');
            exit;
        }
        
        if ($_FILES['photo']['size'] > $max_size) {
            $_SESSION['error'] = "File size too large. Maximum size is 2MB.";
            header('location: candidates.php');
            exit;
        }
        
        $file_extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $filename = uniqid('candidate_') . '.' . $file_extension;
        $target_dir = '../images/';
        $target_file = $target_dir . $filename;
        
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }
        
        if (!move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
            $_SESSION['error'] = "Failed to upload photo. Please try again.";
            header('location: candidates.php');
            exit;
        }
    }
    
    $sql = "INSERT INTO candidates (position_id, firstname, lastname, photo, platform) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        $_SESSION['error'] = "Database error: " . $conn->error;
        header('location: candidates.php');
        exit;
    }
    
    $stmt->bind_param('issss', $position, $firstname, $lastname, $filename, $platform);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = 'Candidate added successfully!';
    } else {
        $_SESSION['error'] = 'Failed to add candidate: ' . $stmt->error;
        if (!empty($filename) && file_exists($target_file)) {
            unlink($target_file);
        }
    }
    
    $stmt->close();

} elseif (isset($_POST['convert_voters'])) {
    // Convert voters to candidates - handle everything locally
    $position_id = intval($_POST['position']);
    $platform = $conn->real_escape_string($_POST['platform']);
    $convert_all = (isset($_POST['convert_all']) && $_POST['convert_all'] == '1');
    $selected_voters = isset($_POST['voters']) ? $_POST['voters'] : '';

    if (!$position_id) {
        $_SESSION['error'] = 'Please select a position for conversion.';
        header('location: candidates.php');
        exit;
    }

    // Prepare insert statement for candidates
    $stmt = $conn->prepare("INSERT INTO candidates (position_id, firstname, lastname, photo, platform) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        $_SESSION['error'] = "Database error: " . $conn->error;
        header('location: candidates.php');
        exit;
    }

    $added = 0;

    if ($convert_all) {
        // Convert all voters
        $voters_query = $conn->query("SELECT firstname, lastname, photo FROM voters");
        if ($voters_query) {
            while ($voter = $voters_query->fetch_assoc()) {
                $photo = !empty($voter['photo']) ? $voter['photo'] : '';
                $stmt->bind_param('issss', $position_id, $voter['firstname'], $voter['lastname'], $photo, $platform);
                if ($stmt->execute()) {
                    $added++;
                }
            }
        }
    } else {
        // Convert selected voters
        if (empty($selected_voters)) {
            $_SESSION['error'] = 'No voters selected for conversion.';
            header('location: candidates.php');
            exit;
        }

        $voter_ids = array_map('intval', explode(',', $selected_voters));
        $ids_placeholders = implode(',', array_fill(0, count($voter_ids), '?'));
        
        $voters_stmt = $conn->prepare("SELECT firstname, lastname, photo FROM voters WHERE id IN ($ids_placeholders)");
        if ($voters_stmt) {
            $voters_stmt->bind_param(str_repeat('i', count($voter_ids)), ...$voter_ids);
            $voters_stmt->execute();
            $voters_result = $voters_stmt->get_result();
            
            while ($voter = $voters_result->fetch_assoc()) {
                $photo = !empty($voter['photo']) ? $voter['photo'] : '';
                $stmt->bind_param('issss', $position_id, $voter['firstname'], $voter['lastname'], $photo, $platform);
                if ($stmt->execute()) {
                    $added++;
                }
            }
            $voters_stmt->close();
        }
    }
    
    $stmt->close();

    if ($added > 0) {
        $_SESSION['success'] = "$added voter(s) converted to candidate(s) successfully!";
    } else {
        $_SESSION['error'] = "No candidates were added during conversion.";
    }

} else {
    $_SESSION['error'] = 'Invalid request. Please use the proper form.';
}

header('location: candidates.php');
exit;
?>