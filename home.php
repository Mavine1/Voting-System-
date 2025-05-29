<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

    <?php include 'includes/navbar.php'; ?>
     
    <div class="content-wrapper" style="background-color: #f8fafc">
        <div class="container" style="background-color: #f8fafc">

            <!-- Main content -->
            <section class="content">
                <?php
                    $parse = parse_ini_file('admin/config.ini', FALSE, INI_SCANNER_RAW);
                    $title = $parse['election_title'];
                ?>
                <h1 class="page-header text-center title" style="color: #7c3aed;"><b><?php echo strtoupper($title); ?></b></h1>
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">

                        <?php
                            // Show session messages without manual close buttons
                            if(isset($_SESSION['error'])) {
                                echo '<div class="alert alert-danger floating-alert" id="error-alert" style="background-color: #fef2f2; border-color: #fecaca; color: #dc2626;"><ul>';
                                foreach($_SESSION['error'] as $error) {
                                    echo "<li>$error</li>";
                                }
                                echo '</ul></div>';
                                unset($_SESSION['error']);
                            }

                            if(isset($_SESSION['success'])) {
                                echo '<div class="alert alert-success floating-alert" id="success-alert" style="background-color: #f0fdf4; border-color: #bbf7d0; color: #16a34a;">';
                                echo "<h4><i class='icon fa fa-check'></i> Success!</h4>{$_SESSION['success']}";
                                echo '</div>';
                                unset($_SESSION['success']);
                            }
                        ?>

                        <div class="alert alert-danger floating-alert" id="alert" style="display:none; background-color: #fef2f2; border-color: #fecaca; color: #dc2626;">
                            <span class="message"></span>
                        </div>

                        <div class="alert alert-info floating-alert" id="info-alert" style="display:none; background-color: #eff6ff; border-color: #bfdbfe; color: #2563eb;">
                            <span class="info-message"></span>
                        </div>

                        <?php
                            $sql = "SELECT * FROM votes WHERE voters_id = '".$voter['id']."'";
                            $vquery = $conn->query($sql);
                            if($vquery->num_rows > 0){
                                ?>
                                <div class="text-center" style="color: #7c3aed; font-size: 35px; font-family: Arial, sans-serif;">
                                    <h3>You have already voted for this election.</h3>
                                    <a href="#view" data-toggle="modal" class="btn btn-primary btn-lg" style="background-color: #8b5cf6; border-color: #8b5cf6; color: white; font-size: 22px; font-family: Arial, sans-serif;">View Ballot</a>
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
                                            ?>
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div class="box" style="background-color: #ffffff; border: 2px solid #e5e7eb; border-radius: 12px; margin-bottom: 20px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);" id="<?php echo $row['id']; ?>">
                                                        <div class="box-header with-border" style="background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%); border-radius: 10px 10px 0 0; padding: 20px;">
                                                            <h3 class="box-title" style="color: #ffffff; font-weight: bold; margin: 0;"><?php echo htmlspecialchars($row['description']); ?></h3>
                                                        </div>
                                                        <div class="box-body" style="padding: 25px;">
                                                            <p style="color: #4b5563; margin-bottom: 20px; font-size: 16px;"><?php echo $instruct; ?></p>
                                                            <!-- Search Container -->
                                                            <div class="search-container" id="search-container-<?php echo $row['id']; ?>" style="margin-bottom: 25px;">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control candidate-search" placeholder="Search candidates by first name or last name..." style="border: 2px solid #d1d5db; border-radius: 25px 0 0 25px; padding: 12px 18px; font-size: 16px; transition: border-color 0.3s ease;" 
                                                                        data-position="<?php echo $row['id']; ?>" data-slug="<?php echo $slug; ?>" data-max-vote="<?php echo $row['max_vote']; ?>">
                                                                    <span class="input-group-btn">
                                                                        <button class="btn btn-primary search-btn" type="button" style="background: #1e40af; border-color: #1e40af; border-radius: 0 25px 25px 0; padding: 12px 24px;">
                                                                            Search
                                                                        </button>
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <!-- Search Results -->
                                                            <div class="search-results" id="results_<?php echo $row['id']; ?>" style="display: none;">
                                                                <h5 style="color: #7c3aed; margin-bottom: 18px; font-weight: 600;">Search Results:</h5>
                                                                <div class="candidates-list"></div>
                                                            </div>

                                                            <!-- Selected Candidates -->
                                                            <div class="selected-candidates" id="selected_<?php echo $row['id']; ?>">
                                                                <h5 style="color: #7c3aed; margin-bottom: 18px; font-weight: 600;">Selected Candidates:</h5>
                                                                <div class="selected-list" style="min-height: 60px; border: 2px dashed #d1d5db; padding: 20px; border-radius: 12px; background-color: #f9fafb;">
                                                                    <p class="text-muted text-center" style="margin: 0; color: #9ca3af;">No candidates selected yet</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    ?>
                                    <div class="text-center" style="margin-top: 40px;">
                                        <button type="button" class="btn btn-info btn-lg" style="background: linear-gradient(135deg, #0891b2 0%, #06b6d4 100%); border-color: #0891b2; color: white; margin-right: 20px; border-radius: 25px; padding: 12px 35px; font-size: 16px; font-weight: 600;" id="preview"><i class="fa fa-file-text"></i> Preview</button> 
                                        <button type="submit" class="btn btn-success btn-lg" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%); border-color: #059669; color: white; border-radius: 25px; padding: 12px 35px; font-size: 16px; font-weight: 600;" name="vote"><i class="fa fa-check-square-o"></i> Submit Vote</button>
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
                'background-color': '#f0fdf4',
                'border-color': '#bbf7d0',
                'color': '#16a34a'
            });
        } else if (type === 'warning') {
            $(alertId).css({
                'background-color': '#fffbeb',
                'border-color': '#fed7aa',
                'color': '#d97706'
            });
        } else {
            $(alertId).css({
                'background-color': '#fef2f2',
                'border-color': '#fecaca',
                'color': '#dc2626'
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
        $(this).css('border-color', '#7c3aed');

        if (val.length < 2) {
            $results.hide();
            $(this).css('border-color', '#d1d5db');
            return;
        }

        $list.html('<div class="text-center" style="color: #7c3aed;"><i class="fa fa-spinner fa-spin"></i> Searching...</div>');
        $results.show();

        $.ajax({
            url: 'search_candidates.php',
            method: 'POST',
            data: {search: val, position_id: posId},
            dataType: 'json',
            timeout: 10000,
            success: function(resp) {
                if (!Array.isArray(resp)) {
                    $list.html('<p class="text-center" style="color: #dc2626;">Invalid response</p>');
                    return;
                }
                if (resp.length === 0) {
                    $list.html('<p class="text-center" style="color: #9ca3af;"><i class="fa fa-search"></i> No candidates found</p>');
                    return;
                }

                let html = resp.map(c => {
                    let photo = c.photo ? 'images/' + c.photo : 'images/profile.jpg';
                    let platform = c.platform || 'No platform information available';
                    return `
                        <div class="candidate-item" data-candidate-id="${c.id}" data-firstname="${c.firstname}"
                             data-lastname="${c.lastname}" data-photo="${photo}" data-platform="${platform}"
                             data-position="${posId}" data-slug="${slug}" data-max-vote="${maxVote}"
                             style="border: 2px solid #e5e7eb; border-radius: 12px; padding: 20px; margin-bottom: 15px; background: #ffffff; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                            <div class="row">
                                <div class="col-md-3"><img src="${photo}" style="max-height: 100px; width: 100%; object-fit: cover; border-radius: 10px;" onerror="this.src='images/profile.jpg'"></div>
                                <div class="col-md-6">
                                    <h5 style="color: #374151; font-weight: 600; margin-bottom: 8px;">${c.firstname} ${c.lastname}</h5>
                                    <p style="color: #6b7280; font-size: 14px; line-height: 1.4;">${platform.substring(0,100)}${platform.length > 100 ? '...' : ''}</p>
                                </div>
                                <div class="col-md-3 text-center">
                                    <button type="button" class="btn btn-success btn-sm select-candidate" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%); border-color: #059669; border-radius: 20px; width: 100%; padding: 8px 16px; font-weight: 600;"><i class="fa fa-check"></i> Select</button>
                                </div>
                            </div>
                        </div>`;
                }).join('');
                $list.html(html);

                // Add hover effects
                $('.candidate-item').hover(
                    function() { $(this).css({'border-color': '#7c3aed', 'transform': 'translateY(-2px)', 'box-shadow': '0 4px 12px rgba(124, 58, 237, 0.15)'}); },
                    function() { $(this).css({'border-color': '#e5e7eb', 'transform': 'translateY(0)', 'box-shadow': '0 2px 4px rgba(0,0,0,0.1)'}); }
                );
            },
            error: function(xhr, status) {
                let errMsg = 'Search failed. ';
                if (status === 'timeout') errMsg += 'Request timed out. Please try again.';
                else if (status === 'error') errMsg += 'Server error. Please try later.';
                else errMsg += 'Check connection and try again.';
                $list.html('<p class="text-center" style="color: #dc2626;">' + errMsg + '</p>');
                showAlert(errMsg);
            }
        });
    });

    // Remove focus styling when input loses focus
    $('.candidate-search').on('blur', function() {
        $(this).css('border-color', '#d1d5db');
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
            platform: $item.data('platform'),
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

        showAlert(`${candidate.firstname} ${candidate.lastname} selected!`, 'success');
    }

    // Update selected candidates display
    function updateSelectedDisplay(position) {
        let $container = $('#selected_' + position + ' .selected-list');
        let candidates = selectedCandidates[position] || [];

        if (candidates.length === 0) {
            $container.html('<p class="text-center" style="margin: 0; color: #9ca3af;">No candidates selected yet</p>');
            $('#search-container-' + position).show(); // Show search if none selected
        } else {
            let html = candidates.map(c => `
                <div class="selected-candidate" style="border: 2px solid #7c3aed; border-radius: 12px; padding: 15px; margin-bottom: 12px; background: linear-gradient(135deg, #faf5ff 0%, #f3e8ff 100%);">
                    <div class="row">
                        <div class="col-md-2"><img src="${c.photo}" style="max-height: 60px; width: 100%; object-fit: cover; border-radius: 8px;" onerror="this.src='images/profile.jpg'"></div>
                        <div class="col-md-8">
                            <h6 style="color: #374151; margin: 0; font-weight: 600; margin-bottom: 4px;">${c.firstname} ${c.lastname}</h6>
                            <p style="color: #6b7280; margin: 0; font-size: 14px; line-height: 1.3;">${c.platform.substring(0,50)}${c.platform.length > 50 ? '...' : ''}</p>
                        </div>
                        <div class="col-md-2 text-right">
                            <button type="button" class="btn btn-danger btn-xs remove-candidate" data-position="${position}" data-candidate-id="${c.id}" style="background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%); border-color: #dc2626; border-radius: 15px; padding: 6px 10px;" title="Remove candidate">
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