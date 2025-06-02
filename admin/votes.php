<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); color: #2c3e50; font-size: 17px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <!-- Content Header (Page header) -->
    <section class="content-header" style="background: linear-gradient(90deg, #1e3a8a 0%, #3b82f6 100%); color: white; padding: 20px; border-radius: 10px; margin: 15px; box-shadow: 0 4px 15px rgba(30, 58, 138, 0.3);">
      <h1 style="margin: 0; font-weight: 600; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
        <i class="fa fa-bar-chart" style="margin-right: 10px;"></i>VOTES SUMMARY
      </h1>
      <ol class="breadcrumb" style="background: rgba(255,255,255,0.1); border-radius: 20px; padding: 8px 15px; margin-top: 10px;">
        <li><a href="#" style="color: #e0e7ff;"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active" style="color: white;">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content" style="padding: 0 15px;">
      <?php
        if(isset($_SESSION['error'])){
          echo "
            <div class='alert alert-danger alert-dismissible' style='background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%); border: none; border-radius: 10px; color: white; box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true' style='color: white; opacity: 0.8;'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              ".$_SESSION['error']."
            </div>
          ";
          unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
          echo "
            <div class='alert alert-success alert-dismissible' style='background: linear-gradient(135deg, #059669 0%, #10b981 100%); border: none; border-radius: 10px; color: white; box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true' style='color: white; opacity: 0.8;'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              ".$_SESSION['success']."
            </div>
          ";
          unset($_SESSION['success']);
        }
      ?>

      <div class="row">
        <div class="col-xs-12">
          <div class="box" style="background: white; border-radius: 15px; box-shadow: 0 8px 25px rgba(0,0,0,0.1); border: none; overflow: hidden;">
            <div class="box-header with-border" style="background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%); border-bottom: 3px solid #3b82f6; padding: 20px;">
              <div class="row">
                <div class="col-md-4">
                  <!-- Position Filter -->
                  <div class="form-group">
                    <label for="position_filter" style="color: #1e40af; font-size: 14px; font-weight: 600; margin-bottom: 8px; display: block;">
                      <i class="fa fa-filter" style="margin-right: 8px;"></i>Filter by Position:
                    </label>
                    <select id="position_filter" class="form-control" style="width: 250px; border: 2px solid #3b82f6; border-radius: 8px; padding: 7px; font-size: 14px; background: white;">
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
                <div class="col-md-8 text-right">
                  <button onclick="window.print()" class="btn btn-curve" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%); color: white; font-size: 14px; font-weight: 600; padding: 12px 24px; border-radius: 25px; border: none; box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3); transition: all 0.3s ease; margin-right: 10px;">
                    <i class="fa fa-print" style="margin-right: 8px;"></i> Print Report
                  </button>
                  <a href="#reset" data-toggle="modal" class="btn btn-curve" style="background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%); color: white; font-size: 14px; font-weight: 600; padding: 12px 24px; border-radius: 25px; border: none; box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3); transition: all 0.3s ease;">
                    <i class="fa fa-refresh" style="margin-right: 8px;"></i> Reset Votes
                  </a>
                </div>
              </div>
            </div>
            
            <div class="box-body" style="padding: 25px;" id="printable-content">
              <div style="overflow-x: auto;">
                <table id="example1" class="table table-hover" style="margin: 0; border-collapse: separate; border-spacing: 0;">
                  <thead>
                    <tr style="background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); color: white;">
                      <th style="padding: 15px; font-weight: 600; text-align: center; border-radius: 10px 0 0 0;">
                        <i class="fa fa-briefcase" style="margin-right: 8px;"></i>Position
                      </th>
                      <th style="padding: 15px; font-weight: 600; text-align: center;">
                        <i class="fa fa-user" style="margin-right: 8px;"></i>Candidate
                      </th>
                      <th style="padding: 15px; font-weight: 600; text-align: center;">
                        <i class="fa fa-trophy" style="margin-right: 8px;"></i>Vote Count
                      </th>
                      <th style="padding: 15px; font-weight: 600; text-align: center;">
                        <i class="fa fa-percent" style="margin-right: 8px;"></i>Percentage
                      </th>
                      <th style="padding: 15px; font-weight: 600; text-align: center; border-radius: 0 10px 0 0;">
                        <i class="fa fa-comment" style="margin-right: 8px;"></i>Remarks
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      // Get filter parameter
                      $position_filter = isset($_GET['position']) ? $_GET['position'] : '';
                      
                      // Base query to get vote counts per candidate with remarks
                      $sql = "SELECT 
                                p.id as position_id,
                                p.description as position_name,
                                p.priority,
                                c.id as candidate_id,
                                c.firstname as candidate_first,
                                c.lastname as candidate_last,
                                c.photo as candidate_photo,
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
                      
                      $current_position = '';
                      $row_counter = 0;
                      while($row = $query->fetch_assoc()){
                        $row_counter++;
                        // Calculate percentage
                        $total_votes_for_position = isset($position_totals[$row['position_id']]) ? $position_totals[$row['position_id']] : 0;
                        $percentage = ($total_votes_for_position > 0) ? round(($row['vote_count'] / $total_votes_for_position) * 100, 1) : 0;
                        
                        // Process remarks
                        $remarks = !empty($row['all_remarks']) ? $row['all_remarks'] : 'No remarks';
                        $remarks = str_replace('; ; ', '; ', $remarks); // Clean up duplicated separators
                        $remarks = trim($remarks, '; '); // Remove leading/trailing separators
                        
                        // Determine row styling
                        $row_style = '';
                        $is_leading = false;
                        if($row['vote_count'] > 0) {
                          // Check if this is the highest vote count for this position
                          $check_sql = "SELECT MAX(vote_counts.vote_count) as max_votes 
                                        FROM (
                                          SELECT COUNT(v2.id) as vote_count
                                          FROM candidates c2 
                                          LEFT JOIN votes v2 ON v2.candidate_id = c2.id
                                          WHERE c2.position_id = ".$row['position_id']."
                                          GROUP BY c2.id
                                        ) as vote_counts";
                          $check_query = $conn->query($check_sql);
                          $max_row = $check_query->fetch_assoc();
                          if($row['vote_count'] == $max_row['max_votes'] && $row['vote_count'] > 0) {
                            $row_style = 'background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%); border-left: 4px solid #059669;';
                            $is_leading = true;
                          }
                        }
                        
                        if(!$is_leading) {
                          $row_style = ($row_counter % 2 == 0) ? 'background: #f8fafc;' : 'background: white;';
                        }
                        
                        echo "
                          <tr style='color: #374151; font-size: 15px; transition: all 0.3s ease; $row_style' onmouseover='this.style.background=\"#e0f2fe\"' onmouseout='this.style.background=\"".($is_leading ? 'linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%)' : (($row_counter % 2 == 0) ? '#f8fafc' : 'white'))."\"'>
                            <td style='padding: 15px; vertical-align: middle; font-weight: 600; color: #1e40af;'>";
                        
                        if($is_leading) {
                          echo "<i class='fa fa-crown' style='color: #f59e0b; margin-right: 8px;'></i>";
                        }
                        
                        echo $row['position_name']."</td>
                            <td style='padding: 15px; vertical-align: middle;'>";
                        
                        // Show candidate photo if available
                        if(!empty($row['candidate_photo'])) {
                          echo "<img src='images/".$row['candidate_photo']."' style='height: 40px; width: 40px; border-radius: 50%; margin-right: 12px; border: 2px solid #3b82f6; box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);'>";
                        } else {
                          echo "<div style='height: 40px; width: 40px; border-radius: 50%; margin-right: 12px; background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%); display: inline-flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 16px;'>".strtoupper(substr($row['candidate_first'], 0, 1))."</div>";
                        }
                        
                        echo "<span style='font-weight: 500;'>".$row['candidate_first'].' '.$row['candidate_last']."</span>";
                        
                        if($is_leading) {
                          echo " <span style='background: linear-gradient(135deg, #059669 0%, #10b981 100%); color: white; padding: 2px 8px; border-radius: 12px; font-size: 11px; font-weight: 600; margin-left: 8px;'>LEADING</span>";
                        }
                        
                        echo "</td>
                            <td style='padding: 15px; vertical-align: middle; text-align: center;'>
                              <span style='background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); color: white; padding: 8px 16px; border-radius: 20px; font-weight: 600; font-size: 16px; box-shadow: 0 2px 8px rgba(30, 64, 175, 0.3);'>".$row['vote_count']."</span>
                            </td>
                            <td style='padding: 15px; vertical-align: middle;'>";
                        
                        // Enhanced progress bar for percentage
                        if($percentage > 0) {
                          $bar_color = $is_leading ? 'linear-gradient(135deg, #059669 0%, #10b981 100%)' : 'linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%)';
                          echo "<div style='background: #f1f5f9; border-radius: 25px; overflow: hidden; height: 25px; position: relative; box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);'>
                                  <div style='background: $bar_color; width: ".$percentage."%; height: 100%; border-radius: 25px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 12px; transition: width 0.5s ease;'>
                                    ".$percentage."%
                                  </div>
                                </div>";
                        } else {
                          echo "<div style='background: #f1f5f9; border-radius: 25px; height: 25px; display: flex; align-items: center; justify-content: center; color: #64748b; font-weight: 500; font-size: 12px;'>0%</div>";
                        }
                        
                        echo "</td>
                            <td style='padding: 15px; vertical-align: middle; max-width: 200px;'>";
                        
                        // Display remarks with styling
                        if($remarks != 'No remarks') {
                          $remarks_array = explode('; ', $remarks);
                          $unique_remarks = array_unique(array_filter($remarks_array)); // Remove duplicates and empty values
                          
                          if(!empty($unique_remarks)) {
                            echo "<div style='max-height: 60px; overflow-y: auto; font-size: 13px;'>";
                            foreach($unique_remarks as $remark) {
                              if(trim($remark) != '') {
                                echo "<span style='background: #e0f2fe; color: #0369a1; padding: 2px 6px; border-radius: 8px; font-size: 11px; margin: 1px; display: inline-block;'>".htmlspecialchars(trim($remark))."</span>";
                              }
                            }
                            echo "</div>";
                          } else {
                            echo "<span style='color: #64748b; font-style: italic; font-size: 12px;'>No remarks</span>";
                          }
                        } else {
                          echo "<span style='color: #64748b; font-style: italic; font-size: 12px;'>No remarks</span>";
                        }
                        
                        echo "</td>
                          </tr>
                        ";
                      }
                      
                      // Show message if no data
                      if($query->num_rows == 0) {
                        echo "<tr><td colspan='5' style='text-align: center; color: #64748b; padding: 40px; font-style: italic;'>
                                <i class='fa fa-info-circle' style='font-size: 24px; margin-bottom: 10px; display: block;'></i>
                                No candidates or votes found
                              </td></tr>";
                      }
                    ?>
                  </tbody>
                </table>
              </div>
              
              <!-- Vote Summary Statistics -->
              <div class="row" style="margin-top: 30px;">
                <div class="col-md-12">
                  <div class="info-box" style="background: white; border-radius: 15px; box-shadow: 0 6px 20px rgba(0,0,0,0.1); border: none; overflow: hidden;">
                    <div style="background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); padding: 20px; color: white;">
                      <div style="display: flex; align-items: center;">
                        <span class="info-box-icon" style="background: rgba(255,255,255,0.2); border-radius: 50%; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; margin-right: 20px;">
                          <i class="fa fa-bar-chart" style="font-size: 24px;"></i>
                        </span>
                        <div>
                          <span style="font-size: 18px; font-weight: 600; display: block; margin-bottom: 5px;">Election Statistics</span>
                          <span style="font-size: 24px; font-weight: 700;">
                            <?php
                              // Get total votes cast
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
                              $turnout = ($voters_row['total_voters'] > 0) ? round(($stats_row['total_votes'] / $voters_row['total_voters']) * 100, 1) : 0;
                              
                              echo "<span style='color: #fbbf24;'>".$stats_row['total_votes']."</span> Total Votes";
                              echo " | <span style='color: #a78bfa;'>".$voters_row['total_voters']."</span> Registered";
                              echo " | <span style='color: #34d399;'>".$turnout."%</span> Turnout";
                            ?>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  
  <?php include 'includes/footer.php'; ?>
  <?php include 'includes/votes_modal.php'; ?>
</div>

<?php include 'includes/scripts.php'; ?>

<script>
$(document).ready(function() {
  // Handle position filter change
  $('#position_filter').change(function() {
    var selectedPosition = $(this).val();
    var currentUrl = window.location.href.split('?')[0];
    
    if(selectedPosition !== '') {
      window.location.href = currentUrl + '?position=' + selectedPosition;
    } else {
      window.location.href = currentUrl;
    }
  });
  
  // Check if DataTable is already initialized and destroy it first
  if ($.fn.DataTable.isDataTable('#example1')) {
    $('#example1').DataTable().destroy();
  }
  
  // Initialize DataTable with custom options
  $('#example1').DataTable({
    'paging': true,
    'lengthChange': false,
    'searching': true,
    'ordering': true,
    'info': true,
    'autoWidth': false,
    'pageLength': 25,
    'order': [[ 0, 'asc' ], [ 2, 'desc' ]], // Order by position then by vote count
    'columnDefs': [
      { 'orderable': false, 'targets': [3, 4] } // Disable sorting on percentage and remarks columns
    ]
  });
  
  // Add hover effects for buttons
  $('button[onclick="window.print()"], a[href="#reset"]').hover(
    function() {
      $(this).css({
        'transform': 'translateY(-2px)',
        'box-shadow': $(this).css('background-color').includes('rgb(220, 38, 38)') || $(this).css('background-image').includes('220, 38, 38') ? 
          '0 6px 20px rgba(220, 38, 38, 0.4)' : '0 6px 20px rgba(5, 150, 105, 0.4)'
      });
    },
    function() {
      $(this).css({
        'transform': 'translateY(0)',
        'box-shadow': $(this).css('background-color').includes('rgb(220, 38, 38)') || $(this).css('background-image').includes('220, 38, 38') ? 
          '0 4px 12px rgba(220, 38, 38, 0.3)' : '0 4px 12px rgba(5, 150, 105, 0.3)'
      });
    }
  );
});
</script>

<style>
/* Enhanced styling for the voting system */
body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
}

.table {
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 4px 15px rgba(0,0,0,0.05);
}

.table > thead > tr > th {
  border: none;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  font-size: 13px;
}

.table > tbody > tr > td {
  border: none;
  border-bottom: 1px solid #e2e8f0;
}

.table > tbody > tr:last-child > td {
  border-bottom: none;
}

.alert {
  border: none;
  margin: 15px;
}

.form-control {
  transition: all 0.3s ease;
}

.form-control:focus {
  border-color: #3b82f6;
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
  outline: none;
}

/* Custom scrollbar for table */
.box-body::-webkit-scrollbar {
  height: 8px;
}

.box-body::-webkit-scrollbar-track {
  background: #f1f5f9;
  border-radius: 4px;
}

.box-body::-webkit-scrollbar-thumb {
  background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
  border-radius: 4px;
}

.box-body::-webkit-scrollbar-thumb:hover {
  background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
}

/* Print styles */
@media print {
  body * {
    visibility: hidden;
  }
  
  #printable-content, #printable-content * {
    visibility: visible;
  }
  
  #printable-content {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
  }
  
  .btn, .form-control, .box-header {
    display: none !important;
  }
  
  .table {
    border: 1px solid #000 !important;
  }
  
  .table th, .table td {
    border: 1px solid #000 !important;
    padding: 8px !important;
    font-size: 12px !important;
  }
  
  .table th {
    background: #f0f0f0 !important;
    color: #000 !important;
  }
  
  .content-wrapper {
    background: white !important;
    margin: 0 !important;
    padding: 0 !important;
  }
  
  .box {
    box-shadow: none !important;
    border: none !important;
  }
  
  @page {
    margin: 0.5in;
    size: landscape;
  }
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .content-header {
    margin: 10px !important;
    padding: 15px !important;
  }
  
  .box-header .row {
    margin: 0;
  }
  
  .box-header .col-md-4,
  .box-header .col-md-8 {
    margin-bottom: 15px;
  }
  
  #position_filter {
    width: 100% !important;
  }
  
  .table-responsive {
    border: none;
  }
  
  .info-box-content span {
    font-size: 14px !important;
  }
  
  .btn {
    display: block !important;
    width: 100% !important;
    margin: 5px 0 !important;
  }
}

@media (max-width: 480px) {
  .content-header h1 {
    font-size: 24px !important;
  }
  
  .table > thead > tr > th,
  .table > tbody > tr > td {
    padding: 8px !important;
    font-size: 12px !important;
  }
  
  .btn {
    padding: 8px 16px !important;
    font-size: 12px !important;
  }
}

/* Animation for leading candidates */
@keyframes pulse {
  0% { box-shadow: 0 0 0 0 rgba(5, 150, 105, 0.4); }
  70% { box-shadow: 0 0 0 10px rgba(5, 150, 105, 0); }
  100% { box-shadow: 0 0 0 0 rgba(5, 150, 105, 0); }
}

.fa-crown {
  animation: pulse 2s infinite;
}

/* Remarks styling */
.table td:last-child {
  max-width: 200px;
  word-wrap: break-word;
}

.table td:last-child div {
  max-height: 60px;
  overflow-y: auto;
}

.table td:last-child div::-webkit-scrollbar {
  width: 4px;
}

.table td:last-child div::-webkit-scrollbar-track {
  background: #f1f5f9;
  border-radius: 2px;
}

.table td:last-child div::-webkit-scrollbar-thumb {
  background: #cbd5e1;
  border-radius: 2px;
}
</style>

</body>
</html>