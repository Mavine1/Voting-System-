<?php
header('Content-Type: application/json');
include 'includes/session.php';

// Disable error display to prevent breaking JSON output (optional for production)
ini_set('display_errors', 0);
error_reporting(0);

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Invalid request method.';
    echo json_encode($response);
    exit;
}

// Retrieve and sanitize inputs
$position_id = isset($_POST['position']) ? intval($_POST['position']) : 0;
$platform = isset($_POST['platform']) ? $conn->real_escape_string(trim($_POST['platform'])) : '';
$convert_all = (isset($_POST['convert_all']) && $_POST['convert_all'] === '1');
$selected_voters = isset($_POST['voters']) ? trim($_POST['voters']) : '';

// Validate required inputs
if (!$position_id) {
    $response['message'] = 'Please select a valid position.';
    echo json_encode($response);
    exit;
}
if ($platform === '') {
    $response['message'] = 'Please enter a platform description.';
    echo json_encode($response);
    exit;
}

// Prepare insert statement for candidates
$stmt = $conn->prepare("INSERT INTO candidates (position_id, firstname, lastname, photo, platform) VALUES (?, ?, ?, ?, ?)");
if (!$stmt) {
    $response['message'] = "Database error: " . $conn->error;
    echo json_encode($response);
    exit;
}

// Fetch voters to convert
if ($convert_all) {
    $voters_result = $conn->query("SELECT firstname, lastname, photo FROM voters");
} else {
    if (empty($selected_voters)) {
        $response['message'] = 'No voters selected for conversion.';
        echo json_encode($response);
        exit;
    }
    $ids = array_map('intval', explode(',', $selected_voters));
    if (count($ids) === 0) {
        $response['message'] = 'Invalid voters selected.';
        echo json_encode($response);
        exit;
    }
    $ids_list = implode(',', $ids);
    $voters_result = $conn->query("SELECT firstname, lastname, photo FROM voters WHERE id IN ($ids_list)");
}

if (!$voters_result || $voters_result->num_rows === 0) {
    $response['message'] = 'No voters found to convert.';
    echo json_encode($response);
    exit;
}

// Insert voters as candidates
$added = 0;
while ($voter = $voters_result->fetch_assoc()) {
    $photo = !empty($voter['photo']) ? $voter['photo'] : '';
    $stmt->bind_param('issss', $position_id, $voter['firstname'], $voter['lastname'], $photo, $platform);
    if ($stmt->execute()) {
        $added++;
    }
}
$stmt->close();

if ($added > 0) {
    $response['success'] = true;
    $response['message'] = "$added voter(s) successfully converted to candidate(s).";
} else {
    $response['message'] = "No candidates were added.";
}

echo json_encode($response);
exit;
