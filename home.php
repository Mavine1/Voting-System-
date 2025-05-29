<?php
include 'includes/session.php';
include 'includes/slugify.php';

$candidates = array();
$max_votes = array();

// Get all positions and their candidates
$sql = "SELECT * FROM positions ORDER BY priority ASC";
$query = $conn->query($sql);

while($row = $query->fetch_assoc()){
    $position_slug = slugify($row['description']);
    $candidates[$position_slug] = array();
    $max_votes[$position_slug] = $row['max_vote'];
    
    // Get candidates for this position
    $sql_candidates = "SELECT * FROM candidates WHERE position_id='".$row['id']."' ORDER BY firstname ASC";
    $cquery = $conn->query($sql_candidates);
    
    while($crow = $cquery->fetch_assoc()){
        $candidates[$position_slug][] = array(
            'id' => $crow['id'],
            'firstname' => $crow['firstname'],
            'lastname' => $crow['lastname'],
            'photo' => $crow['photo'],
            'platform' => $crow['platform'],
            'position_name' => $row['description']
        );
    }
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode(array(
    'candidates' => $candidates,
    'max_votes' => $max_votes
));
?>