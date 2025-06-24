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
  <div class="content-wrapper" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); min-height: 100vh;">
    <!-- Content Header -->
    <section class="content-header" style="background: linear-gradient(90deg, #1e3a8a 0%, #3b82f6 100%); color: white; padding: 25px; border-radius: 15px; margin: 20px; box-shadow: 0 8px 25px rgba(30, 58, 138, 0.3);">
      <h1 style="margin: 0; font-weight: 700; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
        <i class="fa fa-dashboard" style="margin-right: 15px; color: #fbbf24;"></i>
        <b>Election Dashboard</b>
        <i class="fa fa-chart-bar" style="margin-left: 15px; color: #fbbf24;"></i>
      </h1>
      <ol class="breadcrumb" style="background: rgba(255,255,255,0.1); border-radius: 25px; padding: 10px 20px; margin-top: 15px;">
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
        <?php
        $stats = [
          ['query' => "SELECT COUNT(*) AS cnt FROM positions", 'title' => 'Positions Available', 'icon' => 'fa-briefcase', 'color' => '#1e40af', 'link' => 'positions.php'],
          ['query' => "SELECT COUNT(*) AS cnt FROM candidates", 'title' => 'Total Candidates', 'icon' => 'fa-users', 'color' => '#059669', 'link' => 'candidates.php'],
          ['query' => "SELECT COUNT(*) AS cnt FROM voters", 'title' => 'Registered Voters', 'icon' => 'fa-user-plus', 'color' => '#7c3aed', 'link' => 'voters.php'],
          ['query' => "SELECT COUNT(DISTINCT voters_id) AS cnt FROM votes", 'title' => 'Voters Participated', 'icon' => 'fa-check-square', 'color' => '#dc2626', 'link' => 'votes.php']
        ];
        
        $colors = ['#1e40af', '#059669', '#7c3aed', '#dc2626'];
        $gradients = [
          'linear-gradient(135deg, #1e40af 0%, #3b82f6 100%)',
          'linear-gradient(135deg, #059669 0%, #10b981 100%)',
          'linear-gradient(135deg, #7c3aed 0%, #a855f7 100%)',
          'linear-gradient(135deg, #dc2626 0%, #ef4444 100%)'
        ];
        
        foreach($stats as $index => $stat):
          $res = $conn->query($stat['query']);
          $count = $res->fetch_assoc()['cnt'] ?? 0;
        ?>
        <div class="col-lg-3 col-xs-6" style="margin-bottom: 20px;">
          <div class="small-box" style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 8px 25px rgba(0,0,0,0.1); transition: transform 0.3s ease;">
            <div class="inner" style="background: <?= $gradients[$index] ?>; color: white; padding: 25px; position: relative;">
              <h3 style="font-size: 36px; font-weight: 700; margin: 0 0 10px 0; text-shadow: 0 2px 4px rgba(0,0,0,0.3);"><?= $count ?></h3>
              <p style="font-size: 16px; font-weight: 600; margin: 0; opacity: 0.9;">
                <i class="fa <?= $stat['icon'] ?>" style="margin-right: 8px;"></i>
                <b><?= $stat['title'] ?></b>
              </p>
            </div>
            <a href="<?= $stat['link'] ?>" class="small-box-footer" style="background: <?= $colors[$index] ?>; color: white; font-size: 16px; font-weight: 600; text-decoration: none; padding: 15px; display: block; transition: all 0.3s ease;">
              <i class="fa fa-eye" style="margin-right: 8px;"></i> View Details <i class="fa fa-arrow-right" style="float: right; margin-top: 2px;"></i>
            </a>
          </div>
        </div>
        <?php endforeach; ?>
      </div>

      <!-- Votes Tally Header -->
      <div class="row" style="margin: 30px 0;">
        <div class="col-xs-12">
          <div style="background: white; border-radius: 15px; padding: 25px; box-shadow: 0 8px 25px rgba(0,0,0,0.1); border-top: 5px solid #3b82f6;">
            <h3 style="margin: 0; font-weight: 700; color: #1e40af; display: flex; align-items: center; justify-content: space-between;">
              <span>
                <i class="fa fa-chart-bar" style="margin-right: 12px; color: #3b82f6;"></i>
                <b>TOP 5 CANDIDATES BY POSITION</b>
              </span>
              <a href="print.php" class="btn" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%); color: white; font-size: 14px; font-weight: 600; padding: 12px 24px; border-radius: 25px; border: none; box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3); text-decoration: none; transition: all 0.3s ease;">
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
            <div class="box" style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 8px 25px rgba(0,0,0,0.1); transition: transform 0.3s ease;">
              <div class="box-header" style="background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%); border-bottom: 3px solid #3b82f6; padding: 20px;">
                <h4 class="box-title" style="margin: 0; font-weight: 700; color: #1e40af; font-size: 18px;">
                  <i class="fa fa-trophy" style="margin-right: 10px; color: #f59e0b;"></i>
                  <b><?= htmlspecialchars($row['description']) ?></b>
                  <span style="background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%); color: white; padding: 4px 12px; border-radius: 15px; font-size: 12px; margin-left: 10px;">TOP 5</span>
                </h4>
              </div>
              <div class="box-body" style="padding: 25px; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);">
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
const chartColors = [
    '#3b82f6',
    '#10b981',
    '#f59e0b',
    '#ef4444',
    '#8b5cf6'
];

const chartConfig = {
    indexAxis: 'y',
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            display: false
        },
        tooltip: {
            backgroundColor: 'rgba(15, 23, 42, 0.95)',
            titleColor: '#f1f5f9',
            bodyColor: '#e2e8f0',
            borderColor: '#3b82f6',
            borderWidth: 2,
            cornerRadius: 8,
            padding: 12,
            callbacks: {
                label: (context) => {
                    const value = context.parsed.x;
                    const total = context.chart.data.datasets[0].total || 0;
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
                color: 'rgba(148, 163, 184, 0.2)',
                drawBorder: false
            },
            ticks: {
                color: '#64748b',
                font: { weight: '600', size: 11 },
                stepSize: 1,
                callback: (value) => Number.isInteger(value) ? value : ''
            },
            title: {
                display: true,
                text: 'Number of Votes',
                color: '#1e40af',
                font: { weight: 'bold', size: 12 }
            }
        },
        y: {
            grid: { display: false },
            ticks: {
                color: '#475569',
                font: { weight: '600', size: 11 },
                callback: function(value) {
                    const label = this.getLabelForValue(value);
                    return label.length > 20 ? label.substr(0, 20) + '...' : label;
                }
            }
        }
    },
    animation: {
        duration: 1000,
        easing: 'easeOutQuart'
    },
    elements: {
        bar: {
            borderRadius: 6,
            borderSkipped: false
        }
    }

};

function createChart(canvasId, labels, data, positionName) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) return;
    
    const ctx = canvas.getContext('2d');
    const totalVotes = data.reduce((sum, current) => sum + current, 0);
    
    // Create gradient backgrounds
    const backgroundColors = data.map((_, index) => {
        const gradient = ctx.createLinearGradient(0, 0, 400, 0);
        const color = chartColors[index % chartColors.length];
        gradient.addColorStop(0, color);
        gradient.addColorStop(1, color + '80');
        return gradient;
    });
    
    const chartData = {
        labels: labels,
        datasets: [{
            data: data,
            backgroundColor: backgroundColors,
            borderColor: chartColors.slice(0, data.length),
            borderWidth: 2,
            total: totalVotes
        }]
    };
    
    new Chart(ctx, {
        type: 'bar',
        data: chartData,
        options: chartConfig
    });
}

function showNoDataMessage(canvasId, positionName) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) return;
    
    const ctx = canvas.getContext('2d');
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    
    ctx.font = "bold 16px 'Segoe UI'";
    ctx.fillStyle = "#64748b";
    ctx.textAlign = "center";
    ctx.textBaseline = "middle";
    











































































































    ctx.fillText("No votes cast yet", canvas.