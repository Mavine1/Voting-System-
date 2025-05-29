<!-- Description Modal -->
<div class="modal fade" id="platform" tabindex="-1" role="dialog" aria-labelledby="platformLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="background-color: #ffffff; color:#1e40af; font-size: 15px; font-family: Times; border: 2px solid #1e40af;">
      <div class="modal-header" style="background-color: #1e40af; color: #ffffff; border-bottom: 2px solid #1e40af;">
        <button type="button" class="btn btn-close btn-curve pull-right" data-dismiss="modal" aria-label="Close" style="color: #ffffff; background: transparent; border: none;">
          <span aria-hidden="true" style="font-size: 18px;">&times;</span>
        </button>
        <h4 class="modal-title" style="color: #ffffff;"><b><span class="fullname"></span></b></h4>
      </div>
      <div class="modal-body" style="background-color: #ffffff; color: #1e40af;">
        <p id="desc"></p>
      </div>
      <div class="modal-footer" style="background-color: #ffffff; border-top: 1px solid #1e40af;">
        <button type="button" class="btn btn-default btn-curve pull-left" style="background-color: #ffffff; color:#1e40af; border: 2px solid #1e40af; font-size: 12px; font-family: Times;" data-dismiss="modal">
          <i class="fa fa-close"></i> Close
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Add New Candidate Modal -->
<div class="modal fade" id="addnew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="background-color: #ffffff; color:#1e40af; font-size: 15px; font-family: Times; border: 2px solid #1e40af;">
      <div class="modal-header" style="background-color: #1e40af; color: #ffffff; border-bottom: 2px solid #1e40af;">
        <button type="button" class="btn btn-close btn-curve pull-right" data-dismiss="modal" aria-label="Close" style="color: #ffffff; background: transparent; border: none;">
          <span aria-hidden="true" style="font-size: 18px;">&times;</span>
        </button>
        <h4 class="modal-title" style="color: #ffffff;"><b>Add New Candidate</b></h4>
      </div>
      <form class="form-horizontal" method="POST" action="candidates_add.php" enctype="multipart/form-data" autocomplete="off">
        <div class="modal-body" style="background-color: #ffffff; color: #1e40af;">
          <div class="form-group">
            <label for="firstname" class="col-sm-3 control-label" style="color: #1e40af;">Firstname</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="firstname" name="firstname" required style="border: 2px solid #1e40af; color: #1e40af;">
            </div>
          </div>
          <div class="form-group">
            <label for="lastname" class="col-sm-3 control-label" style="color: #1e40af;">Lastname</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="lastname" name="lastname" required style="border: 2px solid #1e40af; color: #1e40af;">
            </div>
          </div>
          <div class="form-group">
            <label for="position" class="col-sm-3 control-label" style="color: #1e40af;">Position</label>
            <div class="col-sm-9">
              <select class="form-control" id="position" name="position" required style="border: 2px solid #1e40af; color: #1e40af;">
                <option value="" selected>- Select -</option>
                <?php
                  $sql = "SELECT * FROM positions";
                  $query = $conn->query($sql);
                  while($row = $query->fetch_assoc()){
                    echo "<option value='".$row['id']."'>".htmlspecialchars($row['description'])."</option>";
                  }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="photo" class="col-sm-3 control-label" style="color: #1e40af;">Photo</label>
            <div class="col-sm-9">
              <input type="file" id="photo" name="photo" accept="image/*" style="border: 2px solid #1e40af; color: #1e40af; padding: 5px;">
            </div>
          </div>
          <div class="form-group">
            <label for="platform" class="col-sm-3 control-label" style="color: #1e40af;">Platform</label>
            <div class="col-sm-9">
              <textarea class="form-control" id="platform" name="platform" rows="7" style="border: 2px solid #1e40af; color: #1e40af;"></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="background-color: #ffffff; border-top: 1px solid #1e40af;">
          <button type="button" class="btn btn-default btn-curve pull-left" style="background-color: #ffffff; color:#1e40af; border: 2px solid #1e40af; font-size: 12px; font-family: Times;" data-dismiss="modal">
            <i class="fa fa-close"></i> Close
          </button>
          <button type="submit" name="add" class="btn btn-primary btn-curve" style="background-color: #1e40af; color:#ffffff; border: 2px solid #1e40af; font-size: 12px; font-family: Times;">
            <i class="fa fa-save"></i> Save
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Convert Voters Modal -->
<div class="modal fade" id="convertVoters" tabindex="-1" role="dialog" aria-labelledby="convertVotersLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="background-color: #ffffff; color:#1e40af; font-size: 15px; font-family: Times; border: 2px solid #1e40af;">
      <div class="modal-header" style="background-color: #1e40af; color: #ffffff; border-bottom: 2px solid #1e40af;">
        <h4 class="modal-title" id="convertVotersLabel" style="color: #ffffff;"><b>Convert Voters to Candidates</b></h4>
        <button type="button" class="btn btn-close btn-curve pull-right" data-dismiss="modal" aria-label="Close" style="color: #ffffff; background: transparent; border: none;">
          <span aria-hidden="true" style="font-size: 18px;">&times;</span>
        </button>
      </div>
      <form id="convertVotersForm" method="POST" action="candidates_add.php" autocomplete="off">
        <div class="modal-body" style="background-color: #ffffff; color: #1e40af;">
          <div class="form-group">
            <input type="checkbox" id="convertAllVoters" name="convert_all" value="1" style="margin-right: 10px;">
            <label for="convertAllVoters" style="color: #1e40af;"><strong>Convert All Voters</strong></label>
          </div>
          <div class="form-group" id="searchGroup">
            <label for="voterSearch" style="color: #1e40af;">Search Voters by Name</label>
            <input type="text" id="voterSearch" class="form-control" placeholder="Type first or last name..." autocomplete="off" style="border: 2px solid #1e40af; color: #1e40af;">
            <div id="searchResults" style="max-height: 200px; overflow-y: auto; background: #ffffff; border: 2px solid #1e40af; display:none; position: relative; z-index: 1050;"></div>
          </div>
          <div class="form-group" id="selectedGroup">
            <label style="color: #1e40af;"><strong>Selected Voters</strong></label>
            <div id="selectedVotersList" style="min-height: 80px; border: 2px solid #1e40af; padding: 10px; background: #ffffff; color: #1e40af;">
              <small>No voters selected</small>
            </div>
          </div>
          <div class="form-group">
            <label for="convertPosition" style="color: #1e40af;">Select Position</label>
            <select class="form-control" id="convertPosition" name="position" required style="border: 2px solid #1e40af; color: #1e40af;">
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
          <div class="form-group">
            <label for="convertPlatform" style="color: #1e40af;">Platform Description</label>
            <textarea class="form-control" id="convertPlatform" name="platform" rows="5" placeholder="Enter platform description..." required style="border: 2px solid #1e40af; color: #1e40af;"></textarea>
          </div>
          <input type="hidden" id="selectedVotersInput" name="voters" value="">
        </div>
        <div class="modal-footer" style="background-color: #ffffff; border-top: 1px solid #1e40af;">
          <button type="button" class="btn btn-default btn-curve pull-left" style="background-color: #ffffff; color:#1e40af; border: 2px solid #1e40af; font-size: 12px; font-family: Times;" data-dismiss="modal">
            <i class="fa fa-close"></i> Close
          </button>
          <button type="submit" name="convert_voters" id="convertVotersBtn" class="btn btn-primary btn-curve" style="background-color: #ef4444; color:#ffffff; border: 2px solid #ef4444; font-size: 12px; font-family: Times;">
            <i class="fa fa-exchange"></i> Convert Selected
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
(() => {
  // PHP-generated voters data:
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

  const convertAllCheckbox = document.getElementById('convertAllVoters');
  const voterSearch = document.getElementById('voterSearch');
  const searchResults = document.getElementById('searchResults');
  const selectedVotersList = document.getElementById('selectedVotersList');
  const selectedVotersInput = document.getElementById('selectedVotersInput');
  const convertPosition = document.getElementById('convertPosition');
  const convertPlatform = document.getElementById('convertPlatform');
  const convertBtn = document.getElementById('convertVotersBtn');
  const searchGroup = document.getElementById('searchGroup');
  const selectedGroup = document.getElementById('selectedGroup');
  const convertForm = document.getElementById('convertVotersForm');

  let selectedVoters = new Map();

  function renderSelectedVoters() {
    if (selectedVoters.size === 0) {
      selectedVotersList.innerHTML = '<small style="color: #1e40af;">No voters selected</small>';
    } else {
      let html = '<div class="row">';
      selectedVoters.forEach(voter => {
        html += `
          <div class="col-xs-6 col-sm-4 col-md-3" style="margin-bottom:10px;">
            <div style="border:2px solid #1e40af; padding:5px; border-radius:4px; display:flex; align-items:center; background-color: #ffffff;">
              <img src="uploads/voters/${voter.photo}" alt="Photo" style="width:40px; height:40px; object-fit:cover; border-radius:3px; margin-right:8px; border: 1px solid #1e40af;">
              <span style="color: #1e40af;">${voter.firstname} ${voter.lastname}</span>
              <button type="button" class="btn btn-xs btn-danger" style="margin-left:auto; background-color: #ef4444; color: #ffffff; border: 1px solid #ef4444;" data-id="${voter.id}">&times;</button>
            </div>
          </div>`;
      });
      html += '</div>';
      selectedVotersList.innerHTML = html;

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
    selectedVotersInput.value = Array.from(selectedVoters.keys()).join(',');
  }

  function filterVoters(term) {
    if (term.trim() === '') {
      searchResults.style.display = 'none';
      searchResults.innerHTML = '';
      return;
    }
    term = term.toLowerCase();
    const matches = voters.filter(v => v.firstname.toLowerCase().includes(term) || v.lastname.toLowerCase().includes(term));
    if (matches.length === 0) {
      searchResults.innerHTML = '<div style="padding:8px; color: #1e40af;">No voters found</div>';
    } else {
      searchResults.innerHTML = matches.map(v => `
        <div class="search-result-item" style="padding:6px 8px; cursor:pointer; display:flex; align-items:center; border-bottom:1px solid #1e40af; color: #1e40af;">
          <img src="uploads/voters/${v.photo}" alt="Photo" style="width:30px; height:30px; object-fit:cover; border-radius:3px; margin-right:8px; border: 1px solid #1e40af;">
          <span>${v.firstname} ${v.lastname}</span>
        </div>
      `).join('');
      Array.from(searchResults.children).forEach((el, idx) => {
        el.onclick = () => {
          const voter = matches[idx];
          if (!selectedVoters.has(voter.id)) {
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

  convertAllCheckbox.addEventListener('change', () => {
    if (convertAllCheckbox.checked) {
      searchGroup.style.display = 'none';
      selectedGroup.style.display = 'none';
      voterSearch.value = '';
      voterSearch.disabled = true;
      voterSearch.required = false;
      selectedVoters.clear();
      renderSelectedVoters();
      updateSelectedVotersInput();
    } else {
      searchGroup.style.display = 'block';
      selectedGroup.style.display = 'block';
      voterSearch.disabled = false;
      voterSearch.required = false;
    }
  });

  voterSearch.addEventListener('input', e => {
    if (convertAllCheckbox.checked) return;
    filterVoters(e.target.value);
  });

  // Form validation before submit
  convertForm.addEventListener('submit', (e) => {
    const convertAll = convertAllCheckbox.checked;
    const position = convertPosition.value;
    const platform = convertPlatform.value.trim();
    const votersSelected = selectedVotersInput.value;

    if (!position) {
      e.preventDefault();
      alert('Please select a position.');
      return false;
    }
    if (!platform) {
      e.preventDefault();
      alert('Please enter a platform description.');
      return false;
    }
    if (!convertAll && (!votersSelected || votersSelected.trim() === '')) {
      e.preventDefault();
      alert('Please select at least one voter or check "Convert All Voters".');
      return false;
    }

    // If everything is valid, the form will submit normally to candidates_add.php
    return true;
  });

  renderSelectedVoters();
})();
</script>

<!-- Edit Candidate Modal -->
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="editLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="background-color: #ffffff; color:#1e40af; font-size: 15px; font-family: Times; border: 2px solid #1e40af;">
      <div class="modal-header" style="background-color: #1e40af; color: #ffffff; border-bottom: 2px solid #1e40af;">
        <button type="button" class="btn btn-close btn-curve pull-right" data-dismiss="modal" aria-label="Close" style="color: #ffffff; background: transparent; border: none;">
          <span aria-hidden="true" style="font-size: 18px;">&times;</span>
        </button>
        <h4 class="modal-title" style="color: #ffffff;"><b>Edit Candidate</b></h4>
      </div>
      <form class="form-horizontal" method="POST" action="candidates_edit.php" autocomplete="off">
        <div class="modal-body" style="background-color: #ffffff; color: #1e40af;">
          <input type="hidden" class="id" name="id">
          <div class="form-group">
            <label for="edit_firstname" class="col-sm-3 control-label" style="color: #1e40af;">Firstname</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="edit_firstname" name="firstname" required style="border: 2px solid #1e40af; color: #1e40af;">
            </div>
          </div>
          <div class="form-group">
            <label for="edit_lastname" class="col-sm-3 control-label" style="color: #1e40af;">Lastname</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="edit_lastname" name="lastname" required style="border: 2px solid #1e40af; color: #1e40af;">
            </div>
          </div>
          <div class="form-group">
            <label for="edit_position" class="col-sm-3 control-label" style="color: #1e40af;">Position</label>
            <div class="col-sm-9">
              <select class="form-control" id="edit_position" name="position" required style="border: 2px solid #1e40af; color: #1e40af;">
                <option value="" selected id="posselect"></option>
                <?php
                  $sql = "SELECT * FROM positions";
                  $query = $conn->query($sql);
                  while ($row = $query->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . htmlspecialchars($row['description']) . "</option>";
                  }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="edit_platform" class="col-sm-3 control-label" style="color: #1e40af;">Platform</label>
            <div class="col-sm-9">
              <textarea class="form-control" id="edit_platform" name="platform" rows="7" style="border: 2px solid #1e40af; color: #1e40af;"></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="background-color: #ffffff; border-top: 1px solid #1e40af;">
          <button type="button" class="btn btn-default btn-curve pull-left" style="background-color: #ffffff; color:#1e40af; border: 2px solid #1e40af; font-size: 12px; font-family: Times;" data-dismiss="modal">
            <i class="fa fa-close"></i> Close
          </button>
          <button type="submit" name="edit" class="btn btn-success btn-curve" style="background-color: #1e40af; color:#ffffff; border: 2px solid #1e40af; font-size: 12px; font-family: Times;">
            <i class="fa fa-check-square-o"></i> Update
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Delete Candidate Modal -->
<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="deleteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="background-color: #ffffff; color:#1e40af; font-size: 15px; font-family: Times; border: 2px solid #ef4444;">
      <div class="modal-header" style="background-color: #ef4444; color: #ffffff; border-bottom: 2px solid #ef4444;">
        <button type="button" class="btn btn-close btn-curve pull-right" data-dismiss="modal" aria-label="Close" style="color: #ffffff; background: transparent; border: none;">
          <span aria-hidden="true" style="font-size: 18px;">&times;</span>
        </button>
        <h4 class="modal-title" style="color: #ffffff;"><b>Deleting...</b></h4>
      </div>
      <form class="form-horizontal" method="POST" action="candidates_delete.php" autocomplete="off">
        <input type="hidden" class="id" name="id">
        <div class="modal-body" style="background-color: #ffffff; color: #1e40af;">
          <div class="text-center">
            <p style="color: #ef4444; font-weight: bold; font-size: 16px;">DELETE CANDIDATE</p>
            <h2 class="bold fullname" style="color: #1e40af;"></h2>
          </div>
        </div>
        <div class="modal-footer" style="background-color: #ffffff; border-top: 1px solid #ef4444;">
          <button type="button" class="btn btn-default btn-curve pull-left" style="background-color: #ffffff; color:#1e40af; border: 2px solid #1e40af; font-size: 12px; font-family: Times;" data-dismiss="modal">
            <i class="fa fa-close"></i> Close
          </button>
          <button type="submit" name="delete" class="btn btn-danger btn-curve" style="background-color: #ef4444; color:#ffffff; border: 2px solid #ef4444; font-size: 12px; font-family: Times;">
            <i class="fa fa-trash"></i> Delete
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Update Photo Modal -->
<div class="modal fade" id="edit_photo" tabindex="-1" role="dialog" aria-labelledby="editPhotoLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="background-color: #ffffff; color:#1e40af; font-size: 15px; font-family: Times; border: 2px solid #1e40af;">
      <div class="modal-header" style="background-color: #1e40af; color: #ffffff; border-bottom: 2px solid #1e40af;">
        <button type="button" class="btn btn-close btn-curve pull-right" data-dismiss="modal" aria-label="Close" style="color: #ffffff; background: transparent; border: none;">
          <span aria-hidden="true" style="font-size: 18px;">&times;</span>
        </button>
        <h4 class="modal-title" style="color: #ffffff;"><b><span class="fullname"></span></b></h4>
      </div>
      <form class="form-horizontal" method="POST" action="candidates_photo.php" enctype="multipart/form-data" autocomplete="off">
        <div class="modal-body" style="background-color: #ffffff; color: #1e40af;">
          <input type="hidden" class="id" name="id">
          <div class="form-group">
            <label for="photo" class="col-sm-3 control-label" style="color: #1e40af;">Photo</label>
            <div class="col-sm-9">
              <input type="file" id="photo" name="photo" required accept="image/*" style="border: 2px solid #1e40af; color: #1e40af; padding: 5px;">
            </div>
          </div>
        </div>
        <div class="modal-footer" style="background-color: #ffffff; border-top: 1px solid #1e40af;">
          <button type="button" class="btn btn-default btn-curve pull-left" style="background-color: #ffffff; color:#1e40af; border: 2px solid #1e40af; font-size: 12px; font-family: Times;" data-dismiss="modal">
            <i class="fa fa-close"></i> Close
          </button>
          <button type="submit" name="upload" class="btn btn-success btn-curve" style="background-color: #1e40af; color:#ffffff; border: 2px solid #1e40af; font-size: 12px; font-family: Times;">
            <i class="fa fa-check-square-o"></i> Update
          </button>
        </div>
      </form>
    </div>
  </div>
</div>