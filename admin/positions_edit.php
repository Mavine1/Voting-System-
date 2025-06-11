<?php
	include 'includes/session.php';

	if(isset($_POST['edit'])){
		$id = $_POST['id'];
		$description = $_POST['description'];
		$max_vote = $_POST['max_vote'];
		$platform = $_POST['platform'];
		
		// Escape strings to prevent SQL injection
		$description = mysqli_real_escape_string($conn, $description);
		$platform = mysqli_real_escape_string($conn, $platform);
		$max_vote = (int)$max_vote;
		$id = (int)$id;

		// Start transaction
		$conn->autocommit(FALSE);
		
		try {
			// Update positions table
			$sql1 = "UPDATE positions SET description = '$description', max_vote = '$max_vote' WHERE id = '$id'";
			
			if(!$conn->query($sql1)){
				throw new Exception($conn->error);
			}
			
			// Update platform in candidates table for all candidates with this position_id
			if(!empty($platform)){
				$sql2 = "UPDATE candidates SET platform = '$platform' WHERE position_id = '$id'";
				
				if(!$conn->query($sql2)){
					throw new Exception($conn->error);
				}
			}
			
			// Commit transaction
			$conn->commit();
			$_SESSION['success'] = 'Position and platform updated successfully';
			
		} catch (Exception $e) {
			// Rollback transaction on error
			$conn->rollback();
			$_SESSION['error'] = 'Error updating position: ' . $e->getMessage();
		}
		
		// Reset autocommit
		$conn->autocommit(TRUE);
	}
	else{
		$_SESSION['error'] = 'Fill up edit form first';
	}

	header('location: positions.php');
?>