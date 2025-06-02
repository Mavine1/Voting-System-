<?php include 'includes/session.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Votes Summary Report</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <style>
        @media print {
            * {
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
            }
            
            body {
                font-family: Arial, sans-serif;
                font-size: 12px;
                line-height: 1.4;
                color: #000;
                margin: 0;
                padding: 20px;
            }
            
            .no-print {
                display: none !important;
            }
            
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }
            
            th, td {
                border: 1px solid #000;
                padding: 8px;
                text-align: left;
                vertical-align: top;
            }
            
            th {
                background-color: #f0f0f0;
                font-weight: bold;
                text-align: center;
            }
            
            .text-center {
                text-align: center;
            }
            
            .header {
                text-align: center;
                margin-bottom: 20px;
            }
            
            .stats {
                margin-top: 20px;
                padding: 10px;
                border: 1px solid #000;
                background-color: #f9f9f9;
            }
            
            .leading {
                background-color: #e8f5e8 !important;
                font-weight: bold;
            }
        }
        
        @media screen {
            body {
                font-family: Arial, sans-serif;
                margin: 20px;
                background: #f5f5f5;
            }
            
            .container {
                background: white;
                padding: 30px;
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }
            
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }
            
            th, td {
                border: 1px solid #ddd;
                padding: 12px;
                text-align: left;
            }
            
            th {
                background-color: #f8f9fa;
                font-weight: bold;
                text-align: center;
            }
            
            .text-center {
                text-align: center;
            }
            
            .print-btn {
                background: #007bff;
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                margin-bottom: 20px;
            }
            
            .print-btn:hover {
                background: #0056b3;
            }
            
            .header {
                text-align: center;
                margin-bottom: 30px;
            }
            
            .stats {
                margin-top: 20px;
                padding: 15px;
                background-color: #f8f9fa;
                border-radius: 4px;
                border: 1px solid #dee2e6;
            }
            
            .leading {
                background-color: #d4edda;
                font-weight: bold;
            }
            
            .filter-section {
                margin-bottom: 20px;
                padding: 15px;
                background: #e9ecef;
                border-radius: 4px;
            }
            
            .form-control {
                padding: 8px;
                border: 1px solid #ccc;
                border-radius: 4px;
                margin-left: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="no-print">
            <button onclick="window.print()" class="print-btn">🖨️ Print Report</button>
            
            <div class="filter-section">
                <label for="position_filter">Filter by Position:</label>
                <select id="position_filter" class="form-control" onchange="filterPosition()">
                    <option value="">All Positions</option>
                    <?php
                        $pos_sql = "SELECT * FROM positions ORDER BY priority ASC";
                        $pos_query = $conn->query($pos_sql);
                        while($pos_row = $pos_query->fetch_assoc()){
                            $selected = (isset($_GET['position']) && $_GET['position'] == $pos_row['id']) ? 'selected' : '';
                            echo "<option value='".$pos_row['id']."' $selected>".$pos_row['description']."</option>";
                        }
                    ?>
                </select>
            </div>
        </div>

        <div class="header">
            <h1>ELECTION VOTES SUMMARY REPORT</h1>
            <p>Generated on: <?php echo date('F d, Y - g:i A'); ?></p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>POSITION</th>
                    <th>CANDIDATE</th>
                    <th>VOTE COUNT</th>
                    <th>PERCENTAGE</th>
                    <th>STATUS</th>
                    <th>REMARKS</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // Get filter parameter
                    $position_filter = isset($_GET['position']) ? $_GET['position'] : '';
                    
                    // Base query to get vote counts per candidate
                    $sql = "SELECT 
                              p.id as position_id,
                              p.description as position_name,
                              p.priority,
                              c.id as candidate_id,
                              c.firstname as candidate_first,
                              c.lastname as candidate_last,
                              COUNT(v.id) as vote_count,
                              GROUP_CONCAT(DISTINCT v.remarks SEPARATOR '; ') as all_remarks
                            FROM positions p
                            LEFT JOIN candidates c ON c.position_id = p.id
                            LEFT JOIN votes v ON v.candidate_id = c.id
                            WHERE 1=1";
                    
                    // Add position filter if selected
                    if(!empty($position_filter)){
                        $sql .= " AND p.id = ".$position_filter;
                    }
                    
                    $sql .= " GROUP BY p.id, c.id
                             ORDER BY p.priority ASC, vote_count DESC";
                    
                    $query = $conn->query($sql);
                    
                    // Get total votes per position for percentage calculation
                    $position_totals = array();
                    $total_sql = "SELECT 
                                    p.id as position_id,
                                    COUNT(v.id) as total_votes
                                  FROM positions p
                                  LEFT JOIN votes v ON v.position_id = p.id
                                  WHERE 1=1";
                    if(!empty($position_filter)){
                        $total_sql .= " AND p.id = ".$position_filter;
                    }
                    $total_sql .= " GROUP BY p.id";
                    
                    $total_query = $conn->query($total_sql);
                    while($total_row = $total_query->fetch_assoc()){
                        $position_totals[$total_row['position_id']] = $total_row['total_votes'];
                    }
                    
                    // Track leading candidates per position
                    $position_leaders = array();
                    $leader_sql = "SELECT 
                                     p.id as position_id,
                                     MAX(vote_counts.vote_count) as max_votes 
                                   FROM positions p
                                   LEFT JOIN (
                                     SELECT 
                                       c.position_id,
                                       COUNT(v.id) as vote_count
                                     FROM candidates c 
                                     LEFT JOIN votes v ON v.candidate_id = c.id
                                     GROUP BY c.id
                                   ) as vote_counts ON vote_counts.position_id = p.id
                                   WHERE 1=1";
                    if(!empty($position_filter)){
                        $leader_sql .= " AND p.id = ".$position_filter;
                    }
                    $leader_sql .= " GROUP BY p.id";
                    
                    $leader_query = $conn->query($leader_sql);
                    while($leader_row = $leader_query->fetch_assoc()){
                        $position_leaders[$leader_row['position_id']] = $leader_row['max_votes'];
                    }
                    
                    if($query->num_rows > 0) {
                        while($row = $query->fetch_assoc()){
                            // Calculate percentage
                            $total_votes_for_position = isset($position_totals[$row['position_id']]) ? $position_totals[$row['position_id']] : 0;
                            $percentage = ($total_votes_for_position > 0) ? round(($row['vote_count'] / $total_votes_for_position) * 100, 1) : 0;
                            
                            // Check if leading
                            $max_votes_for_position = isset($position_leaders[$row['position_id']]) ? $position_leaders[$row['position_id']] : 0;
                            $is_leading = ($row['vote_count'] > 0 && $row['vote_count'] == $max_votes_for_position);
                            
                            // Process remarks
                            $remarks = !empty($row['all_remarks']) ? $row['all_remarks'] : 'No remarks';
                            $remarks = str_replace('; ; ', '; ', $remarks);
                            $remarks = trim($remarks, '; ');
                            if($remarks == '') $remarks = 'No remarks';
                            
                            // Clean up remarks for display
                            $remarks_array = array_unique(array_filter(explode('; ', $remarks)));
                            $clean_remarks = implode('; ', $remarks_array);
                            if(empty($clean_remarks) || $clean_remarks == 'No remarks') {
                                $clean_remarks = 'No remarks';
                            }
                            
                            $row_class = $is_leading ? 'leading' : '';
                            $status = $is_leading ? 'LEADING' : 'CANDIDATE';
                            
                            echo "<tr class='$row_class'>
                                    <td>".$row['position_name']."</td>
                                    <td>".$row['candidate_first'].' '.$row['candidate_last']."</td>
                                    <td class='text-center'>".$row['vote_count']."</td>
                                    <td class='text-center'>".$percentage."%</td>
                                    <td class='text-center'>".$status."</td>
                                    <td>".htmlspecialchars($clean_remarks)."</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>No candidates or votes found</td></tr>";
                    }
                ?>
            </tbody>
        </table>

        <div class="stats">
            <h3>Election Statistics Summary</h3>
            <?php
                // Get comprehensive statistics
                $stats_sql = "SELECT COUNT(*) as total_votes FROM votes";
                if(!empty($position_filter)){
                    $stats_sql .= " WHERE position_id = ".$position_filter;
                }
                $stats_query = $conn->query($stats_sql);
                $stats_row = $stats_query->fetch_assoc();
                
                // Get total registered voters
                $voters_sql = "SELECT COUNT(*) as total_voters FROM voters";
                $voters_query = $conn->query($voters_sql);
                $voters_row = $voters_query->fetch_assoc();
                
                // Get total positions
                $positions_sql = "SELECT COUNT(*) as total_positions FROM positions";
                if(!empty($position_filter)){
                    $positions_sql .= " WHERE id = ".$position_filter;
                }
                $positions_query = $conn->query($positions_sql);
                $positions_row = $positions_query->fetch_assoc();
                
                // Get total candidates
                $candidates_sql = "SELECT COUNT(*) as total_candidates FROM candidates c JOIN positions p ON c.position_id = p.id WHERE 1=1";
                if(!empty($position_filter)){
                    $candidates_sql .= " AND p.id = ".$position_filter;
                }
                $candidates_query = $conn->query($candidates_sql);
                $candidates_row = $candidates_query->fetch_assoc();
                
                $turnout = ($voters_row['total_voters'] > 0) ? round(($stats_row['total_votes'] / $voters_row['total_voters']) * 100, 1) : 0;
                
                echo "<p><strong>Total Votes Cast:</strong> ".$stats_row['total_votes']."</p>";
                echo "<p><strong>Total Registered Voters:</strong> ".$voters_row['total_voters']."</p>";
                echo "<p><strong>Voter Turnout:</strong> ".$turnout."%</p>";
                echo "<p><strong>Total Positions:</strong> ".$positions_row['total_positions']."</p>";
                echo "<p><strong>Total Candidates:</strong> ".$candidates_row['total_candidates']."</p>";
                
                if(!empty($position_filter)){
                    $selected_pos_sql = "SELECT description FROM positions WHERE id = ".$position_filter;
                    $selected_pos_query = $conn->query($selected_pos_sql);
                    $selected_pos_row = $selected_pos_query->fetch_assoc();
                    echo "<p><strong>Filtered Position:</strong> ".$selected_pos_row['description']."</p>";
                }
            ?>
        </div>
    </div>

    <script>
        function filterPosition() {
            var selectedPosition = document.getElementById('position_filter').value;
            var currentUrl = window.location.href.split('?')[0];
            
            if(selectedPosition !== '') {
                window.location.href = currentUrl + '?position=' + selectedPosition;
            } else {
                window.location.href = currentUrl;
            }
        }
    </script>
</body>
</html>