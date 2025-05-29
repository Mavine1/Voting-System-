

<?php
include '../includes/session.php';
include '../includes/dbconnect.php';

header('Content-Type: application/json');

try {
    if (!isset($_POST['search']) || strlen(trim($_POST['search'])) < 2) {
        throw new Exception('Search term too short');
    }

    $searchTerm = '%' . $conn->real_escape_string(trim($_POST['search'])) . '%';
    
    $sql = "SELECT id, firstname, lastname, photo FROM voters 
            WHERE firstname LIKE ? OR lastname LIKE ?
            ORDER BY lastname, firstname
            LIMIT 50";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $voters = [];
    while ($row = $result->fetch_assoc()) {
        $voters[] = $row;
    }
    
    echo json_encode($voters);
    
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>