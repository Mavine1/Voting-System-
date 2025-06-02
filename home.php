<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>

<style>
/* Animated background with books and awards */
.animated-bg {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #ffffff 0%, #e0f2fe 50%, #bbdefb 100%);
    overflow: hidden;
    z-index: -1;
}

.floating-item {
    position: absolute;
    animation: float 6s ease-in-out infinite;
    opacity: 0.1;
}

.book {
    width: 40px;
    height: 50px;
    background: linear-gradient(45deg, #1e40af, #3b82f6);
    border-radius: 3px;
    box-shadow: 2px 2px 5px rgba(0,0,0,0.2);
}

.book::before {
    content: '';
    position: absolute;
    left: 5px;
    top: 5px;
    right: 5px;
    bottom: 5px;
    background: rgba(255,255,255,0.3);
    border-radius: 2px;
}

.award {
    width: 35px;
    height: 35px;
    background: linear-gradient(45deg, #ffd700, #ffed4e);
    border-radius: 50%;
    position: relative;
    box-shadow: 2px 2px 5px rgba(0,0,0,0.2);
}

.award::before {
    content: '★';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: #1e40af;
    font-size: 18px;
    font-weight: bold;
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    25% { transform: translateY(-20px) rotate(5deg); }
    50% { transform: translateY(-10px) rotate(-3deg); }
    75% { transform: translateY(-15px) rotate(3deg); }
}

.platform-section {
    background: rgba(30, 64, 175, 0.05);
    border: 1px solid rgba(30, 64, 175, 0.2);
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
}

.remarks-section {
    background: rgba(30, 64, 175, 0.05);
    border: 2px solid #1e40af;
    border-radius: 10px;
    padding: 20px;
    margin-top: 15px;
}
</style>

<body class="hold-transition skin-blue layout-top-nav">
<!-- Animated Background -->
<div class="animated-bg">
    <!-- Books -->
    <div class="floating-item book" style="top: 10%; left: 5%; animation-delay: 0s;"></div>
    <div class="floating-item book" style="top: 20%; right: 10%; animation-delay: 1s;"></div>
    <div class="floating-item book" style="top: 60%; left: 15%; animation-delay: 2s;"></div>
    <div class="floating-item book" style="top: 80%; right: 20%; animation-delay: 3s;"></div>
    <div class="floating-item book" style="top: 40%; left: 80%; animation-delay: 4s;"></div>
    
    <!-- Awards -->
    <div class="floating-item award" style="top: 15%; left: 25%; animation-delay: 0.5s;"></div>
    <div class="floating-item award" style="top: 35%; right: 15%; animation-delay: 1.5s;"></div>
    <div class="floating-item award" style="top: 70%; left: 10%; animation-delay: 2.5s;"></div>
    <div class="floating-item award" style="top: 50%; right: 5%; animation-delay: 3.5s;"></div>
    <div class="floating-item award" style="top: 25%; left: 70%; animation-delay: 4.5s;"></div>
    
    <!-- More Books -->
    <div class="floating-item book" style="top: 5%; left: 40%; animation-delay: 1.2s;"></div>
    <div class="floating-item book" style="top: 85%; left: 60%; animation-delay: 2.8s;"></div>
    <div class="floating-item book" style="top: 45%; left: 5%; animation-delay: 4.2s;"></div>
    
    <!-- More Awards -->
    <div class="floating-item award" style="top: 65%; left: 85%; animation-delay: 0.8s;"></div>
    <div class="floating-item award" style="top: 10%; left: 60%; animation-delay: 3.2s;"></div>
</div>

<div class="wrapper">

    <?php include 'includes/navbar.php'; ?>
     
    <div class="content-wrapper" style="background-color: rgba(255,255,255,0.95)">
        <div class="container" style="background-color: rgba(255,255,255,0.95)">

            <!-- Main content -->
            <section class="content">
                <?php
                    $parse = parse_ini_file('admin/config.ini', FALSE, INI_SCANNER_RAW);
                    $title = $parse['election_title'];
                ?>
                <h1 class="page-header text-center title" style="color: #1e40af; font-size: 22px; font-family: Times;"><b><?php echo strtoupper($title); ?></b></h1>
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">

                        <?php
                            // Show session messages without manual close buttons
                            if(isset($_SESSION['error'])) {
                                echo '<div class="alert alert-danger floating-alert" id="error-alert" style="background-color: #ef4444; border-color: #ef4444; color: #ffffff;"><ul>';
                                foreach($_SESSION['error'] as $error) {
                                    echo "<li>$error</li>";
                                }
                                echo '</ul></div>';
                                unset($_SESSION['error']);
                            }

                            if(isset($_SESSION['success'])) {
                                echo '<div class="alert alert-success floating-alert" id="success-alert" style="background-color: #1e40af; border-color: #1e40af; color: #ffffff;">';
                                echo "<h4><i class='icon fa fa-check'></i> Success!</h4>{$_SESSION['success']}";
                                echo '</div>';
                                unset($_SESSION['success']);
                            }
                        ?>

                        <div class="alert alert-danger floating-alert" id="alert" style="display:none; background-color: #ef4444; border-color: #ef4444; color: #ffffff;">
                            <span class="message"></span>
                        </div>

                        <div class="alert alert-info floating-alert" id="info-alert" style="display:none; background-color: #1e40af; border-color: #1e40af; color: #ffffff;">
                            <span class="info-message"></span>
                        </div>

                        <?php
                            $sql = "SELECT * FROM votes WHERE voters_id = '".$voter['id']."'";
                            $vquery = $conn->query($sql);
                            if($vquery->num_rows > 0){
                                ?>
                                <div class="text-center" style="color: #1e40af; font-size: 22px; font-family: Times;">
                                    <h3>You have already voted for this election.</h3>
                                    <a href="#view" data-toggle="modal" class="btn btn-primary btn-lg" style="background-color: #1e40af; border-color: #1e40af; color: #ffffff; font-size: 12px; font-family: Times;">View Ballot</a>
                                </div>
                                <?php
                            } else {
                                ?>
                                <!-- Voting Ballot -->
                                <form method="POST" id="ballotForm" action="submit_ballot.php">
                                    <?php
                                        include 'includes/slugify.php';
                                        $sql = "SELECT * FROM positions ORDER BY priority ASC";
                                        $query = $conn->query($sql);
                                        while($row = $query->fetch_assoc()){
                                            $slug = slugify($row['description']);
                                            $instruct = ($row['max_vote'] > 1) ? "You may select up to {$row['max_vote']} candidates" : "Select only one candidate";
                                            
                                            // Get position platform/description if available
                                            $platform_sql = "SELECT DISTINCT platform FROM candidates WHERE position_id = '".$row['id']."' AND platform != '' LIMIT 1";
                                            $platform_query = $conn->query($platform_sql);
                                            $position_platform = '';
                                            if($platform_query && $platform_query->num_rows > 0) {
                                                $platform_row = $platform_query->fetch_assoc();
                                                if(!empty($platform_row['platform'])) {
                                                    $position_platform = $platform_row['platform'];
                                                }
                                            }
                                            ?>
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div class="box" style="background-color: rgba(255,255,255,0.95); border: 2px solid #1e40af; border-radius: 10px; margin-bottom: 20px; box-shadow: 0 8px 32px rgba(30, 64, 175, 0.3);" id="<?php echo $row['id']; ?>">
                                                        <div class="box-header with-border" style="background-color: #1e40af; border-radius: 8px 8px 0 0; padding: 20px;">
                                                            <h3 class="box-title" style="color: #ffffff; font-weight: bold; margin: 0; font-size: 22px; font-family: Times;"><?php echo htmlspecialchars($row['description']); ?></h3>
                                                        </div>
                                                        <div class="box-body" style="padding: 25px;">
                                                            <p style="color: #1e40af; margin-bottom: 20px; font-size: 16px; font-family: Times;"><?php echo $instruct; ?></p>
                                                            
                                                            <?php if(!empty($position_platform)): ?>
                                                            <!-- Platform Section -->
                                                            <div class="platform-section">
                                                                <h5 style="color: #1e40af; margin-bottom: 12px; font-weight: 600; font-size: 18px; font-family: Times;">
                                                                    <i class="fa fa-info-circle"></i> Position Platform/Information:
                                                                </h5>
                                                                <p style="color: #1e40af; margin: 0; font-size: 14px; line-height: 1.6; font-family: Times;">
                                                                    <?php echo nl2br(htmlspecialchars($position_platform)); ?>
                                                                </p>
                                                            </div>
                                                            <?php endif; ?>

                                                            <!-- Search Container -->
                                                            <div class="search-container" id="search-container-<?php echo $row['id']; ?>" style="margin-bottom: 25px;">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control candidate-search" placeholder="Search candidates by first name or last name..." style="border: 2px solid #1e40af; border-radius: 5px 0 0 5px; padding: 12px 18px; font-size: 16px; color: #1e40af; transition: border-color 0.3s ease;" 
                                                                        data-position="<?php echo $row['id']; ?>" data-slug="<?php echo $slug; ?>" data-max-vote="<?php echo $row['max_vote']; ?>">
                                                                    <span class="input-group-btn">
                                                                        <button class="btn btn-primary search-btn" type="button" style="background-color: #1e40af; border-color: #1e40af; color: #ffffff; border-radius: 0 5px 5px 0; padding: 12px 24px; font-size: 12px; font-family: Times;">
                                                                            Search
                                                                        </button>
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <!-- Search Results -->
                                                            <div class="search-results" id="results_<?php echo $row['id']; ?>" style="display: none;">
                                                                <h5 style="color: #1e40af; margin-bottom: 18px; font-weight: 600; font-size: 22px; font-family: Times;">Search Results:</h5>
                                                                <div class="candidates-list"></div>
                                                            </div>

                                                            <!-- Selected Candidates -->
                                                            <div class="selected-candidates" id="selected_<?php echo $row['id']; ?>">
                                                                <h5 style="color: #1e40af; margin-bottom: 18px; font-weight: 600; font-size: 22px; font-family: Times;">Selected Candidates:</h5>
                                                                <div class="selected-list" style="min-height: 60px; border: 2px dashed #1e40af; padding: 20px; border-radius: 10px; background-color: rgba(255,255,255,0.95);">
                                                                    <p class="text-muted text-center" style="margin: 0; color: #1e40af; font-family: Times;">No candidates selected yet</p>
                                                                </div>
                                                            </div>

                                                            <!-- Remarks Section -->
                                                            <div class="remarks-section" id="remarks_<?php echo $row['id']; ?>" style="display: none;">
                                                                <h5 style="color: #1e40af; margin-bottom: 15px; font-weight: 600; font-size: 18px; font-family: Times;">
                                                                    <i class="fa fa-comment-o"></i> Why are you voting for this candidate?
                                                                </h5>
                                                                <textarea class="form-control remarks-input" name="remarks_<?php echo $slug; ?>" 
                                                                    placeholder="Share your reason for voting for this candidate (optional)..." 
                                                                    rows="3" style="border: 2px solid #1e40af; border-radius: 8px; padding: 12px; font-size: 14px; color: #1e40af; font-family: Times; resize: vertical; min-height: 80px;"
                                                                    data-position="<?php echo $row['id']; ?>"></textarea>
                                                                <small style="color: #1e40af; font-style: italic; font-family: Times; margin-top: 8px; display: block;">
                                                                    This helps improve future elections and candidate selection.
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    ?>
                                    <div class="text-center" style="margin-top: 40px;">
                                        <button type="button" class="btn btn-info btn-lg" style="background-color: #008000; border-color: #1e40af; color: #ffffff; margin-right: 20px; border-radius: 5px; padding: 12px 35px; font-size: 12px; font-family: Times; font-weight: 600;" id="preview"><i class="fa fa-file-text"></i> Preview</button> 
                                        <button type="submit" class="btn btn-success btn-lg" style="background-color: #1e40af; border-color: #1e40af; color: #ffffff; border-radius: 5px; padding: 12px 35px; font-size: 12px; font-family: Times; font-weight: 600;" name="vote"><i class="fa fa-check-square-o"></i> Submit Vote</button>
                                    </div>
                                </form>
                                <!-- End Voting Ballot -->
                                <?php
                            }
                        ?>
                    </div>
                </div>
            </section>
        </div>
    </div>
  
    <?php include 'includes/footer.php'; ?>
    <?php include 'includes/ballot_modal.php'; ?>
</div>

<?php include 'includes/scripts.php'; ?>

<script>
$(function() {
    let selectedCandidates = {};

    // Auto-fade visible alerts after 20s
    function autoFadeAlerts() {
        $('.floating-alert:visible').each(function() {
            setTimeout(() => $(this).fadeOut(1000), 20000);
        });
    }
    autoFadeAlerts();

    // Show floating alert message (auto fade) and reset fade timer
    function showAlert(msg, type = 'danger') {
        const alertId = (type === 'success') ? '#info-alert' : '#alert';
        const msgClass = (type === 'success') ? '.info-message' : '.message';

        if (type === 'success') {
            $(alertId).css({
                'background-color': '#1e40af',
                'border-color': '#1e40af',
                'color': '#ffffff'
            });
        } else if (type === 'warning') {
            $(alertId).css({
                'background-color': '#f59e0b',
                'border-color': '#f59e0b',
                'color': '#ffffff'
            });
        } else {
            $(alertId).css({
                'background-color': '#ef4444',
                'border-color': '#ef4444',
                'color': '#ffffff'
            });
        }

        $(alertId).removeClass('alert-danger alert-success alert-info alert-warning')
                  .addClass('alert-' + type)
                  .find(msgClass).html(msg);
        $(alertId).stop(true, true).fadeIn(500);

        clearTimeout($(alertId).data('fadeTimeout'));
        const timeout = setTimeout(() => $(alertId).fadeOut(1000), 1000);
        $(alertId).data('fadeTimeout', timeout);
    }

    // AJAX Search on input
    $('.candidate-search').on('input', function() {
        let val = $(this).val().trim();
        let posId = $(this).data('position');
        let maxVote = $(this).data('max-vote');
        let slug = $(this).data('slug');
        let $results = $('#results_' + posId);
        let $list = $results.find('.candidates-list');

        // Add focus styling
        $(this).css('border-color', '#1e40af');

        if (val.length < 2) {
            $results.hide();
            $(this).css('border-color', '#1e40af');
            return;
        }

        $list.html('<div class="text-center" style="color: #1e40af;"><i class="fa fa-spinner fa-spin"></i> Searching...</div>');
        $results.show();

        $.ajax({
            url: 'search_candidates.php',
            method: 'POST',
            data: {search: val, position_id: posId},
            dataType: 'json',
            timeout: 10000,
            success: function(resp) {
                if (!Array.isArray(resp)) {
                    $list.html('<p class="text-center" style="color: #ef4444;">Invalid response</p>');
                    return;
                }
                if (resp.length === 0) {
                    $list.html('<p class="text-center" style="color: #1e40af;"><i class="fa fa-search"></i> No candidates found</p>');
                    return;
                }

                let html = resp.map(c => {
                    let photo = c.photo ? 'images/' + c.photo : 'images/profile.jpg';
                    return `
                        <div class="candidate-item" data-candidate-id="${c.id}" data-firstname="${c.firstname}"
                             data-lastname="${c.lastname}" data-photo="${photo}"
                             data-position="${posId}" data-slug="${slug}" data-max-vote="${maxVote}"
                             style="border: 2px solid #1e40af; border-radius: 10px; padding: 20px; margin-bottom: 15px; background: rgba(255,255,255,0.95); cursor: pointer; transition: all 0.3s ease; box-shadow: 0 8px 32px rgba(30, 64, 175, 0.3);">
                            <div class="row">
                                <div class="col-md-3"><img src="${photo}" style="max-height: 100px; width: 100%; object-fit: cover; border-radius: 10px;" onerror="this.src='images/profile.jpg'"></div>
                                <div class="col-md-6">
                                    <h5 style="color: #1e40af; font-weight: 600; margin-bottom: 8px; font-size: 22px; font-family: Times;">${c.firstname} ${c.lastname}</h5>
                                </div>
                                <div class="col-md-3 text-center">
                                    <button type="button" class="btn btn-success btn-sm select-candidate" style="background-color: #008000; border-color: #008000; border-radius: 5px; width: 100%; padding: 8px 16px; font-weight: 600; color: #ffffff; font-size: 12px; font-family: Times;"><i class="fa fa-check"></i> Select</button>
                                </div>
                            </div>
                        </div>`;
                }).join('');
                $list.html(html);

                // Add hover effects
                $('.candidate-item').hover(
                    function() { $(this).css({'border-color': '#3b82f6', 'transform': 'translateY(-2px)', 'box-shadow': '0 12px 40px rgba(30, 64, 175, 0.4)'}); },
                    function() { $(this).css({'border-color': '#1e40af', 'transform': 'translateY(0)', 'box-shadow': '0 8px 32px rgba(30, 64, 175, 0.3)'}); }
                );
            },
            error: function(xhr, status) {
                let errMsg = 'Search failed. ';
                if (status === 'timeout') errMsg += 'Request timed out. Please try again.';
                else if (status === 'error') errMsg += 'Server error. Please try later.';
                else errMsg += 'Check connection and try again.';
                $list.html('<p class="text-center" style="color: #ef4444;">' + errMsg + '</p>');
                showAlert(errMsg);
            }
        });
    });

    // Remove focus styling when input loses focus
    $('.candidate-search').on('blur', function() {
        $(this).css('border-color', '#1e40af');
    });

    // Select candidate handler
    $(document).on('click', '.select-candidate', function(e) {
        e.stopPropagation();
        let $item = $(this).closest('.candidate-item');
        let candidate = {
            id: $item.data('candidate-id'),
            firstname: $item.data('firstname'),
            lastname: $item.data('lastname'),
            photo: $item.data('photo'),
            position: $item.data('position'),
            slug: $item.data('slug'),
            maxVote: $item.data('max-vote')
        };
        addCandidate(candidate);
    });

    // Add candidate logic
    function addCandidate(candidate) {
        if (!selectedCandidates[candidate.position]) selectedCandidates[candidate.position] = [];

        // Check duplicate
        if (selectedCandidates[candidate.position].some(c => c.id === candidate.id)) {
            showAlert('Candidate already selected!', 'warning');
            return;
        }

        // Check max votes
        if (selectedCandidates[candidate.position].length >= candidate.maxVote) {
            showAlert(`Only up to ${candidate.maxVote} candidate(s) allowed for this position.`, 'warning');
            return;
        }

        selectedCandidates[candidate.position].push(candidate);
        updateSelectedDisplay(candidate.position);
        updateHiddenInputs(candidate.position, candidate.slug, candidate.maxVote);

        // Hide search container & results after selection
        $('#search-container-' + candidate.position).hide();
        $('#results_' + candidate.position).hide();

        // Show remarks section
        $('#remarks_' + candidate.position).slideDown();

        showAlert(`${candidate.firstname} ${candidate.lastname} selected!`, 'success');
    }

    // Update selected candidates display
    function updateSelectedDisplay(position) {
        let $container = $('#selected_' + position + ' .selected-list');
        let candidates = selectedCandidates[position] || [];

        if (candidates.length === 0) {
            $container.html('<p class="text-center" style="margin: 0; color: #1e40af; font-family: Times;">No candidates selected yet</p>');
            $('#search-container-' + position).show(); // Show search if none selected
            $('#remarks_' + position).slideUp(); // Hide remarks section
        } else {
            let html = candidates.map(c => `
                <div class="selected-candidate" style="border: 2px solid #1e40af; border-radius: 10px; padding: 15px; margin-bottom: 12px; background: rgba(255,255,255,0.95);">
                    <div class="row">
                        <div class="col-md-2"><img src="${c.photo}" style="max-height: 60px; width: 100%; object-fit: cover; border-radius: 8px;" onerror="this.src='images/profile.jpg'"></div>
                        <div class="col-md-8">
                            <h6 style="color: #1e40af; margin: 0; font-weight: 600; margin-bottom: 4px; font-size: 22px; font-family: Times;">${c.firstname} ${c.lastname}</h6>
                        </div>
                        <div class="col-md-2 text-right">
                            <button type="button" class="btn btn-danger btn-xs remove-candidate" data-position="${position}" data-candidate-id="${c.id}" style="background-color: #ef4444; border-color: #ef4444; border-radius: 5px; padding: 6px 10px; color: #ffffff; font-size: 12px; font-family: Times;" title="Remove candidate">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>`).join('');
            $container.html(html);
        }
    }

    // Remove candidate handler
    $(document).on('click', '.remove-candidate', function() {
        let pos = $(this).data('position');
        let cid = $(this).data('candidate-id');
        let removed = null;

        if (selectedCandidates[pos]) {
            removed = selectedCandidates[pos].find(c => c.id === cid);
            selectedCandidates[pos] = selectedCandidates[pos].filter(c => c.id !== cid);
            updateSelectedDisplay(pos);

            // Update hidden inputs or remove all if none left
            if (selectedCandidates[pos].length) {
                updateHiddenInputs(pos, selectedCandidates[pos][0].slug, selectedCandidates[pos][0].maxVote);
            } else {
                let slug = $('.candidate-search[data-position="' + pos + '"]').data('slug');
                $(`input[name^="${slug}"]`).remove();
                $('#search-container-' + pos).show();  // Show search container back when none selected
                // Clear remarks textarea
                $(`textarea[name="remarks_${slug}"]`).val('');
            }

            if (removed) showAlert(`${removed.firstname} ${removed.lastname} removed.`, 'warning');
        }
    });

    // Update hidden inputs for form submission
    function updateHiddenInputs(position, slug, maxVote) {
        $(`input[name^="${slug}"]`).remove();
        let candidates = selectedCandidates[position] || [];
        let inputName = maxVote > 1 ? slug + '[]' : slug;
        candidates.forEach(c => {
            $('<input>').attr({type: 'hidden', name: inputName, value: c.id}).appendTo('#ballotForm');
        });
    }

    // Preview button click (ajax)
    $('#preview').click(function(e) {
        e.preventDefault();
        let form = $('#ballotForm').serialize();
        if (!form) {
            showAlert('Select at least one candidate before previewing.', 'warning');
            return;
        }

        $(this).html('<i class="fa fa-spinner fa-spin"></i> Loading Preview...').prop('disabled', true);

        $.ajax({
            type: 'POST',
            url: 'preview.php',
            data: form,
            dataType: 'json',
            timeout: 15000,
            success: function(resp) {
                if (resp.error) {
                    let msgs = Object.values(resp.message).join('<br>');
                    showAlert(msgs, 'danger');
                } else {
                    $('#preview_modal').modal('show');
                    $('#preview_body').html(resp.list);
                }
            },
            error: function(xhr, status) {
                showAlert('Failed to load preview. ' + (status === 'timeout' ? 'Request timed out.' : 'Please try again.'), 'danger');
            },
            complete: function() {
                $('#preview').html('<i class="fa fa-file-text"></i> Preview').prop('disabled', false);
            }
        });
    });
});
</script>

</body>
</html>