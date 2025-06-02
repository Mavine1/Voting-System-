<?php
include 'includes/session.php';
include 'includes/slugify.php';

if(isset($_POST['vote'])){
    // Check if voter has already voted
    $sql = "SELECT * FROM votes WHERE voters_id = '".$voter['id']."'";
    $vquery = $conn->query($sql);
    if($vquery->num_rows > 0){
        $_SESSION['error'][] = 'You have already voted for this election.';
        header('location: home.php');
        exit();
    }
    
    if(count($_POST) == 1){
        $_SESSION['error'][] = 'Please vote atleast one candidate';
    }
    else{
        $_SESSION['post'] = $_POST;
        $sql = "SELECT * FROM positions";
        $query = $conn->query($sql);
        $error = false;
        $sql_array = array();
        $remarks_array = array(); // Store remarks data
        
        while($row = $query->fetch_assoc()){
            $position = slugify($row['description']);
            $pos_id = $row['id'];
            
            if(isset($_POST[$position])){
                if($row['max_vote'] > 1){
                    if(count($_POST[$position]) > $row['max_vote']){
                        $error = true;
                        $_SESSION['error'][] = 'You can only choose '.$row['max_vote'].' candidates for '.$row['description'];
                    }
                    else{
                        foreach($_POST[$position] as $key => $values){
                            $sql_array[] = "INSERT INTO votes (voters_id, candidate_id, position_id) VALUES ('".$voter['id']."', '$values', '$pos_id')";
                            
                            // Store remark data for this candidate
                            $remark_key = 'remarks_' . $position;
                            if(isset($_POST[$remark_key]) && !empty(trim($_POST[$remark_key]))){
                                $remarks_array[] = array(
                                    'voter_id' => $voter['id'],
                                    'candidate_id' => $values,
                                    'position_id' => $pos_id,
                                    'remark' => trim($_POST[$remark_key])
                                );
                            }
                        }
                    }
                }
                else{
                    $candidate = $_POST[$position];
                    $sql_array[] = "INSERT INTO votes (voters_id, candidate_id, position_id) VALUES ('".$voter['id']."', '$candidate', '$pos_id')";
                    
                    // Store remark data for this candidate
                    $remark_key = 'remarks_' . $position;
                    if(isset($_POST[$remark_key]) && !empty(trim($_POST[$remark_key]))){
                        $remarks_array[] = array(
                            'voter_id' => $voter['id'],
                            'candidate_id' => $candidate,
                            'position_id' => $pos_id,
                            'remark' => trim($_POST[$remark_key])
                        );
                    }
                }
            }
        }

        if(!$error){
            // Begin transaction for data integrity
            $conn->begin_transaction();
            
            try {
                // Insert votes
                foreach($sql_array as $sql_row){
                    $conn->query($sql_row);
                }
                
                // Insert remarks if any
                foreach($remarks_array as $remark_data){
                    $stmt = $conn->prepare("INSERT INTO voter_remarks (voter_id, candidate_id, position_id, remark) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("iiis", 
                        $remark_data['voter_id'], 
                        $remark_data['candidate_id'], 
                        $remark_data['position_id'], 
                        $remark_data['remark']
                    );
                    $stmt->execute();
                    $stmt->close();
                }
                
                // Commit transaction
                $conn->commit();
                
                unset($_SESSION['post']);
                $_SESSION['success'] = 'Ballot Submitted';
                
            } catch (Exception $e) {
                // Rollback transaction on error
                $conn->rollback();
                $_SESSION['error'][] = 'An error occurred while submitting your vote. Please try again.';
                error_log("Ballot submission error: " . $e->getMessage());
            }
        }
    }
}
else{
    $_SESSION['error'][] = 'Select candidates to vote first';
}

header('location: home.php');
exit();
?>