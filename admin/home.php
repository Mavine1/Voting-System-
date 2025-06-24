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
      $hasData = false;
      
      while ($row = $query->fetch_assoc()) {
          $inc = ($inc == 2) ? 1 : $inc + 1;
          if ($inc == 1) echo "<div class='row' style='margin-bottom: 30px;'>";
          
          // Check if this position has any votes or candidates
          $positionId = (int)$row['id'];
          $checkDataQuery = "SELECT COUNT(*) as total FROM candidates WHERE position_id = $positionId";
          $dataCheck = $conn->query($checkDataQuery);
          $candidateCount = $dataCheck->fetch_assoc()['total'] ?? 0;
          
          if ($candidateCount > 0) {
              $hasData = true;
          }
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
                <?php if ($candidateCount == 0): ?>
                  <div class="no-data-message" style="text-align: center; padding: 60px 20px; color: #6b7280;">
                    <i class="fa fa-exclamation-circle" style="font-size: 48px; color: #d1d5db; margin-bottom: 15px;"></i>
                    <h4 style="color: #374151; font-weight: 600; margin-bottom: 10px;">No Candidates Available</h4>
                    <p style="color: #6b7280; margin: 0;">Please add candidates for this position to view the voting results.</p>
                  </div>
                <?php else: ?>
                  <div class="chart" style="position: relative;">
                    <canvas id="<?= slugify($row['description']) ?>" style="height: 300px; width: 100%;"></canvas>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <?php
          if ($inc == 2) echo "</div>";
      }
      if ($inc == 1) echo "<div class='col-sm-6'></div></div>";
      
      // Show overall message if no data exists
      if (!$hasData): ?>
        <div class="row" style="margin: 30px 0;">
          <div class="col-xs-12">
            <div style="background: white; border-radius: 15px; padding: 40px; box-shadow: 0 8px 25px rgba(0,0,0,0.1); text-align: center;">
              <i class="fa fa-chart-line" style="font-size: 64px; color: #d1d5db; margin-bottom: 20px;"></i>
              <h3 style="color: #374151; font-weight: 700; margin-bottom: 15px;">No Election Data Available</h3>
              <p style="color: #6b7280; font-size: 16px; margin-bottom: 25px;">Start by adding positions and candidates to see the voting results dashboard.</p>
              <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                <a href="positions.php" class="btn" style="background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%); color: white; padding: 12px 24px; border-radius: 25px; text-decoration: none; font-weight: 600;">
                  <i class="fa fa-plus" style="margin-right: 8px;"></i> Add Positions
                </a>
                <a href="candidates.php" class="btn" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%); color: white; padding: 12px 24px; border-radius: 25px; text-decoration: none; font-weight: 600;">
                  <i class="fa fa-user-plus" style="margin-right: 8px;"></i> Add Candidates
                </a>
              </div>
            </div>
          </div>
        </div>
      <?php endif; ?>

    </section>
  </div>

  <?php include 'includes/footer.php'; ?>

</div>
<!-- ./wrapper -->

<?php include 'includes/scripts.php'; ?>

<!-- Chart.js Scripts with Enhanced Error Handling -->
<?php
$query = $conn->query("SELECT * FROM positions ORDER BY priority ASC");
while ($row = $query->fetch_assoc()) {
    $positionId = (int)$row['id'];
    
    // Enhanced SQL query with better error handling
    $sqlCandidates = "
        SELECT 
            c.id,
            c.firstname, 
            c.lastname, 
            COALESCE(COUNT(v.id), 0) AS vote_count
        FROM candidates c
        LEFT JOIN votes v ON v.candidate_id = c.id
        WHERE c.position_id = $positionId
        GROUP BY c.id, c.firstname, c.lastname
        ORDER BY vote_count DESC, c.lastname ASC
        LIMIT 5
    ";
    
    $cquery = $conn->query($sqlCandidates);
    
    if (!$cquery) {
        // Handle SQL error
        error_log("SQL Error in dashboard: " . $conn->error);
        continue;
    }

    $candidateNames = [];
    $voteCounts = [];
    $hasRealData = false;

    while ($crow = $cquery->fetch_assoc()) {
        $candidateNames[] = htmlspecialchars($crow['firstname'] . ' ' . $crow['lastname']);
        $voteCount = (int)$crow['vote_count'];
        $voteCounts[] = $voteCount;
        if ($voteCount > 0) $hasRealData = true;
    }

    // Skip creating chart if no candidates exist
    if (empty($candidateNames)) {
        continue;
    }

    // Fill remaining slots with sample data for better visualization when no votes exist
    while (count($candidateNames) < 5 && count($candidateNames) < 5) {
        break; // Don't add fake candidates, just work with what we have
    }

    $candidateNamesJson = json_encode($candidateNames);
    $voteCountsJson = json_encode($voteCounts);
    $canvasId = slugify($row['description']);
    
    // Only generate chart if we have candidates
    if (!empty($candidateNames)): ?>
    <script>
        $(function() {
            const ctx = document.getElementById('<?= $canvasId ?>');
            if (!ctx) return; // Skip if canvas doesn't exist
            
            try {
                new Chart(ctx.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: <?= $candidateNamesJson ?>,
                        datasets: [{
                            label: 'Votes',
                            data: <?= $voteCountsJson ?>,
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
                        indexAxis: 'y',
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
                                displayColors: true,
                                callbacks: {
                                    label: function(context) {
                                        const votes = context.parsed.x;
                                        const percentage = <?= $hasRealData ? 'true' : 'false' ?> && context.dataset.data.reduce((a, b) => a + b, 0) > 0 
                                            ? ((votes / context.dataset.data.reduce((a, b) => a + b, 0)) * 100).toFixed(1) + '%'
                                            : '';
                                        return context.dataset.label + ': ' + votes + ' votes' + (percentage ? ' (' + percentage + ')' : '');
                                    },
                                    title: function(context) {
                                        return context[0].label;
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
                                    font: { weight: '600' },
                                    stepSize: 1
                                },
                                title: {
                                    display: true,
                                    text: 'Number of Votes',
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
                                        return label.length > 20 ? label.substr(0, 20) + '...' : label;
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
            } catch (error) {
                console.error('Error creating chart for <?= $canvasId ?>:', error);
                // Show fallback message
                document.getElementById('<?= $canvasId ?>').parentNode.innerHTML = 
                    '<div style="text-align: center; padding: 40px; color: #6b7280;">' +
                    '<i class="fa fa-exclamation-triangle" style="font-size: 32px; margin-bottom: 15px;"></i>' +
                    '<p>Unable to load chart data</p>' +
                    '</div>';
            }
        });
    </script>
    <?php endif;
}
?>

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
  .no-data-message {
    background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
    border-radius: 12px;
    border: 2px dashed #d1d5db;
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
  
  /* Chart container improvements */
  .chart {
    min-height: 300px;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  
  /* Empty state styling */
  .empty-state {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border: 2px dashed #cbd5e1;
    border-radius: 12px;
    padding: 40px 20px;
    text-align: center;
    margin: 20px 0;
  }
  
  .empty-state i {
    font-size: 48px;
    color: #cbd5e1;
    margin-bottom: 15px;
    display: block;
  }
  
  .empty-state h4 {
    color: #475569;
    font-weight: 600;
    margin-bottom: 10px;
    font-size: 18px;
  }
  
  .empty-state p {
    color: #64748b;
    margin: 0;
    font-size: 14px;
  }
  
  /* Loading animation for charts */
  .chart-loading {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 300px;
    flex-direction: column;
  }
  
  .chart-loading .spinner {
    width: 40px;
    height: 40px;
    border: 4px solid #e2e8f0;
    border-top: 4px solid #3b82f6;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin-bottom: 15px;
  }
  
  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
  
  /* Improved button styles */
  .action-buttons {
    display: flex;
    gap: 15px;
    justify-content: center;
    flex-wrap: wrap;
    margin-top: 20px;
  }
  
  .action-buttons .btn {
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  }
  
  .action-buttons .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
  }
  
  /* Card hover effects */
  .stats-card {
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
  }
  
  .stats-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
  }
  
  .stats-card:hover::before {
    left: 100%;
  }
  
  /* Responsive improvements */
  @media (max-width: 576px) {
    .action-buttons {
      flex-direction: column;
      align-items: center;
    }
    
    .action-buttons .btn {
      width: 200px;
      max-width: 100%;
    }
    
    .empty-state {
      padding: 30px 15px;
    }
    
    .empty-state i {
      font-size: 36px;
    }
    
    .empty-state h4 {
      font-size: 16px;
    }
  }