<?php 
include 'includes/session.php';
include 'includes/slugify.php';
include 'includes/header.php'; 
?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php 
  include 'includes/navbar.php';
  include 'includes/menubar.php'; 
  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); min-height: 100vh;">
    <!-- Content Header (Page header) -->
    <section class="content-header" style="background: linear-gradient(90deg, #1e3a8a 0%, #3b82f6 100%); color: white; padding: 25px; border-radius: 15px; margin: 20px; box-shadow: 0 8px 25px rgba(30, 58, 138, 0.3);">
      <h1 style="margin: 0; font-weight: 700; text-shadow: 0 2px 4px rgba(0,0,0,0.3); font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
        <i class="fa fa-dashboard" style="margin-right: 15px; color: #fbbf24;"></i>
        <b>Election Dashboard</b>
        <i class="fa fa-chart-bar" style="margin-left: 15px; color: #fbbf24;"></i>
      </h1>
      <ol class="breadcrumb" style="background: rgba(255,255,255,0.1); border-radius: 25px; padding: 10px 20px; margin-top: 15px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
        <li><a href="#" style="color: #e0e7ff; text-decoration: none;"><i class="fa fa-home" style="margin-right: 5px;"></i> Home</a></li>
        <li class="active" style="color: white; margin-left: 10px;">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content" style="padding: 0 20px;">

      <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible" style="background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%); border: none; border-radius: 12px; color: white; box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3); margin: 15px 0;">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color: white; opacity: 0.8;">&times;</button>
          <h4><i class="icon fa fa-exclamation-triangle"></i> Error!</h4>
          <?= $_SESSION['error'] ?>
        </div>
        <?php unset($_SESSION['error']); ?>
      <?php endif; ?>

      <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%); border: none; border-radius: 12px; color: white; box-shadow: 0 4px 15px rgba(5, 150, 105, 0.3); margin: 15px 0;">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color: white; opacity: 0.8;">&times;</button>
          <h4><i class="icon fa fa-check-circle"></i> Success!</h4>
          <?= $_SESSION['success'] ?>
        </div>
        <?php unset($_SESSION['success']); ?>
      <?php endif; ?>

      <!-- Statistics Cards -->
      <div class="row" style="margin-bottom: 30px;">
        <!-- Positions Card -->
        <div class="col-lg-3 col-xs-6" style="margin-bottom: 20px;">
          <div class="small-box" style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 8px 25px rgba(0,0,0,0.1); border: none; transition: transform 0.3s ease;">
            <div class="inner" style="background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); color: white; padding: 25px; position: relative;">
              <div style="position: absolute; top: -10px; right: -10px; width: 50px; height: 50px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
              <?php
              $res = $conn->query("SELECT COUNT(*) AS cnt FROM positions");
              $count = $res->fetch_assoc()['cnt'] ?? 0;
              ?>
              <h3 style="font-size: 36px; font-weight: 700; margin: 0 0 10px 0; text-shadow: 0 2px 4px rgba(0,0,0,0.3);"><?= $count ?></h3>
              <p style="font-size: 16px; font-weight: 600; margin: 0; opacity: 0.9;">
                <i class="fa fa-briefcase" style="margin-right: 8px;"></i>
                <b>Positions Available</b>
              </p>
            </div>
            <div class="icon" style="position: absolute; top: 20px; right: 20px; font-size: 24px; color: rgba(255,255,255,0.3);">
              <i class="fa fa-cog"></i>
            </div>
            <a href="positions.php" class="small-box-footer" style="background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%); color: white; font-size: 16px; font-weight: 600; text-decoration: none; padding: 15px; display: block; transition: all 0.3s ease;">
              <i class="fa fa-eye" style="margin-right: 8px;"></i> View Details <i class="fa fa-arrow-right" style="float: right; margin-top: 2px;"></i>
            </a>
          </div>
        </div>

        <!-- Candidates Card -->
        <div class="col-lg-3 col-xs-6" style="margin-bottom: 20px;">
          <div class="small-box" style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 8px 25px rgba(0,0,0,0.1); border: none; transition: transform 0.3s ease;">
            <div class="inner" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%); color: white; padding: 25px; position: relative;">
              <div style="position: absolute; top: -10px; right: -10px; width: 50px; height: 50px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
              <?php
              $res = $conn->query("SELECT COUNT(*) AS cnt FROM candidates");
              $count = $res->fetch_assoc()['cnt'] ?? 0;
              ?>
              <h3 style="font-size: 36px; font-weight: 700; margin: 0 0 10px 0; text-shadow: 0 2px 4px rgba(0,0,0,0.3);"><?= $count ?></h3>
              <p style="font-size: 16px; font-weight: 600; margin: 0; opacity: 0.9;">
                <i class="fa fa-users" style="margin-right: 8px;"></i>
                <b>Total Candidates</b>
              </p>
            </div>
            <div class="icon" style="position: absolute; top: 20px; right: 20px; font-size: 24px; color: rgba(255,255,255,0.3);">
              <i class="fa fa-black-tie"></i>
            </div>
            <a href="candidates.php" class="small-box-footer" style="background: linear-gradient(135deg, #047857 0%, #059669 100%); color: white; font-size: 16px; font-weight: 600; text-decoration: none; padding: 15px; display: block; transition: all 0.3s ease;">
              <i class="fa fa-eye" style="margin-right: 8px;"></i> View Details <i class="fa fa-arrow-right" style="float: right; margin-top: 2px;"></i>
            </a>
          </div>
        </div>

        <!-- Voters Card -->
        <div class="col-lg-3 col-xs-6" style="margin-bottom: 20px;">
          <div class="small-box" style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 8px 25px rgba(0,0,0,0.1); border: none; transition: transform 0.3s ease;">
            <div class="inner" style="background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%); color: white; padding: 25px; position: relative;">
              <div style="position: absolute; top: -10px; right: -10px; width: 50px; height: 50px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
              <?php
              $res = $conn->query("SELECT COUNT(*) AS cnt FROM voters");
              $count = $res->fetch_assoc()['cnt'] ?? 0;
              ?>
              <h3 style="font-size: 36px; font-weight: 700; margin: 0 0 10px 0; text-shadow: 0 2px 4px rgba(0,0,0,0.3);"><?= $count ?></h3>
              <p style="font-size: 16px; font-weight: 600; margin: 0; opacity: 0.9;">
                <i class="fa fa-user-plus" style="margin-right: 8px;"></i>
                <b>Registered Voters</b>
              </p>
            </div>
            <div class="icon" style="position: absolute; top: 20px; right: 20px; font-size: 24px; color: rgba(255,255,255,0.3);">
              <i class="fa fa-users"></i>
            </div>
            <a href="voters.php" class="small-box-footer" style="background: linear-gradient(135deg, #6d28d9 0%, #7c3aed 100%); color: white; font-size: 16px; font-weight: 600; text-decoration: none; padding: 15px; display: block; transition: all 0.3s ease;">
              <i class="fa fa-eye" style="margin-right: 8px;"></i> View Details <i class="fa fa-arrow-right" style="float: right; margin-top: 2px;"></i>
            </a>
          </div>
        </div>

        <!-- Votes Cast Card -->
        <div class="col-lg-3 col-xs-6" style="margin-bottom: 20px;">
          <div class="small-box" style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 8px 25px rgba(0,0,0,0.1); border: none; transition: transform 0.3s ease;">
            <div class="inner" style="background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%); color: white; padding: 25px; position: relative;">
              <div style="position: absolute; top: -10px; right: -10px; width: 50px; height: 50px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
              <?php
              $res = $conn->query("SELECT COUNT(DISTINCT voters_id) AS cnt FROM votes");
              $count = $res->fetch_assoc()['cnt'] ?? 0;
              ?>
              <h3 style="font-size: 36px; font-weight: 700; margin: 0 0 10px 0; text-shadow: 0 2px 4px rgba(0,0,0,0.3);"><?= $count ?></h3>
              <p style="font-size: 16px; font-weight: 600; margin: 0; opacity: 0.9;">
                <i class="fa fa-check-square" style="margin-right: 8px;"></i>
                <b>Voters Participated</b>
              </p>
            </div>
            <div class="icon" style="position: absolute; top: 20px; right: 20px; font-size: 24px; color: rgba(255,255,255,0.3);">
              <i class="fa fa-edit"></i>
            </div>
            <a href="votes.php" class="small-box-footer" style="background: linear-gradient(135deg, #b91c1c 0%, #dc2626 100%); color: white; font-size: 16px; font-weight: 600; text-decoration: none; padding: 15px; display: block; transition: all 0.3s ease;">
              <i class="fa fa-eye" style="margin-right: 8px;"></i> View Details <i class="fa fa-arrow-right" style="float: right; margin-top: 2px;"></i>
            </a>
          </div>
        </div>
      </div>

      <!-- Votes Tally Section -->
      <div class="row" style="margin: 30px 0;">
        <div class="col-xs-12">
          <div style="background: white; border-radius: 15px; padding: 25px; box-shadow: 0 8px 25px rgba(0,0,0,0.1); border-top: 5px solid #3b82f6;">
            <h3 style="margin: 0; font-weight: 700; color: #1e40af; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; display: flex; align-items: center; justify-content: space-between;">
              <span>
                <i class="fa fa-chart-bar" style="margin-right: 12px; color: #3b82f6;"></i>
                <b>VOTES TALLY - TOP 5 CANDIDATES</b>
              </span>
              <a href="print.php" class="btn btn-curve" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%); color: white; font-size: 14px; font-weight: 600; padding: 12px 24px; border-radius: 25px; border: none; box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3); text-decoration: none; transition: all 0.3s ease;">
                <i class="fa fa-print" style="margin-right: 8px;"></i> Print Report
              </a>
            </h3>
          </div>
        </div>
      </div>

      <!-- Charts Section -->
      <?php
      $sql = "SELECT * FROM positions ORDER BY priority ASC";
      $query = $conn->query($sql);
      $inc = 2;
      while ($row = $query->fetch_assoc()) {
          $inc = ($inc == 2) ? 1 : $inc + 1;
          if ($inc == 1) echo "<div class='row' style='margin-bottom: 30px;'>";
          ?>
          <div class="col-sm-6" style="margin-bottom: 20px;">
            <div class="box" style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 8px 25px rgba(0,0,0,0.1); border: none;">
              <div class="box-header with-border" style="background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%); border-bottom: 3px solid #3b82f6; padding: 20px;">
                <h4 class="box-title" style="margin: 0; font-weight: 700; color: #1e40af; font-size: 18px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                  <i class="fa fa-trophy" style="margin-right: 10px; color: #f59e0b;"></i>
                  <b><?= htmlspecialchars($row['description']) ?></b>
                  <span style="background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%); color: white; padding: 4px 12px; border-radius: 15px; font-size: 12px; margin-left: 10px;">TOP 5</span>
                </h4>
              </div>
              <div class="box-body" style="padding: 25px; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);">
                <div class="chart" style="position: relative; height: 300px;">
                  <canvas id="<?= slugify($row['description']) ?>" style="width: 100%; height: 100%;"></canvas>
                </div>
              </div>
            </div>
          </div>
          <?php
          if ($inc == 2) echo "</div>";
      }
      if ($inc == 1) echo "<div class='col-sm-6'></div></div>";
      ?>

    </section>
  </div>

  <?php include 'includes/footer.php'; ?>

</div>
<!-- ./wrapper -->

<?php include 'includes/scripts.php'; ?>

<?php include 'includes/scripts.php'; ?>

<!-- Chart.js Scripts with Top 5 Candidates per Position -->
<?php
$sql = "SELECT * FROM positions ORDER BY priority ASC";
$query = $conn->query($sql);
while($row = $query->fetch_assoc()){
    // Get all candidates for this position
    $sql = "SELECT * FROM candidates WHERE position_id = '".$row['id']."' ORDER BY lastname ASC";
    $cquery = $conn->query($sql);
    
    $carray = array();
    $varray = array();
    $candidate_count = 0;
    
    // Get actual candidates and their votes
    while($crow = $cquery->fetch_assoc()){
        array_push($carray, $crow['lastname']);
        $sql = "SELECT * FROM votes WHERE candidate_id = '".$crow['id']."'";
        $vquery = $conn->query($sql);
        array_push($varray, $vquery->num_rows);
        $candidate_count++;
        
        // Limit to top 5 candidates
        if($candidate_count >= 5) break;
    }
    
    // If we have less than 5 candidates, fill with empty entries
    while(count($carray) < 5){
        array_push($carray, 'No Candidate');
        array_push($varray, 0);
    }
    
    // Sort arrays by vote count (descending) while keeping candidate names aligned
    $combined = array_combine($carray, $varray);
    arsort($combined);
    $carray = array_keys($combined);
    $varray = array_values($combined);
    
    $carray = json_encode($carray);
    $varray = json_encode($varray);
    ?>
    <script>
    $(function(){
        var rowid = '<?php echo $row['id']; ?>';
        var description = '<?php echo slugify($row['description']); ?>';
        var barChartCanvas = $('#'+description).get(0);
        
        if(barChartCanvas){
            var ctx = barChartCanvas.getContext('2d');
            
            // Check if Chart.js is loaded
            if(typeof Chart !== 'undefined'){
                var barChart = new Chart(ctx, {
                    type: 'horizontalBar',
                    data: {
                        labels: <?php echo $carray; ?>,
                        datasets: [{
                            label: 'Votes',
                            data: <?php echo $varray; ?>,
                            backgroundColor: [
                                'rgba(30, 64, 175, 0.8)',
                                'rgba(220, 38, 38, 0.8)',
                                'rgba(5, 150, 105, 0.8)',
                                'rgba(124, 58, 237, 0.8)',
                                'rgba(245, 158, 11, 0.8)'
                            ],
                            borderColor: [
                                'rgba(30, 64, 175, 1)',
                                'rgba(220, 38, 38, 1)',
                                'rgba(5, 150, 105, 1)',
                                'rgba(124, 58, 237, 1)',
                                'rgba(245, 158, 11, 1)'
                            ],
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                titleColor: 'white',
                                bodyColor: 'white',
                                borderColor: 'rgba(59, 130, 246, 1)',
                                borderWidth: 1,
                                cornerRadius: 8,
                                callbacks: {
                                    label: function(context) {
                                        return 'Votes: ' + context.parsed.x;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.1)'
                                },
                                ticks: {
                                    color: '#374151',
                                    font: { weight: '600' },
                                    stepSize: 1
                                }
                            },
                            y: {
                                grid: { display: false },
                                ticks: {
                                    color: '#374151',
                                    font: { weight: '600' },
                                    callback: function(value) {
                                        const label = this.getLabelForValue(value);
                                        return label.length > 15 ? label.substr(0, 15) + '...' : label;
                                    }
                                }
                            }
                        },
                        animation: {
                            duration: 1500,
                            easing: 'easeInOutQuart'
                        }
                    }
                });
            } else {
                // Fallback for older Chart.js versions
                var barChart = new Chart(ctx);
                var barChartData = {
                    labels: <?php echo $carray; ?>,
                    datasets: [{
                        label: 'Votes',
                        fillColor: 'rgba(60,141,188,0.9)',
                        strokeColor: 'rgba(60,141,188,0.8)',
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: <?php echo $varray; ?>
                    }]
                };
                
                var barChartOptions = {
                    scaleBeginAtZero: true,
                    scaleShowGridLines: true,
                    scaleGridLineColor: 'rgba(0,0,0,.05)',
                    scaleGridLineWidth: 1,
                    scaleShowHorizontalLines: true,
                    scaleShowVerticalLines: true,
                    barShowStroke: true,
                    barStrokeWidth: 2,
                    barValueSpacing: 5,
                    barDatasetSpacing: 1,
                    responsive: true,
                    maintainAspectRatio: false
                };
                
                barChartOptions.datasetFill = false;
                var myChart = barChart.HorizontalBar(barChartData, barChartOptions);
            }
        }
    });
    </script>
<?php
}
?>

<script>
// Ensure all charts are properly sized after page load
$(window).on('load', function() {
    // Trigger resize for all charts
    setTimeout(function() {
        $(window).trigger('resize');
    }, 100);
});
</script>

<style>
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
  }
  .small-box {
    transition: all 0.3s ease;
    cursor: pointer;
  }
  .small-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.2) !important;
  }
  .small-box:hover .small-box-footer {
    background: rgba(0,0,0,0.1) !important;
  }
  .alert {
    border: none;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }
  .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.3) !important;
  }
  .box {
    transition: all 0.3s ease;
  }
  .box:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.15) !important;
  }
  .chart {
    position: relative;
    height: 300px;
    width: 100%;
  }
  @media (max-width: 768px) {
    .content-header {
      margin: 10px !important;
      padding: 20px !important;
    }
    .content-header h1 {
      font-size: 24px !important;
    }
    .small-box .inner {
      padding: 20px !important;
    }
    .small-box .inner h3 {
      font-size: 28px !important;
    }
    .box-body {
      padding: 15px !important;
    }
    .chart {
      height: 250px !important;
    }
  }
  @media (max-width: 480px) {
    .row {
      margin: 0 !important;
    }
    .col-lg-3, .col-xs-6 {
      padding: 5px !important;
    }
    .content-header h1 {
      font-size: 20px !important;
    }
    .small-box .inner h3 {
      font-size: 24px !important;
    }
    .box-title {
      font-size: 16px !important;
    }
    .chart {
      height: 200px !important;
    }
  }
  @keyframes bounce {
    0%, 20%, 60%, 100% {transform: translateY(0);}
    40% {transform: translateY(-10px);}
    80% {transform: translateY(-5px);}
  }
  .fa-trophy {
    animation: bounce 2s infinite;
  }
  @keyframes fadeInUp {
    from {opacity: 0; transform: translateY(30px);}
    to {opacity: 1; transform: translateY(0);}
  }
  .box {
    animation: fadeInUp 0.6s ease-out;
  }
  .gradient-text {
    background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
  }
</style>

</body>
</html>