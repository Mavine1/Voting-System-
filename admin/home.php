<?php
// Enhanced Votes Tally Section with proper data fetching
$sql = "SELECT * FROM positions ORDER BY priority ASC";
$query = $conn->query($sql);
$inc = 2;
$hasData = false;

while ($row = $query->fetch_assoc()) {
    $inc = ($inc == 2) ? 1 : $inc + 1;
    if ($inc == 1) echo "<div class='row' style='margin-bottom: 30px;'>";
    
    $positionId = (int)$row['id'];
    
    // Enhanced query to get top 5 candidates with vote counts for this position
    $candidatesQuery = "
        SELECT 
            c.id,
            c.firstname, 
            c.lastname, 
            c.photo,
            COALESCE(COUNT(v.id), 0) AS vote_count,
            COALESCE(
                ROUND(
                    (COUNT(v.id) * 100.0) / NULLIF(
                        (SELECT COUNT(*) FROM votes v2 
                         JOIN candidates c2 ON v2.candidate_id = c2.id 
                         WHERE c2.position_id = $positionId), 0
                    ), 2
                ), 0
            ) AS vote_percentage
        FROM candidates c
        LEFT JOIN votes v ON v.candidate_id = c.id
        WHERE c.position_id = $positionId
        GROUP BY c.id, c.firstname, c.lastname, c.photo
        ORDER BY vote_count DESC, c.lastname ASC
        LIMIT 5
    ";
    
    $candidatesResult = $conn->query($candidatesQuery);
    $candidateCount = $candidatesResult ? $candidatesResult->num_rows : 0;
    
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
                    <!-- Display candidates with vote counts -->
                    <div class="candidates-list">
                        <?php 
                        $rank = 1;
                        $candidatesResult->data_seek(0); // Reset result pointer
                        while ($candidate = $candidatesResult->fetch_assoc()): 
                            $voteCount = (int)$candidate['vote_count'];
                            $percentage = (float)$candidate['vote_percentage'];
                            
                            // Determine rank styling
                            $rankColors = [
                                1 => ['bg' => '#f59e0b', 'icon' => 'crown'],
                                2 => ['bg' => '#6b7280', 'icon' => 'medal'],
                                3 => ['bg' => '#dc2626', 'icon' => 'award']
                            ];
                            $rankStyle = $rankColors[$rank] ?? ['bg' => '#3b82f6', 'icon' => 'star'];
                        ?>
                            <div class="candidate-item" style="display: flex; align-items: center; padding: 15px; margin-bottom: 12px; background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid <?= $rankStyle['bg'] ?>; transition: all 0.3s ease;">
                                <!-- Rank Badge -->
                                <div class="rank-badge" style="background: <?= $rankStyle['bg'] ?>; color: white; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; margin-right: 15px; box-shadow: 0 2px 8px rgba(0,0,0,0.2);">
                                    <?php if ($rank <= 3): ?>
                                        <i class="fa fa-<?= $rankStyle['icon'] ?>" style="font-size: 16px;"></i>
                                    <?php else: ?>
                                        <?= $rank ?>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Candidate Photo -->
                                <div class="candidate-photo" style="margin-right: 15px;">
                                    <?php if (!empty($candidate['photo']) && file_exists('images/' . $candidate['photo'])): ?>
                                        <img src="images/<?= htmlspecialchars($candidate['photo']) ?>" 
                                             alt="<?= htmlspecialchars($candidate['firstname'] . ' ' . $candidate['lastname']) ?>"
                                             style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; border: 3px solid <?= $rankStyle['bg'] ?>; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                    <?php else: ?>
                                        <div style="width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%); display: flex; align-items: center; justify-content: center; border: 3px solid <?= $rankStyle['bg'] ?>;">
                                            <i class="fa fa-user" style="color: #64748b; font-size: 20px;"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Candidate Info -->
                                <div class="candidate-info" style="flex: 1;">
                                    <h5 style="margin: 0 0 5px 0; font-weight: 700; color: #1e293b; font-size: 16px;">
                                        <?= htmlspecialchars($candidate['firstname'] . ' ' . $candidate['lastname']) ?>
                                    </h5>
                                    <div style="display: flex; align-items: center; gap: 15px;">
                                        <span style="color: #64748b; font-size: 14px; font-weight: 600;">
                                            <i class="fa fa-vote-yea" style="margin-right: 5px; color: <?= $rankStyle['bg'] ?>;"></i>
                                            <?= number_format($voteCount) ?> votes
                                        </span>
                                        <?php if ($percentage > 0): ?>
                                            <span style="background: linear-gradient(135deg, <?= $rankStyle['bg'] ?>20 0%, <?= $rankStyle['bg'] ?>10 100%); color: <?= $rankStyle['bg'] ?>; padding: 4px 10px; border-radius: 12px; font-size: 12px; font-weight: 700;">
                                                <?= number_format($percentage, 1) ?>%
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <!-- Vote Progress Bar -->
                                <?php if ($percentage > 0): ?>
                                    <div class="vote-progress" style="width: 80px; margin-left: 15px;">
                                        <div style="background: #e2e8f0; height: 8px; border-radius: 4px; overflow: hidden;">
                                            <div style="background: linear-gradient(90deg, <?= $rankStyle['bg'] ?> 0%, <?= $rankStyle['bg'] ?>CC 100%); height: 100%; width: <?= min($percentage, 100) ?>%; border-radius: 4px; transition: width 1s ease;"></div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php 
                        $rank++;
                        endwhile; 
                        ?>
                    </div>
                    
                    <!-- Chart Section -->
                    <div class="chart-section" style="margin-top: 25px; padding-top: 25px; border-top: 2px solid #e2e8f0;">
                        <h5 style="margin-bottom: 15px; color: #1e293b; font-weight: 700; text-align: center;">
                            <i class="fa fa-chart-bar" style="margin-right: 8px; color: #3b82f6;"></i>
                            Visual Representation
                        </h5>
                        <div class="chart" style="position: relative;">
                            <canvas id="<?= slugify($row['description']) ?>" style="height: 300px; width: 100%;"></canvas>
                        </div>
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

<!-- Enhanced Chart.js Scripts -->
<?php
$query = $conn->query("SELECT * FROM positions ORDER BY priority ASC");
while ($row = $query->fetch_assoc()) {
    $positionId = (int)$row['id'];
    
    // Get top 5 candidates with vote data for chart
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
    
    if (!$cquery || $cquery->num_rows === 0) {
        continue;
    }

    $candidateNames = [];
    $voteCounts = [];
    $totalVotes = 0;

    while ($crow = $cquery->fetch_assoc()) {
        $candidateNames[] = htmlspecialchars($crow['firstname'] . ' ' . $crow['lastname']);
        $voteCount = (int)$crow['vote_count'];
        $voteCounts[] = $voteCount;
        $totalVotes += $voteCount;
    }

    // Skip chart if no votes
    if ($totalVotes === 0) {
        continue;
    }

    $candidateNamesJson = json_encode($candidateNames);
    $voteCountsJson = json_encode($voteCounts);
    $canvasId = slugify($row['description']);
    ?>
    <script>
        $(function() {
            const ctx = document.getElementById('<?= $canvasId ?>');
            if (!ctx) return;
            
            try {
                new Chart(ctx.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: <?= $candidateNamesJson ?>,
                        datasets: [{
                            label: 'Votes',
                            data: <?= $voteCountsJson ?>,
                            backgroundColor: [
                                'rgba(245, 158, 11, 0.8)',  // Gold for 1st
                                'rgba(107, 114, 128, 0.8)', // Silver for 2nd
                                'rgba(220, 38, 38, 0.8)',   // Bronze for 3rd
                                'rgba(59, 130, 246, 0.8)',  // Blue for 4th
                                'rgba(124, 58, 237, 0.8)'   // Purple for 5th
                            ],
                            borderColor: [
                                'rgba(245, 158, 11, 1)',
                                'rgba(107, 114, 128, 1)',
                                'rgba(220, 38, 38, 1)',
                                'rgba(59, 130, 246, 1)',
                                'rgba(124, 58, 237, 1)'
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
                                        const total = <?= $totalVotes ?>;
                                        const percentage = total > 0 ? ((votes / total) * 100).toFixed(1) + '%' : '0%';
                                        return [
                                            'Votes: ' + votes.toLocaleString(),
                                            'Percentage: ' + percentage,
                                            'Rank: #' + (context.dataIndex + 1)
                                        ];
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
                                    stepSize: 1,
                                    callback: function(value) {
                                        return Number.isInteger(value) ? value : '';
                                    }
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
            } catch (error) {
                console.error('Error creating chart for <?= $canvasId ?>:', error);
                document.getElementById('<?= $canvasId ?>').parentNode.innerHTML = 
                    '<div style="text-align: center; padding: 40px; color: #6b7280;">' +
                    '<i class="fa fa-exclamation-triangle" style="font-size: 32px; margin-bottom: 15px; color: #ef4444;"></i>' +
                    '<p style="margin: 0;">Unable to load chart data</p>' +
                    '</div>';
            }
        });
    </script>
<?php } ?>

<style>
/* Enhanced candidate item hover effects */
.candidate-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15) !important;
}

/* Rank badge animations */
.rank-badge {
    position: relative;
    overflow: hidden;
}

.rank-badge::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: left 0.5s;
}

.candidate-item:hover .rank-badge::before {
    left: 100%;
}

/* Progress bar animation */
.vote-progress div div {
    animation: progressFill 2s ease-in-out;
}

@keyframes progressFill {
    from { width: 0%; }
}

/* Responsive improvements */
@media (max-width: 768px) {
    .candidate-item {
        flex-direction: column;
        text-align: center;
        padding: 20px 15px !important;
    }
    
    .rank-badge, .candidate-photo {
        margin-right: 0 !important;
        margin-bottom: 10px;
    }
    
    .candidate-info {
        margin-bottom: 15px;
    }
    
    .vote-progress {
        width: 100% !important;
        margin-left: 0 !important;
    }
}

@media (max-width: 480px) {
    .candidate-item {
        margin-bottom: 8px !important;
        padding: 15px 10px !important;
    }
    
    .rank-badge {
        width: 35px !important;
        height: 35px !important;
    }
    
    .candidate-photo img,
    .candidate-photo div {
        width: 40px !important;
        height: 40px !important;
    }
    
    .candidate-info h5 {
        font-size: 14px !important;
    }
}
</style>