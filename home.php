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
				        	<div class="alert alert-danger alert-dismissible">
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
				            	<div class='alert alert-success alert-dismissible'>
				              		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				              		<h4><i class='icon fa fa-check'></i> Success!</h4>
				              	".$_SESSION['success']."
				            	</div>
				          	";
				          	unset($_SESSION['success']);
				        }

				    ?>
 
				    <div class="alert alert-danger alert-dismissible" id="alert" style="display:none;">
		        		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			        	<span class="message"></span>
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
															<p style="color: #333; margin-bottom: 15px;">'.$instruct.'
																<span class="pull-right">
																	<button type="button" class="btn btn-warning btn-sm reset" style="background-color: #ffc107; border-color: #ffc107; color: #333; border-radius: 20px;" data-desc="'.$slug.'"><i class="fa fa-refresh"></i> Reset</button>
																</span>
															</p>
															
															<!-- Search Input -->
															<div class="search-container" style="margin-bottom: 20px;">
																<div class="input-group">
																	<input type="text" class="form-control candidate-search" placeholder="Search candidates by first name or last name..." style="border: 2px solid #4a90e2; border-radius: 25px 0 0 25px; padding: 10px 15px;" data-position="'.$row['id'].'" data-slug="'.$slug.'" data-max-vote="'.$row['max_vote'].'">
																	<span class="input-group-btn">
																		<button class="btn btn-primary" type="button" style="background-color: #4a90e2; border-color: #4a90e2; border-radius: 0 25px 25px 0; padding: 10px 20px;"><i class="fa fa-search"></i></button>
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

<!-- AJAX Search Script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
$(document).ready(function(){
    let selectedCandidates = {};
    let currentCandidate = null;
    
    // Search functionality
    $('.candidate-search').on('input', function(){
        let searchTerm = $(this).val();
        let positionId = $(this).data('position');
        let slug = $(this).data('slug');
        let maxVote = $(this).data('max-vote');
        
        if(searchTerm.length >= 2) {
            $.ajax({
                url: 'search_candidates.php',
                method: 'POST',
                data: {
                    search: searchTerm,
                    position_id: positionId
                },
                dataType: 'json',
                success: function(response) {
                    displaySearchResults(response, positionId, slug, maxVote);
                }
            });
        } else {
            $('#results_' + positionId).hide();
        }
    });
    
    // Display search results
    function displaySearchResults(candidates, positionId, slug, maxVote) {
        let resultsContainer = $('#results_' + positionId);
        let candidatesList = resultsContainer.find('.candidates-list');
        
        if(candidates.length > 0) {
            let html = '';
            candidates.forEach(function(candidate) {
                let photo = candidate.photo ? 'images/' + candidate.photo : 'images/profile.jpg';
                html += `
                    <div class="candidate-item" style="border: 2px solid #e3f2fd; border-radius: 10px; padding: 15px; margin-bottom: 10px; background-color: white; cursor: pointer; transition: all 0.3s;" 
                         data-candidate-id="${candidate.id}" 
                         data-firstname="${candidate.firstname}" 
                         data-lastname="${candidate.lastname}" 
                         data-photo="${photo}" 
                         data-platform="${candidate.platform}"
                         data-position="${positionId}"
                         data-slug="${slug}"
                         data-max-vote="${maxVote}">
                        <div class="row">
                            <div class="col-md-3">
                                <img src="${photo}" class="img-responsive" style="border-radius: 8px; max-height: 100px; width: 100%;">
                            </div>
                            <div class="col-md-6">
                                <h5 style="color: #2c5aa0; margin-bottom: 5px;">${candidate.firstname} ${candidate.lastname}</h5>
                                <p style="color: #666; font-size: 14px;">${candidate.platform.substring(0, 100)}${candidate.platform.length > 100 ? '...' : ''}</p>
                            </div>
                            <div class="col-md-3 text-center">
                                <button type="button" class="btn btn-info btn-sm view-details" style="background-color: #17a2b8; border-radius: 20px; margin-bottom: 5px;">
                                    <i class="fa fa-eye"></i> View Details
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            });
            candidatesList.html(html);
            resultsContainer.show();
        } else {
            candidatesList.html('<p class="text-center text-muted">No candidates found</p>');
            resultsContainer.show();
        }
    }
    
    // View candidate details
    $(document).on('click', '.view-details', function(e) {
        e.stopPropagation();
        let item = $(this).closest('.candidate-item');
        currentCandidate = {
            id: item.data('candidate-id'),
            firstname: item.data('firstname'),
            lastname: item.data('lastname'),
            photo: item.data('photo'),
            platform: item.data('platform'),
            position: item.data('position'),
            slug: item.data('slug'),
            maxVote: item.data('max-vote')
        };
        
        $('#candidatePhoto').attr('src', currentCandidate.photo);
        $('#candidateName').text(currentCandidate.firstname + ' ' + currentCandidate.lastname);
        $('#candidatePlatform').html(currentCandidate.platform);
        $('#candidateModal').modal('show');
    });
    
    // Select candidate from modal
    $('#selectCandidate').click(function() {
        if(currentCandidate) {
            selectCandidate(currentCandidate);
            $('#candidateModal').modal('hide');
        }
    });
    
    // Select candidate directly from search results
    $(document).on('click', '.candidate-item', function() {
        let candidate = {
            id: $(this).data('candidate-id'),
            firstname: $(this).data('firstname'),
            lastname: $(this).data('lastname'),
            photo: $(this).data('photo'),
            platform: $(this).data('platform'),
            position: $(this).data('position'),
            slug: $(this).data('slug'),
            maxVote: $(this).data('max-vote')
        };
        selectCandidate(candidate);
    });
    
    // Function to select candidate
    function selectCandidate(candidate) {
        if(!selectedCandidates[candidate.position]) {
            selectedCandidates[candidate.position] = [];
        }
        
        // Check if candidate is already selected
        let alreadySelected = selectedCandidates[candidate.position].find(c => c.id === candidate.id);
        if(alreadySelected) {
            alert('This candidate is already selected!');
            return;
        }
        
        // Check max vote limit
        if(selectedCandidates[candidate.position].length >= candidate.maxVote) {
            alert(`You can only select up to ${candidate.maxVote} candidate(s) for this position.`);
            return;
        }
        
        selectedCandidates[candidate.position].push(candidate);
        updateSelectedCandidates(candidate.position);
        updateHiddenInputs(candidate.position, candidate.slug, candidate.maxVote);
    }
    
    // Update selected candidates display
    function updateSelectedCandidates(positionId) {
        let container = $('#selected_' + positionId + ' .selected-list');
        let candidates = selectedCandidates[positionId] || [];
        
        if(candidates.length === 0) {
            container.html('<p class="text-muted text-center" style="margin: 0;">No candidates selected yet</p>');
        } else {
            let html = '';
            candidates.forEach(function(candidate, index) {
                html += `
                    <div class="selected-candidate" style="border: 2px solid #4a90e2; border-radius: 8px; padding: 10px; margin-bottom: 10px; background-color: white;">
                        <div class="row">
                            <div class="col-md-2">
                                <img src="${candidate.photo}" class="img-responsive" style="border-radius: 5px; max-height: 60px;">
                            </div>
                            <div class="col-md-8">
                                <h6 style="color: #2c5aa0; margin: 0;">${candidate.firstname} ${candidate.lastname}</h6>
                            </div>
                            <div class="col-md-2 text-right">
                                <button type="button" class="btn btn-danger btn-xs remove-candidate" data-position="${positionId}" data-candidate-id="${candidate.id}" style="border-radius: 15px;">
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
        
        selectedCandidates[positionId] = selectedCandidates[positionId].filter(c => c.id !== candidateId);
        updateSelectedCandidates(positionId);
        
        // Update hidden inputs
        let position = Object.values(selectedCandidates).find(pos => pos.length > 0 && pos[0].position === positionId);
        if(position && position.length > 0) {
            updateHiddenInputs(positionId, position[0].slug, position[0].maxVote);
        } else {
            // Remove all hidden inputs for this position
            $(`input[name^="${$('.candidate-search[data-position="' + positionId + '"]').data('slug')}"]`).remove();
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
    
    // Reset functionality
    $(document).on('click', '.reset', function(e) {
        e.preventDefault();
        let desc = $(this).data('desc');
        let positionId = $('.candidate-search[data-slug="' + desc + '"]').data('position');
        
        selectedCandidates[positionId] = [];
        updateSelectedCandidates(positionId);
        $(`input[name^="${desc}"]`).remove();
        $('.candidate-search[data-slug="' + desc + '"]').val('');
        $('#results_' + positionId).hide();
    });
    
    // Preview functionality
    $('#preview').click(function(e) {
        e.preventDefault();
        let form = $('#ballotForm').serialize();
        if(form === '') {
            $('.message').html('You must vote for at least one candidate');
            $('#alert').show();
        } else {
            $.ajax({
                type: 'POST',
                url: 'preview.php',
                data: form,
                dataType: 'json',
                success: function(response) {
                    if(response.error) {
                        let errmsg = '';
                        let messages = response.message;
                        for (let i in messages) {
                            errmsg += messages[i]; 
                        }
                        $('.message').html(errmsg);
                        $('#alert').show();
                    } else {
                        $('#preview_modal').modal('show');
                        $('#preview_body').html(response.list);
                    }
                }
            });
        }
    });
    
    // Style enhancements
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
</style>

</body>
</html>