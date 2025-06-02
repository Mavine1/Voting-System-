<?php
	include 'includes/session.php';
	include 'includes/slugify.php';

	if (isset($_POST['vote'])) {
		if (count($_POST) == 1) {
			$_SESSION['error'][] = 'Please vote for at least one candidate.';
		} else {
			$_SESSION['post'] = $_POST;
			$sql = "SELECT * FROM positions";
			$query = $conn->query($sql);
			$error = false;
			$sql_array = array();

			while ($row = $query->fetch_assoc()) {
				$position = slugify($row['description']);
				$pos_id = $row['id'];

				if (isset($_POST[$position])) {
					// Get remarks for this specific position
					$remarks_field = 'remarks_' . $position;
					$remarks = isset($_POST[$remarks_field]) ? $conn->real_escape_string(trim($_POST[$remarks_field])) : '';

					// Multiple selections allowed
					if ($row['max_vote'] > 1) {
						if (count($_POST[$position]) > $row['max_vote']) {
							$error = true;
							$_SESSION['error'][] = 'You can only choose ' . $row['max_vote'] . ' candidates for ' . $row['description'];
						} else {
							foreach ($_POST[$position] as $candidate_id) {
								$candidate_id = $conn->real_escape_string($candidate_id);
								$sql_array[] = "INSERT INTO votes (voters_id, candidate_id, position_id, remarks) 
												VALUES ('" . $voter['id'] . "', '$candidate_id', '$pos_id', '$remarks')";
							}
						}
					}
					// Single selection
					else {
						$candidate_id = $conn->real_escape_string($_POST[$position]);
						$sql_array[] = "INSERT INTO votes (voters_id, candidate_id, position_id, remarks) 
										VALUES ('" . $voter['id'] . "', '$candidate_id', '$pos_id', '$remarks')";
					}
				}
			}

			if (!$error) {
				// Begin transaction to ensure data consistency
				$conn->autocommit(FALSE);
				$transaction_success = true;

				foreach ($sql_array as $query_str) {
					if (!$conn->query($query_str)) {
						$transaction_success = false;
						$_SESSION['error'][] = 'Database error: ' . $conn->error;
						break;
					}
				}

				if ($transaction_success) {
					$conn->commit();
					unset($_SESSION['post']);
					$_SESSION['success'] = 'Ballot Submitted Successfully';
				} else {
					$conn->rollback();
				}

				$conn->autocommit(TRUE);
			}
		}
	} else {
		$_SESSION['error'][] = 'Please select candidates before submitting.';
	}

	header('location: home.php');
?>