<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

    <?php include 'includes/navbar.php'; ?>
     
    <div class="content-wrapper" style="background-color: #ffffff">
        <div class="container" style="background-color: #ffffff">

            <!-- Main content -->
            <section class="content">
                <?php
                    $parse = parse_ini_file('admin/config.ini', FALSE, INI_SCANNER_RAW);
                    $title = $parse['election_title'];
                ?>
                <h1 class="page-header text-center title" style="color: #2c5aa0;"><b><?php echo strtoupper($title); ?></b></h1>
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">

                        <?php
                            // Display session messages without manual close buttons
                            if(isset($_SESSION['error'])) {
                                echo '<div class="alert alert-danger floating-alert" id="error-alert"><ul>';
                                foreach($_SESSION['error'] as $error) {
                                    echo "<li>$error</li>";
                                }
                                echo '</ul></div>';
                                unset($_SESSION['error']);
                            }

                            if(isset($_SESSION['success'])) {
                                echo '<div class="alert alert-success floating-alert" id="success-alert">';
                                echo "<h4><i class='icon fa fa-check'></i> Success!</h4>{$_SESSION['success']}";
                                echo '</div>';
                                unset($_SESSION['success']);
                            }
                        ?>

                        <div class="alert alert-danger floating-alert" id="alert" style="display:none;">
                            <span class="message"></span>
                        </div>

                        <div class="alert alert-info floating-alert" id="info-alert" style="display:none;">
                            <span class="info-message"></span>
                        </div>

                        <?php
                            $sql = "SELECT * FROM votes WHERE voters_id = '".$voter['id']."'";
                            $vquery = $conn->query($sql);
                            if($vquery->num_rows > 0){
                                ?>
                                <div class="text-center" style="color: #2c5aa0; font-size: 35px; font-family: Arial, sans-serif;">
                                    <h3>You have already voted for this election.</h3>
                                    <a href="#view" data-toggle="modal" class="btn btn-primary btn-lg" style="background-color: #4a90e2; border-color: #4a90e2; color: white; font-size: 22px; font-family: Arial, sans-serif;">View Ballot</a>
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
                                                    <div class="box" style="background-color: #f8f9fa; border: 2px solid #e3f2fd; border-radius: 8px; margin-bottom: 20px;" id="<?php echo $row['id']; ?>">
                                                        <div class="box-header with-border" style="background-color: #e3f2fd; border-radius: 6px 6px 0 0;">
                                                            <h3 class="box-title" style="color: #2c5aa0; font-weight: bold;"><?php echo htmlspecialchars($row['description']); ?></h3>
                                                        </div>
                                                        <div class="box-body" style="padding: 20px;">
                                                            <p style="color: #333; margin-bottom: 15px;"><?php echo $instruct; ?></p>
                                                            <!-- Search Container -->
                                                            <div class="search-container" id="search-container-<?php echo $row['id']; ?>" style="margin-bottom: 20px;">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control candidate-search" placeholder="Search candidates by first name or last name..." style="border: 2px solid #4a90e2; border-radius: 25px 0 0 25px; padding: 10px 15px;" 
                                                                        data-position="<?php echo $row['id']; ?>" data-slug="<?php echo $slug; ?>" data-max-vote="<?php echo $row['max_vote']; ?>">
                                                                    <span class="input-group-btn">
                                                                        <button class="btn btn-primary search-btn" type="button" style="background-color: #4a90e2; border-color: #4a90e2; border-radius: 0 25px 25px 0; padding: 10px 20px;">
                                                                            <i class="fa fa-search"></i>
                                                                        </button>
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <!-- Search Results -->
                                                            <div class="search-results" id="results_<?php echo $row['id']; ?>" style="display: none;">
                                                                <h5 style="color: #2c5aa0; margin-bottom: 15px;">Search Results:</h5>
                                                                <div class="candidates-list"></div>
                                                            </div>

                                                            <!-- Selected Candidates -->
                                                            <div class="selected-candidates" id="selected_<?php echo $row['id']; ?>">
                                                                <h5 style="color: #2c5aa0; margin-bottom: 15px;">Selected Candidates:</h5>
                                                                <div class="selected-list" style="min-height: 50px; border: 2px dashed #ddd; padding: 15px; border-radius: 8px; background-color: #f9f9f9;">
                                                                    <p class="text-muted text-center" style="margin: 0;">No candidates selected yet</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    ?>
                                    <div class="text-center" style="margin-top: 30px;">
                                        <button type="button" class="btn btn-info btn-lg" style="background-color: #17a2b8; border-color: #17a2b8; color: white; margin-right: 15px; border-radius: 25px; padding: 10px 30px;" id="preview"><i class="fa fa-file-text"></i> Preview</button> 
                                        <button type="submit" class="btn btn-success btn-lg" style="background-color: #28a745; border-color: #28a745; color: white; border-radius: 25px; padding: 10px 30px;" name="vote"><i class="fa fa-check-square-o"></i> Submit Vote</button>
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

<!-- Candidate Details Modal -->
<div class="modal fade" id="candidateModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header" style="background-color: #4a90e2; color: white; border-radius: 15px 15px 0 0;">
                <h4 class="modal-title">Candidate Information</h4>
            </div>
            <div class="modal-body" style="padding: 30px;">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <img id="candidatePhoto" src="" class="img-responsive" style="border-radius: 10px; max-height: 200px; margin: 0 auto;">
                    </div>
                    <div class="col-md-8">
                        <h3 id="candidateName" style="color: #2c5aa0; margin-bottom: 20px;"></h3>
                        <h5 style="color: #666; margin-bottom: 10px;">Platform:</h5>
                        <div id="candidatePlatform" style="background-color: #f8f9fa; padding: 15px; border-radius: 8px; border-left: 4px solid #4a90e2;"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="text-align: center;">
                <button type="button" class="btn btn-primary" id="selectCandidate" style="background-color: #4a90e2; border-color: #4a90e2; border-radius: 25px; padding: 10px 30px;">Select This Candidate</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius: 25px; padding: 10px 30px;">Close</button>
            </div>
        </div>
    </div>
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

    // Show floating alert message (auto fade)
    function showAlert(msg, type = 'danger') {
        const alertId = (type === 'success') ? '#info-alert' : '#alert';
        const msgClass = (type === 'success') ? '.info-message' : '.message';

        $(alertId).removeClass('alert-danger alert-success alert-info')
                  .addClass('alert-' + type)
                  .find(msgClass).html(msg);
        $(alertId).stop(true, true).fadeIn(500);
        setTimeout(() => $(alertId).fadeOut(1000), 20000);
    }

    // AJAX Search on input
    $('.candidate-search').on('input', function() {
        let val = $(this).val().trim();
        let posId = $(this).data('position');
        let maxVote = $(this).data('max-vote');
        let slug = $(this).data('slug');
        let $results = $('#results_' + posId);
        let $list = $results.find('.candidates-list');

        if (val.length < 2) {
            $results.hide();
            return;
        }

        $list.html('<div class="text-center"><i class="fa fa-spinner fa-spin"></i> Searching...</div>');
        $results.show();

        $.ajax({
            url: 'search_candidates.php',
            method: 'POST',
            data: {search: val, position_id: posId},
            dataType: 'json',
            timeout: 10000,
            success: function(resp) {
                if (!Array.isArray(resp)) {
                    $list.html('<p class="text-danger text-center">Invalid response</p>');
                    return;
                }
                if (resp.length === 0) {
                    $list.html('<p class="text-muted text-center"><i class="fa fa-search"></i> No candidates found</p>');
                    return;
                }

                let html = resp.map(c => {
                    let photo = c.photo ? 'images/' + c.photo : 'images/profile.jpg';
                    let platform = c.platform || 'No platform information available';
                    return `
                        <div class="candidate-item" data-candidate-id="${c.id}" data-firstname="${c.firstname}"
                             data-lastname="${c.lastname}" data-photo="${photo}" data-platform="${platform}"
                             data-position="${posId}" data-slug="${slug}" data-max-vote="${maxVote}"
                             style="border:2px solid #e3f2fd; border-radius:10px; padding:15px; margin-bottom:10px; background:#fff; cursor:pointer;">
                            <div class="row">
                                <div class="col-md-3"><img src="${photo}" style="max-height:100px; width:100%; object-fit:cover; border-radius:8px;" onerror="this.src='images/profile.jpg'"></div>
                                <div class="col-md-6">
                                    <h5 style="color:#2c5aa0;">${c.firstname} ${c.lastname}</h5>
                                    <p style="color:#666; font-size:14px;">${platform.substring(0,100)}${platform.length > 100 ? '...' : ''}</p>
                                </div>
                                <div class="col-md-3 text-center">
                                    <button type="button" class="btn btn-success btn-sm select-candidate" style="border-radius:20px; width:100%;"><i class="fa fa-check"></i> Select</button>
                                </div>
                            </div>
                        </div>`;
                }).join('');
                $list.html(html);
            },
            error: function(xhr, status) {
                let errMsg = 'Search failed. ';
                if (status === 'timeout') errMsg += 'Request timed out. Please try again.';
                else if (status === 'error') errMsg += 'Server error. Please try later.';
                else errMsg += 'Check connection and try again.';
                $list.html('<p class="text-danger text-center">' + errMsg + '</p>');
                showAlert(errMsg);
            }
        });
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
            $container.html('<p class="text-muted text-center" style="margin:0;">No candidates selected yet</p>');
            $('#search-container-' + position).show(); // Show search if none selected
        } else {
            let html = candidates.map(c => `
                <div class="selected-candidate" style="border:2px solid #4a90e2; border-radius:8px; padding:10px; margin-bottom:10px; background:#fff;">
                    <div class="row">
                        <div class="col-md-2"><img src="${c.photo}" style="max-height:60px; object-fit:cover; border-radius:5px;" onerror="this.src='images/profile.jpg'"></div>
                        <div class="col-md-8">
                            <h6 style="color:#2c5aa0; margin:0; font-weight:bold;">${c.firstname} ${c.lastname}</h6>
                            <p style="color:#666; margin:5px 0 0; font-size:14px;">${c.platform.substring(0,50)}${c.platform.length > 50 ? '...' : ''}</p>
                        </div>
                        <div class="col-md-2 text-right">
                            <button type="button" class="btn btn-danger btn-xs remove-candidate" data-position="${position}" data-candidate-id="${c.id}" style="border-radius:15px;" title="Remove candidate">
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

            if (removed) showAlert(`${removed.firstname} ${removed.lastname} removed.`, 'info');
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

    // Preview button click
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

    // Vote form submission
    $('#ballotForm').submit(function(e) {
        e.preventDefault();
        let formData = $(this).serialize();
        if (!formData) {
            showAlert('Select at least one candidate before submitting.', 'warning');
            return false;
        }

        if (!confirm('Are you sure you want to submit your vote? This action cannot be undone.')) {
            return false;
        }

        let $btn = $('button[name="vote"]');
        $btn.html('<i class="fa fa-spinner fa-spin"></i> Submitting...').prop('disabled', true);

        $.ajax({
            type: 'POST',
            url: 'submit_ballot.php',
            data: formData,
            dataType: 'json',
            success: function(resp) {
                if (resp.success) {
                    showAlert('Vote submitted successfully!', 'success');
                    setTimeout(() => location.reload(), 2000);
                } else {
                    showAlert(resp.message || 'Failed to submit vote. Try again.', 'danger');
                    $btn.html('<i class="fa fa-check-square-o"></i> Submit Vote').prop('disabled', false);
                }
            },
            error: function() {
                showAlert('Failed to submit vote. Check your connection and try again.', 'danger');
                $btn.html('<i class="fa fa-check-square-o"></i> Submit Vote').prop('disabled', false);
            }
        });
    });
});
</script>

<style>
/* --- Styles as in your original code with minor cleanup for alerts --- */

body {
    background-color: #ffffff !important;
    font-family: Arial, sans-serif;
}

.content-wrapper {
    background-color: #ffffff !important;
}

/* Floating alert styles */
.floating-alert {
    position: fixed !important;
    top: 20px;
    right: 20px;
    z-index: 9999;
    max-width: 400px;
    min-width: 300px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    border-radius: 8px;
    animation: slideInRight 0.5s ease;
    padding: 15px 20px;
}

@keyframes slideInRight {
    0% {
        transform: translateX(100%);
        opacity: 0;
    }
    100% {
        transform: translateX(0);
        opacity: 1;
    }
}

.candidate-item {
    transition: all 0.3s ease;
}

.candidate-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(74, 144, 226, 0.3);
}

.search-container .form-control:focus {
    border-color: #4a90e2;
    box-shadow: 0 0 5px rgba(74, 144, 226, 0.3);
}

.btn:hover {
    transform: translateY(-1px);
    transition: all 0.3s ease;
}

.selected-candidate {
    transition: all 0.3s ease;
}

.selected-candidate:hover {
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.fa-spinner {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.btn-primary:hover {
    background-color: #357abd;
    border-color: #357abd;
}

.btn-success:hover {
    background-color: #218838;
    border-color: #218838;
}

.btn-info:hover {
    background-color: #138496;
    border-color: #138496;
}

.btn-warning:hover {
    background-color: #e0a800;
    border-color: #e0a800;
}

.btn-danger:hover {
    background-color: #c82333;
    border-color: #c82333;
}

.search-results {
    max-height: 400px;
    overflow-y: auto;
    border: 1px solid #e3f2fd;
    border-radius: 8px;
    padding: 10px;
    background-color: #fafafa;
}

.search-results::-webkit-scrollbar {
    width: 8px;
}

.search-results::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.search-results::-webkit-scrollbar-thumb {
    background: #4a90e2;
    border-radius: 10px;
}

.search-results::-webkit-scrollbar-thumb:hover {
    background: #357abd;
}

.selected-list {
    max-height: 300px;
    overflow-y: auto;
}

.selected-list::-webkit-scrollbar {
    width: 6px;
}

.selected-list::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.selected-list::-webkit-scrollbar-thumb {
    background: #4a90e2;
    border-radius: 10px;
}

@media (max-width: 768px) {
    .floating-alert {
        right: 10px;
        left: 10px;
        max-width: none;
        min-width: auto;
    }
    
    .candidate-item .col-md-3,
    .candidate-item .col-md-6,
    .candidate-item .col-md-8 {
        margin-bottom: 10px;
    }
    
    .selected-candidate .col-md-2,
    .selected-candidate .col-md-8 {
        margin-bottom: 5px;
    }
}

.modal-content {
    border: none;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
}

.modal-header {
    border-bottom: 1px solid #dee2e6;
}

.modal-footer {
    border-top: 1px solid #dee2e6;
}

.box {
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: box-shadow 0.3s ease;
}

.box:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.alert {
    border: none;
    border-left: 4px solid;
    padding: 15px 20px;
}

.alert-danger {
    border-left-color: #dc3545;
    background-color: #f8d7da;
    color: #721c24;
}

.alert-success {
    border-left-color: #28a745;
    background-color: #d4edda;
    color: #155724;
}

.alert-warning {
    border-left-color: #ffc107;
    background-color: #fff3cd;
    color: #856404;
}

.alert-info {
    border-left-color: #17a2b8;
    background-color: #d1ecf1;
    color: #0c5460;
}

.title {
    text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
    margin-bottom: 30px;
}

.input-group .form-control:focus {
    box-shadow: none;
    border-color: #4a90e2;
}

.input-group-btn .btn {
    border-left: none;
}

.candidate-item img,
.selected-candidate img {
    border: 2px solid #e3f2fd;
    transition: border-color 0.3s ease;
}

.candidate-item:hover img {
    border-color: #4a90e2;
}

.candidate-item p {
    line-height: 1.4;
    margin-bottom: 0;
}

.text-center .btn {
    margin: 0 5px;
}

@media (max-width: 576px) {
    .text-center .btn {
        margin: 5px 0;
        display: block;
        width: 100%;
    }
}
</style>

</body>
</html>
