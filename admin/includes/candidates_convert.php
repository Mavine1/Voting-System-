<?php
header('Content-Type: application/json');
include 'includes/session.php';

$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $position_id = intval($_POST['position']);
    $platform = $conn->real_escape_string($_POST['platform']);
    $add_all = isset($_POST['convert_all']) && $_POST['convert_all'] == '1';
    $selected_voters = isset($_POST['voters']) ? $_POST['voters'] : '';

    if (!$position_id) {
        $response['error'] = 'Please select a position.';
        echo json_encode($response);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO candidates (position_id, firstname, lastname, photo, platform) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        $response['error'] = 'Prepare failed: ' . $conn->error;
        echo json_encode($response);
        exit;
    }

    if ($add_all) {
        $voters = $conn->query("SELECT firstname, lastname, photo FROM voters");
    } else {
        if (empty($selected_voters)) {
            $response['error'] = 'No voters selected for conversion.';
            echo json_encode($response);
            exit;
        }
        $ids = array_map('intval', explode(',', $selected_voters));
        $ids_list = implode(',', $ids);
        $voters = $conn->query("SELECT firstname, lastname, photo FROM voters WHERE id IN ($ids_list)");
    }

    $added = 0;
    if ($voters && $voters->num_rows > 0) {
        while ($voter = $voters->fetch_assoc()) {
            $photo = !empty($voter['photo']) ? $voter['photo'] : '';
            $stmt->bind_param('issss', $position_id, $voter['firstname'], $voter['lastname'], $photo, $platform);
            if ($stmt->execute()) {
                $added++;
            }
        }
    } else {
        $response['error'] = 'No voters found to convert.';
        echo json_encode($response);
        exit;
    }

    $stmt->close();

    if ($added > 0) {
        $response['success'] = true;
        $response['message'] = "$added voter(s) converted to candidate(s) successfully.";
    } else {
        $response['error'] = "No candidates were added.";
    }

    echo json_encode($response);
    exit;
}

$response['error'] = 'Invalid request method.';
echo json_encode($response);
exit;
?>
