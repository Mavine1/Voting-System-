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
      <div class="modal-body">
        <!-- Search Box -->
        <div class="form-group">
          <label for="voterSearch">Search Voters by Name</label>
          <input type="text" id="voterSearch" class="form-control" placeholder="Enter first or last name...">
        </div>

        <!-- Voters List -->
        <div style="max-height: 300px; overflow-y: auto; border: 1px solid #ccc; padding: 10px; background-color: white;">
          <table class="table table-striped table-hover" id="votersTable">
            <thead>
              <tr>
                <th>Select</th>
                <th>Photo</th>
                <th>Firstname</th>
                <th>Lastname</th>
              </tr>
            </thead>
            <tbody>
              <?php
                // Example PHP query to fetch all voters ordered by firstname (you can add filtering server side or AJAX)
                $sql = "SELECT id, firstname, lastname, photo FROM voters ORDER BY firstname, lastname";
                $query = $conn->query($sql);
                while($row = $query->fetch_assoc()){
                  echo '
                  <tr>
                    <td><input type="checkbox" class="voter-checkbox" name="voters[]" value="'.$row['id'].'"></td>
                    <td><img src="uploads/voters/'.$row['photo'].'" alt="Photo" style="width:50px; height:50px; object-fit:cover; border-radius: 4px;"></td>
                    <td>'.htmlspecialchars($row['firstname']).'</td>
                    <td>'.htmlspecialchars($row['lastname']).'</td>
                  </tr>
                  ';
                }
              ?>
            </tbody>
          </table>
        </div>

        <!-- Position Select -->
        <div class="form-group" style="margin-top: 15px;">
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
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-curve pull-left" style="background-color: #FFDEAD; color:black; font-size: 12px; font-family: Times;" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
        <button type="button" id="convertVoters" class="btn btn-primary btn-curve" style="background-color: #9CD095; color:black; font-size: 12px; font-family: Times;"><i class="fa fa-exchange"></i> Convert Selected</button>
      </div>
    </div>
  </div>
</div>

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



     