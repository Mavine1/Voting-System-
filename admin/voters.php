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
                <b>VOTES TALLY - TOP CANDIDATES</b>
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
                  <span style="background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%); color: white; padding: 4px 12px; border-radius: 15px; font-size: 12px; margin-left: 10px;">TOP CANDIDATES</span>
                </h4>
              </div>
              <div class="box-body" style="padding: 25px; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);">
                <div class="chart-container" style="position: relative; height: 350px; width: 100%;">
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

<!-- Chart.js Scripts with Enhanced Top Candidates Display -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>

<script>
// Chart color palette
const chartColors = [
    'rgba(30, 64, 175, 0.8)',    // Blue
    'rgba(220, 38, 38, 0.8)',    // Red  
    'rgba(5, 150, 105, 0.8)',    // Green
    'rgba(124, 58, 237, 0.8)',   // Purple
    'rgba(245, 158, 11, 0.8)',   // Yellow
    'rgba(8, 145, 178, 0.8)',    // Cyan
    'rgba(124, 45, 18, 0.8)',    // Brown
    'rgba(134, 25, 143, 0.8)'    // Pink
];

const borderColors = [
    'rgba(30, 64, 175, 1)',
    'rgba(220, 38, 38, 1)',
    'rgba(5, 150, 105, 1)',
    'rgba(124, 58, 237, 1)',
    'rgba(245, 158, 11, 1)',
    'rgba(8, 145, 178, 1)',
    'rgba(124, 45, 18, 1)',
    'rgba(134, 25, 143, 1)'
];

// Chart configuration object
const chartDefaults = {
    responsive: true,
    maintainAspectRatio: false,
    indexAxis: 'y', // Horizontal bars
    plugins: {
        legend: {
            display: false
        },
        tooltip: {
            backgroundColor: 'rgba(0, 0, 0, 0.8)',
            titleColor: 'white',
            bodyColor: 'white',
            borderColor: 'rgba(59, 130, 246, 1)',
            borderWidth: 2,
            cornerRadius: 8,
            displayColors: false,
            callbacks: {
                title: function(context) {
                    return context[0].label;
                },
                label: function(context) {
                    const value = context.parsed.x;
                    const total = context.chart.data.total;
                    const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                    return `${value} votes (${percentage}%)`;
                }
            }
        }
    },
    scales: {
        x: {
            beginAtZero: true,
            grid: {
                color: 'rgba(0, 0, 0, 0.1)',
                drawBorder: false
            },
            ticks: {
                color: '#374151',
                font: { 
                    weight: '600',
                    size: 12
                },
                stepSize: 1,
                callback: function(value) {
                    return Number.isInteger(value) ? value : '';
                }
            },
            title: {
                display: true,
                text: 'Number of Votes',
                color: '#1e40af',
                font: { 
                    weight: 'bold', 
                    size: 14 
                }
            }
        },
        y: {
            grid: { 
                display: false 
            },
            ticks: {
                color: '#374151',
                font: { 
                    weight: '600',
                    size: 11
                },
                callback: function(value) {
                    const label = this.getLabelForValue(value);
                    // Truncate long names
                    return label.length > 18 ? label.substr(0, 18) + '...' : label;
                }
            },
            title: {
                display: true,
                text: 'Candidates',
                color: '#1e40af',
                font: { 
                    weight: 'bold', 
                    size: 14 
                }
            }
        }
    },
    animation: {
        duration: 1500,
        easing: 'easeInOutQuart'
    },
    elements: {
        bar: {
            borderRadius: 6,
            borderSkipped: false
        }
    }
};

// Function to create chart
function createChart(canvasId, labels, data, positionName) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) return;
    
    const ctx = canvas.getContext('2d');
    
    // Calculate total votes
    const totalVotes = data.reduce((sum, current) => sum + current, 0);
    
    // Generate colors for bars
    const backgroundColors = [];
    const borderColors = [];
    
    for(let i = 0; i < data.length; i++) {
        backgroundColors.push(chartColors[i % chartColors.length]);
        borderColors.push(borderColors[i % borderColors.length]);
    }
    
    const chartData = {
        labels: labels,
        datasets: [{
            label: 'Votes',
            data: data,
            backgroundColor: backgroundColors,
            borderColor: borderColors,
            borderWidth: 2,
            borderRadius: 6,
            borderSkipped: false
        }],
        total: totalVotes // Store total for percentage calculation
    };
    
    // Add percentage to labels
    const percentageLabels = labels.map((label, index) => {
        const percentage = totalVotes > 0 ? ((data[index] / totalVotes) * 100).toFixed(1) : 0;
        return `${label} (${percentage}%)`;
    });
    
    // Clone the default options to avoid modifying the original
    const options = JSON.parse(JSON.stringify(chartDefaults));
    
    // Update labels to include percentages
    options.scales.y.ticks.callback = function(value) {
        const label = percentageLabels[value];
        return label.length > 25 ? label.substr(0, 25) + '...' : label;
    };
    
    new Chart(ctx, {
        type: 'bar',
        data: chartData,
        options: options
    });
}

// Function to show no data message
function showNoDataMessage(canvasId, positionName) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) return;
    
    const ctx = canvas.getContext('2d');
    
    // Clear canvas
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    
    // Set styles for no data message
    ctx.font = "bold 18px 'Segoe UI', Arial, sans-serif";
    ctx.fillStyle = "#6b7280";
    ctx.textAlign = "center";
    ctx.textBaseline = "middle";
    
    // Draw main message
    ctx.fillText("No votes cast yet", 
        canvas.width/2, 
        canvas.height/2 - 15);
    
    // Draw subtitle
    ctx.font = "14px 'Segoe UI', Arial, sans-serif";
    ctx.fillStyle = "#9ca3af";
    ctx.fillText(`for ${positionName}`, 
        canvas.width/2, 
        canvas.height/2 + 10);
    
    // Draw icon
    ctx.font = "12px 'Segoe UI', Arial, sans-serif";
    ctx.fillText("Charts will appear once voting begins", 
        canvas.width/2, 
        canvas.height/2 + 35);
}

// Wait for DOM to be ready
$(document).ready(function() {
    // Small delay to ensure canvas elements are rendered
    setTimeout(function() {
        <?php
        // Generate JavaScript for each position
        $sql = "SELECT * FROM positions ORDER BY priority ASC";
        $query = $conn->query($sql);
        while($row = $query->fetch_assoc()){
            // Get candidates with their vote counts
            $sql_candidates = "SELECT c.*, COUNT(v.candidate_id) as vote_count 
                             FROM candidates c 
                             LEFT JOIN votes v ON c.id = v.candidate_id 
                             WHERE c.position_id = '".$row['id']."' 
                             GROUP BY c.id 
                             ORDER BY vote_count DESC, c.lastname ASC 
                             LIMIT 5";
            $cquery = $conn->query($sql_candidates);
            
            $candidate_names = array();
            $vote_counts = array();
            $has_votes = false;
            
            // Collect candidate data
            while($crow = $cquery->fetch_assoc()){
                $full_name = trim($crow['firstname'] . ' ' . $crow['lastname']);
                $vote_count = intval($crow['vote_count']);
                
                // Only include candidates with votes
                if($vote_count > 0) {
                    array_push($candidate_names, $full_name);
                    array_push($vote_counts, $vote_count);
                    $has_votes = true;
                }
            }
            
            $canvas_id = slugify($row['description']);
            $position_name = htmlspecialchars($row['description']);
            
            if($has_votes && count($candidate_names) > 0) {
                // Output JavaScript to create chart
                $names_json = json_encode($candidate_names);
                $votes_json = json_encode($vote_counts);
                
                echo "createChart('$canvas_id', $names_json, $votes_json, '$position_name');\n";
            } else {
                // Output JavaScript to show no data message
                echo "showNoDataMessage('$canvas_id', '$position_name');\n";
            }
        }
        ?>
    }, 500);
});

// Handle window resize
$(window).on('resize', function() {
    Chart.helpers.each(Chart.instances, function(instance) {
        instance.resize();
    });
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
  
  .chart-container {
    position: relative;
    height: 350px;
    width: 100%;
  }
  
  .chart-container canvas {
    border-radius: 8px;
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
    .chart-container {
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
    .chart-container {
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
  
  /* Loading animation for charts */
  @keyframes chartLoad {
    0% { opacity: 0; transform: scale(0.8); }
    100% { opacity: 1; transform: scale(1); }
  }
  
  .chart-container canvas {
    animation: chartLoad 0.8s ease-out;
  }
</style>

</body>
</html>