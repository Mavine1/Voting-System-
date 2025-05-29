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
    <form id="convertVoterForm" method="POST" action="candidates_add.php">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="convertVotersLabel">Convert Voters to Candidates</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">

          <div class="form-group">
            <label>Search Voters by Name</label>
            <input type="text" id="voterSearch" class="form-control" placeholder="Enter first or last name...">
            <small class="form-text text-muted">Type at least 2 characters to search.</small>
          </div>

          <div id="voterSearchResults" style="max-height:300px; overflow-y:auto; border:1px solid #ccc; padding:10px;">
            <!-- AJAX voter search results will appear here -->
          </div>

          <hr>

          <div class="form-group">
            <label for="positionSelect">Select Position</label>
            <select id="positionSelect" name="position" class="form-control" required>
              <option value="">-- Select Position --</option>
              <?php
              $posSql = "SELECT * FROM positions ORDER BY priority ASC";
              $posQuery = $conn->query($posSql);
              while($pos = $posQuery->fetch_assoc()) {
                echo "<option value='{$pos['id']}'>" . htmlspecialchars($pos['description']) . "</option>";
              }
              ?>
            </select>
          </div>

          <div class="form-group">
            <label for="platformDesc">Platform Description</label>
            <textarea id="platformDesc" name="platform" class="form-control" rows="4" placeholder="Enter platform description" required></textarea>
          </div>

          <div class="form-group">
            <label><input type="checkbox" id="addAllVoters" name="add_all_voters"> Add <strong>ALL</strong> voters as candidates (ignore search/select)</label>
          </div>

          <!-- Hidden input to hold comma-separated selected voter IDs -->
          <input type="hidden" name="selected_voters" id="selectedVotersInput">

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Convert to Candidates</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
$(document).ready(function(){
  let selectedVoters = new Set();

  // Debounce helper to limit AJAX calls while typing
  function debounce(func, wait) {
    let timeout;
    return function(...args) {
      clearTimeout(timeout);
      timeout = setTimeout(() => func.apply(this, args), wait);
    };
  }

  // Update hidden input with selected voters as CSV
  function updateSelectedVotersInput() {
    $('#selectedVotersInput').val(Array.from(selectedVoters).join(','));
  }

  // Render voter search results
  function renderVoterResults(voters) {
    const container = $('#voterSearchResults');
    container.empty();

    if (voters.length === 0) {
      container.append('<p>No voters found.</p>');
      return;
    }

    voters.forEach(voter => {
      const checked = selectedVoters.has(voter.id.toString()) ? 'checked' : '';
      const photoUrl = voter.photo && voter.photo !== '' ? '../images/' + voter.photo : '../images/profile.jpg';

      const voterHtml = `
        <div class="form-check" style="padding: 5px 0; border-bottom: 1px solid #eee;">
          <input class="form-check-input voter-checkbox" type="checkbox" value="${voter.id}" id="voter_${voter.id}" ${checked}>
          <label class="form-check-label" for="voter_${voter.id}">
            <img src="${photoUrl}" alt="Photo" style="height:30px; width:30px; border-radius:50%; object-fit:cover; margin-right:8px;">
            ${voter.firstname} ${voter.lastname}
          </label>
        </div>`;
      container.append(voterHtml);
    });
  }

  // AJAX search function
  const ajaxSearchVoters = debounce(function() {
    const query = $('#voterSearch').val().trim();

    if (query.length < 2) {
      $('#voterSearchResults').empty();
      return;
    }

    $.ajax({
      url: 'search_voters.php',  // Your PHP search endpoint
      type: 'POST',
      dataType: 'json',
      data: { search: query },
      success: function(data) {
        renderVoterResults(data);
      },
      error: function() {
        $('#voterSearchResults').html('<p class="text-danger">Search failed. Please try again.</p>');
      }
    });
  }, 300);

  // Bind input event to search box
  $('#voterSearch').on('input', function() {
    if ($('#addAllVoters').is(':checked')) {
      // Disable search when adding all voters
      $('#voterSearchResults').empty();
      return;
    }
    ajaxSearchVoters();
  });

  // Toggle all voters checkbox disables search & selection
  $('#addAllVoters').change(function() {
    if ($(this).is(':checked')) {
      $('#voterSearch').prop('disabled', true);
      $('#voterSearchResults').empty();
      selectedVoters.clear();
      updateSelectedVotersInput();
    } else {
      $('#voterSearch').prop('disabled', false);
    }
  });

  // Handle selection/deselection of voters in search results
  $('#voterSearchResults').on('change', '.voter-checkbox', function() {
    const voterId = $(this).val();
    if ($(this).is(':checked')) {
      selectedVoters.add(voterId);
    } else {
      selectedVoters.delete(voterId);
    }
    updateSelectedVotersInput();
  });

  // Optional: clear selections when modal closes
  $('#convertVoters').on('hidden.bs.modal', function () {
    selectedVoters.clear();
    updateSelectedVotersInput();
    $('#voterSearch').val('').prop('disabled', false);
    $('#voterSearchResults').empty();
    $('#addAllVoters').prop('checked', false);
    $('#positionSelect').val('');
    $('#platformDesc').val('');
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



     