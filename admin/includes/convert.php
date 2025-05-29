<?php
header('Content-Type: application/json');
include 'includes/session.php';

// Disable error display to avoid breaking JSON
ini_set('display_errors', 0);
error_reporting(0);

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Invalid request method.';
    echo json_encode($response);
    exit;
}

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
            $response['message'] = "Failed to upload photo.";
            echo json_encode($response);
            exit;
        }
    }

    $sql = "INSERT INTO candidates (position_id, firstname, lastname, photo, platform) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        $response['message'] = "Prepare failed: " . $conn->error;
        echo json_encode($response);
        exit;
    }
    $stmt->bind_param('issss', $position, $firstname, $lastname, $filename, $platform);
    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Candidate added successfully.';
    } else {
        $response['message'] = $stmt->error;
    }
    $stmt->close();

} elseif (isset($_POST['convert_all']) || isset($_POST['voters'])) {
    // Convert voters to candidates
    $position_id = intval($_POST['position']);
    $platform = $conn->real_escape_string($_POST['platform']);
    $add_all = (isset($_POST['convert_all']) && $_POST['convert_all'] == '1');
    $selected_voters = isset($_POST['voters']) ? $_POST['voters'] : '';

    if (!$position_id) {
        $response['message'] = 'Please select a position.';
        echo json_encode($response);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO candidates (position_id, firstname, lastname, photo, platform) 
                            VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        $response['message'] = "Prepare failed: " . $conn->error;
        echo json_encode($response);
        exit;
    }

    if ($add_all) {
        $voters = $conn->query("SELECT firstname, lastname, photo FROM voters");
    } else {
        if (empty($selected_voters)) {
            $response['message'] = 'No voters selected for conversion.';
            echo json_encode($response);
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
        $response['success'] = true;
        $response['message'] = "$added voter(s) converted to candidate(s) successfully.";
    } else {
        $response['message'] = "No candidates were added.";
    }

} else {
    $response['message'] = 'Fill up add form first';
}

echo json_encode($response);
exit;
?>
