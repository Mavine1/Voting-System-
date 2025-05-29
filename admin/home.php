<?php include 'includes/session.php'; ?>
<?php include 'includes/slugify.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

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
      <?php
        if(isset($_SESSION['error'])){
          echo "
            <div class='alert alert-danger alert-dismissible' style='background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%); border: none; border-radius: 12px; color: white; box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3); margin: 15px 0;'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true' style='color: white; opacity: 0.8;'>&times;</button>
              <h4><i class='icon fa fa-exclamation-triangle'></i> Error!</h4>
              ".$_SESSION['error']."
            </div>
          ";
          unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
          echo "
            <div class='alert alert-success alert-dismissible' style='background: linear-gradient(135deg, #059669 0%, #10b981 100%); border: none; border-radius: 12px; color: white; box-shadow: 0 4px 15px rgba(5, 150, 105, 0.3); margin: 15px 0;'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true' style='color: white; opacity: 0.8;'>&times;</button>
              <h4><i class='icon fa fa-check-circle'></i> Success!</h4>
              ".$_SESSION['success']."
            </div>
          ";
          unset($_SESSION['success']);
        }
      ?>

      <!-- Statistics Cards -->
      <div class="row" style="margin-bottom: 30px;">
        <!-- Positions Card -->
        <div class="col-lg-3 col-xs-6" style="margin-bottom: 20px;">
          <div class="small-box" style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 8px 25px rgba(0,0,0,0.1); border: none; transition: transform 0.3s ease;">
            <div class="inner" style="background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); color: white; padding: 25px; position: relative;">
              <div style="position: absolute; top: -10px; right: -10px; width: 50px; height: 50px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
              <?php
                $sql = "SELECT * FROM positions";
                $query = $conn->query($sql);
                echo "<h3 style='font-size: 36px; font-weight: 700; margin: 0 0 10px 0; text-shadow: 0 2px 4px rgba(0,0,0,0.3);'>".$query->num_rows."</h3>";
              ?>
              <p style="font-size: 16px; font-weight: 600; margin: 0; opacity: 0.9;">
                <i class="fa fa-briefcase" style="margin-right: 8px;"></i>
                <b>Positions Available</b>
              </p>
            </div>
            <div class="icon" style="position: absolute; top: 20px; right: 20px; font-size: 24px; color: rgba(255,255,255,0.3);">
              <i class="fa fa-cog"></i>
            </div>
            <a href="positions.php" class="small-box-footer" style="background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%); color: white; font-size: 16px; font-weight: 600; text-decoration: none; padding: 15px; display: block; transition: all 0.3s ease;">
              <i class="fa fa-eye" style="margin-right: 8px;"></i>View Details <i class="fa fa-arrow-right" style="float: right; margin-top: 2px;"></i>
            </a>
          </div>
        </div>

        <!-- Candidates Card -->
        <div class="col-lg-3 col-xs-6" style="margin-bottom: 20px;">
          <div class="small-box" style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 8px 25px rgba(0,0,0,0.1); border: none; transition: transform 0.3s ease;">
            <div class="inner" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%); color: white; padding: 25px; position: relative;">
              <div style="position: absolute; top: -10px; right: -10px; width: 50px; height: 50px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
              <?php
                $sql = "SELECT * FROM candidates";
                $query = $conn->query($sql);
                echo "<h3 style='font-size: 36px; font-weight: 700; margin: 0 0 10px 0; text-shadow: 0 2px 4px rgba(0,0,0,0.3);'>".$query->num_rows."</h3>";
              ?>
              <p style="font-size: 16px; font-weight: 600; margin: 0; opacity: 0.9;">
                <i class="fa fa-users" style="margin-right: 8px;"></i>
                <b>Total Candidates</b>
              </p>
            </div>
            <div class="icon" style="position: absolute; top: 20px; right: 20px; font-size: 24px; color: rgba(255,255,255,0.3);">
              <i class="fa fa-black-tie"></i>
            </div>
            <a href="candidates.php" class="small-box-footer" style="background: linear-gradient(135deg, #047857 0%, #059669 100%); color: white; font-size: 16px; font-weight: 600; text-decoration: none; padding: 15px; display: block; transition: all 0.3s ease;">
              <i class="fa fa-eye" style="margin-right: 8px;"></i>View Details <i class="fa fa-arrow-right" style="float: right; margin-top: 2px;"></i>
            </a>
          </div>
        </div>

        <!-- Voters Card -->
        <div class="col-lg-3 col-xs-6" style="margin-bottom: 20px;">
          <div class="small-box" style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 8px 25px rgba(0,0,0,0.1); border: none; transition: transform 0.3s ease;">
            <div class="inner" style="background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%); color: white; padding: 25px; position: relative;">
              <div style="position: absolute; top: -10px; right: -10px; width: 50px; height: 50px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
              <?php
                $sql = "SELECT * FROM voters";
                $query = $conn->query($sql);
                echo "<h3 style='font-size: 36px; font-weight: 700; margin: 0 0 10px 0; text-shadow: 0 2px 4px rgba(0,0,0,0.3);'>".$query->num_rows."</h3>";
              ?>
              <p style="font-size: 16px; font-weight: 600; margin: 0; opacity: 0.9;">
                <i class="fa fa-user-plus" style="margin-right: 8px;"></i>
                <b>Registered Voters</b>
              </p>
            </div>
            <div class="icon" style="position: absolute; top: 20px; right: 20px; font-size: 24px; color: rgba(255,255,255,0.3);">
              <i class="fa fa-users"></i>
            </div>
            <a href="voters.php" class="small-box-footer" style="background: linear-gradient(135deg, #6d28d9 0%, #7c3aed 100%); color: white; font-size: 16px; font-weight: 600; text-decoration: none; padding: 15px; display: block; transition: all 0.3s ease;">
              <i class="fa fa-eye" style="margin-right: 8px;"></i>View Details <i class="fa fa-arrow-right" style="float: right; margin-top: 2px;"></i>
            </a>
          </div>
        </div>

        <!-- Votes Cast Card -->
        <div class="col-lg-3 col-xs-6" style="margin-bottom: 20px;">
          <div class="small-box" style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 8px 25px rgba(0,0,0,0.1); border: none; transition: transform 0.3s ease;">
            <div class="inner" style="background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%); color: white; padding: 25px; position: relative;">
              <div style="position: absolute; top: -10px; right: -10px; width: 50px; height: 50px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
              <?php
                // Count unique voters who voted (group by voters_id)
                $sql = "SELECT COUNT(DISTINCT voters_id) AS voters_participated FROM votes";
                $query = $conn->query($sql);
                $row = $query->fetch_assoc();
                echo "<h3 style='font-size: 36px; font-weight: 700; margin: 0 0 10px 0; text-shadow: 0 2px 4px rgba(0,0,0,0.3);'>".$row['voters_participated']."</h3>";
              ?>
              <p style="font-size: 16px; font-weight: 600; margin: 0; opacity: 0.9;">
                <i class="fa fa-check-square" style="margin-right: 8px;"></i>
                <b>Voters Participated</b>
              </p>
            </div>
            <div class="icon" style="position: absolute; top: 20px; right: 20px; font-size: 24px; color: rgba(255,255,255,0.3);">
              <i class="fa fa-edit"></i>
            </div>
            <a href="votes.php" class="small-box-footer" style="background: linear-gradient(135deg, #b91c1c 0%, #dc2626 100%); color: white; font-size: 16px; font-weight: 600; text-decoration: none; padding: 15px; display: block; transition: all 0.3s ease;">
              <i class="fa fa-eye" style="margin-right: 8px;"></i>View Details <i class="fa fa-arrow-right" style="float: right; margin-top: 2px;"></i>
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
                <i class="fa fa-print" style="margin-right: 8px;"></i>Print Report
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
        while($row = $query->fetch_assoc()){
          $inc = ($inc == 2) ? 1 : $inc+1; 
          if($inc == 1) echo "<div class='row' style='margin-bottom: 30px;'>";
          echo "
            <div class='col-sm-6' style='margin-bottom: 20px;'> 
              <div class='box' style='background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 8px 25px rgba(0,0,0,0.1); border: none;'>
                <div class='box-header with-border' style='background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%); border-bottom: 3px solid #3b82f6; padding: 20px;'>
                  <h4 class='box-title' style='margin: 0; font-weight: 700; color: #1e40af; font-size: 18px; font-family: \"Segoe UI\", Tahoma, Geneva, Verdana, sans-serif;'>
                    <i class='fa fa-trophy' style='margin-right: 10px; color: #f59e0b;'></i>
                    <b>".htmlspecialchars($row['description'])."</b>
                    <span style='background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%); color: white; padding: 4px 12px; border-radius: 15px; font-size: 12px; margin-left: 10px;'>TOP 5</span>
                  </h4>
                </div>
                <div class='box-body' style='padding: 25px; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);'>
                  <div class='chart' style='position: relative;'>
                    <canvas id='".slugify($row['description'])."' style='height: 300px; width: 100%;'></canvas>
                  </div>
                </div>
              </div>
            </div>
          ";
          if($inc == 2) echo "</div>";
        }
        if($inc == 1) echo "<div class='col-sm-6'></div></div>";
      ?>

    </section>
  </div>
  <?php include 'includes/footer.php'; ?>

</div>
<!-- ./wrapper -->

<?php include 'includes/scripts.php'; ?>

<!-- Chart.js Scripts with Top 5 Candidates per Position -->
<?php
  $sql = "SELECT * FROM positions ORDER BY priority ASC";
  $query = $conn->query($sql);

  while($row = $query->fetch_assoc()){
    $positionId = $row['id'];

    // Fetch top 5 candidates by vote count for this position
    $sqlCandidates = "
      SELECT c.firstname, c.lastname, COUNT(v.id) AS vote_count
      FROM candidates c
      LEFT JOIN votes v ON v.candidate_id = c.id AND v.position_id = $positionId
      WHERE c.position_id = $positionId
      GROUP BY c.id
      ORDER BY vote_count DESC
      LIMIT 5
    ";
    $cquery = $conn->query($sqlCandidates);

    $candidateNames = [];
    $voteCounts = [];

    while($crow = $cquery->fetch_assoc()){
      $candidateNames[] = $crow['firstname'] . ' ' . $crow['lastname'];
      $voteCounts[] = (int)$crow['vote_count'];
    }

    // Fill to 5 entries if less than 5 candidates
    while(count($candidateNames) < 5){
      $candidateNames[] = 'No Candidate';
      $voteCounts[] = 0;
    }

    // JSON encode for JS
    $candidateNamesJson = json_encode($candidateNames);
    $voteCountsJson = json_encode($voteCounts);
    $canvasId = slugify($row['description']);
?>

<script>
  $(function(){
    const ctx = document.getElementById('<?php echo $canvasId; ?>').getContext('2d');

    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: <?php echo $candidateNamesJson; ?>,
        datasets: [{
          label: 'Votes',
          data: <?php echo $voteCountsJson; ?>,
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
          borderWidth: 2,
          borderRadius: 8,
          borderSkipped: false
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        indexAxis: 'y', // Horizontal bars
        plugins: {
          legend: { display: false },
          tooltip: {
            backgroundColor: 'rgba(0, 0, 0, 0.8)',
            titleColor: 'white',
            bodyColor: 'white',
            borderColor: 'rgba(59, 130, 246, 1)',
            borderWidth: 1,
            cornerRadius: 8,
            displayColors: true,
            callbacks: {
              label: function(context) {
                return context.dataset.label + ': ' + context.parsed.x + ' votes';
              }
            }
          }
        },
        scales: {
          x: {
            beginAtZero: true,
            grid: {
              color: 'rgba(0, 0, 0, 0.1)',
              borderColor: 'rgba(0, 0, 0, 0.2)'
            },
            ticks: {
              color: '#374151',
              font: { weight: '600' }
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
        animation: { duration: 1500, easing: 'easeInOutQuart' }
      }
    });
  });
</script>

<?php } ?>

<style>
/* Your existing styles... */

body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
}

/* Card Hover Effects */
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

/* Alert Styling */
.alert {
  border: none;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Button Hover Effects */
.btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(0,0,0,0.3) !important;
}

/* Chart Container Styling */
.box {
  transition: all 0.3s ease;
}
.box:hover {
  transform: translateY(-2px);
  box-shadow: 0 12px 30px rgba(0,0,0,0.15) !important;
}

/* Responsive Design */
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
  canvas {
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
}

/* Animation for icons */
@keyframes bounce {
  0%, 20%, 60%, 100% {
    transform: translateY(0);
  }
  40% {
    transform: translateY(-10px);
  }
  80% {
    transform: translateY(-5px);
  }
}

.fa-trophy {
  animation: bounce 2s infinite;
}

/* Loading animation for charts */
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.box {
  animation: fadeInUp 0.6s ease-out;
}

/* Gradient text effect */
.gradient-text {
  background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}
</style>

</body>
</html>
