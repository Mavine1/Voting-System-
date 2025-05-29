<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/menubar.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="background-color:#ffffff">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1 style="color:#1e40af"><b>
            Candidates List
          </b> </h1>
        <ol class="breadcrumb" style="color:#1e40af; font-size: 17px; font-family:Times">
          <li><a href="#" style="color:#1e40af"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active" style="color:#1e40af; font-size: 17px; font-family:Times">Dashboard</li>
        </ol>
      </section>
      <!-- Main content -->
      <section class="content">
        <?php
        if (isset($_SESSION['error'])) {
          echo "
            <div class='alert alert-danger alert-dismissible' style='background-color:#ef4444; border-color:#ef4444; color:#ffffff;'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true' style='color:#ffffff;'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              " . $_SESSION['error'] . "
            </div>
          ";
          unset($_SESSION['error']);
        }
        if (isset($_SESSION['success'])) {
          echo "
            <div class='alert alert-success alert-dismissible' style='background-color:#1e40af; border-color:#1e40af; color:#ffffff;'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true' style='color:#ffffff;'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              " . $_SESSION['success'] . "
            </div>
          ";
          unset($_SESSION['success']);
        }
        ?>
        <div class="row">
          <div class="col-xs-12">
            <div class="box" style="background-color: #ffffff; border: 2px solid #1e40af;">
              <div class="box-header with-border" style="background-color: #1e40af; color: #ffffff;">
                <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-curve" style="background-color: #ffffff; color:#1e40af; border: 2px solid #1e40af; font-size: 12px; font-family:Times"><i class="fa fa-plus"></i> New</a>
                <a href="#convertVoters" data-toggle="modal" class="btn btn-info btn-sm btn-curve" style="background-color: #ef4444; color:#ffffff; border: 2px solid #ef4444; font-size: 12px; font-family:Times">
                  <i class="fa fa-exchange-alt"></i> Convert Voters
                </a>
              </div>
              <div class="box-body" style="background-color: #ffffff;">
                <table id="example1" class="table" style="background-color: #ffffff;">
                  <thead style="background-color: #1e40af; color: #ffffff;">
                    <th class="hidden"></th>
                    <th>Position</th>
                    <th>Photo</th>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Platform</th>
                    <th>Tools</th>
                  </thead>
                  <tbody>
                    <?php
                    $sql = "SELECT *, candidates.id AS canid FROM candidates LEFT JOIN positions ON positions.id=candidates.position_id ORDER BY positions.priority ASC";
                    $query = $conn->query($sql);
                    while ($row = $query->fetch_assoc()) {
                      $image = (!empty($row['photo'])) ? '../images/' . $row['photo'] : '../images/profile.jpg';
                      echo "
                        <tr style='color:#1e40af; font-size: 15px; font-family:Times; background-color:#ffffff; border-bottom: 1px solid #1e40af;'>
                          <td class='hidden'></td>
                          <td>" . $row['description'] . "</td>
                          <td>
                            <img src='" . $image . "' width='30px' height='30px' style='border: 2px solid #1e40af; border-radius: 50%;'>
                            <a href='#edit_photo' data-toggle='modal' class='pull-right photo' data-id='" . $row['canid'] . "' style='color:#1e40af;'><span class='fa fa-edit'></span></a>
                          </td>
                          <td>" . $row['firstname'] . "</td>
                          <td>" . $row['lastname'] . "</td>
                          <td><a href='#platform' data-toggle='modal' class='btn btn-info btn-sm btn-curve platform' style='background-color: #1e40af; color:#ffffff; border: 2px solid #1e40af; font-size: 12px; font-family:Times' data-id='" . $row['canid'] . "'><i class='fa fa-search'></i> View</a></td>
                          <td>
                            
                            
                            <button class='btn btn-success btn-sm edit btn-curve' style='background-color: #ffffff; color:#1e40af; border: 2px solid #1e40af; font-size: 12px; font-family:Times; margin-right: 5px;' data-id='" . $row['canid'] . "' ><i class='fa fa-edit'></i> Edit</button>
                            <button class='btn btn-danger btn-sm delete btn-curve' style='background-color:#ef4444; color:#ffffff; border: 2px solid #ef4444; font-size: 12px; font-family:Times' data-id='" . $row['canid'] . "'><i class='fa fa-trash'></i> Delete</button>

                          </td>
                        </tr>
                      ";
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <?php include 'includes/footer.php'; ?>
    <?php include 'includes/candidates_modal.php'; ?>
  </div>
  <?php include 'includes/scripts.php'; ?>
  <script>
    $(function() {
      $(document).on('click', '.edit', function(e) {
        e.preventDefault();
        $('#edit').modal('show');
        var id = $(this).data('id');
        getRow(id);
      });

      $(document).on('click', '.delete', function(e) {
        e.preventDefault();
        $('#delete').modal('show');
        var id = $(this).data('id');
        getRow(id);
      });

      $(document).on('click', '.photo', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        getRow(id);
      });

      $(document).on('click', '.platform', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        getRow(id);
      });

    });

    function getRow(id) {
      $.ajax({
        type: 'POST',
        url: 'candidates_row.php',
        data: {
          id: id
        },
        dataType: 'json',
        success: function(response) {
          $('.id').val(response.canid);
          $('#edit_firstname').val(response.firstname);
          $('#edit_lastname').val(response.lastname);
          $('#posselect').val(response.position_id).html(response.description);
          $('#edit_platform').val(response.platform);
          $('.fullname').html(response.firstname + ' ' + response.lastname);
          $('#desc').html(response.platform);
        }
      });
    }
  </script>
</body>

</html>