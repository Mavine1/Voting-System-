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
<!-- Convert Voters Modal -->
<?php
// At the top of your page before any HTML output, handle search form submission and store results
include 'includes/session.php';

$searchResults = [];
$searchTerm = '';
$searchPositionId = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search_submit'])) {
    $searchTerm = trim($_POST['search'] ?? '');
    $searchPositionId = intval($_POST['position_id'] ?? 0);

    if ($searchTerm !== '' && $searchPositionId > 0) {
        // Search voters by first or last name (basic LIKE query)
        $stmt = $conn->prepare("SELECT id, firstname, lastname, photo FROM voters WHERE firstname LIKE ? OR lastname LIKE ? ORDER BY lastname, firstname");
        $likeTerm = "%$searchTerm%";
        $stmt->bind_param("ss", $likeTerm, $likeTerm);
        $stmt->execute();
        $result = $stmt->get_result();
        $searchResults = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    }
}
?>

<!-- Convert Voters Modal -->
<div class="modal fade" id="convertVoters" tabindex="-1" role="dialog" aria-labelledby="convertVotersLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <!-- Form submits to same page or a dedicated PHP file (adjust action) -->
    <form method="POST" action="" id="convertVoterForm">
      <div class="modal-content" style="background-color: #d8d1bd; color: black; font-family: Times; font-size: 15px;">
        <div class="modal-header">
          <h5 class="modal-title" id="convertVotersLabel">Convert Voters to Candidates</h5>
          <button type="button" class="close btn btn-close btn-curve pull-right" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>

        <div class="modal-body">
          <!-- Search Section -->
          <div class="form-group">
            <label for="search">Search Voters by First or Last Name</label>
            <input type="text" id="search" name="search" class="form-control" placeholder="Enter name..." value="<?php echo htmlspecialchars($searchTerm); ?>" required>
          </div>

          <div class="form-group">
            <label for="position_id_search">Select Position to Search</label>
            <select id="position_id_search" name="position_id" class="form-control" required>
              <option value="">-- Select Position --</option>
              <?php
              $posSql = "SELECT * FROM positions ORDER BY priority ASC";
              $posQuery = $conn->query($posSql);
              while ($pos = $posQuery->fetch_assoc()) {
                  $selected = ($pos['id'] == $searchPositionId) ? 'selected' : '';
                  echo "<option value='{$pos['id']}' $selected>" . htmlspecialchars($pos['description']) . "</option>";
              }
              ?>
            </select>
          </div>

          <button type="submit" name="search_submit" class="btn btn-info btn-sm btn-curve" style="margin-bottom:15px;">Search</button>

          <hr>

          <!-- Voter Search Results with Checkboxes -->
          <?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search_submit'])): ?>
            <h5>Search Results</h5>
            <?php if (count($searchResults) > 0): ?>
              <div style="max-height: 300px; overflow-y: auto; border: 1px solid #ccc; padding: 10px;">
                <?php foreach ($searchResults as $voter): ?>
                  <div class="form-check" style="padding: 5px 0; border-bottom: 1px solid #eee;">
                    <input class="form-check-input" type="checkbox" id="voter_<?php echo $voter['id']; ?>" name="selected_voters[]" value="<?php echo $voter['id']; ?>">
                    <label class="form-check-label" for="voter_<?php echo $voter['id']; ?>">
                      <img src="<?php echo !empty($voter['photo']) ? '../images/'.$voter['photo'] : '../images/profile.jpg'; ?>" alt="Photo" style="height:30px; width:30px; border-radius:50%; object-fit:cover; margin-right:8px;">
                      <?php echo htmlspecialchars($voter['firstname'] . ' ' . $voter['lastname']); ?>
                    </label>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php else: ?>
              <p>No voters found matching your search.</p>
            <?php endif; ?>
          <?php endif; ?>

          <hr>

          <!-- Position select for conversion (required) -->
          <div class="form-group">
            <label for="positionSelect">Position for Candidates</label>
            <select id="positionSelect" name="position" class="form-control" required>
              <option value="">-- Select Position --</option>
              <?php
              // List all positions for conversion selection
              $posQuery2 = $conn->query($posSql);
              while ($pos2 = $posQuery2->fetch_assoc()) {
                  echo "<option value='{$pos2['id']}'>" . htmlspecialchars($pos2['description']) . "</option>";
              }
              ?>
            </select>
          </div>

          <!-- Platform description -->
          <div class="form-group">
            <label for="platformDesc">Platform Description</label>
            <textarea id="platformDesc" name="platform" class="form-control" rows="4" placeholder="Enter platform description" required></textarea>
          </div>

          <!-- Add All voters checkbox -->
          <div class="form-group">
            <label><input type="checkbox" name="add_all_voters" id="addAllVoters"> Add <strong>ALL</strong> voters as candidates (ignore search/select)</label>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" name="convert" class="btn btn-primary">Convert Selected Voters</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  // Disable search selection if Add All voters checked
  document.getElementById('addAllVoters').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('input[name="selected_voters[]"]');
    if (this.checked) {
      checkboxes.forEach(cb => {
        cb.checked = false;
        cb.disabled = true;
      });
    } else {
      checkboxes.forEach(cb => cb.disabled = false);
    }
  });
</script>


<!-- JQuery and JS -->
<script>
$(document).ready(function() {
  let selectedVoters = new Set();

  // Debounce function to limit search calls
  function debounce(func, wait) {
    let timeout;
    return function() {
      const context = this, args = arguments;
      clearTimeout(timeout);
      timeout = setTimeout(() => func.apply(context, args), wait);
    };
  }

  // Update hidden input with selected voters CSV
  function updateSelectedVotersInput() {
    $('#selectedVotersInput').val(Array.from(selectedVoters).join(','));
  }

  // Render voters search results inside modal
  function renderVoters(voters) {
    const container = $('#voterSearchResults');
    container.empty();

    if (voters.length === 0) {
      container.append('<p>No voters found.</p>');
      return;
    }

    voters.forEach(voter => {
      const isChecked = selectedVoters.has(voter.id.toString()) ? 'checked' : '';
      const photo = voter.photo && voter.photo !== '' ? '../images/' + voter.photo : '../images/profile.jpg';

      container.append(`
        <div class="form-check" style="padding: 5px 0; border-bottom: 1px solid #eee;">
          <input class="form-check-input voter-checkbox" type="checkbox" id="voter_${voter.id}" value="${voter.id}" ${isChecked}>
          <label class="form-check-label" for="voter_${voter.id}">
            <img src="${photo}" alt="Photo" style="height:30px; width:30px; border-radius:50%; object-fit:cover; margin-right:8px;">
            ${voter.firstname} ${voter.lastname}
          </label>
        </div>
      `);
    });
  }

  // AJAX call to search voters by name
  const ajaxSearchVoters = debounce(function() {
    const query = $('#voterSearch').val().trim();

    if (query.length < 2) {
      $('#voterSearchResults').empty();
      return;
    }

    $.ajax({
      url: 'search_voters.php', // Your backend PHP search handler
      method: 'POST',
      dataType: 'json',
      data: { search: query },
      success: function(data) {
        renderVoters(data);
      },
      error: function() {
        $('#voterSearchResults').html('<p class="text-danger">Search failed. Please try again.</p>');
      }
    });
  }, 300);

  // Search input keyup event
  $('#voterSearch').on('input', function() {
    if ($('#addAllVoters').is(':checked')) {
      $('#voterSearchResults').empty();
      return;
    }
    ajaxSearchVoters();
  });

  // Handle "Add All Voters" checkbox toggle
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

  // Track checkbox changes inside search results
  $('#voterSearchResults').on('change', '.voter-checkbox', function() {
    const voterId = $(this).val();
    if ($(this).is(':checked')) {
      selectedVoters.add(voterId);
    } else {
      selectedVoters.delete(voterId);
    }
    updateSelectedVotersInput();
  });

  // Reset modal when closed
  $('#convertVoters').on('hidden.bs.modal', function() {
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



     