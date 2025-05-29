<!-- Description -->
<div class="modal fade" id="platform">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #d8d1bd ;color:black ; font-size: 15px; font-family:Times ">
            <div class="modal-header">
              <button type="button" class=" btn btn-close btn-curve pull-right"  data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b><span class="fullname"></span></b></h4>
            </div>
            <div class="modal-body">
                <p id="desc"></p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-curve pull-left" style='background-color:  #FFDEAD  ;color:black ; font-size: 12px; font-family:Times' data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Add -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #d8d1bd ;color:black ; font-size: 15px; font-family:Times ">
            <div class="modal-header">
              <button type="button" class=" btn btn-close btn-curve pull-right"  data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>Add New Candidate</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="candidates_add.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="firstname" class="col-sm-3 control-label">Firstname</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="firstname" name="firstname" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="lastname" class="col-sm-3 control-label">Lastname</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="lastname" name="lastname" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="position" class="col-sm-3 control-label">Position</label>

                    <div class="col-sm-9">
                      <select class="form-control" id="position" name="position" required>
                        <option value="" selected>- Select -</option>
                        <?php
                          $sql = "SELECT * FROM positions";
                          $query = $conn->query($sql);
                          while($row = $query->fetch_assoc()){
                            echo "
                              <option value='".$row['id']."'>".$row['description']."</option>
                            ";
                          }
                        ?>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="photo" class="col-sm-3 control-label">Photo</label>

                    <div class="col-sm-9">
                      <input type="file" id="photo" name="photo">
                    </div>
                </div>
                <div class="form-group">
                    <label for="platform" class="col-sm-3 control-label">Platform</label>

                    <div class="col-sm-9">
                      <textarea class="form-control" id="platform" name="platform" rows="7"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-curve pull-left"style='background-color:  #FFDEAD  ;color:black ; font-size: 12px; font-family:Times' data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button type="submit" class="btn btn-primary btn-curve" style='background-color: #9CD095 ;color:black ; font-size: 12px; font-family:Times'name="add"><i class="fa fa-save"></i> Save</button>
              </form>
            </div>
        </div>
    </div>
</div>

<!-- Convert Voters Modal -->
<div class="modal fade" id="convertVoters" tabindex="-1" role="dialog" aria-labelledby="convertVotersLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <form id="convertVoterForm" method="POST" action="candidates_add.php" enctype="multipart/form-data">
      <div class="modal-content" style="background-color: #d8d1bd; color: black; font-size: 15px; font-family: Times;">
        <div class="modal-header">
          <h5 class="modal-title" id="convertVotersLabel">Convert Voters to Candidates</h5>
          <button type="button" class="close btn btn-close btn-curve pull-right" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <!-- Search Voters -->
          <div class="form-group">
            <label for="voterSearch">Search Voters by Name</label>
            <input type="text" id="voterSearch" class="form-control" placeholder="Enter first or last name...">
            <small class="form-text text-muted">Type at least 2 characters to search.</small>
          </div>

          <!-- Search Results -->
          <div id="voterSearchResults" style="max-height: 300px; overflow-y: auto; border: 1px solid #ccc; padding: 10px; margin-bottom: 15px;">
            <p class="text-muted text-center">Search results will appear here</p>
          </div>

          <!-- Selected Voters Display -->
          <div id="selectedVotersDisplay" class="mb-3" style="display: none;">
            <h6>Selected Voters:</h6>
            <div id="selectedVotersList" class="d-flex flex-wrap gap-2"></div>
          </div>

          <hr>

          <!-- Position Selection -->
          <div class="form-group">
            <label for="positionSelect">Select Position</label>
            <select id="positionSelect" name="position" class="form-control" required>
              <option value="">-- Select Position --</option>
              <?php
                $posSql = "SELECT * FROM positions ORDER BY priority ASC";
                $posQuery = $conn->query($posSql);
                while($pos = $posQuery->fetch_assoc()) {
                  echo "<option value='" . $pos['id'] . "'>" . $pos['description'] . "</option>";
                }
              ?>
            </select>
          </div>

          <!-- Platform Description -->
          <div class="form-group">
            <label for="platformDesc">Platform Description</label>
            <textarea id="platformDesc" name="platform" class="form-control" rows="4" placeholder="Enter platform description" required></textarea>
          </div>

          <!-- Photo Upload -->
          <div class="form-group">
            <label for="candidatePhoto">Candidate Photo (Optional)</label>
            <input type="file" id="candidatePhoto" name="photo" class="form-control">
            <small class="form-text text-muted">If not provided, voter's existing photo will be used.</small>
          </div>

          <!-- Add All Voters Checkbox -->
          <div class="form-group">
            <div class="checkbox">
              <label>
                <input type="checkbox" id="addAllVoters" name="add_all_voters">
                <strong>Convert ALL voters</strong> (ignores search/selection above)
              </label>
            </div>
          </div>

          <!-- Hidden input to store selected voter IDs -->
          <input type="hidden" name="selected_voters" id="selectedVotersInput" value="">
          <input type="hidden" name="convert" value="1">
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-curve pull-left" style='background-color: #FFDEAD; color:black; font-size: 12px; font-family:Times' data-dismiss="modal">
            <i class="fa fa-close"></i> Cancel
          </button>
          <button type="submit" class="btn btn-primary btn-curve" style='background-color: #9CD095; color:black; font-size: 12px; font-family:Times'>
            <i class="fa fa-exchange-alt"></i> Convert to Candidates
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
$(document).ready(function() {
  let selectedVoters = new Map(); // Using Map to store voter objects for easy access

  // Function to perform voter search
  function searchVoters(query) {
    if (query.length < 2) {
      $('#voterSearchResults').html('<p class="text-muted text-center">Enter at least 2 characters to search.</p>');
      return;
    }

    // Show loading indicator
    $('#voterSearchResults').html('<p class="text-muted text-center"><i class="fa fa-spinner fa-spin"></i> Searching voters...</p>');

    $.ajax({
      url: 'includes/search_voters_embedded.php',
      method: 'POST',
      data: { search: query },
      dataType: 'json',
      success: function(data) {
        if (data.error) {
          $('#voterSearchResults').html(`<p class="text-danger">${data.error}</p>`);
        } else {
          renderVoters(data);
        }
      },
      error: function() {
        $('#voterSearchResults').html('<p class="text-danger">Error searching voters. Please try again.</p>');
      }
    });
  }

  // Debounce the search function
  const debouncedSearch = _.debounce(searchVoters, 300);

  // Update hidden input with selected voters CSV
  function updateSelectedVotersInput() {
    $('#selectedVotersInput').val(Array.from(selectedVoters.keys()).join(','));
    updateSelectedVotersDisplay();
  }

  // Update the display of selected voters
  function updateSelectedVotersDisplay() {
    const container = $('#selectedVotersList');
    container.empty();
    
    if (selectedVoters.size > 0) {
      $('#selectedVotersDisplay').show();
      
      selectedVoters.forEach((voter, id) => {
        const photo = voter.photo && voter.photo !== '' ? '../images/' + voter.photo : '../images/profile.jpg';
        const voterBadge = $(`
          <div class="selected-voter-badge" style="background: #f0f0f0; padding: 5px 10px; border-radius: 20px; display: flex; align-items: center;">
            <img src="${photo}" alt="Photo" style="height:20px; width:20px; border-radius:50%; object-fit:cover; margin-right:5px;">
            <span>${voter.firstname} ${voter.lastname}</span>
            <button type="button" class="btn-remove-voter" data-id="${id}" style="background: none; border: none; color: #999; margin-left: 5px; padding: 0 5px;">
              <i class="fa fa-times"></i>
            </button>
          </div>
        `);
        container.append(voterBadge);
      });
    } else {
      $('#selectedVotersDisplay').hide();
    }
  }

  // Render voters search results
  function renderVoters(voters) {
    const container = $('#voterSearchResults');
    container.empty();

    if (voters.length === 0) {
      container.append('<p class="text-muted text-center">No voters found matching your search.</p>');
      return;
    }

    const listGroup = $('<div class="list-group"></div>');
    
    voters.forEach(voter => {
      const isSelected = selectedVoters.has(voter.id.toString());
      const photo = voter.photo && voter.photo !== '' ? '../images/' + voter.photo : '../images/profile.jpg';
      
      const voterItem = $(`
        <div class="list-group-item voter-item" data-id="${voter.id}" style="padding: 10px; border-radius: 5px; margin-bottom: 5px; cursor: pointer;">
          <div class="d-flex align-items-center">
            <input type="checkbox" class="voter-checkbox" id="voter_${voter.id}" value="${voter.id}" 
              ${isSelected ? 'checked' : ''} style="margin-right: 10px;">
            <img src="${photo}" alt="Photo" style="height:40px; width:40px; border-radius:50%; object-fit:cover; margin-right:10px;">
            <div>
              <h5 style="margin: 0; font-weight: bold;">${voter.firstname} ${voter.lastname}</h5>
              <small class="text-muted">Voter ID: ${voter.id}</small>
            </div>
          </div>
        </div>
      `);
      
      listGroup.append(voterItem);
    });
    
    container.append(listGroup);
  }

  // Search input event
  $('#voterSearch').on('input', function() {
    if ($('#addAllVoters').is(':checked')) return;
    debouncedSearch($(this).val().trim());
  });

  // Handle checkbox changes
  $('#voterSearchResults').on('change', '.voter-checkbox', function() {
    const voterId = $(this).val();
    const voterItem = $(this).closest('.voter-item');
    const voterData = {
      id: voterId,
      firstname: voterItem.find('h5').text().split(' ')[0],
      lastname: voterItem.find('h5').text().split(' ')[1],
      photo: voterItem.find('img').attr('src').replace('../images/', '')
    };

    if ($(this).is(':checked')) {
      selectedVoters.set(voterId, voterData);
    } else {
      selectedVoters.delete(voterId);
    }
    updateSelectedVotersInput();
  });

  // Handle click on voter item (toggle selection)
  $('#voterSearchResults').on('click', '.voter-item', function(e) {
    // Don't toggle if clicking on the checkbox directly
    if ($(e.target).is('input') || $(e.target).is('img')) return;
    
    const checkbox = $(this).find('.voter-checkbox');
    checkbox.prop('checked', !checkbox.prop('checked'));
    checkbox.trigger('change');
  });

  // Handle remove button click on selected voters
  $('#selectedVotersList').on('click', '.btn-remove-voter', function() {
    const voterId = $(this).data('id');
    selectedVoters.delete(voterId.toString());
    
    // Also uncheck in search results if visible
    $(`#voterSearchResults .voter-checkbox[value="${voterId}"]`).prop('checked', false);
    
    updateSelectedVotersInput();
  });

  // Handle "Add All Voters" checkbox
  $('#addAllVoters').change(function() {
    if ($(this).is(':checked')) {
      $('#voterSearch').prop('disabled', true);
      $('#voterSearchResults').html('<p class="text-info">All voters will be converted.</p>');
      selectedVoters.clear();
      updateSelectedVotersInput();
    } else {
      $('#voterSearch').prop('disabled', false);
      $('#voterSearch').trigger('input');
    }
  });

  // Form validation
  $('#convertVoterForm').submit(function(e) {
    if (!$('#positionSelect').val()) {
      e.preventDefault();
      alert('Please select a position for the candidates.');
      return false;
    }
    
    if (!selectedVoters.size && !$('#addAllVoters').is(':checked')) {
      e.preventDefault();
      alert('Please select at least one voter to convert or check "Convert ALL voters".');
      return false;
    }
    
    return true;
  });

  // Reset modal when closed
  $('#convertVoters').on('hidden.bs.modal', function() {
    selectedVoters.clear();
    updateSelectedVotersInput();
    $('#voterSearch').val('').prop('disabled', false);
    $('#voterSearchResults').html('<p class="text-muted text-center">Search results will appear here</p>');
    $('#addAllVoters').prop('checked', false);
    $('#positionSelect').val('');
    $('#platformDesc').val('');
    $('#candidatePhoto').val('');
  });
});
</script>

<!-- Edit -->
<div class="modal fade" id="edit">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #d8d1bd ;color:black ; font-size: 15px; font-family:Times ">
            <div class="modal-header">
              <button type="button" class=" btn btn-close btn-curve pull-right"  data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>Edit Voter</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="candidates_edit.php">
                <input type="hidden" class="id" name="id">
                <div class="form-group">
                    <label for="edit_firstname" class="col-sm-3 control-label">Firstname</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_firstname" name="firstname" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="edit_lastname" class="col-sm-3 control-label">Lastname</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_lastname" name="lastname" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="edit_position" class="col-sm-3 control-label">Position</label>

                    <div class="col-sm-9">
                      <select class="form-control" id="edit_position" name="position" required>
                        <option value="" selected id="posselect"></option>
                        <?php
                          $sql = "SELECT * FROM positions";
                          $query = $conn->query($sql);
                          while($row = $query->fetch_assoc()){
                            echo "
                              <option value='".$row['id']."'>".$row['description']."</option>
                            ";
                          }
                        ?>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="edit_platform" class="col-sm-3 control-label">Platform</label>

                    <div class="col-sm-9">
                      <textarea class="form-control" id="edit_platform" name="platform" rows="7"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-curve pull-left"style='background-color:  #FFDEAD  ;color:black ; font-size: 12px; font-family:Times' data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button type="submit" class="btn btn-success btn-curve"style='background-color: #9CD095 ;color:black ; font-size: 12px; font-family:Times' name="edit"><i class="fa fa-check-square-o"></i> Update</button>
              </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete -->
<div class="modal fade" id="delete">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #d8d1bd ;color:black ; font-size: 15px; font-family:Times ">
            <div class="modal-header">
              <button type="button" class=" btn btn-close btn-curve pull-right" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>Deleting...</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="candidates_delete.php">
                <input type="hidden" class="id" name="id">
                <div class="text-center">
                    <p>DELETE CANDIDATE</p>
                    <h2 class="bold fullname"></h2>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-curve pull-left"style='background-color:  #FFDEAD  ;color:black ; font-size: 12px; font-family:Times' data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button type="submit" class="btn btn-danger btn-curve" style='background-color: #ff8e88 ;color:black ; font-size: 12px; font-family:Times'name="delete"><i class="fa fa-trash"></i> Delete</button>
              </form>
            </div>
        </div>
    </div>
</div>

<!-- Update Photo -->
<div class="modal fade" id="edit_photo">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #d8d1bd ;color:black ; font-size: 15px; font-family:Times ">
            <div class="modal-header">
              <button type="button" class=" btn btn-close btn-curve pull-right"  data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b><span class="fullname"></span></b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="candidates_photo.php" enctype="multipart/form-data">
                <input type="hidden" class="id" name="id">
                <div class="form-group">
                    <label for="photo" class="col-sm-3 control-label">Photo</label>

                    <div class="col-sm-9">
                      <input type="file" id="photo" name="photo" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-curve pull-left"style='background-color:  #FFDEAD  ;color:black ; font-size: 12px; font-family:Times' data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button type="submit" class="btn btn-success btn-curve"style='background-color: #9CD095 ;color:black ; font-size: 12px; font-family:Times' name="upload"><i class="fa fa-check-square-o"></i> Update</button>
              </form>
            </div>
        </div>
    </div>
</div>