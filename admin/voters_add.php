<?php
/**
 * Voter Registration Handler
 * Enhanced security, validation, and error handling
 */

include 'includes/session.php';

// Initialize response array for better error tracking
$response = [
    'success' => false,
    'message' => '',
    'errors' => []
];

/**
 * Validate and sanitize input data
 */
function validateInput($data) {
    $errors = [];
    
    // Required fields validation
    $required_fields = ['firstname', 'lastname', 'email', 'username', 'password'];
    foreach ($required_fields as $field) {
        if (empty(trim($data[$field] ?? ''))) {
            $errors[] = ucfirst($field) . ' is required';
        }
    }
    
    // Email validation
    if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address';
    }
    
    // Username validation (alphanumeric, 3-20 characters)
    if (!empty($data['username'])) {
        if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $data['username'])) {
            $errors[] = 'Username must be 3-20 characters and contain only letters, numbers, and underscores';
        }
    }
    
    // Password strength validation
    if (!empty($data['password'])) {
        if (strlen($data['password']) < 6) {
            $errors[] = 'Password must be at least 6 characters long';
        }
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/', $data['password'])) {
            $errors[] = 'Password must contain at least one uppercase letter, one lowercase letter, and one number';
        }
    }
    
    // Name validation (letters and spaces only)
    if (!empty($data['firstname']) && !preg_match('/^[a-zA-Z\s]{2,50}$/', $data['firstname'])) {
        $errors[] = 'First name must contain only letters and be 2-50 characters long';
    }
    
    if (!empty($data['lastname']) && !preg_match('/^[a-zA-Z\s]{2,50}$/', $data['lastname'])) {
        $errors[] = 'Last name must contain only letters and be 2-50 characters long';
    }
    
    return $errors;
}

/**
 * Check if email or username already exists
 */
function checkDuplicates($conn, $email, $username) {
    $sql = "SELECT id, email, username FROM voters WHERE email = ? OR username = ?";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        return ['Database preparation error: ' . $conn->error];
    }
    
    $stmt->bind_param("ss", $email, $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $errors = [];
    while ($row = $result->fetch_assoc()) {
        if ($row['email'] === $email) {
            $errors[] = 'Email address is already registered';
        }
        if ($row['username'] === $username) {
            $errors[] = 'Username is already taken';
        }
    }
    
    $stmt->close();
    return $errors;
}

/**
 * Handle photo upload with enhanced security
 */
function handlePhotoUpload($photo_file) {
    $upload_result = [
        'success' => false,
        'filename' => 'default-avatar.jpg',
        'error' => ''
    ];
    
    // If no file uploaded, use default
    if (empty($photo_file['name'])) {
        $upload_result['success'] = true;
        return $upload_result;
    }
    
    // Validate file
    $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
    $max_size = 5 * 1024 * 1024; // 5MB
    
    if (!in_array($photo_file['type'], $allowed_types)) {
        $upload_result['error'] = 'Only JPG, JPEG, PNG and GIF files are allowed';
        return $upload_result;
    }
    
    if ($photo_file['size'] > $max_size) {
        $upload_result['error'] = 'File size must be less than 5MB';
        return $upload_result;
    }
    
    // Generate unique filename to prevent conflicts
    $file_extension = pathinfo($photo_file['name'], PATHINFO_EXTENSION);
    $unique_filename = 'voter_' . uniqid() . '_' . time() . '.' . $file_extension;
    
    $target_dir = '../images/voters/';
    
    // Create directory if it doesn't exist
    if (!is_dir($target_dir)) {
        if (!mkdir($target_dir, 0755, true)) {
            $upload_result['error'] = 'Failed to create upload directory';
            return $upload_result;
        }
    }
    
    $target_file = $target_dir . $unique_filename;
    
    // Verify it's actually an image
    if (!getimagesize($photo_file['tmp_name'])) {
        $upload_result['error'] = 'File is not a valid image';
        return $upload_result;
    }
    
    // Move uploaded file
    if (move_uploaded_file($photo_file['tmp_name'], $target_file)) {
        // Optionally resize image here for consistency
        $upload_result['success'] = true;
        $upload_result['filename'] = $unique_filename;
    } else {
        $upload_result['error'] = 'Failed to upload photo. Please try again.';
    }
    
    return $upload_result;
}

/**
 * Insert new voter into database
 */
function insertVoter($conn, $data, $photo_filename) {
    $sql = "INSERT INTO voters (username, email, password, firstname, lastname, photo, created_at, status) 
            VALUES (?, ?, ?, ?, ?, ?, NOW(), 'active')";
    
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        return ['success' => false, 'error' => 'Database preparation error: ' . $conn->error];
    }
    
    $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT, ['cost' => 12]);
    
    $stmt->bind_param("ssssss", 
        $data['username'], 
        $data['email'], 
        $hashed_password, 
        $data['firstname'], 
        $data['lastname'], 
        $photo_filename
    );
    
    if ($stmt->execute()) {
        $voter_id = $conn->insert_id;
        $stmt->close();
        
        // Log the registration for audit trail
        $log_sql = "INSERT INTO activity_log (action, user_type, user_id, description, timestamp) 
                    VALUES ('voter_registered', 'voter', ?, 'New voter registered', NOW())";
        $log_stmt = $conn->prepare($log_sql);
        if ($log_stmt) {
            $log_stmt->bind_param("i", $voter_id);
            $log_stmt->execute();
            $log_stmt->close();
        }
        
        return ['success' => true, 'voter_id' => $voter_id];
    } else {
        $error = $stmt->error;
        $stmt->close();
        return ['success' => false, 'error' => 'Registration failed: ' . $error];
    }
}

// Main processing logic
try {
    // Check if form was submitted
    if (!isset($_POST['add']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }
    
    // Validate CSRF token (if implemented)
    if (isset($_POST['csrf_token']) && !hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'])) {
        throw new Exception('Security token mismatch. Please try again.');
    }
    
    // Sanitize input data
    $input_data = [
        'firstname' => trim($_POST['firstname'] ?? ''),
        'lastname' => trim($_POST['lastname'] ?? ''),
        'email' => trim(strtolower($_POST['email'] ?? '')),
        'username' => trim(strtolower($_POST['username'] ?? '')),
        'password' => $_POST['password'] ?? ''
    ];
    
    // Validate input
    $validation_errors = validateInput($input_data);
    if (!empty($validation_errors)) {
        $response['errors'] = $validation_errors;
        $response['message'] = 'Please correct the following errors:';
        throw new Exception('Validation failed');
    }
    
    // Check for duplicates
    $duplicate_errors = checkDuplicates($conn, $input_data['email'], $input_data['username']);
    if (!empty($duplicate_errors)) {
        $response['errors'] = $duplicate_errors;
        $response['message'] = 'Registration failed:';
        throw new Exception('Duplicate data found');
    }
    
    // Handle photo upload
    $photo_result = handlePhotoUpload($_FILES['photo'] ?? []);
    if (!$photo_result['success'] && !empty($photo_result['error'])) {
        $response['errors'] = [$photo_result['error']];
        $response['message'] = 'Photo upload failed:';
        throw new Exception('Photo upload failed');
    }
    
    // Insert voter
    $insert_result = insertVoter($conn, $input_data, $photo_result['filename']);
    if (!$insert_result['success']) {
        $response['errors'] = [$insert_result['error']];
        $response['message'] = 'Registration failed:';
        throw new Exception('Database insertion failed');
    }
    
    // Success
    $response['success'] = true;
    $response['message'] = 'Voter registered successfully! Welcome, ' . htmlspecialchars($input_data['firstname']) . '!';
    $_SESSION['success'] = $response['message'];
    
    // Optional: Send welcome email
    // sendWelcomeEmail($input_data['email'], $input_data['firstname']);
    
} catch (Exception $e) {
    // Log error for debugging
    error_log("Voter registration error: " . $e->getMessage());
    
    // Set error message
    if (!empty($response['errors'])) {
        $_SESSION['error'] = $response['message'] . '<br>• ' . implode('<br>• ', $response['errors']);
    } else {
        $_SESSION['error'] = 'Registration failed. Please try again.';
    }
}

// Clean up any temporary data
unset($_SESSION['temp_voter_data']);

// Redirect back to voters page
header('Location: voters.php');
exit();

/**
 * Additional utility functions (optional)
 */

function sendWelcomeEmail($email, $firstname) {
    // Implementation for sending welcome email
    // This would typically use a mail library like PHPMailer
    return true;
}

function generateCSRFToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}
?>