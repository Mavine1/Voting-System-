<?php
include 'includes/session.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Validate input
        if (!isset($_POST['search']) || !isset($_POST['position_id'])) {
            throw new Exception('Invalid request parameters');
        }

        $searchTerm = trim($_POST['search']);
        $positionId = intval($_POST['position_id']);

        if (empty($searchTerm)) {
            throw new Exception('Search term cannot be empty');
        }

        if ($positionId <= 0) {
            throw new Exception('Invalid position ID');
        }

        // Prepare search query - search in both firstname and lastname
        $sql = "SELECT * FROM candidates 
                WHERE position_id = ? 
                AND (firstname LIKE ? OR lastname LIKE ?)
                ORDER BY lastname, firstname";
        
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception('Database query preparation failed');
        }

        $searchParam = "%$searchTerm%";
        $stmt->bind_param("iss", $positionId, $searchParam, $searchParam);
        $stmt->execute();
        $result = $stmt->get_result();

        $candidates = [];
        while ($row = $result->fetch_assoc()) {
            // Ensure photo path is correct
            $row['photo'] = !empty($row['photo']) ? $row['photo'] : 'profile.jpg';
            $candidates[] = $row;
        }

        // Return JSON response
        header('Content-Type: application/json');
        echo json_encode($candidates);
        
    } catch (Exception $e) {
        // Log error and return empty array
        error_log('Search error: ' . $e->getMessage());
        header('Content-Type: application/json');
        echo json_encode([]);
    }
} else {
    header('Content-Type: application/json');
    echo json_encode([]);
}
?>