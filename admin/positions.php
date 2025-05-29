<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background: linear-gradient(135deg, #e3f2fd 0%, #ffffff 100%); min-height: 100vh;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 style="color: #1565c0; font-weight: bold; text-shadow: 0 1px 3px rgba(21, 101, 192, 0.3);">
        <i class="fa fa-users" style="margin-right: 10px;"></i>
        Positions Management
      </h1>
      <ol class="breadcrumb" style="background: rgba(255, 255, 255, 0.9); border-radius: 25px; padding: 8px 15px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
        <li><a href="#" style="color: #1976d2; text-decoration: none;"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active" style="color: #0d47a1; font-weight: 500;">Positions</li>
      </ol>
    </section>
    
    <!-- Main content -->
    <section class="content">
      <?php
        if(isset($_SESSION['error'])){
          echo "
            <div class='alert alert-danger alert-dismissible' style='background: linear-gradient(45deg, #ffebee, #ffcdd2); border: 1px solid #f44336; border-radius: 10px; box-shadow: 0 4px 15px rgba(244, 67, 54, 0.2);'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true' style='color: #d32f2f; font-weight: bold;'>&times;</button>
              <h4 style='color: #d32f2f; margin: 0 0 10px 0;'><i class='icon fa fa-warning'></i> Error!</h4>
              <p style='color: #d32f2f; margin: 0;'>".$_SESSION['error']."</p>
            </div>
          ";
          unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
          echo "
            <div class='alert alert-success alert-dismissible' style='background: linear-gradient(45deg, #e8f5e8, #c8e6c9); border: 1px solid #4caf50; border-radius: 10px; box-shadow: 0 4px 15px rgba(76, 175, 80, 0.2);'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true' style='color: #388e3c; font-weight: bold;'>&times;</button>
              <h4 style='color: #388e3c; margin: 0 0 10px 0;'><i class='icon fa fa-check'></i> Success!</h4>
              <p style='color: #388e3c; margin: 0;'>".$_SESSION['success']."</p>
            </div>
          ";
          unset($_SESSION['success']);
        }
      ?>
      
      <div class="row">
        <div class="col-xs-12">
          <div class="box" style="background: #ffffff; border-radius: 15px; box-shadow: 0 8px 25px rgba(33, 150, 243, 0.15); border: 1px solid #e3f2fd; overflow: hidden;">
            <div class="box-header with-border" style="background: linear-gradient(135deg, #2196f3 0%, #1976d2 100%); color: white; padding: 20px; border-bottom: none;">
              <h3 class="box-title" style="color: white; font-weight: 600; margin: 0; font-size: 18px;">
                <i class="fa fa-list-alt" style="margin-right: 8px;"></i>
                Positions List
              </h3>
              <div class="box-tools pull-right">
                <a href="#addnew" data-toggle="modal" class="btn btn-curve" style="background: rgba(255, 255, 255, 0.2); color: white; border: 2px solid rgba(255, 255, 255, 0.3); border-radius: 25px; padding: 8px 20px; font-weight: 500; transition: all 0.3s ease; backdrop-filter: blur(10px);" onmouseover="this.style.background='rgba(255, 255, 255, 0.3)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 5px 15px rgba(0, 0, 0, 0.2)'" onmouseout="this.style.background='rgba(255, 255, 255, 0.2)'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                  <i class="fa fa-plus"></i> Add New Position
                </a>
              </div>
            </div>
            
            <div class="box-body" style="padding: 25px; background: #ffffff;">
              <div style="overflow-x: auto; border-radius: 10px; box-shadow: 0 4px 15px rgba(33, 150, 243, 0.1);">
                <table id="example1" class="table" style="margin: 0; background: white; border-radius: 10px; overflow: hidden;">
                  <thead>
                    <tr style="background: linear-gradient(135deg, #64b5f6 0%, #42a5f5 100%); color: white;">
                      <th class="hidden"></th>
                      <th style="padding: 15px 20px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; border: none;">
                        <i class="fa fa-file-text-o" style="margin-right: 8px;"></i>Description
                      </th>
                      <th style="padding: 15px 20px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; border: none;">
                        <i class="fa fa-sort-numeric-asc" style="margin-right: 8px;"></i>Maximum Vote
                      </th>
                      <th style="padding: 15px 20px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; border: none;">
                        <i class="fa fa-cogs" style="margin-right: 8px;"></i>Actions
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $sql = "SELECT * FROM positions ORDER BY priority ASC";
                      $query = $conn->query($sql);
                      $row_count = 0;
                      while($row = $query->fetch_assoc()){
                        $row_bg = ($row_count % 2 == 0) ? '#f8f9fa' : '#ffffff';
                        echo "
                          <tr style='background: ".$row_bg."; transition: all 0.3s ease;' onmouseover='this.style.background=\"#e3f2fd\"; this.style.transform=\"scale(1.01)\"; this.style.boxShadow=\"0 4px 15px rgba(33, 150, 243, 0.1)\"' onmouseout='this.style.background=\"".$row_bg."\"; this.style.transform=\"scale(1)\"; this.style.boxShadow=\"none\"'>
                            <td class='hidden'></td>
                            <td style='padding: 15px 20px; color: #1565c0; font-weight: 500; border: none; font-size: 14px;'>
                              <i class='fa fa-bookmark' style='color: #42a5f5; margin-right: 8px;'></i>
                              ".$row['description']."
                            </td>
                            <td style='padding: 15px 20px; color: #1976d2; font-weight: 600; border: none; font-size: 14px;'>
                              <span style='background: linear-gradient(45deg, #e3f2fd, #bbdefb); color: #0d47a1; padding: 5px 12px; border-radius: 15px; font-size: 12px; font-weight: bold;'>
                                ".$row['max_vote']."
                              </span>
                            </td>
                            <td style='padding: 15px 20px; border: none;'>
                              <div style='display: flex; gap: 8px;'>
                                <button class='btn btn-sm edit btn-curve' style='background: linear-gradient(45deg, #4fc3f7, #29b6f6); color: white; border: none; border-radius: 20px; padding: 6px 15px; font-weight: 500; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(79, 195, 247, 0.3);' data-id='".$row['id']."' onmouseover='this.style.transform=\"translateY(-2px)\"; this.style.boxShadow=\"0 4px 15px rgba(79, 195, 247, 0.4)\"' onmouseout='this.style.transform=\"translateY(0)\"; this.style.boxShadow=\"0 2px 8px rgba(79, 195, 247, 0.3)\"'>
                                  <i class='fa fa-edit'></i> Edit
                                </button>
                                <button class='btn btn-sm delete btn-curve' style='background: linear-gradient(45deg, #f48fb1, #f06292); color: white; border: none; border-radius: 20px; padding: 6px 15px; font-weight: 500; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(244, 143, 177, 0.3);' data-id='".$row['id']."' onmouseover='this.style.transform=\"translateY(-2px)\"; this.style.boxShadow=\"0 4px 15px rgba(244, 143, 177, 0.4)\"' onmouseout='this.style.transform=\"translateY(0)\"; this.style.boxShadow=\"0 2px 8px rgba(244, 143, 177, 0.3)\"'>
                                  <i class='fa fa-trash'></i> Delete
                                </button>
                              </div>
                            </td>
                          </tr>
                        ";
                        $row_count++;
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
  <?php include 'includes/positions_modal.php'; ?>
</div>

<?php include 'includes/scripts.php'; ?>

<style>
/* Custom scrollbar for table */
.box-body::-webkit-scrollbar {
  height: 8px;
}

.box-body::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 4px;
}

.box-body::-webkit-scrollbar-thumb {
  background: linear-gradient(45deg, #42a5f5, #2196f3);
  border-radius: 4px;
}

.box-body::-webkit-scrollbar-thumb:hover {
  background: linear-gradient(45deg, #1976d2, #1565c0);
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .content-wrapper {
    padding: 10px;
  }
  
  .box-header {
    padding: 15px !important;
  }
  
  .box-body {
    padding: 15px !important;
  }
  
  .btn {
    font-size: 11px !important;
    padding: 4px 10px !important;
  }
}

/* Table animations */
.table tbody tr {
  border-bottom: 1px solid #e3f2fd;
}

.table tbody tr:last-child {
  border-bottom: none;
}

/* Button hover effects */
.btn-curve {
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Loading state for buttons */
.btn:active {
  transform: scale(0.95);
}

/* Enhanced focus states for accessibility */
.btn:focus, .btn:focus-visible {
  outline: 2px solid #2196f3;
  outline-offset: 2px;
}
</style>

<script>
$(function(){
  // Add loading states to buttons
  function showLoading(button) {
    button.prop('disabled', true);
    const originalText = button.html();
    button.data('original-text', originalText);
    button.html('<i class="fa fa-spinner fa-spin"></i> Loading...');
  }
  
  function hideLoading(button) {
    button.prop('disabled', false);
    button.html(button.data('original-text'));
  }
  
  $(document).on('click', '.edit', function(e){
    e.preventDefault();
    const button = $(this);
    showLoading(button);
    
    $('#edit').modal('show');
    var id = $(this).data('id');
    getRow(id, function() {
      hideLoading(button);
    });
  });

  $(document).on('click', '.delete', function(e){
    e.preventDefault();
    const button = $(this);
    showLoading(button);
    
    $('#delete').modal('show');
    var id = $(this).data('id');
    getRow(id, function() {
      hideLoading(button);
    });
  });

  // Add smooth scrolling to table if content overflows
  $('#example1').on('scroll', function() {
    const scrollTop = $(this).scrollTop();
    const scrollHeight = $(this)[0].scrollHeight;
    const height = $(this).height();
    
    if (scrollTop + height >= scrollHeight - 5) {
      // Near bottom of table
      console.log('Near bottom of table');
    }
  });
});

function getRow(id, callback){
  $.ajax({
    type: 'POST',
    url: 'positions_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('.id').val(response.id);
      $('#edit_description').val(response.description);
      $('#edit_max_vote').val(response.max_vote);
      $('.description').html(response.description);
      
      if (callback) callback();
    },
    error: function(xhr, status, error) {
      console.error('Error fetching row data:', error);
      
      // Show error message
      const errorAlert = `
        <div class="alert alert-danger alert-dismissible" style="background: linear-gradient(45deg, #ffebee, #ffcdd2); border: 1px solid #f44336; border-radius: 10px; margin: 10px 0;">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color: #d32f2f;">&times;</button>
          <h4 style="color: #d32f2f; margin: 0 0 10px 0;"><i class="fa fa-warning"></i> Error!</h4>
          <p style="color: #d32f2f; margin: 0;">Failed to load position data. Please try again.</p>
        </div>
      `;
      $('.content').prepend(errorAlert);
      
      if (callback) callback();
    }
  });
}

// Add keyboard navigation support
$(document).keydown(function(e) {
  if (e.key === 'Escape') {
    $('.modal').modal('hide');
  }
});

// Initialize tooltips if Bootstrap tooltip is available
$(function () {
  if (typeof $().tooltip === 'function') {
    $('[data-toggle="tooltip"]').tooltip();
  }
});
</script>
</body>
</html>