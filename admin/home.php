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

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
      <h1>
        <i class="fa fa-dashboard"></i>
        <b>Election Dashboard</b>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h4><i class="icon fa fa-exclamation-triangle"></i> Error!</h4>
          <?= $_SESSION['error'] ?>
        </div>
        <?php unset($_SESSION['error']); ?>
      <?php endif; ?>

      <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h4><i class="icon fa fa-check-circle"></i> Success!</h4>
          <?= $_SESSION['success'] ?>
        </div>
        <?php unset($_SESSION['success']); ?>
      <?php endif; ?>

      <!-- Statistics Cards -->
      <div class="row">
        <!-- Positions Card -->
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-blue">
            <div class="inner">
              <?php
              $res = $conn->query("SELECT COUNT(*) AS cnt FROM positions");
              $count = $res->fetch_assoc()['cnt'] ?? 0;
              ?>
              <h3><?= $count ?></h3>
              <p>Positions Available</p>
            </div>
            <div class="icon">
              <i class="fa fa-briefcase"></i>
            </div>
            <a href="positions.php" class="small-box-footer">
              View Details <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

        <!-- Candidates Card -->
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-green">
            <div class="inner">
              <?php
              $res = $conn->query("SELECT COUNT(*) AS cnt FROM candidates");
              $count = $res->fetch_assoc()['cnt'] ?? 0;
              ?>
              <h3><?= $count ?></h3>
              <p>Total Candidates</p>
            </div>
            <div class="icon">
              <i class="fa fa-users"></i>
            </div>
            <a href="candidates.php" class="small-box-footer">
              View Details <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

        <!-- Voters Card -->
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-purple">
            <div class="inner">
              <?php
              $res = $conn->query("SELECT COUNT(*) AS cnt FROM voters");
              $count = $res->fetch_assoc()['cnt'] ?? 0;
              ?>
              <h3><?= $count ?></h3>
              <p>Registered Voters</p>
            </div>
            <div class="icon">
              <i class="fa fa-user-plus"></i>
            </div>
            <a href="voters.php" class="small-box-footer">
              View Details <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

        <!-- Votes Cast Card -->
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-red">
            <div class="inner">
              <?php
              $res = $conn->query("SELECT COUNT(DISTINCT voters_id) AS cnt FROM votes");
              $count = $res->fetch_assoc()['cnt'] ?? 0;
              ?>
              <h3><?= $count ?></h3>
              <p>Voters Participated</p>
            </div>
            <div class="icon">
              <i class="fa fa-check-square"></i>
            </div>
            <a href="votes.php" class="small-box-footer">
              View Details <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
      </div>

      <!-- Votes Tally Section Header -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">
                <i class="fa fa-chart-bar"></i>
                VOTES TALLY - TOP CANDIDATES
              </h3>
              <div class="box-tools pull-right">
                <a href="print.php" class="btn btn-success btn-sm">
                  <i class="fa fa-print"></i> Print Report
                </a>
              </div>
            </div>
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
          if ($inc == 1) echo "<div class='row'>";
          ?>
          <div class="col-sm-6">
            <div class="box box-solid">
              <div class="box-header with-border">
                <h3 class="box-title">
                  <i class="fa fa-trophy text-yellow"></i>
                  <?= htmlspecialchars($row['description']) ?>
                </h3>
              </div>
              <div class="box-body">
                <div class="chart-container">
                  <canvas id="<?= slugify($row['description']) ?>"></canvas>
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

<?php include 'includes/scripts.php'; ?>

<!-- Chart.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>

<script>
// Modern color palette
const colors = [
    '#3B82F6', '#10B981', '#8B5CF6', '#EF4444', 
    '#F59E0B', '#06B6D4', '#84CC16', '#EC4899'
];

const backgroundColors = colors.map(color => color + '20'); // Add transparency
const borderColors = colors;

// Chart configuration
const chartConfig = {
    type: 'bar',
    options: {
        responsive: true,
        maintainAspectRatio: false,
        indexAxis: 'y',
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: 'rgba(17, 24, 39, 0.95)',
                titleColor: '#F9FAFB',
                bodyColor: '#D1D5DB',
                borderColor: '#3B82F6',
                borderWidth: 1,
                cornerRadius: 8,
                padding: 12,
                displayColors: true,
                callbacks: {
                    label: function(context) {
                        const value = context.parsed.x;
                        const total = context.dataset.total || 0;
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
                    color: 'rgba(156, 163, 175, 0.2)',
                    drawBorder: false
                },
                ticks: {
                    color: '#6B7280',
                    font: { size: 11 },
                    stepSize: 1,
                    callback: function(value) {
                        return Number.isInteger(value) ? value : '';
                    }
                },
                title: {
                    display: true,
                    text: 'Number of Votes',
                    color: '#374151',
                    font: { weight: 'bold', size: 12 }
                }
            },
            y: {
                grid: { display: false },
                ticks: {
                    color: '#374151',
                    font: { weight: '500', size: 11 },
                    callback: function(value) {
                        const label = this.getLabelForValue(value);
                        return label.length > 20 ? label.substr(0, 20) + '...' : label;
                    }
                }
            }
        },
        elements: {
            bar: {
                borderRadius: 4,
                borderSkipped: false
            }
        },
        animation: {
            duration: 1000,
            easing: 'easeOutQuart'
        }
    }
};

function createChart(canvasId, labels, data, total) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) return;
    
    const ctx = canvas.getContext('2d');
    
    const chartData = {
        labels: labels,
        datasets: [{
            data: data,
            backgroundColor: backgroundColors.slice(0, data.length),
            borderColor: borderColors.slice(0, data.length),
            borderWidth: 2,
            total: total
        }]
    };
    
    new Chart(ctx, {
        ...chartConfig,
        data: chartData
    });
}

function showNoDataMessage(canvasId, positionName) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) return;
    
    const ctx = canvas.getContext('2d');
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    
    ctx.font = "16px Arial";
    ctx.fillStyle = "#9CA3AF";
    ctx.textAlign = "center";
    ctx.textBaseline = "middle";
    
    ctx.fillText("No votes cast yet", canvas.width/2, canvas.height/2 - 10);
    ctx.font = "12px Arial";
    ctx.fillText("Charts will appear once voting begins", canvas.width/2, canvas.height/2 + 15);
}

$(document).ready(function() {
    setTimeout(function() {
        <?php
        $sql = "SELECT * FROM positions ORDER BY priority ASC";
        $query = $conn->query($sql);
        while($row = $query->fetch_assoc()){
            $sql_candidates = "SELECT c.*, COUNT(v.candidate_id) as vote_count 
                             FROM candidates c 
                             LEFT JOIN votes v ON c.id = v.candidate_id 
                             WHERE c.position_id = '".$row['id']."' 
                             GROUP BY c.id 
                             ORDER BY vote_count DESC, c.lastname ASC 
                             LIMIT 8";
            $cquery = $conn->query($sql_candidates);
            
            $candidate_names = array();
            $vote_counts = array();
            $total_votes = 0;
            $has_votes = false;
            
            while($crow = $cquery->fetch_assoc()){
                $full_name = trim($crow['firstname'] . ' ' . $crow['lastname']);
                $vote_count = intval($crow['vote_count']);
                
                if($vote_count > 0) {
                    array_push($candidate_names, $full_name);
                    array_push($vote_counts, $vote_count);
                    $total_votes += $vote_count;
                    $has_votes = true;
                }
            }
            
            $canvas_id = slugify($row['description']);
            $position_name = htmlspecialchars($row['description']);
            
            if($has_votes && count($candidate_names) > 0) {
                $names_json = json_encode($candidate_names);
                $votes_json = json_encode($vote_counts);
                echo "createChart('$canvas_id', $names_json, $votes_json, $total_votes);\n";
            } else {
                echo "showNoDataMessage('$canvas_id', '$position_name');\n";
            }
        }
        ?>
    }, 300);
});
</script>

<style>
.chart-container {
    position: relative;
    height: 300px;
    width: 100%;
}

.box-solid > .box-header {
    background: #f4f4f4;
    border-bottom: 1px solid #ddd;
}

.small-box {
    border-radius: 2px;
    position: relative;
    display: block;
    margin-bottom: 20px;
    box-shadow: 0 1px 1px rgba(0,0,0,0.1);
}

@media (max-width: 768px) {
    .chart-container {
        height: 250px;
    }
    
    .box-title {
        font-size: 14px;
    }
}
</style>

</body>
</html>