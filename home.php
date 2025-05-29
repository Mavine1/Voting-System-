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
                            if(isset($_SESSION['error'])){
                                ?>
                                <div class="alert alert-danger alert-dismissible floating-alert" id="error-alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <ul>
                                        <?php
                                            foreach($_SESSION['error'] as $error){
                                                echo "
                                                    <li>".$error."</li>
                                                ";
                                            }
                                        ?>
                                    </ul>
                                </div>
                                <?php
                                unset($_SESSION['error']);
                            }
                            if(isset($_SESSION['success'])){
                                echo "
                                    <div class='alert alert-success alert-dismissible floating-alert' id='success-alert'>
                                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                        <h4><i class='icon fa fa-check'></i> Success!</h4>
                                        ".$_SESSION['success']."
                                    </div>
                                ";
                                unset($_SESSION['success']);
                            }
                        ?>
    
                        <div class="alert alert-danger alert-dismissible floating-alert" id="alert" style="display:none;">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <span class="message"></span>
                        </div>

                        <div class="alert alert-info alert-dismissible floating-alert" id="info-alert" style="display:none;">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
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
                            }
                            else{
                                ?>
                                <!-- Voting Ballot -->
                                <form method="POST" id="ballotForm" action="submit_ballot.php">
                                    <?php
                                        include 'includes/slugify.php';

                                        $sql = "SELECT * FROM positions ORDER BY priority ASC";
                                        $query = $conn->query($sql);
                                        while($row = $query->fetch_assoc()){
                                            $slug = slugify($row['description']);
                                            $instruct = ($row['max_vote'] > 1) ? 'You may select up to '.$row['max_vote'].' candidates' : 'Select only one candidate';

                                            echo '
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="box" style="background-color: #f8f9fa; border: 2px solid #e3f2fd; border-radius: 8px; margin-bottom: 20px;" id="'.$row['id'].'">
                                                            <div class="box-header with-border" style="background-color: #e3f2fd; border-radius: 6px 6px 0 0;">
                                                                <h3 class="box-title" style="color: #2c5aa0; font-weight: bold;">'.$row['description'].'</h3>
                                                            </div>
                                                            <div class="box-body" style="padding: 20px;">
                                                                <p style="color: #333; margin-bottom: 15px;">'.$instruct.'</p>
                                                                
                                                                <!-- Search Container - Initially visible -->
                                                                <div class="search-container" id="search-container-'.$row['id'].'" style="margin-bottom: 20px;">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control candidate-search" placeholder="Search candidates by first name or last name..." style="border: 2px solid #4a90e2; border-radius: 25px 0 0 25px; padding: 10px 15px;" data-position="'.$row['id'].'" data-slug="'.$slug.'" data-max-vote="'.$row['max_vote'].'">
                                                                        <span class="input-group-btn">
                                                                            <button class="btn btn-primary search-btn" type="button" style="background-color: #4a90e2; border-color: #4a90e2; border-radius: 0 25px 25px 0; padding: 10px 20px;"><i class="fa fa-search"></i></button>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                
                                                                <!-- Search Results -->
                                                                <div class="search-results" id="results_'.$row['id'].'" style="display: none;">
                                                                    <h5 style="color: #2c5aa0; margin-bottom: 15px;">Search Results:</h5>
                                                                    <div class="candidates-list"></div>
                                                                </div>
                                                                
                                                                <!-- Selected Candidates -->
                                                                <div class="selected-candidates" id="selected_'.$row['id'].'">
                                                                    <h5 style="color: #2c5aa0; margin-bottom: 15px;">Selected Candidates:</h5>
                                                                    <div class="selected-list" style="min-height: 50px; border: 2px dashed #ddd; padding: 15px; border-radius: 8px; background-color: #f9f9f9;">
                                                                        <p class="text-muted text-center" style="margin: 0;">No candidates selected yet</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            ';
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
                <button type="button" class="close" data-dismiss="modal" style="color: white;">
                    <span>&times;</span>
                </button>
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
$(document).ready(function(){
    let selectedCandidates = {};
    let currentCandidate = null;
    
    // Auto-fade messages after 20 seconds
    function setupAutoFadeMessages() {
        $('.floating-alert').each(function() {
            if ($(this).is(':visible')) {
                setTimeout(() => {
                    $(this).fadeOut(1000);
                }, 20000); // 20 seconds
            }
        });
    }
    
    // Show floating message
    function showFloatingMessage(message, type = 'danger') {
        let alertId = type === 'success' ? '#info-alert' : '#alert';
        let messageClass = type === 'success' ? '.info-message' : '.message';
        
        $(alertId).find(messageClass).html(message);
        $(alertId).removeClass('alert-danger alert-success alert-info')
                  .addClass('alert-' + type)
                  .fadeIn(500);
        
        // Auto-fade after 20 seconds
        setTimeout(() => {
            $(alertId).fadeOut(1000);
        }, 20000);
    }
    
    // Initialize auto-fade for existing messages
    setupAutoFadeMessages();
    
    // AJAX Search functionality with enhanced error handling
    $('.candidate-search').on('input', function(){
        let searchTerm = $(this).val().trim();
        let positionId = $(this).data('position');
        let slug = $(this).data('slug');
        let maxVote = $(this).data('max-vote');
        
        if(searchTerm.length >= 2) {
            // Show loading state
            let resultsContainer = $('#results_' + positionId);
            let candidatesList = resultsContainer.find('.candidates-list');
            candidatesList.html('<div class="text-center"><i class="fa fa-spinner fa-spin"></i> Searching...</div>');
            resultsContainer.show();
            
            $.ajax({
                url: 'search_candidates.php',
                method: 'POST',
                data: {
                    search: searchTerm,
                    position_id: positionId
                },
                dataType: 'json',
                timeout: 10000, // 10 second timeout
                success: function(response) {
                    if (response && Array.isArray(response)) {
                        displaySearchResults(response, positionId, slug, maxVote);
                    } else {
                        candidatesList.html('<p class="text-center text-danger">Invalid response from server</p>');
                    }
                },
                error: function(xhr, status, error) {
                    let errorMessage = 'Search failed. ';
                    if (status === 'timeout') {
                        errorMessage += 'Request timed out. Please try again.';
                    } else if (status === 'error') {
                        errorMessage += 'Server error. Please try again later.';
                    } else {
                        errorMessage += 'Please check your connection and try again.';
                    }
                    candidatesList.html('<p class="text-center text-danger">' + errorMessage + '</p>');
                    showFloatingMessage(errorMessage, 'danger');
                }
            });
        } else if(searchTerm.length === 0) {
            $('#results_' + positionId).hide();
        }
    });
    
    // Display search results with enhanced UI
    function displaySearchResults(candidates, positionId, slug, maxVote) {
        let resultsContainer = $('#results_' + positionId);
        let candidatesList = resultsContainer.find('.candidates-list');
        
        if(candidates.length > 0) {
            let html = '';
            candidates.forEach(function(candidate) {
                let photo = candidate.photo ? 'images/' + candidate.photo : 'images/profile.jpg';
                let platform = candidate.platform || 'No platform information available';
                
                html += `
                    <div class="candidate-item" style="border: 2px solid #e3f2fd; border-radius: 10px; padding: 15px; margin-bottom: 10px; background-color: white; cursor: pointer; transition: all 0.3s;" 
                         data-candidate-id="${candidate.id}" 
                         data-firstname="${candidate.firstname || ''}" 
                         data-lastname="${candidate.lastname || ''}" 
                         data-photo="${photo}" 
                         data-platform="${platform}"
                         data-position="${positionId}"
                         data-slug="${slug}"
                         data-max-vote="${maxVote}">
                        <div class="row">
                            <div class="col-md-3">
                                <img src="${photo}" class="img-responsive" style="border-radius: 8px; max-height: 100px; width: 100%; object-fit: cover;" 
                                     onerror="this.src='images/profile.jpg'">
                            </div>
                            <div class="col-md-6">
                                <h5 style="color: #2c5aa0; margin-bottom: 5px;">${candidate.firstname} ${candidate.lastname}</h5>
                                <p style="color: #666; font-size: 14px;">${platform.substring(0, 100)}${platform.length > 100 ? '...' : ''}</p>
                            </div>
                            <div class="col-md-3 text-center">
                                <button type="button" class="btn btn-success btn-sm select-candidate" style="background-color: #28a745; border-radius: 20px; width: 100%; margin-bottom: 5px;">
                                    <i class="fa fa-check"></i> Select
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            });
            candidatesList.html(html);
            resultsContainer.show();
        } else {
            candidatesList.html('<p class="text-center text-muted"><i class="fa fa-search"></i> No candidates found matching your search</p>');
            resultsContainer.show();
        }
    }
    
    // Function to select candidate with enhanced validation
    function selectCandidate(candidate) {
        if(!selectedCandidates[candidate.position]) {
            selectedCandidates[candidate.position] = [];
        }
        
        // Check if candidate is already selected
        let alreadySelected = selectedCandidates[candidate.position].find(c => c.id === candidate.id);
        if(alreadySelected) {
            showFloatingMessage('This candidate is already selected!', 'warning');
            return;
        }
        
        // Check max vote limit
        if(selectedCandidates[candidate.position].length >= candidate.maxVote) {
            showFloatingMessage(`You can only select up to ${candidate.maxVote} candidate(s) for this position.`, 'warning');
            return;
        }
        
        selectedCandidates[candidate.position].push(candidate);
        updateSelectedCandidates(candidate.position);
        updateHiddenInputs(candidate.position, candidate.slug, candidate.maxVote);
        
        // Hide search container for this position
        $('#search-container-' + candidate.position).hide();
        
        showFloatingMessage(`${candidate.firstname} ${candidate.lastname} has been selected successfully!`, 'success');
    }
    
    // Update selected candidates display
    function updateSelectedCandidates(positionId) {
        let container = $('#selected_' + positionId + ' .selected-list');
        let candidates = selectedCandidates[positionId] || [];
        
        if(candidates.length === 0) {
            container.html('<p class="text-muted text-center" style="margin: 0;">No candidates selected yet</p>');
            // Show search container when no candidates are selected
            $('#search-container-' + positionId).show();
        } else {
            let html = '';
            candidates.forEach(function(candidate, index) {
                html += `
                    <div class="selected-candidate" style="border: 2px solid #4a90e2; border-radius: 8px; padding: 10px; margin-bottom: 10px; background-color: white; animation: slideIn 0.3s ease;">
                        <div class="row">
                            <div class="col-md-2">
                                <img src="${candidate.photo}" class="img-responsive" style="border-radius: 5px; max-height: 60px; object-fit: cover;" 
                                     onerror="this.src='images/profile.jpg'">
                            </div>
                            <div class="col-md-8">
                                <h6 style="color: #2c5aa0; margin: 0; font-weight: bold;">${candidate.firstname} ${candidate.lastname}</h6>
                                <p style="color: #666; margin: 5px 0 0 0; font-size: 14px;">${candidate.platform.substring(0, 50)}${candidate.platform.length > 50 ? '...' : ''}</p>
                            </div>
                            <div class="col-md-2 text-right">
                                <button type="button" class="btn btn-danger btn-xs remove-candidate" data-position="${positionId}" data-candidate-id="${candidate.id}" style="border-radius: 15px;" title="Remove candidate">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            });
            container.html(html);
        }
    }
    
    // Remove selected candidate
    $(document).on('click', '.remove-candidate', function() {
        let positionId = $(this).data('position');
        let candidateId = $(this).data('candidate-id');
        
        let removedCandidate = selectedCandidates[positionId].find(c => c.id === candidateId);
        selectedCandidates[positionId] = selectedCandidates[positionId].filter(c => c.id !== candidateId);
        updateSelectedCandidates(positionId);
        
        // Update hidden inputs
        let position = selectedCandidates[positionId];
        if(position && position.length > 0) {
            updateHiddenInputs(positionId, position[0].slug, position[0].maxVote);
        } else {
            // Remove all hidden inputs for this position
            let slug = $('.candidate-search[data-position="' + positionId + '"]').data('slug');
            $(`input[name^="${slug}"]`).remove();
        }
        
        if (removedCandidate) {
            showFloatingMessage(`${removedCandidate.firstname} ${removedCandidate.lastname} has been removed from your selection.`, 'info');
        }
    });
    
    // Update hidden inputs for form submission
    function updateHiddenInputs(positionId, slug, maxVote) {
        // Remove existing hidden inputs for this position
        $(`input[name^="${slug}"]`).remove();
        
        let candidates = selectedCandidates[positionId] || [];
        let inputName = maxVote > 1 ? slug + '[]' : slug;
        
        candidates.forEach(function(candidate) {
            $('<input>').attr({
                type: 'hidden',
                name: inputName,
                value: candidate.id
            }).appendTo('#ballotForm');
        });
    }
    
    // Select candidate directly from search results
    $(document).on('click', '.select-candidate', function(e) {
        e.stopPropagation();
        let item = $(this).closest('.candidate-item');
        let candidate = {
            id: item.data('candidate-id'),
            firstname: item.data('firstname'),
            lastname: item.data('lastname'),
            photo: item.data('photo'),
            platform: item.data('platform'),
            position: item.data('position'),
            slug: item.data('slug'),
            maxVote: item.data('max-vote')
        };
        selectCandidate(candidate);
    });
    
    // Enhanced Preview functionality
    $('#preview').click(function(e) {
        e.preventDefault();
        let form = $('#ballotForm').serialize();
        if(form === '') {
            showFloatingMessage('You must vote for at least one candidate before previewing.', 'warning');
        } else {
            // Show loading state
            $(this).html('<i class="fa fa-spinner fa-spin"></i> Loading Preview...');
            $(this).prop('disabled', true);
            
            $.ajax({
                type: 'POST',
                url: 'preview.php',
                data: form,
                dataType: 'json',
                timeout: 15000,
                success: function(response) {
                    if(response.error) {
                        let errmsg = '';
                        let messages = response.message;
                        for (let i in messages) {
                            errmsg += messages[i] + '<br>'; 
                        }
                        showFloatingMessage(errmsg, 'danger');
                    } else {
                        $('#preview_modal').modal('show');
                        $('#preview_body').html(response.list);
                    }
                },
                error: function(xhr, status, error) {
                    let errorMessage = 'Failed to load preview. ';
                    if (status === 'timeout') {
                        errorMessage += 'Request timed out.';
                    } else {
                        errorMessage += 'Please try again.';
                    }
                    showFloatingMessage(errorMessage, 'danger');
                },
                complete: function() {
                    $('#preview').html('<i class="fa fa-file-text"></i> Preview');
                    $('#preview').prop('disabled', false);
                }
            });
        }
    });
    
    // Enhanced form submission
    $('#ballotForm').on('submit', function(e) {
        e.preventDefault();
        
        let formData = $(this).serialize();
        if(formData === '') {
            showFloatingMessage('You must select at least one candidate before submitting your vote.', 'warning');
            return false;
        }
        
        if (confirm('Are you sure you want to submit your vote? This action cannot be undone.')) {
            $('button[name="vote"]').html('<i class="fa fa-spinner fa-spin"></i> Submitting...');
            $('button[name="vote"]').prop('disabled', true);
            
            $.ajax({
                type: 'POST',
                url: 'submit_ballot.php',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if(response.success) {
                        showFloatingMessage('Your vote has been submitted successfully!', 'success');
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    } else {
                        showFloatingMessage(response.message || 'Failed to submit vote. Please try again.', 'danger');
                        $('button[name="vote"]').html('<i class="fa fa-check-square-o"></i> Submit Vote');
                        $('button[name="vote"]').prop('disabled', false);
                    }
                },
                error: function() {
                    showFloatingMessage('Failed to submit vote. Please check your connection and try again.', 'danger');
                    $('button[name="vote"]').html('<i class="fa fa-check-square-o"></i> Submit Vote');
                    $('button[name="vote"]').prop('disabled', false);
                }
            });
        }
    });
    
    // Style enhancements with smoother animations
    $(document).on('mouseenter', '.candidate-item', function() {
        $(this).css({
            'border-color': '#4a90e2',
            'box-shadow': '0 4px 8px rgba(74, 144, 226, 0.3)',
            'transform': 'translateY(-2px)'
        });
    });
    
    $(document).on('mouseleave', '.candidate-item', function() {
        $(this).css({
            'border-color': '#e3f2fd',
            'box-shadow': 'none',
            'transform': 'translateY(0)'
        });
    });
    
    // Close alert manually
    $(document).on('click', '.floating-alert .close', function() {
        $(this).closest('.floating-alert').fadeOut(500);
    });
});
</script>

<style>
body {
    background-color: #ffffff !important;
    font-family: Arial, sans-serif;
}

.content-wrapper {
    background-color: #ffffff !important;
}

/* Floating alert styles for right corner positioning */
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

@keyframes slideIn {
    0% {
        transform: translateX(-10px);
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

/* Loading spinner */
.fa-spinner {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Enhanced button styles */
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

/* Search results styling */
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

/* Selected candidates area styling */
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

/* Responsive adjustments */
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

/* Modal enhancements */
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

/* Form enhancements */
.box {
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: box-shadow 0.3s ease;
}

.box:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

/* Alert enhancements */
.alert {
    border: none;
    border-left: 4px solid;
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

/* Title styling */
.title {
    text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
    margin-bottom: 30px;
}

/* Input group enhancements */
.input-group .form-control:focus {
    box-shadow: none;
    border-color: #4a90e2;
}

.input-group-btn .btn {
    border-left: none;
}

/* Candidate photo styling */
.candidate-item img,
.selected-candidate img {
    border: 2px solid #e3f2fd;
    transition: border-color 0.3s ease;
}

.candidate-item:hover img {
    border-color: #4a90e2;
}

/* Platform text styling */
.candidate-item p {
    line-height: 1.4;
    margin-bottom: 0;
}

/* Button group spacing */
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
