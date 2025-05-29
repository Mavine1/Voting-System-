<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); min-height: 100vh;">
    <!-- Content Header (Page header) -->
    <section class="content-header" style="background: linear-gradient(90deg, #1e40af, #3b82f6); padding: 25px 20px; margin-bottom: 30px; border-radius: 0 0 15px 15px; box-shadow: 0 4px 15px rgba(30, 64, 175, 0.2);">
      <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
          <h1 style="color: white; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 32px; font-weight: 700; margin: 0; text-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <i class="fa fa-users" style="margin-right: 12px; color: #60a5fa;"></i>
            Voters Management
          </h1>
          <p style="color: #cbd5e1; margin: 5px 0 0 0; font-size: 16px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
            Manage and oversee all registered voters
          </p>
        </div>
        <ol class="breadcrumb" style="background: rgba(255,255,255,0.1); border-radius: 25px; padding: 8px 20px; margin: 0; backdrop-filter: blur(10px);">
          <li><a href="#" style="color: #e2e8f0; text-decoration: none; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;"><i class="fa fa-dashboard"></i> Home</a></li>
          <li style="color: white; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">Voters List</li>
        </ol>
      </div>
    </section>

    <!-- Main content -->
    <section class="content" style="padding: 0 20px;">
      <?php
        if(isset($_SESSION['error'])){
          echo "
            <div class='alert alert-danger alert-dismissible' style='background: linear-gradient(90deg, #dc2626, #ef4444); border: none; border-radius: 12px; color: white; box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3); margin-bottom: 25px;'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true' style='color: white; font-size: 24px; opacity: 0.8;'>&times;</button>
              <h4 style='margin: 0; font-family: \"Segoe UI\", Tahoma, Geneva, Verdana, sans-serif;'><i class='icon fa fa-warning'></i> Error!</h4>
              <p style='margin: 5px 0 0 0; font-family: \"Segoe UI\", Tahoma, Geneva, Verdana, sans-serif;'>".$_SESSION['error']."</p>
            </div>
          ";
          unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
          echo "
            <div class='alert alert-success alert-dismissible' style='background: linear-gradient(90deg, #059669, #10b981); border: none; border-radius: 12px; color: white; box-shadow: 0 4px 15px rgba(5, 150, 105, 0.3); margin-bottom: 25px;'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true' style='color: white; font-size: 24px; opacity: 0.8;'>&times;</button>
              <h4 style='margin: 0; font-family: \"Segoe UI\", Tahoma, Geneva, Verdana, sans-serif;'><i class='icon fa fa-check'></i> Success!</h4>
              <p style='margin: 5px 0 0 0; font-family: \"Segoe UI\", Tahoma, Geneva, Verdana, sans-serif;'>".$_SESSION['success']."</p>
            </div>
          ";
          unset($_SESSION['success']);
        }
      ?>
      
      <div class="row">
        <div class="col-xs-12">
          <div class="box" style="background: white; border-radius: 15px; box-shadow: 0 8px 25px rgba(0,0,0,0.1); border: none; overflow: hidden;">
            
            <!-- Card Header -->
            <div class="box-header with-border" style="background: linear-gradient(90deg, #f8fafc, #ffffff); padding: 25px; border-bottom: 1px solid #e2e8f0;">
              <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                  <h3 style="margin: 0; color: #1e40af; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 22px; font-weight: 600;">
                    <i class="fa fa-list" style="margin-right: 10px; color: #3b82f6;"></i>
                    Registered Voters
                  </h3>
                  <p style="margin: 5px 0 0 0; color: #64748b; font-size: 14px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                    Complete list of all registered voters in the system
                  </p>
                </div>
                <a href="#addnew" data-toggle="modal" class="btn btn-primary" style="background: linear-gradient(90deg, #dc2626, #ef4444); border: none; border-radius: 25px; padding: 12px 25px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-weight: 600; color: white; box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3); transition: all 0.3s ease; text-decoration: none;">
                  <i class="fa fa-plus" style="margin-right: 8px;"></i> Add New Voter
                </a>
              </div>
            </div>

            <!-- Table Container -->
            <div class="box-body" style="padding: 0;">
              <div style="overflow-x: auto;">
                <table id="example1" class="table" style="margin: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                  <thead>
                    <tr style="background: linear-gradient(90deg, #1e40af, #3b82f6); color: white;">
                      <th style="padding: 18px; font-weight: 600; font-size: 14px; letter-spacing: 0.5px; border: none;">
                        <i class="fa fa-user" style="margin-right: 8px; color: #93c5fd;"></i>USERNAME
                      </th>
                      <th style="padding: 18px; font-weight: 600; font-size: 14px; letter-spacing: 0.5px; border: none;">
                        <i class="fa fa-id-badge" style="margin-right: 8px; color: #93c5fd;"></i>LASTNAME
                      </th>
                      <th style="padding: 18px; font-weight: 600; font-size: 14px; letter-spacing: 0.5px; border: none;">
                        <i class="fa fa-id-badge" style="margin-right: 8px; color: #93c5fd;"></i>FIRSTNAME
                      </th>
                      <th style="padding: 18px; font-weight: 600; font-size: 14px; letter-spacing: 0.5px; border: none;">
                        <i class="fa fa-image" style="margin-right: 8px; color: #93c5fd;"></i>PHOTO
                      </th>
                      <th style="padding: 18px; font-weight: 600; font-size: 14px; letter-spacing: 0.5px; border: none;">
                        <i class="fa fa-id-card" style="margin-right: 8px; color: #93c5fd;"></i>VOTER ID
                      </th>
                      <th style="padding: 18px; font-weight: 600; font-size: 14px; letter-spacing: 0.5px; border: none;">
                        <i class="fa fa-cogs" style="margin-right: 8px; color: #93c5fd;"></i>ACTIONS
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $sql = "SELECT * FROM voters";
                      $query = $conn->query($sql);
                      $row_count = 0;
                      while($row = $query->fetch_assoc()){
                        $row_count++;
                        $image = (!empty($row['photo'])) ? '../images/'.$row['photo'] : '../images/profile.jpg';
                        $row_class = ($row_count % 2 == 0) ? "background: #f8fafc;" : "background: white;";
                        echo "
                          <tr style='".$row_class." transition: all 0.3s ease;' onmouseover='this.style.background=\"#e0f2fe\"; this.style.transform=\"scale(1.01)\";' onmouseout='this.style.background=\"".(($row_count % 2 == 0) ? "#f8fafc" : "white")."\"; this.style.transform=\"scale(1)\";'>
                            <td style='padding: 15px; color: #1e40af; font-weight: 600; font-size: 14px; border-bottom: 1px solid #e2e8f0;'>
                              <div style='display: flex; align-items: center;'>
                                <div style='width: 8px; height: 8px; background: #10b981; border-radius: 50%; margin-right: 10px;'></div>
                                ".$row['username']."
                              </div>
                            </td>
                            <td style='padding: 15px; color: #374151; font-size: 14px; border-bottom: 1px solid #e2e8f0;'>".$row['lastname']."</td>
                            <td style='padding: 15px; color: #374151; font-size: 14px; border-bottom: 1px solid #e2e8f0;'>".$row['firstname']."</td>
                            <td style='padding: 15px; border-bottom: 1px solid #e2e8f0;'>
                              <div style='display: flex; align-items: center;'>
                                <img src='".$image."' style='width: 45px; height: 45px; border-radius: 50%; object-fit: cover; border: 3px solid #dc2626; margin-right: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);'>
                                <a href='#edit_photo' data-toggle='modal' class='photo' data-id='".$row['id']."' style='color: #3b82f6; font-size: 16px; text-decoration: none; transition: all 0.3s ease;' onmouseover='this.style.color=\"#dc2626\";' onmouseout='this.style.color=\"#3b82f6\";'>
                                  <i class='fa fa-edit'></i>
                                </a>
                              </div>
                            </td>
                            <td style='padding: 15px; border-bottom: 1px solid #e2e8f0;'>
                              <span style='background: linear-gradient(90deg, #3b82f6, #60a5fa); color: white; padding: 6px 12px; border-radius: 15px; font-size: 12px; font-weight: 600;'>
                                ID: ".$row['id']."
                              </span>
                            </td>
                            <td style='padding: 15px; border-bottom: 1px solid #e2e8f0;'>
                              <div style='display: flex; gap: 8px;'>
                                <button class='btn btn-success btn-sm edit' style='background: linear-gradient(90deg, #059669, #10b981); border: none; border-radius: 20px; padding: 8px 15px; color: white; font-size: 12px; font-weight: 600; box-shadow: 0 2px 8px rgba(5, 150, 105, 0.3); transition: all 0.3s ease;' data-id='".$row['id']."'>
                                  <i class='fa fa-edit' style='margin-right: 5px;'></i> Edit
                                </button>
                                <button class='btn btn-danger btn-sm delete' style='background: linear-gradient(90deg, #dc2626, #ef4444); border: none; border-radius: 20px; padding: 8px 15px; color: white; font-size: 12px; font-weight: 600; box-shadow: 0 2px 8px rgba(220, 38, 38, 0.3); transition: all 0.3s ease;' data-id='".$row['id']."'>
                                  <i class='fa fa-trash' style='margin-right: 5px;'></i> Delete
                                </button>
                              </div>
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
      </div>
    </section>   
  </div>

  <?php include 'includes/footer.php'; ?>
  <?php include 'includes/voters_modal.php'; ?>
</div>

<!-- Custom Styles -->
<style>
  /* Button hover effects */
  .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.15) !important;
  }

  /* Table row hover effects */
  .table tbody tr:hover {
    background: #e0f2fe !important;
    transform: scale(1.01);
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
  }

  /* Smooth transitions for all interactive elements */
  .btn, .table tbody tr, a {
    transition: all 0.3s ease !important;
  }

  /* Custom scrollbar for table */
  .box-body::-webkit-scrollbar {
    height: 8px;
  }

  .box-body::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 10px;
  }

  .box-body::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 10px;
  }

  .box-body::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
  }

  /* Alert animations */
  .alert {
    animation: slideInDown 0.5s ease-out;
  }

  @keyframes slideInDown {
    from {
      transform: translateY(-100%);
      opacity: 0;
    }
    to {
      transform: translateY(0);
      opacity: 1;
    }
  }
</style>

<?php include 'includes/scripts.php'; ?>

<script>
$(function(){
  $(document).on('click', '.edit', function(e){
    e.preventDefault();
    $('#edit').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.delete', function(e){
    e.preventDefault();
    $('#delete').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.photo', function(e){
    e.preventDefault();
    var id = $(this).data('id');
    getRow(id);
  });
});

function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'voters_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('.id').val(response.id);
      $('#edit_firstname').val(response.firstname);
      $('#edit_lastname').val(response.lastname);
      $('#edit_password').val(response.password);
      $('.fullname').html(response.firstname+' '+response.lastname);
      $('#edit_username').val(response.username);
    }
  });
}
</script>

</body>
</html>