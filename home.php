<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Election Voting System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
            font-family: 'Arial', sans-serif;
        }

        /* Animated Background Elements */
        .floating-icons {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
            overflow: hidden;
        }

        .floating-icon {
            position: absolute;
            color: rgba(255, 255, 255, 0.1);
            animation: float 15s infinite linear;
        }

        .floating-icon.award {
            font-size: 3rem;
        }

        .floating-icon.book {
            font-size: 2.5rem;
        }

        .floating-icon.trophy {
            font-size: 3.5rem;
        }

        @keyframes float {
            0% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-100px) rotate(360deg);
                opacity: 0;
            }
        }

        /* Content Wrapper */
        .content-wrapper {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            min-height: 100vh;
            position: relative;
            z-index: 2;
            border-radius: 20px;
            margin: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .container {
            background: transparent;
            padding: 40px 20px;
        }

        /* Header Styling */
        .page-header {
            color: #2c5aa0;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 40px;
            font-weight: bold;
        }

        /* Alert Styling */
        .floating-alert {
            border-radius: 15px;
            border: none;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        /* Voting Box Styling */
        .box {
            background: linear-gradient(145deg, #f8f9fa, #e9ecef);
            border: 3px solid #4a90e2;
            border-radius: 20px;
            margin-bottom: 30px;
            box-shadow: 0 15px 30px rgba(74, 144, 226, 0.2);
            transition: all 0.3s ease;
        }

        .box:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(74, 144, 226, 0.3);
        }

        .box-header {
            background: linear-gradient(135deg, #4a90e2, #2c5aa0);
            color: white;
            border-radius: 17px 17px 0 0;
            padding: 20px;
        }

        .box-title {
            color: white !important;
            font-weight: bold;
            font-size: 1.3em;
        }

        .box-body {
            padding: 30px;
        }

        /* Search Container */
        .search-container {
            margin-bottom: 25px;
        }

        .form-control {
            border: 3px solid #4a90e2;
            border-radius: 25px;
            padding: 15px 20px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #2c5aa0;
            box-shadow: 0 0 20px rgba(74, 144, 226, 0.3);
        }

        .search-btn {
            background: linear-gradient(135deg, #4a90e2, #2c5aa0);
            border: 3px solid #4a90e2;
            border-radius: 0 25px 25px 0;
            padding: 15px 25px;
            transition: all 0.3s ease;
        }

        .search-btn:hover {
            background: linear-gradient(135deg, #2c5aa0, #1a4480);
            transform: scale(1.05);
        }

        /* Candidate Items */
        .candidate-item {
            border: 3px solid #e3f2fd;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 15px;
            background: linear-gradient(145deg, #ffffff, #f8f9ff);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .candidate-item:hover {
            border-color: #4a90e2;
            transform: translateX(10px);
            box-shadow: 0 10px 20px rgba(74, 144, 226, 0.2);
        }

        /* Selected Candidates */
        .selected-list {
            min-height: 60px;
            border: 3px dashed #4a90e2;
            padding: 20px;
            border-radius: 15px;
            background: linear-gradient(145deg, #f0f8ff, #e6f3ff);
        }

        .selected-candidate {
            border: 3px solid #4a90e2;
            border-radius: 15px;
            padding: 15px;
            margin-bottom: 15px;
            background: linear-gradient(145deg, #ffffff, #f0f8ff);
            animation: slideIn 0.5s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Buttons */
        .btn {
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4a90e2, #2c5aa0);
            box-shadow: 0 8px 16px rgba(74, 144, 226, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #2c5aa0, #1a4480);
            transform: translateY(-3px);
            box-shadow: 0 12px 24px rgba(74, 144, 226, 0.4);
        }

        .btn-info {
            background: linear-gradient(135deg, #17a2b8, #138496);
            box-shadow: 0 8px 16px rgba(23, 162, 184, 0.3);
        }

        .btn-info:hover {
            background: linear-gradient(135deg, #138496, #0f6674);
            transform: translateY(-3px);
            box-shadow: 0 12px 24px rgba(23, 162, 184, 0.4);
        }

        .btn-success {
            background: linear-gradient(135deg, #28a745, #20c997);
            box-shadow: 0 8px 16px rgba(40, 167, 69, 0.3);
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #20c997, #17a2b8);
            transform: translateY(-3px);
            box-shadow: 0 12px 24px rgba(40, 167, 69, 0.4);
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc3545, #c82333);
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #c82333, #a71e2a);
            transform: scale(1.1);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .content-wrapper {
                margin: 10px;
                border-radius: 15px;
            }
            
            .floating-icon {
                font-size: 2rem !important;
            }
        }

        /* Loading animations */
        .fa-spin {
            animation: fa-spin 1s infinite linear;
        }

        @keyframes fa-spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <!-- Animated Background -->
    <div class="floating-icons"></div>

    <div class="content-wrapper">
        <div class="container">
            <!-- Main content -->
            <section class="content">
                <h1 class="page-header text-center title">
                    <b>STUDENT COUNCIL ELECTION 2024</b>
                </h1>
                
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <!-- Alert Messages -->
                        <div class="alert alert-danger floating-alert" id="alert" style="display:none;">
                            <span class="message"></span>
                        </div>

                        <div class="alert alert-info floating-alert" id="info-alert" style="display:none;">
                            <span class="info-message"></span>
                        </div>

                        <!-- Voting Ballot -->
                        <form method="POST" id="ballotForm">
                            <!-- President Position -->
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box" id="president">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">
                                                <i class="fas fa-crown"></i> President
                                            </h3>
                                        </div>
                                        <div class="box-body">
                                            <p style="color: #333; margin-bottom: 20px; font-weight: bold;">
                                                <i class="fas fa-info-circle"></i> Select only one candidate
                                            </p>
                                            
                                            <!-- Search Container -->
                                            <div class="search-container" id="search-container-president">
                                                <div class="input-group">
                                                    <input type="text" class="form-control candidate-search" 
                                                           placeholder="Search candidates by first name or last name..." 
                                                           data-position="president">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-primary search-btn" type="button">
                                                            <i class="fa fa-search"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>

                                            <!-- Search Results -->
                                            <div class="search-results" id="results_president" style="display: none;">
                                                <h5 style="color: #2c5aa0; margin-bottom: 20px;">
                                                    <i class="fas fa-search"></i> Search Results:
                                                </h5>
                                                <div class="candidates-list">
                                                    <!-- Sample candidates will be loaded here -->
                                                </div>
                                            </div>

                                            <!-- Selected Candidates -->
                                            <div class="selected-candidates" id="selected_president">
                                                <h5 style="color: #2c5aa0; margin-bottom: 20px;">
                                                    <i class="fas fa-check-circle"></i> Selected Candidate:
                                                </h5>
                                                <div class="selected-list">
                                                    <p class="text-muted text-center" style="margin: 0;">
                                                        <i class="fas fa-user-plus"></i> No candidate selected yet
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Vice President Position -->
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box" id="vice-president">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">
                                                <i class="fas fa-medal"></i> Vice President
                                            </h3>
                                        </div>
                                        <div class="box-body">
                                            <p style="color: #333; margin-bottom: 20px; font-weight: bold;">
                                                <i class="fas fa-info-circle"></i> Select only one candidate
                                            </p>
                                            
                                            <!-- Search Container -->
                                            <div class="search-container" id="search-container-vice-president">
                                                <div class="input-group">
                                                    <input type="text" class="form-control candidate-search" 
                                                           placeholder="Search candidates by first name or last name..." 
                                                           data-position="vice-president">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-primary search-btn" type="button">
                                                            <i class="fa fa-search"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>

                                            <!-- Selected Candidates -->
                                            <div class="selected-candidates" id="selected_vice-president">
                                                <h5 style="color: #2c5aa0; margin-bottom: 20px;">
                                                    <i class="fas fa-check-circle"></i> Selected Candidate:
                                                </h5>
                                                <div class="selected-list">
                                                    <p class="text-muted text-center" style="margin: 0;">
                                                        <i class="fas fa-user-plus"></i> No candidate selected yet
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="text-center" style="margin-top: 40px; margin-bottom: 40px;">
                                <button type="button" class="btn btn-info btn-lg" id="preview" style="margin-right: 20px;">
                                    <i class="fa fa-file-text"></i> Preview Ballot
                                </button> 
                                <button type="submit" class="btn btn-success btn-lg" name="vote">
                                    <i class="fa fa-check-square"></i> Submit Vote
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- Preview Modal -->
    <div class="modal fade" id="preview_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="border-radius: 20px; border: none;">
                <div class="modal-header" style="background: linear-gradient(135deg, #4a90e2, #2c5aa0); color: white; border-radius: 20px 20px 0 0;">
                    <button type="button" class="close" data-dismiss="modal" style="color: white;">
                        <span>&times;</span>
                    </button>
                    <h4 class="modal-title">
                        <i class="fas fa-eye"></i> Ballot Preview
                    </h4>
                </div>
                <div class="modal-body" id="preview_body" style="padding: 30px;">
                    <!-- Preview content will be loaded here -->
                </div>
                <div class="modal-footer" style="border-radius: 0 0 20px 20px;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    
    <script>
        // Sample candidates data
        const sampleCandidates = {
            president: [
                {id: 1, firstname: 'John', lastname: 'Smith', photo: 'images/john.jpg', platform: 'Improving student facilities and academic excellence'},
                {id: 2, firstname: 'Sarah', lastname: 'Johnson', photo: 'images/sarah.jpg', platform: 'Enhancing student engagement and campus life'},
                {id: 3, firstname: 'Michael', lastname: 'Brown', photo: 'images/michael.jpg', platform: 'Promoting sustainability and green initiatives'}
            ],
            'vice-president': [
                {id: 4, firstname: 'Emily', lastname: 'Davis', photo: 'images/emily.jpg', platform: 'Supporting academic programs and student welfare'},
                {id: 5, firstname: 'David', lastname: 'Wilson', photo: 'images/david.jpg', platform: 'Fostering innovation and technology integration'},
                {id: 6, firstname: 'Lisa', lastname: 'Anderson', photo: 'images/lisa.jpg', platform: 'Building stronger community partnerships'}
            ]
        };

        $(function() {
            let selectedCandidates = {};

            // Create animated background elements
            function createFloatingIcons() {
                const icons = [
                    'fas fa-trophy', 'fas fa-medal', 'fas fa-award', 'fas fa-star',
                    'fas fa-book', 'fas fa-graduation-cap', 'fas fa-scroll', 'fas fa-certificate'
                ];
                
                const container = $('.floating-icons');
                
                function addIcon() {
                    const icon = icons[Math.floor(Math.random() * icons.length)];
                    const iconElement = $(`<div class="floating-icon ${icon.includes('trophy') || icon.includes('medal') || icon.includes('award') ? 'award' : icon.includes('book') || icon.includes('graduation') ? 'book' : 'trophy'}"><i class="${icon}"></i></div>`);
                    
                    iconElement.css({
                        left: Math.random() * 100 + '%',
                        animationDelay: Math.random() * 2 + 's',
                        animationDuration: (15 + Math.random() * 10) + 's'
                    });
                    
                    container.append(iconElement);
                    
                    setTimeout(() => {
                        iconElement.remove();
                    }, 25000);
                }
                
                // Add initial icons
                for(let i = 0; i < 8; i++) {
                    setTimeout(addIcon, i * 2000);
                }
                
                // Continue adding icons
                setInterval(addIcon, 3000);
            }
            
            createFloatingIcons();

            // Show floating alert message
            function showAlert(msg, type = 'danger') {
                const alertId = (type === 'success') ? '#info-alert' : '#alert';
                const msgClass = (type === 'success') ? '.info-message' : '.message';

                $(alertId).removeClass('alert-danger alert-success alert-info alert-warning')
                          .addClass('alert-' + type)
                          .find(msgClass).html(msg);
                $(alertId).stop(true, true).fadeIn(500);

                clearTimeout($(alertId).data('fadeTimeout'));
                const timeout = setTimeout(() => $(alertId).fadeOut(1000), 4000);
                $(alertId).data('fadeTimeout', timeout);
            }

            // Search functionality
            $('.candidate-search').on('input', function() {
                let val = $(this).val().trim().toLowerCase();
                let position = $(this).data('position');
                let $results = $('#results_' + position.replace('-', '_'));
                let $list = $results.find('.candidates-list');

                if (val.length < 2) {
                    $results.hide();
                    return;
                }

                $list.html('<div class="text-center"><i class="fa fa-spinner fa-spin"></i> Searching...</div>');
                $results.show();

                // Simulate search delay
                setTimeout(() => {
                    const candidates = sampleCandidates[position] || [];
                    const filtered = candidates.filter(c => 
                        c.firstname.toLowerCase().includes(val) || 
                        c.lastname.toLowerCase().includes(val)
                    );

                    if (filtered.length === 0) {
                        $list.html('<p class="text-muted text-center"><i class="fa fa-search"></i> No candidates found</p>');
                        return;
                    }

                    let html = filtered.map(c => {
                        let photo = c.photo || 'https://via.placeholder.com/150x150?text=No+Photo';
                        return `
                            <div class="candidate-item" data-candidate-id="${c.id}" data-firstname="${c.firstname}"
                                 data-lastname="${c.lastname}" data-photo="${photo}" data-platform="${c.platform}"
                                 data-position="${position}">
                                <div class="row">
                                    <div class="col-md-3">
                                        <img src="${photo}" style="max-height:100px; width:100%; object-fit:cover; border-radius:10px;" 
                                             onerror="this.src='https://via.placeholder.com/150x150?text=No+Photo'">
                                    </div>
                                    <div class="col-md-6">
                                        <h5 style="color:#2c5aa0; margin-bottom: 10px;">
                                            <i class="fas fa-user"></i> ${c.firstname} ${c.lastname}
                                        </h5>
                                        <p style="color:#666; font-size:14px;">${c.platform.substring(0,100)}${c.platform.length > 100 ? '...' : ''}</p>
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <button type="button" class="btn btn-success select-candidate" style="width:100%;">
                                            <i class="fa fa-check"></i> Select
                                        </button>
                                    </div>
                                </div>
                            </div>`;
                    }).join('');
                    $list.html(html);
                }, 500);
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
                    position: $item.data('position')
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

                // For single selection positions, replace existing
                selectedCandidates[candidate.position] = [candidate];
                updateSelectedDisplay(candidate.position);

                // Hide search results
                $('#results_' + candidate.position.replace('-', '_')).hide();
                $('#search-container-' + candidate.position).hide();

                showAlert(`${candidate.firstname} ${candidate.lastname} selected!`, 'success');
            }

            // Update selected candidates display
            function updateSelectedDisplay(position) {
                let $container = $('#selected_' + position.replace('-', '_') + ' .selected-list');
                let candidates = selectedCandidates[position] || [];

                if (candidates.length === 0) {
                    $container.html('<p class="text-muted text-center" style="margin:0;"><i class="fas fa-user-plus"></i> No candidate selected yet</p>');
                    $('#search-container-' + position).show();
                } else {
                    let html = candidates.map(c => `
                        <div class="selected-candidate">
                            <div class="row">
                                <div class="col-md-2">
                                    <img src="${c.photo}" style="max-height:60px; width: 100%; object-fit:cover; border-radius:8px;" 
                                         onerror="this.src='https://via.placeholder.com/60x60?text=No+Photo'">
                                </div>
                                <div class="col-md-8">
                                    <h6 style="color:#2c5aa0; margin:0; font-weight:bold;">
                                        <i class="fas fa-user"></i> ${c.firstname} ${c.lastname}
                                    </h6>
                                    <p style="color:#666; margin:5px 0 0; font-size:14px;">${c.platform.substring(0,80)}${c.platform.length > 80 ? '...' : ''}</p>
                                </div>
                                <div class="col-md-2 text-right">
                                    <button type="button" class="btn btn-danger btn-sm remove-candidate" 
                                            data-position="${position}" data-candidate-id="${c.id}" title="Remove candidate">
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

                    if (removed) showAlert(`${removed.firstname} ${removed.lastname} removed.`, 'info');
                }
            });

            // Preview button click
            $('#preview').click(function(e) {
                e.preventDefault();
                
                if (Object.keys(selectedCandidates).length === 0) {
                    showAlert('Please select at least one candidate before previewing.', 'warning');
                    return;
                }

                $(this).html('<i class="fa fa-spinner fa-spin"></i> Loading Preview...').prop('disabled', true);

                setTimeout(() => {
                    let previewHtml = '<div class="preview-content">';
                    previewHtml += '<h4 style="color: #2c5aa0; margin-bottom: 20px;"><i class="fas fa-vote-yea"></i> Your Ballot Summary</h4>';
                    
                    Object.keys(selectedCandidates).forEach(position => {
                        if (selectedCandidates[position].length > 0) {
                            previewHtml += `<div style="margin-bottom: 20px; padding: 15px; border: 2px solid #4a90e2; border-radius: 10px; background: #f0f8ff;">`;
                            previewHtml += `<h5 style="color: #2c5aa0; text-transform: capitalize;"><i class="fas fa-arrow-right"></i> ${position.replace('-', ' ')}</h5>`;
                            selectedCandidates[position].forEach(candidate => {
                                previewHtml += `<p style="margin: 5px 0; font-weight: bold;"><i class="fas fa-user"></i> ${candidate.firstname} ${candidate.lastname}</p>`;
                            });
                            previewHtml += '</div>';
                        }
                    });
                    
                    previewHtml += '</div>';
                    $('#preview_body').html(previewHtml);
                    $('#preview_modal').modal('show');
                    
                    $('#preview').html('<i class="fa fa-file-text"></i> Preview Ballot').prop('disabled', false);
                }, 800);
            });

            // Form submission
            $('#ballotForm').on('submit', function(e) {
                e.preventDefault();
                
                if (Object.keys(selectedCandidates).length === 0) {
                    showAlert('Please select at least one candidate before submitting.', 'warning');
                    return;
                }

                showAlert('Vote submitted successfully! Thank you for participating.', 'success');
                
                // Disable form after submission
                setTimeout(() => {
                    $(this).html('<div class="text-center" style="padding: 50px;"><h3 style="color: #28a745;"><i class="fas fa-check-circle"></i> Vote Submitted Successfully!</h3><p>Thank you for participating in the election.</p></div>');
                }, 2000);
            });
        });
    </script>
</body>
</html>