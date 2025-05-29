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
<div class="modal fade" id="convertVoters" tabindex="-1" role="dialog" aria-labelledby="convertVotersLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" >
    <div class="modal-content" style="background-color: #d8d1bd; color:black; font-size: 15px; font-family: Times;">
      <div class="modal-header">
        <h4 class="modal-title" id="convertVotersLabel"><b>Convert Voters to Candidates</b></h4>
        <button type="button" class="btn btn-close btn-curve pull-right" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- Remove method and action to prevent default form post -->
      <form id="convertVotersForm" autocomplete="off" onsubmit="return false;">
        <div class="modal-body">
          <!-- Convert All Voters Checkbox -->
          <div class="form-group">
            <input type="checkbox" id="convertAllVoters" name="convert_all" value="1">
            <label for="convertAllVoters"><strong>Convert All Voters</strong></label>
          </div>

          <!-- Search Box -->
          <div class="form-group">
            <label for="voterSearch">Search Voters by Name</label>
            <input type="text" id="voterSearch" class="form-control" placeholder="Type first or last name..." autocomplete="off" required>
            <div id="searchResults" style="max-height: 200px; overflow-y: auto; background: white; border: 1px solid #ccc; display:none; position: relative; z-index: 1050;"></div>
          </div>

          <!-- Selected Voters List -->
          <div class="form-group">
            <label><strong>Selected Voters</strong></label>
            <div id="selectedVotersList" style="min-height: 80px; border: 1px solid #ccc; padding: 10px; background: white;">
              <small>No voters selected</small>
            </div>
          </div>

          <!-- Position Select -->
          <div class="form-group">
            <label for="convertPosition">Select Position</label>
            <select class="form-control" id="convertPosition" name="position" required>
              <option value="" selected disabled>-- Select Position --</option>
              <?php
                $pos_sql = "SELECT id, description FROM positions ORDER BY description";
                $pos_query = $conn->query($pos_sql);
                while($pos_row = $pos_query->fetch_assoc()){
                  echo '<option value="'.$pos_row['id'].'">'.htmlspecialchars($pos_row['description']).'</option>';
                }
              ?>
            </select>
          </div>

          <!-- Platform Description -->
          <div class="form-group">
            <label for="convertPlatform">Platform Description</label>
            <textarea class="form-control" id="convertPlatform" name="platform" rows="5" placeholder="Enter platform description..." required></textarea>
          </div>

          <!-- Hidden input to hold selected voter IDs -->
          <input type="hidden" id="selectedVotersInput" name="voters" value="">
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-curve pull-left" style="background-color: #FFDEAD; color:black; font-size: 12px; font-family: Times;" data-dismiss="modal">
            <i class="fa fa-close"></i> Close
          </button>
          <button type="button" id="convertVotersBtn" class="btn btn-primary btn-curve" style="background-color: #9CD095; color:black; font-size: 12px; font-family: Times;">
            <i class="fa fa-exchange"></i> Convert Selected
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
// Assume voters data and select logic here, similar to previous code, omitted for brevity

document.getElementById('convertVotersBtn').addEventListener('click', function() {
  // Get values
  const convertAll = document.getElementById('convertAllVoters').checked;
  const position = document.getElementById('convertPosition').value;
  const platform = document.getElementById('convertPlatform').value.trim();
  const selectedVoters = document.getElementById('selectedVotersInput').value;

  // Validation
  if (!position) {
    alert('Please select a position.');
    return;
  }
  if (!platform) {
    alert('Please enter a platform description.');
    return;
  }
  if (!convertAll && (!selectedVoters || selectedVoters.trim() === '')) {
    alert('Please select voters or check "Convert All Voters".');
    return;
  }

  // Prepare data
  const data = new FormData();
  data.append('convert_all', convertAll ? '1' : '0');
  data.append('position', position);
  data.append('platform', platform);
  if (!convertAll) data.append('voters', selectedVoters);

  // AJAX request
  fetch('candidates_convert.php', {
    method: 'POST',
    body: data,
  })
  .then(response => response.json())
  .then(result => {
    if(result.success) {
      alert(result.message || 'Voters converted successfully.');
      // Optionally refresh page or UI
      location.reload();
    } else {
      alert(result.error || 'Error converting voters.');
    }
  })
  .catch(err => {
    alert('AJAX error: ' + err);
  });
});
</script>


<script>
(() => {
  // Load all voters once (in a real app, consider AJAX fetching)
  const voters = [
    <?php
      $sql = "SELECT id, firstname, lastname, photo FROM voters ORDER BY firstname, lastname";
      $query = $conn->query($sql);
      $arr = [];
      while ($row = $query->fetch_assoc()) {
        $id = $row['id'];
        $fname = addslashes($row['firstname']);
        $lname = addslashes($row['lastname']);
        $photo = addslashes($row['photo']);
        $arr[] = "{id: $id, firstname: '$fname', lastname: '$lname', photo: '$photo'}";
      }
      echo implode(",", $arr);
    ?>
  ];

  const voterSearch = document.getElementById('voterSearch');
  const searchResults = document.getElementById('searchResults');
  const selectedVotersList = document.getElementById('selectedVotersList');
  const selectedVotersInput = document.getElementById('selectedVotersInput');
  const convertAllCheckbox = document.getElementById('convertAllVoters');
  const convertPosition = document.getElementById('convertPosition');
  const convertPlatform = document.getElementById('convertPlatform');
  const form = document.getElementById('convertVotersForm');

  let selectedVoters = new Map(); // key=id, value=object

  function renderSelectedVoters() {
    if(selectedVoters.size === 0) {
      selectedVotersList.innerHTML = '<small>No voters selected</small>';
    } else {
      let html = '<div class="row">';
      selectedVoters.forEach(voter => {
        html += `
          <div class="col-xs-6 col-sm-4 col-md-3" style="margin-bottom:10px;">
            <div style="border:1px solid #ccc; padding:5px; border-radius:4px; display:flex; align-items:center;">
              <img src="uploads/voters/${voter.photo}" alt="Photo" style="width:40px; height:40px; object-fit:cover; border-radius:3px; margin-right:8px;">
              <span>${voter.firstname} ${voter.lastname}</span>
              <button type="button" class="btn btn-xs btn-danger" style="margin-left:auto;" data-id="${voter.id}">&times;</button>
            </div>
          </div>`;
      });
      html += '</div>';
      selectedVotersList.innerHTML = html;

      // Add remove button event listeners
      selectedVotersList.querySelectorAll('button.btn-danger').forEach(btn => {
        btn.onclick = () => {
          selectedVoters.delete(parseInt(btn.dataset.id));
          renderSelectedVoters();
          updateSelectedVotersInput();
        };
      });
    }
    updateSelectedVotersInput();
  }

  function updateSelectedVotersInput() {
    // Convert Map keys to comma-separated string
    selectedVotersInput.value = Array.from(selectedVoters.keys()).join(',');
  }

  function filterVoters(term) {
    if(term.trim() === '') {
      searchResults.style.display = 'none';
      searchResults.innerHTML = '';
      return;
    }
    term = term.toLowerCase();
    let matches = voters.filter(v => v.firstname.toLowerCase().includes(term) || v.lastname.toLowerCase().includes(term));
    if(matches.length === 0) {
      searchResults.innerHTML = '<div style="padding:8px;">No voters found</div>';
    } else {
      searchResults.innerHTML = matches.map(v => `
        <div class="search-result-item" style="padding:6px 8px; cursor:pointer; display:flex; align-items:center; border-bottom:1px solid #eee;">
          <img src="uploads/voters/${v.photo}" alt="Photo" style="width:30px; height:30px; object-fit:cover; border-radius:3px; margin-right:8px;">
          <span>${v.firstname} ${v.lastname}</span>
        </div>
      `).join('');
      // Add click handlers for each
      Array.from(searchResults.children).forEach((el, idx) => {
        el.onclick = () => {
          const voter = matches[idx];
          if(!selectedVoters.has(voter.id)) {
            selectedVoters.set(voter.id, voter);
            renderSelectedVoters();
          }
          voterSearch.value = '';
          searchResults.style.display = 'none';
          searchResults.innerHTML = '';
        };
      });
    }
    searchResults.style.display = 'block';
  }

  // Event listeners
  voterSearch.addEventListener('input', e => {
    if(convertAllCheckbox.checked) return; // ignore search if convert all checked
    filterVoters(e.target.value);
  });

  convertAllCheckbox.addEventListener('change', () => {
    if(convertAllCheckbox.checked) {
      // Disable search and clear selected voters
      voterSearch.value = '';
      searchResults.style.display = 'none';
      searchResults.innerHTML = '';
      selectedVoters.clear();
      renderSelectedVoters();
      voterSearch.disabled = true;
      voterSearch.required = false;
    } else {
      voterSearch.disabled = false;
      voterSearch.required = true;
    }
  });

  form.addEventListener('submit', e => {
    if(!convertAllCheckbox.checked && selectedVoters.size === 0) {
      e.preventDefault();
      alert('Please select at least one voter or check "Convert All Voters"');
      return false;
    }
    if(!convertPosition.value) {
      e.preventDefault();
      alert('Please select a position');
      return false;
    }
    if(!convertPlatform.value.trim()) {
      e.preventDefault();
      alert('Please enter a platform description');
      return false;
    }

    // If convertAll is checked, clear selected voters input because all voters will be converted server-side
    if(convertAllCheckbox.checked){
      selectedVotersInput.value = '';
    }
  });

  // Initialize
  renderSelectedVoters();
})();
</script>

<script>
// Optional: Simple client-side search filtering for voters table
document.getElementById('voterSearch').addEventListener('input', function(){
  const filter = this.value.toLowerCase();
  const rows = document.querySelectorAll('#votersTable tbody tr');
  rows.forEach(row => {
    const first = row.children[2].textContent.toLowerCase();
    const last = row.children[3].textContent.toLowerCase();
    if(first.includes(filter) || last.includes(filter)){
      row.style.display = '';
    } else {
      row.style.display = 'none';
    }
  });
});

// Example: on clicking convertVoters button, gather selected voters, position and platform, then submit via AJAX or form
document.getElementById('convertVoters').addEventListener('click', function(){
  const checkedBoxes = [...document.querySelectorAll('.voter-checkbox:checked')];
  if(checkedBoxes.length === 0){
    alert('Please select at least one voter to convert.');
    return;
  }
  const position = document.getElementById('convertPosition').value;
  if(!position){
    alert('Please select a position.');
    return;
  }
  const platform = document.getElementById('convertPlatform').value.trim();
  if(!platform){
    alert('Please enter a platform description.');
    return;
  }
  // Prepare data
  const voterIds = checkedBoxes.map(cb => cb.value);
  // TODO: Submit data via AJAX or form POST to a PHP script to convert voters into candidates
  console.log({voterIds, position, platform});
  alert('Form submission logic goes here.');
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



     