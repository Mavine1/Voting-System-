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

			$remark = isset($_POST['remark']) ? $conn->real_escape_string($_POST['remark']) : ''; // Sanitize remark input

			while ($row = $query->fetch_assoc()) {
				$position = slugify($row['description']);
				$pos_id = $row['id'];

				if (isset($_POST[$position])) {
					// Multiple selections allowed
					if ($row['max_vote'] > 1) {
						if (count($_POST[$position]) > $row['max_vote']) {
							$error = true;
							$_SESSION['error'][] = 'You can only choose ' . $row['max_vote'] . ' candidates for ' . $row['description'];
						} else {
							foreach ($_POST[$position] as $candidate_id) {
								$sql_array[] = "INSERT INTO votes (voters_id, candidate_id, position_id, remarks) 
												VALUES ('" . $voter['id'] . "', '$candidate_id', '$pos_id', '$remark')";
							}
						}
					}
					// Single selection
					else {
						$candidate_id = $_POST[$position];
						$sql_array[] = "INSERT INTO votes (voters_id, candidate_id, position_id, remarks) 
										VALUES ('" . $voter['id'] . "', '$candidate_id', '$pos_id', '$remark')";
					}
				}
			}

			if (!$error) {
				foreach ($sql_array as $query_str) {
					$conn->query($query_str);
				}

				unset($_SESSION['post']);
				$_SESSION['success'] = 'Ballot Submitted Successfully';
			}
		}
	} else {
		$_SESSION['error'][] = 'Please select candidates before submitting.';
	}

	header('location: home.php');
?>
