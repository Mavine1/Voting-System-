<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background-color:#F1E9D2 ;color:black ; font-size: 17px; font-family:Times ">
    <!-- Content Header (Page header) -->
    <section class="content-header" style= "color:black ; font-size: 17px; font-family:Times">
      <h1>
        VOTES SUMMARY
      </h1>
      <ol class="breadcrumb" style="color:black ; font-size: 17px; font-family:Times">
        <li><a href="#"><i class="fa fa-dashboard" ></i> Home</a></li>
        <li class="active" style="color:black ; font-size: 17px; font-family:Times" >Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <?php
        if(isset($_SESSION['error'])){
          echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              ".$_SESSION['error']."
            </div>
          ";
          unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
          echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              ".$_SESSION['success']."
            </div>
          ";
          unset($_SESSION['success']);
        }
      ?>

      <div class="row">
        <div class="col-xs-12">
          <div class="box" style="background-color: #d8d1bd">
            <div class="box-header with-border" style="background-color: #d8d1bd">
              <div class="row">
                <div class="col-md-6">
                  <!-- Position Filter -->
                  <div class="form-group">
                    <label for="position_filter" style="color:black; font-size: 14px; font-family:Times">Filter by Position:</label>
                    <select id="position_filter" class="form-control" style="width: 200px; display: inline-block; margin-left: 10px;">
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
                <div class="col-md-6 text-right">
                  <a href="#reset" data-toggle="modal" class="btn btn-danger btn-sm btn-curve" style="background-color: #ff8e88;color:black ; font-size: 12px; font-family:Times">
                    <i class="fa fa-refresh"></i> Reset Votes
                  </a>
                </div>
              </div>
            </div>
            
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead style="background-color: #c8c1a4;">
                  <th style="color:black; font-weight: bold;">Position</th>
                  <th style="color:black; font-weight: bold;">Candidate</th>
                  <th style="color:black; font-weight: bold;">Vote Count</th>
                  <th style="color:black; font-weight: bold;">Percentage</th>
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
                              c.photo as candidate_photo,
                              COUNT(v.id) as vote_count
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
                    while($row = $query->fetch_assoc()){
                      // Calculate percentage
                      $total_votes_for_position = isset($position_totals[$row['position_id']]) ? $position_totals[$row['position_id']] : 0;
                      $percentage = ($total_votes_for_position > 0) ? round(($row['vote_count'] / $total_votes_for_position) * 100, 1) : 0;
                      
                      // Highlight row if this candidate is winning
                      $row_class = '';
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
                          $row_class = 'style="background-color: #d4edda;"'; // Light green for leading candidate
                        }
                      }
                      
                      echo "
                        <tr style='color:black ; font-size: 15px; font-family:Times' $row_class>
                          <td><strong>".$row['position_name']."</strong></td>
                          <td>";
                      
                      // Show candidate photo if available
                      if(!empty($row['candidate_photo'])) {
                        echo "<img src='images/".$row['candidate_photo']."' style='height: 30px; width: 30px; border-radius: 50%; margin-right: 10px;'>";
                      }
                      
                      echo $row['candidate_first'].' '.$row['candidate_last']."
                          </td>
                          <td><strong>".$row['vote_count']."</strong></td>
                          <td>";
                      
                      // Progress bar for percentage
                      if($percentage > 0) {
                        echo "<div class='progress' style='height: 20px; margin-bottom: 0;'>
                                <div class='progress-bar progress-bar-info' role='progressbar' 
                                     style='width: ".$percentage."%; background-color: #5bc0de;'>
                                  ".$percentage."%
                                </div>
                              </div>";
                      } else {
                        echo "0%";
                      }
                      
                      echo "</td>
                        </tr>
                      ";
                    }
                    
                    // Show message if no data
                    if($query->num_rows == 0) {
                      echo "<tr><td colspan='4' style='text-align: center; color: #666;'>No candidates or votes found</td></tr>";
                    }
                  ?>
                </tbody>
              </table>
              
              <!-- Vote Summary Statistics -->
              <div class="row" style="margin-top: 20px;">
                <div class="col-md-12">
                  <div class="info-box" style="background-color: #e8e1cc;">
                    <span class="info-box-icon" style="background-color: #5bc0de;"><i class="fa fa-bar-chart"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text" style="color: black; font-family: Times;">Total Statistics</span>
                      <span class="info-box-number" style="color: black; font-family: Times;">
                        <?php
                          // Get total votes cast
                          $stats_sql = "SELECT COUNT(*) as total_votes FROM votes";
                          if(!empty($position_filter)){
                            $stats_sql .= " WHERE position_id = ".$position_filter;
                          }
                          $stats_query = $conn->query($stats_sql);
                          $stats_row = $stats_query->fetch_assoc();
                          echo "Total Votes Cast: ".$stats_row['total_votes'];
                          
                          // Get total registered voters
                          $voters_sql = "SELECT COUNT(*) as total_voters FROM voters";
                          $voters_query = $conn->query($voters_sql);
                          $voters_row = $voters_query->fetch_assoc();
                          $turnout = ($voters_row['total_voters'] > 0) ? round(($stats_row['total_votes'] / $voters_row['total_voters']) * 100, 1) : 0;
                          echo " | Registered Voters: ".$voters_row['total_voters'];
                          echo " | Turnout: ".$turnout."%";
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
      { 'orderable': false, 'targets': 3 } // Disable sorting on percentage column
    ]
  });
});
</script>

<style>
.progress {
  background-color: #f5f5f5;
  border-radius: 4px;
  box-shadow: inset 0 1px 2px rgba(0,0,0,.1);
}

.table > thead > tr > th {
  border-bottom: 2px solid #a69c7f;
}

.table > tbody > tr > td {
  border-top: 1px solid #ddd;
  vertical-align: middle;
}

.info-box {
  border-radius: 5px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.12);
  margin-bottom: 15px;
}

.alert {
  border-radius: 4px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .box-header .row {
    margin: 0;
  }
  
  .box-header .col-md-6 {
    margin-bottom: 10px;
  }
  
  .form-control {
    width: 100% !important;
  }
}
</style>

</body>
</html>